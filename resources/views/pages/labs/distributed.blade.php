@extends('layouts.app', ['title' => 'Laboratorium Sistem Terdistribusi - Simulator Klaster AI'])

@section('content')
<div class="py-10 bg-slate-950">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Breadcrumb & Header -->
        <nav class="flex items-center gap-2 text-xs text-slate-400 mb-6">
            <a href="{{ route('home') }}" class="hover:text-white">Beranda</a>
            <span>/</span>
            <span class="text-slate-200">Laboratorium Sistem Terdistribusi</span>
        </nav>

        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
            <div>
                <span class="text-xs font-bold uppercase tracking-wider text-sky-400">Interactive Cluster Simulator</span>
                <h1 class="text-2xl sm:text-4xl font-black text-white mt-1">Simulator Klaster Komputasi AI Terdistribusi</h1>
                <p class="text-sm text-slate-400 mt-1 max-w-2xl">
                    Eksperimen langsung dengan arsitektur klaster inferensi AI: uji algoritma load balancing, simulasi failover kegagalan node (Chaos Engineering), dan amati konsensus Raft secara real-time.
                </p>
            </div>

            <div class="flex items-center gap-2">
                <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-semibold bg-emerald-500/10 text-emerald-400 border border-emerald-500/30">
                    <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                    Topology: 4 GPU Nodes Active
                </span>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left Col: Control Panel -->
            <div class="space-y-6">
                <div class="rounded-3xl bg-slate-900 border border-slate-800 p-6 shadow-xl space-y-5">
                    <div class="border-b border-slate-800 pb-3">
                        <h2 class="text-base font-bold text-white">Konfigurasi Simulasi Beban Kerja</h2>
                        <p class="text-xs text-slate-400">Atur parameter beban request inferensi AI.</p>
                    </div>

                    <!-- Algorithm Selection -->
                    <div class="space-y-2">
                        <label class="block text-xs font-semibold text-slate-300">Algoritma Load Balancing:</label>
                        <select id="simAlgorithm" class="w-full px-3 py-2 rounded-xl bg-slate-950 border border-slate-700 text-xs text-white focus:ring-1 focus:ring-sky-500">
                            <option value="round_robin">Round Robin (Beban Bergilir Merata)</option>
                            <option value="least_connections" selected>Least Connections (Optimal untuk Inferensi LLM)</option>
                            <option value="weighted_capacity">Weighted Capacity (Prioritas GPU High-End)</option>
                        </select>
                    </div>

                    <!-- Batch Requests Input -->
                    <div class="space-y-2">
                        <div class="flex justify-between text-xs">
                            <label class="font-semibold text-slate-300">Total Batch Requests:</label>
                            <span id="batchReqDisplay" class="font-mono text-sky-400 font-bold">150 Req</span>
                        </div>
                        <input type="range" id="simBatchRequests" min="20" max="500" step="10" value="150" 
                               oninput="document.getElementById('batchReqDisplay').innerText = this.value + ' Req'"
                               class="w-full accent-sky-500">
                    </div>

                    <!-- Concurrency Streams -->
                    <div class="space-y-2">
                        <div class="flex justify-between text-xs">
                            <label class="font-semibold text-slate-300">Konkurensi Aliran (Concurrent Clients):</label>
                            <span id="concurrencyDisplay" class="font-mono text-sky-400 font-bold">25 Streams</span>
                        </div>
                        <input type="range" id="simConcurrency" min="5" max="50" step="5" value="25"
                               oninput="document.getElementById('concurrencyDisplay').innerText = this.value + ' Streams'"
                               class="w-full accent-sky-500">
                    </div>

                    <!-- Chaos Monkey / Node Failure Injector -->
                    <div class="space-y-2 pt-2 border-t border-slate-800">
                        <label class="block text-xs font-semibold text-rose-300 flex items-center gap-1.5">
                            <svg class="w-4 h-4 text-rose-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                            Chaos Engineering (Uji Kegagalan Node):
                        </label>
                        <select id="simFailedNode" class="w-full px-3 py-2 rounded-xl bg-slate-950 border border-rose-500/30 text-xs text-rose-200 focus:ring-1 focus:ring-rose-500">
                            <option value="">Semua Node Normal (Tanpa Kegagalan)</option>
                            <option value="node-1">Node-1 Mati (Leader Crash - Uji Pemilihan Raft)</option>
                            <option value="node-2">Node-2 Mati (Worker A100 Crash)</option>
                            <option value="node-3">Node-3 Mati (Worker L40S Crash)</option>
                        </select>
                        <p class="text-[10px] text-slate-500">Simulasikan kejadian hardware failure untuk melihat proses failover otomatis.</p>
                    </div>

                    <!-- Run Simulation Button -->
                    <div class="pt-2">
                        <button type="button" onclick="runClusterSimulation()" id="btnRunSimulation" class="w-full py-3.5 rounded-xl font-bold text-xs bg-gradient-to-r from-sky-500 via-indigo-500 to-cyan-400 text-white shadow-lg shadow-sky-500/25 hover:opacity-95 transition-all flex items-center justify-center gap-2">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span>Jalankan Simulasi Klaster &rarr;</span>
                        </button>
                    </div>
                </div>

                <!-- Simulation Info & Save -->
                @auth
                    <form method="POST" action="{{ route('labs.distributed.save') }}" id="saveDistForm" class="rounded-2xl bg-slate-900 border border-slate-800 p-5 space-y-3 hidden">
                        @csrf
                        <input type="hidden" name="input_data" id="distSaveInput">
                        <input type="hidden" name="result_data" id="distSaveResult">
                        <div class="text-xs font-bold text-white">Simpan Hasil Eksperimen:</div>
                        <input type="text" name="title" class="w-full px-3 py-1.5 rounded-lg bg-slate-950 border border-slate-800 text-xs text-white" value="Uji Klaster AI - {{ date('d M Y H:i') }}" required>
                        <button type="submit" class="w-full py-2 rounded-xl bg-slate-800 hover:bg-slate-700 text-slate-200 border border-slate-700 font-bold text-xs transition-colors">
                            Simpan ke Akun &darr;
                        </button>
                    </form>
                @endauth

                <!-- Saved List -->
                @if(! empty($savedSimulations) && count($savedSimulations) > 0)
                    <div class="rounded-2xl bg-slate-900 border border-slate-800 p-5 space-y-3">
                        <div class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Riwayat Tersimpan Anda:</div>
                        <div class="space-y-2">
                            @foreach($savedSimulations as $sim)
                                <div class="p-2.5 rounded-xl bg-slate-950 border border-slate-800 text-xs">
                                    <div class="font-bold text-white truncate">{{ $sim->title }}</div>
                                    <div class="text-[10px] text-slate-500 flex justify-between mt-1">
                                        <span class="text-sky-400">Distributed Cluster</span>
                                        <span>{{ $sim->created_at->diffForHumans() }}</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

            <!-- Right 2 Cols: Live Cluster Topology & Metrics -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Cluster Live Topology Grid -->
                <div class="rounded-3xl bg-slate-900 border border-slate-800 p-6 shadow-xl space-y-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <h2 class="text-base font-bold text-white flex items-center gap-2">
                                <span>Topologi Node Klaster GPU AI</span>
                                <span id="clusterStatusBadge" class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-500/10 text-emerald-400 border border-emerald-500/30">
                                    Status: Healthy
                                </span>
                            </h2>
                            <p class="text-xs text-slate-400">Visualisasi status realtime masing-masing node komputasi.</p>
                        </div>
                    </div>

                    <!-- 4 Nodes Grid -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4" id="nodesContainer">
                        @foreach($initialNodes as $node)
                            <div class="node-card p-4 rounded-2xl bg-slate-950 border border-slate-800 space-y-3 transition-all" id="card-{{ $node['id'] }}">
                                <div class="flex items-start justify-between">
                                    <div>
                                        <div class="flex items-center gap-2">
                                            <span class="w-2 h-2 rounded-full bg-emerald-400 node-indicator" id="dot-{{ $node['id'] }}"></span>
                                            <span class="font-bold text-xs text-white">{{ $node['name'] }}</span>
                                        </div>
                                        <div class="text-[10px] text-slate-400 font-mono mt-0.5">{{ $node['ip'] }}</div>
                                    </div>
                                    <span class="px-2 py-0.5 rounded text-[10px] font-semibold bg-slate-900 text-slate-300 border border-slate-800 node-role" id="role-{{ $node['id'] }}">
                                        {{ $node['role'] }}
                                    </span>
                                </div>

                                <div class="text-xs text-slate-300 space-y-1">
                                    <div class="flex justify-between text-[11px]">
                                        <span class="text-slate-500">Hardware GPU:</span>
                                        <span class="font-medium text-slate-200">{{ $node['gpu'] }} ({{ $node['vram_gb'] }}GB)</span>
                                    </div>
                                    <div class="flex justify-between text-[11px]">
                                        <span class="text-slate-500">Kapasitas Maks:</span>
                                        <span class="font-mono text-slate-200">{{ $node['capacity_rps'] }} RPS</span>
                                    </div>
                                    <div class="flex justify-between text-[11px]">
                                        <span class="text-slate-500">Koneksi Terlayani:</span>
                                        <span class="font-mono font-bold text-sky-400" id="conn-{{ $node['id'] }}">{{ $node['active_connections'] }}</span>
                                    </div>
                                </div>

                                <!-- Load Progress Bar -->
                                <div class="space-y-1 pt-1">
                                    <div class="flex justify-between text-[10px] text-slate-400 font-mono">
                                        <span>Utilisasi Beban</span>
                                        <span id="loadText-{{ $node['id'] }}">{{ $node['load_percentage'] }}%</span>
                                    </div>
                                    <div class="w-full h-1.5 rounded-full bg-slate-800 overflow-hidden">
                                        <div class="h-full bg-sky-500 rounded-full transition-all duration-500" id="loadBar-{{ $node['id'] }}" style="width: {{ $node['load_percentage'] }}%"></div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Cluster Analytics Metrics Bar -->
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-4" id="metricsBar">
                    <div class="rounded-2xl bg-slate-900 border border-slate-800 p-4 text-center">
                        <div class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Throughput Klaster</div>
                        <div class="text-xl font-black text-emerald-400 font-mono mt-1" id="metricThroughput">380 RPS</div>
                        <div class="text-[10px] text-slate-500 mt-0.5">Permintaan per Detik</div>
                    </div>

                    <div class="rounded-2xl bg-slate-900 border border-slate-800 p-4 text-center">
                        <div class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Rata-rata Latensi</div>
                        <div class="text-xl font-black text-sky-400 font-mono mt-1" id="metricAvgLatency">28.4 ms</div>
                        <div class="text-[10px] text-slate-500 mt-0.5">End-to-End Response</div>
                    </div>

                    <div class="rounded-2xl bg-slate-900 border border-slate-800 p-4 text-center">
                        <div class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">P99 Latensi</div>
                        <div class="text-xl font-black text-indigo-400 font-mono mt-1" id="metricP99Latency">52.1 ms</div>
                        <div class="text-[10px] text-slate-500 mt-0.5">Worst-case SLA</div>
                    </div>

                    <div class="rounded-2xl bg-slate-900 border border-slate-800 p-4 text-center">
                        <div class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Konsensus Raft</div>
                        <div class="text-xl font-black text-purple-400 font-mono mt-1" id="metricRaftTerm">Term 3</div>
                        <div class="text-[10px] text-slate-500 mt-0.5" id="metricRaftQuorum">Quorum 100%</div>
                    </div>
                </div>

                <!-- Failover Event Alert (Visible when chaos injected) -->
                <div id="failoverAlertBox" class="p-4 rounded-2xl bg-amber-950/80 border border-amber-500/40 text-amber-200 text-xs shadow-xl hidden space-y-2">
                    <div class="font-bold flex items-center gap-2">
                        <svg class="w-4 h-4 text-amber-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                        <span>Kejadian Failover Klaster Terdeteksi:</span>
                    </div>
                    <div id="failoverDetailsText" class="text-[11px] leading-relaxed text-amber-300/90"></div>
                </div>

                <!-- Live Request Sample Trace Stream -->
                <div class="rounded-3xl bg-slate-900 border border-slate-800 p-6 shadow-xl space-y-4">
                    <div class="flex items-center justify-between">
                        <h3 class="text-xs font-bold text-slate-300 uppercase tracking-wider">Log Aliran Inferensi AI (Sample Tracing):</h3>
                        <span class="text-[10px] text-slate-500">Model: DeepSeek-R1-Distill-70B</span>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-xs text-left">
                            <thead class="text-slate-400 bg-slate-950 uppercase text-[10px] border-b border-slate-800">
                                <tr>
                                    <th class="p-2.5">Request ID</th>
                                    <th class="p-2.5">Waktu</th>
                                    <th class="p-2.5">Target Node</th>
                                    <th class="p-2.5">Tokens</th>
                                    <th class="p-2.5">Latensi</th>
                                    <th class="p-2.5">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-800 text-slate-300 font-mono text-[11px]" id="requestLogsBody">
                                <tr>
                                    <td colspan="6" class="p-4 text-center text-slate-500 font-sans">
                                        Klik "Jalankan Simulasi Klaster" untuk mengalirkan paket inferensi.
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    async function runClusterSimulation() {
        const btn = document.getElementById('btnRunSimulation');
        btn.disabled = true;
        btn.innerHTML = '<span class="animate-pulse">Menghitung Alur Beban...</span>';

        const algorithm = document.getElementById('simAlgorithm').value;
        const batchRequests = parseInt(document.getElementById('simBatchRequests').value);
        const concurrency = parseInt(document.getElementById('simConcurrency').value);
        const failedNode = document.getElementById('simFailedNode').value;

        try {
            const response = await fetch("{{ route('labs.distributed.simulate') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    algorithm: algorithm,
                    batch_requests: batchRequests,
                    concurrency: concurrency,
                    failed_node: failedNode,
                    replication_factor: 3
                })
            });

            const data = await response.json();
            btn.disabled = false;
            btn.innerHTML = `
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>Jalankan Simulasi Klaster &rarr;</span>
            `;

            if (data.success && data.result) {
                renderClusterResults(data.result, { algorithm, batchRequests, concurrency, failedNode });
            }
        } catch (err) {
            console.error(err);
            btn.disabled = false;
        }
    }

    function renderClusterResults(result, inputParams) {
        // Update nodes cards
        result.nodes.forEach(node => {
            const card = document.getElementById('card-' + node.id);
            const dot = document.getElementById('dot-' + node.id);
            const conn = document.getElementById('conn-' + node.id);
            const bar = document.getElementById('loadBar-' + node.id);
            const text = document.getElementById('loadText-' + node.id);
            const role = document.getElementById('role-' + node.id);

            if (node.status === 'crashed') {
                if (card) {
                    card.classList.add('border-rose-500/50', 'bg-rose-950/20');
                    card.classList.remove('border-slate-800', 'bg-slate-950');
                }
                if (dot) dot.className = 'w-2 h-2 rounded-full bg-rose-500 animate-ping';
                if (conn) conn.innerText = '0 (CRASHED)';
                if (text) text.innerText = '0% (Offline)';
                if (bar) bar.style.width = '0%';
                if (role) role.innerText = 'OFFLINE (FAILED)';
            } else {
                if (card) {
                    card.classList.remove('border-rose-500/50', 'bg-rose-950/20');
                    card.classList.add('border-slate-800', 'bg-slate-950');
                }
                if (dot) dot.className = 'w-2 h-2 rounded-full bg-emerald-400';
                if (conn) conn.innerText = node.active_connections;
                if (text) text.innerText = node.load_percentage + '%';
                if (bar) {
                    bar.style.width = Math.min(100, node.load_percentage) + '%';
                    bar.className = node.load_percentage > 85 ? 'h-full bg-rose-500 rounded-full' : (node.load_percentage > 60 ? 'h-full bg-amber-500 rounded-full' : 'h-full bg-sky-500 rounded-full');
                }
            }
        });

        // Update overall metrics
        document.getElementById('metricThroughput').innerText = result.metrics.throughput_rps + ' RPS';
        document.getElementById('metricAvgLatency').innerText = result.metrics.average_latency_ms + ' ms';
        document.getElementById('metricP99Latency').innerText = result.metrics.p99_latency_ms + ' ms';
        document.getElementById('metricRaftTerm').innerText = 'Term ' + result.raft_consensus.term;
        document.getElementById('metricRaftQuorum').innerText = result.metrics.cluster_health;

        // Failover alert handling
        const alertBox = document.getElementById('failoverAlertBox');
        if (result.raft_consensus.election_event) {
            const ev = result.raft_consensus.election_event;
            alertBox.classList.remove('hidden');
            document.getElementById('failoverDetailsText').innerHTML = `
                Node Leader mengalami kegagalan. Klaster memicu <strong>Raft Leader Election (Term ${ev.term})</strong>. Node <strong>${ev.elected_new_leader}</strong> terpilih sebagai Leader baru dengan konsensus ${ev.quorum_votes}. Waktu pemulihan failover: <strong>${ev.recovery_time_ms} ms</strong> tanpa request yang hilang!
            `;
            const roleNode2 = document.getElementById('role-node-2');
            if (roleNode2) roleNode2.innerText = 'Elected New Leader (Raft)';
        } else {
            alertBox.classList.add('hidden');
        }

        // Request samples table
        const tbody = document.getElementById('requestLogsBody');
        let html = '';
        result.request_samples.forEach(sample => {
            html += `
                <tr>
                    <td class="p-2.5 text-sky-400">${sample.request_id}</td>
                    <td class="p-2.5 text-slate-400">${sample.timestamp}</td>
                    <td class="p-2.5 text-slate-200">${sample.target_node}</td>
                    <td class="p-2.5 text-slate-400">${sample.tokens} tok</td>
                    <td class="p-2.5 text-emerald-400 font-bold">${sample.latency_ms} ms</td>
                    <td class="p-2.5 text-emerald-300">${sample.status}</td>
                </tr>
            `;
        });
        tbody.innerHTML = html;

        // Show save form if available
        const saveForm = document.getElementById('saveDistForm');
        if (saveForm) {
            saveForm.classList.remove('hidden');
            document.getElementById('distSaveInput').value = JSON.stringify(inputParams);
            document.getElementById('distSaveResult').value = JSON.stringify(result);
        }
    }

    // Auto run on load
    document.addEventListener('DOMContentLoaded', () => {
        runClusterSimulation();
    });
</script>
@endpush

