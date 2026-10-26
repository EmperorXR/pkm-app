<?php

namespace Tests\Unit;

use App\Services\DistributedSimulatorService;
use Tests\TestCase;

class DistributedSimulatorTest extends TestCase
{
    protected DistributedSimulatorService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new DistributedSimulatorService;
    }

    public function test_it_returns_initial_topology_nodes(): void
    {
        $nodes = $this->service->getInitialNodes();
        $this->assertCount(4, $nodes);
        $this->assertEquals('node-1', $nodes[0]['id']);
        $this->assertEquals('healthy', $nodes[0]['status']);
    }

    public function test_it_simulates_round_robin_workload(): void
    {
        $result = $this->service->simulate([
            'algorithm' => 'round_robin',
            'batch_requests' => 100,
            'concurrency' => 20,
            'failed_node' => '',
            'replication_factor' => 3,
        ]);

        $this->assertEquals('round_robin', $result['algorithm_used']);
        $this->assertEquals(100, $result['metrics']['total_processed']);
        $this->assertGreaterThan(0, $result['metrics']['throughput_rps']);
        $this->assertCount(4, $result['nodes']);
    }

    public function test_it_handles_failed_leader_and_triggers_raft_election(): void
    {
        $result = $this->service->simulate([
            'algorithm' => 'least_connections',
            'batch_requests' => 100,
            'concurrency' => 20,
            'failed_node' => 'node-1',
            'replication_factor' => 3,
        ]);

        $this->assertEquals('crashed', $result['nodes'][0]['status']);
        $this->assertNotNull($result['raft_consensus']['election_event']);
        $this->assertTrue($result['raft_consensus']['election_event']['triggered']);
        $this->assertStringContainsString('node-2', $result['raft_consensus']['election_event']['elected_new_leader']);
    }
}
