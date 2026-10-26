<?php

namespace App\Services;

class DistributedSimulatorService
{
    /**
     * Get default initial cluster topology.
     *
     * @return array<int, array{id: string, name: string, role: string, ip: string, gpu: string, vram_gb: int, capacity_rps: int, status: string, active_connections: int, load_percentage: float}>
     */
    public function getInitialNodes(): array
    {
        return [
            [
                'id' => 'node-1',
                'name' => 'Coordinator-Master',
                'role' => 'Leader (Raft Consensus)',
                'ip' => '10.244.1.10',
                'gpu' => 'NVIDIA H100 SXM5',
                'vram_gb' => 80,
                'capacity_rps' => 450,
                'status' => 'healthy',
                'active_connections' => 34,
                'load_percentage' => 42.5,
            ],
            [
                'id' => 'node-2',
                'name' => 'Worker-Inference-A',
                'role' => 'Worker (Transformer Model)',
                'ip' => '10.244.1.11',
                'gpu' => 'NVIDIA A100 Tensor Core',
                'vram_gb' => 80,
                'capacity_rps' => 380,
                'status' => 'healthy',
                'active_connections' => 52,
                'load_percentage' => 58.0,
            ],
            [
                'id' => 'node-3',
                'name' => 'Worker-Inference-B',
                'role' => 'Worker (Vision-Language Model)',
                'ip' => '10.244.1.12',
                'gpu' => 'NVIDIA L40S Server',
                'vram_gb' => 48,
                'capacity_rps' => 310,
                'status' => 'healthy',
                'active_connections' => 28,
                'load_percentage' => 35.2,
            ],
            [
                'id' => 'node-4',
                'name' => 'Edge-Cache-Node',
                'role' => 'Worker (Quantized LLM & KV Cache)',
                'ip' => '10.244.1.13',
                'gpu' => 'NVIDIA RTX 6000 Ada',
                'vram_gb' => 48,
                'capacity_rps' => 260,
                'status' => 'healthy',
                'active_connections' => 19,
                'load_percentage' => 24.8,
            ],
        ];
    }

    /**
     * Run simulation with user parameters.
     *
     * @param  array<string, mixed>  $params
     * @return array<string, mixed>
     */
    public function simulate(array $params): array
    {
        $algorithm = (string) ($params['algorithm'] ?? 'round_robin');
        $batchRequests = (int) ($params['batch_requests'] ?? 100);
        $concurrency = (int) ($params['concurrency'] ?? 20);
        $failedNodeId = (string) ($params['failed_node'] ?? '');
        $dataReplicationFactor = (int) ($params['replication_factor'] ?? 3);

        $nodes = $this->getInitialNodes();

        // Mark failed node if requested
        $activeNodes = [];
        $failedNodes = [];
        foreach ($nodes as &$node) {
            if ($node['id'] === $failedNodeId) {
                $node['status'] = 'crashed';
                $node['active_connections'] = 0;
                $node['load_percentage'] = 0.0;
                $failedNodes[] = $node;
            } else {
                $activeNodes[] = &$node;
            }
        }
        unset($node);

        $totalActiveCapacity = array_sum(array_column($activeNodes, 'capacity_rps')) ?: 1;
        $requestLogs = [];
        $nodeDistribution = [];
        foreach ($nodes as $node) {
            $nodeDistribution[$node['id']] = 0;
        }

        $idx = 0;
        $activeCount = count($activeNodes);

        for ($i = 1; $i <= $batchRequests; $i++) {
            if ($activeCount === 0) {
                break;
            }

            if ($algorithm === 'least_connections') {
                usort($activeNodes, function (array $a, array $b): int {
                    return $a['active_connections'] <=> $b['active_connections'];
                });
                $chosenNode = &$activeNodes[0];
            } elseif ($algorithm === 'weighted_capacity') {
                // Probabilistic based on capacity
                $rand = mt_rand(1, $totalActiveCapacity);
                $cum = 0;
                $chosenNode = &$activeNodes[0];
                foreach ($activeNodes as &$candidate) {
                    $cum += $candidate['capacity_rps'];
                    if ($rand <= $cum) {
                        $chosenNode = &$candidate;
                        break;
                    }
                }
                unset($candidate);
            } else {
                // Round Robin
                $chosenNode = &$activeNodes[$idx % $activeCount];
                $idx++;
            }

            $chosenNode['active_connections']++;
            $nodeDistribution[$chosenNode['id']]++;

            if ($i <= 10 || $i % 25 === 0 || $i === $batchRequests) {
                $latency = round(rand(18, 48) + ($chosenNode['active_connections'] * 0.35), 2);
                $requestLogs[] = [
                    'request_id' => 'REQ-AI-'.str_pad((string) $i, 4, '0', STR_PAD_LEFT),
                    'timestamp' => now()->subMilliseconds(($batchRequests - $i) * 12)->format('H:i:s.v'),
                    'target_node' => $chosenNode['name'],
                    'target_ip' => $chosenNode['ip'],
                    'model' => 'DeepSeek-R1-Distill-70B',
                    'tokens' => rand(128, 1024),
                    'latency_ms' => $latency,
                    'status' => '200 OK (Served)',
                ];
            }
        }

        // Recalculate node load percentages
        foreach ($nodes as &$node) {
            if ($node['status'] !== 'crashed') {
                $processed = $nodeDistribution[$node['id']];
                $node['processed_requests'] = $processed;
                $node['load_percentage'] = min(100.0, round(($processed / max(1, $batchRequests)) * 100 * (4 / max(1, $activeCount)), 1));
            } else {
                $node['processed_requests'] = 0;
            }
        }
        unset($node);

        $avgLatency = round(22.5 + ($batchRequests / ($totalActiveCapacity ?: 1)) * 30, 2);
        $p99Latency = round($avgLatency * 1.85, 2);
        $throughput = round(($batchRequests / max(1, ($avgLatency * $batchRequests / 1000))), 1);

        $failoverHappened = ! empty($failedNodes);
        $electionEvent = null;
        if ($failoverHappened && $failedNodeId === 'node-1') {
            $electionEvent = [
                'triggered' => true,
                'term' => 4,
                'previous_leader' => 'node-1 (Coordinator-Master)',
                'elected_new_leader' => 'node-2 (Worker-Inference-A)',
                'quorum_votes' => '3 of 3 active nodes (100% consensus)',
                'recovery_time_ms' => 142,
            ];
        }

        return [
            'algorithm_used' => $algorithm,
            'batch_requests' => $batchRequests,
            'concurrency' => $concurrency,
            'replication_factor' => $dataReplicationFactor,
            'nodes' => $nodes,
            'distribution' => $nodeDistribution,
            'metrics' => [
                'total_processed' => $batchRequests,
                'failed_requests' => $activeCount === 0 ? $batchRequests : 0,
                'average_latency_ms' => $avgLatency,
                'p99_latency_ms' => $p99Latency,
                'throughput_rps' => $throughput,
                'cluster_health' => $failoverHappened ? 'Degraded (Failover Active)' : 'Healthy (Optimal)',
                'network_bandwidth_gbs' => round(($batchRequests * 0.45) / 10, 2),
            ],
            'raft_consensus' => [
                'term' => $failoverHappened && $failedNodeId === 'node-1' ? 4 : 3,
                'state' => 'Synchronized',
                'replication_factor' => $dataReplicationFactor,
                'heartbeat_interval_ms' => 50,
                'election_event' => $electionEvent,
            ],
            'request_samples' => $requestLogs,
        ];
    }
}
