@extends('layouts.app', ['title' => 'Laboratorium AI - Kalkulator Sistem Pendukung Keputusan (SPK)'])

@section('content')
<div class="py-10 bg-slate-950">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Breadcrumb & Header -->
        <nav class="flex items-center gap-2 text-xs text-slate-400 mb-6">
            <a href="{{ route('home') }}" class="hover:text-white">Beranda</a>
            <span>/</span>
            <span class="text-slate-200">Laboratorium AI & SPK</span>
        </nav>

        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
            <div>
                <span class="text-xs font-bold uppercase tracking-wider text-indigo-400">Interactive Hands-on Lab</span>
                <h1 class="text-2xl sm:text-4xl font-black text-white mt-1">Simulator & Kalkulator AI Multi-Kriteria (DSS)</h1>
                <p class="text-sm text-slate-400 mt-1 max-w-2xl">
                    Implementasi praktis metode <strong>SAW</strong>, <strong>TOPSIS</strong>, dan <strong>Weighted Product (WP)</strong> untuk pengambilan keputusan arsitektur komputasi cerdas.
                </p>
            </div>

            <!-- Preset Selector -->
            <div class="flex items-center gap-3">
                <span class="text-xs text-slate-400 font-medium">Dataset Contoh:</span>
                <a href="{{ route('labs.spk', ['dataset' => 'ai_server']) }}" class="px-3 py-1.5 rounded-lg text-xs font-semibold {{ $selectedDatasetKey === 'ai_server' ? 'bg-indigo-600 text-white' : 'bg-slate-900 text-slate-300 hover:bg-slate-800' }} border border-slate-700 transition-colors">
                    Server AI
                </a>
                <a href="{{ route('labs.spk', ['dataset' => 'distributed_model']) }}" class="px-3 py-1.5 rounded-lg text-xs font-semibold {{ $selectedDatasetKey === 'distributed_model' ? 'bg-indigo-600 text-white' : 'bg-slate-900 text-slate-300 hover:bg-slate-800' }} border border-slate-700 transition-colors">
                    Distributed Deep Learning
                </a>
            </div>
        </div>

        <!-- Simulator Container -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left 2 Cols: Form & Matrix -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Method Selection Bar -->
                <div class="rounded-2xl bg-slate-900 border border-slate-800 p-5 shadow-xl">
                    <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-3">Pilih Algoritma Pengambilan Keputusan:</label>
                    <div class="grid grid-cols-3 gap-3">
                        <button type="button" id="btnMethodSaw" onclick="setMethod('saw')" class="p-3.5 rounded-xl border text-center transition-all method-btn border-indigo-500 bg-indigo-500/10 text-white font-bold text-xs">
                            <div class="text-sm">SAW</div>
                            <div class="text-[10px] text-indigo-300 font-normal">Simple Additive Weighting</div>
                        </button>
                        <button type="button" id="btnMethodTopsis" onclick="setMethod('topsis')" class="p-3.5 rounded-xl border text-center transition-all method-btn border-slate-800 bg-slate-950 text-slate-400 hover:text-white font-bold text-xs">
                            <div class="text-sm">TOPSIS</div>
                            <div class="text-[10px] text-slate-400 font-normal">Similarity to Ideal Solution</div>
                        </button>
                        <button type="button" id="btnMethodWp" onclick="setMethod('wp')" class="p-3.5 rounded-xl border text-center transition-all method-btn border-slate-800 bg-slate-950 text-slate-400 hover:text-white font-bold text-xs">
                            <div class="text-sm">WP</div>
                            <div class="text-[10px] text-slate-400 font-normal">Weighted Product</div>
                        </button>
                    </div>
                </div>

                <!-- Criteria Table -->
                <div class="rounded-2xl bg-slate-900 border border-slate-800 p-6 shadow-xl space-y-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <h2 class="text-base font-bold text-white">1. Kriteria Keputusan & Pembobotan</h2>
                            <p class="text-xs text-slate-400">Tentukan bobot relatif dan tipe sifat (Benefit: semakin besar semakin baik, Cost: semakin kecil semakin baik).</p>
                        </div>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-xs text-left" id="criteriaTable">
                            <thead class="text-slate-400 bg-slate-950 uppercase text-[10px] border-b border-slate-800">
                                <tr>
                                    <th class="p-3 rounded-l-lg">Kode</th>
                                    <th class="p-3">Nama Kriteria</th>
                                    <th class="p-3">Bobot (W)</th>
                                    <th class="p-3 rounded-r-lg">Tipe Atribut</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-800 text-slate-200" id="criteriaTableBody">
                                @foreach($initialData['criteria'] as $c)
                                    <tr data-code="{{ $c['code'] }}">
                                        <td class="p-3 font-mono font-bold text-indigo-400">{{ $c['code'] }}</td>
                                        <td class="p-3 font-medium">{{ $c['name'] }}</td>
                                        <td class="p-3">
                                            <input type="number" step="0.01" min="0.01" max="1.0" class="criterion-weight w-24 px-2 py-1 bg-slate-950 border border-slate-700 rounded text-slate-100 font-mono text-xs focus:ring-1 focus:ring-indigo-500" value="{{ $c['weight'] }}">
                                        </td>
                                        <td class="p-3">
                                            <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase {{ $c['type'] === 'benefit' ? 'bg-emerald-500/10 text-emerald-400 border border-emerald-500/30' : 'bg-rose-500/10 text-rose-400 border border-rose-500/30' }}">
                                                {{ $c['type'] }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Alternatives Table -->
                <div class="rounded-2xl bg-slate-900 border border-slate-800 p-6 shadow-xl space-y-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <h2 class="text-base font-bold text-white">2. Matriks Keputusan Alternatif (X)</h2>
                            <p class="text-xs text-slate-400">Nilai kinerja masing-masing alternatif terhadap setiap kriteria.</p>
                        </div>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-xs text-left" id="alternativesTable">
                            <thead class="text-slate-400 bg-slate-950 uppercase text-[10px] border-b border-slate-800">
                                <tr>
                                    <th class="p-3 rounded-l-lg">Kode</th>
                                    <th class="p-3">Nama Alternatif</th>
                                    @foreach($initialData['criteria'] as $c)
                                        <th class="p-3 text-center">{{ $c['code'] }}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-800 text-slate-200" id="alternativesTableBody">
                                @foreach($initialData['alternatives'] as $alt)
                                    <tr data-alt="{{ $alt['code'] }}">
                                        <td class="p-3 font-mono font-bold text-sky-400">{{ $alt['code'] }}</td>
                                        <td class="p-3 font-medium text-slate-100">{{ $alt['name'] }}</td>
                                        @foreach($initialData['criteria'] as $c)
                                            <td class="p-3 text-center">
                                                <input type="number" step="any" class="alt-val w-20 px-2 py-1 bg-slate-950 border border-slate-700 rounded text-center text-slate-100 font-mono text-xs focus:ring-1 focus:ring-indigo-500" data-criterion="{{ $c['code'] }}" value="{{ $alt['values'][$c['code']] ?? 0 }}">
                                            </td>
                                        @endforeach
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Calculate Action Button -->
                    <div class="pt-4 flex items-center justify-between gap-4">
                        <button type="button" onclick="runCalculation()" id="btnCalculate" class="px-6 py-3 rounded-xl font-bold text-xs bg-gradient-to-r from-indigo-500 via-sky-500 to-cyan-400 text-white shadow-lg shadow-indigo-500/25 hover:opacity-95 transition-all flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                            </svg>
                            <span>Hitung Perangkingan & Analisis AI</span>
                        </button>
                        <span id="calcIndicator" class="text-xs text-slate-400 hidden">Memproses kalkulasi...</span>
                    </div>
                </div>
            </div>

            <!-- Right 1 Col: Dynamic Results & Rankings -->
            <div class="space-y-6">
                <!-- Result Leaderboard Card -->
                <div class="rounded-3xl bg-slate-900 border border-indigo-500/30 p-6 shadow-2xl space-y-4">
                    <div class="flex items-center justify-between">
                        <span class="px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider bg-indigo-500/10 text-indigo-400 border border-indigo-500/30">
                            Hasil Rekomendasi AI
                        </span>
                        <span class="text-[11px] text-slate-400" id="resMethodLabel">SAW</span>
                    </div>

                    <h2 class="text-lg font-bold text-white">Peringkat Alternatif Optimal</h2>

                    <!-- Rankings list -->
                    <div class="space-y-3" id="rankingsContainer">
                        <!-- Populated by JavaScript -->
                        <div class="text-center py-8 text-xs text-slate-500">
                            Klik tombol <strong>Hitung Perangkingan</strong> untuk melihat hasil analisis.
                        </div>
                    </div>

                    <!-- Save Form (Logged-in only) -->
                    @auth
                        <form method="POST" action="{{ route('labs.spk.save') }}" id="saveSimulationForm" class="pt-4 border-t border-slate-800 space-y-3 hidden">
                            @csrf
                            <input type="hidden" name="method" id="saveMethodInput" value="saw">
                            <input type="hidden" name="input_data" id="saveInputData">
                            <input type="hidden" name="result_data" id="saveResultData">
                            <div>
                                <label class="block text-[11px] text-slate-400 mb-1">Judul Catatan Simulasi:</label>
                                <input type="text" name="title" class="w-full px-3 py-1.5 rounded-lg bg-slate-950 border border-slate-800 text-xs text-white" value="Eksperimen SPK - {{ date('d M Y H:i') }}" required>
                            </div>
                            <button type="submit" class="w-full py-2 rounded-xl bg-slate-800 hover:bg-slate-700 text-slate-200 border border-slate-700 font-bold text-xs transition-colors">
                                Simpan Riwayat Simulasi Ini &darr;
                            </button>
                        </form>
                    @else
                        <div class="pt-4 border-t border-slate-800 text-center">
                            <a href="{{ route('login') }}" class="text-xs text-indigo-400 hover:underline">
                                Masuk untuk menyimpan hasil simulasi ini ke akun Anda &rarr;
                            </a>
                        </div>
                    @endauth
                </div>

                <!-- Theory Quick Reference -->
                <div class="rounded-2xl bg-slate-900 border border-slate-800 p-6 space-y-3 text-xs text-slate-300">
                    <div class="font-bold text-white uppercase tracking-wider text-[11px]">Rangkuman Formula Matematis</div>
                    <div id="formulaExplanation" class="space-y-2 text-[11px] text-slate-400 leading-relaxed">
                        <p><strong>SAW:</strong> Mengalikan rating ternormalisasi $r_{ij}$ dengan bobot kriteria $w_j$, lalu menjumlahkan preferensi akhir $V_i = \sum (w_j \cdot r_{ij})$.</p>
                    </div>
                </div>

                <!-- Saved Simulations History -->
                @if(! empty($savedSimulations) && count($savedSimulations) > 0)
                    <div class="rounded-2xl bg-slate-900 border border-slate-800 p-5 space-y-3">
                        <div class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Riwayat Tersimpan Anda:</div>
                        <div class="space-y-2">
                            @foreach($savedSimulations as $sim)
                                <div class="p-2.5 rounded-xl bg-slate-950 border border-slate-800 text-xs">
                                    <div class="font-bold text-white truncate">{{ $sim->title }}</div>
                                    <div class="text-[10px] text-slate-500 flex justify-between mt-1">
                                        <span class="uppercase text-indigo-400">{{ str_replace('spk_', '', $sim->simulation_type) }}</span>
                                        <span>{{ $sim->created_at->diffForHumans() }}</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Step-by-Step Mathematical Computation View -->
        <div id="stepBreakdownSection" class="mt-12 rounded-3xl bg-slate-900 border border-slate-800 p-8 shadow-2xl space-y-6 hidden">
            <div class="flex items-center justify-between border-b border-slate-800 pb-4">
                <div>
                    <span class="text-xs font-bold uppercase tracking-wider text-emerald-400">Step-by-Step Transparency</span>
                    <h3 class="text-xl font-bold text-white mt-1">Rincian Komputasi Matriks & Normalisasi</h3>
                </div>
            </div>

            <!-- Normalized Matrix R -->
            <div class="space-y-3">
                <h4 class="text-xs font-bold text-slate-300 uppercase tracking-wider">Matriks Ternormalisasi (R):</h4>
                <div class="overflow-x-auto">
                    <table class="w-full text-xs text-left" id="stepNormMatrixTable">
                        <thead class="text-slate-400 bg-slate-950 uppercase text-[10px] border-b border-slate-800">
                            <tr id="stepNormMatrixHead">
                                <th class="p-3">Alternatif</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-800 text-slate-200" id="stepNormMatrixBody"></tbody>
                    </table>
                </div>
            </div>

            <!-- TOPSIS / WP Extra Details -->
            <div id="extraStepDetails" class="space-y-3 pt-4 border-t border-slate-800"></div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    let currentMethod = 'saw';
    const criteriaData = @json($initialData['criteria']);
    const alternativesData = @json($initialData['alternatives']);

    function setMethod(method) {
        currentMethod = method;
        document.querySelectorAll('.method-btn').forEach(btn => {
            btn.classList.remove('border-indigo-500', 'bg-indigo-500/10', 'text-white');
            btn.classList.add('border-slate-800', 'bg-slate-950', 'text-slate-400');
        });

        const activeId = method === 'saw' ? 'btnMethodSaw' : (method === 'topsis' ? 'btnMethodTopsis' : 'btnMethodWp');
        const activeBtn = document.getElementById(activeId);
        activeBtn.classList.add('border-indigo-500', 'bg-indigo-500/10', 'text-white');
        activeBtn.classList.remove('border-slate-800', 'bg-slate-950', 'text-slate-400');

        const label = document.getElementById('resMethodLabel');
        const formula = document.getElementById('formulaExplanation');
        if (label) label.innerText = method.toUpperCase();

        if (method === 'saw') {
            formula.innerHTML = '<p><strong>SAW:</strong> Mengalikan rating ternormalisasi r_{ij} dengan bobot kriteria w_j, lalu menjumlahkan preferensi akhir V_i = &sum; (w_j &times; r_{ij}).</p>';
        } else if (method === 'topsis') {
            formula.innerHTML = '<p><strong>TOPSIS:</strong> Menghitung matriks normalisasi vektor terbobot, menentukan solusi ideal positif (A+) & negatif (A-), serta menghitung kedekatan relatif C_i = D^- / (D^- + D^+).</p>';
        } else {
            formula.innerHTML = '<p><strong>Weighted Product:</strong> Menghitung Vektor S dengan perpangkatan bobot w_j (positif untuk benefit, negatif untuk cost): S_i = &prod; x_{ij}^{w_j}, lalu V_i = S_i / &sum; S_k.</p>';
        }

        runCalculation();
    }

    async function runCalculation() {
        const indicator = document.getElementById('calcIndicator');
        if (indicator) indicator.classList.remove('hidden');

        // Gather criteria
        const criteria = [];
        document.querySelectorAll('#criteriaTableBody tr').forEach(row => {
            const code = row.getAttribute('data-code');
            const original = criteriaData.find(c => c.code === code) || {};
            const weight = parseFloat(row.querySelector('.criterion-weight').value) || 0.1;
            criteria.push({
                code: code,
                name: original.name || code,
                weight: weight,
                type: original.type || 'benefit'
            });
        });

        // Gather alternatives
        const alternatives = [];
        document.querySelectorAll('#alternativesTableBody tr').forEach(row => {
            const altCode = row.getAttribute('data-alt');
            const original = alternativesData.find(a => a.code === altCode) || {};
            const values = {};
            row.querySelectorAll('.alt-val').forEach(input => {
                const critCode = input.getAttribute('data-criterion');
                values[critCode] = parseFloat(input.value) || 0.0;
            });

            alternatives.push({
                code: altCode,
                name: original.name || altCode,
                values: values
            });
        });

        try {
            const response = await fetch("{{ route('labs.spk.calculate') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    method: currentMethod,
                    criteria: criteria,
                    alternatives: alternatives
                })
            });

            const data = await response.json();
            if (indicator) indicator.classList.add('hidden');

            if (data.success && data.result) {
                renderResults(data.result, criteria, alternatives);
            }
        } catch (err) {
            console.error(err);
            if (indicator) indicator.classList.add('hidden');
        }
    }

    function renderResults(result, criteria, alternatives) {
        const container = document.getElementById('rankingsContainer');
        const scores = result.final_scores || result.vector_v || [];

        let html = '';
        scores.forEach((item, idx) => {
            const isWinner = idx === 0;
            const rankBadge = isWinner 
                ? '<span class="w-6 h-6 rounded-full bg-amber-400 text-slate-950 font-black text-xs flex items-center justify-center shrink-0">1</span>'
                : (idx === 1 
                    ? '<span class="w-6 h-6 rounded-full bg-slate-300 text-slate-950 font-bold text-xs flex items-center justify-center shrink-0">2</span>'
                    : '<span class="w-6 h-6 rounded-full bg-amber-700/60 text-white font-bold text-xs flex items-center justify-center shrink-0">' + (idx + 1) + '</span>');

            html += `
                <div class="p-3.5 rounded-2xl ${isWinner ? 'bg-gradient-to-r from-indigo-950 to-slate-900 border border-indigo-500/50 shadow-lg' : 'bg-slate-950 border border-slate-800'} flex items-center justify-between gap-3">
                    <div class="flex items-center gap-3">
                        ${rankBadge}
                        <div>
                            <div class="text-xs font-bold text-white flex items-center gap-2">
                                <span>${item.name}</span>
                                <span class="font-mono text-[10px] text-slate-400">(${item.code})</span>
                            </div>
                            ${isWinner ? '<span class="text-[10px] font-bold text-emerald-400 tracking-wide uppercase">&starf; REKOMENDASI TERBAIK AI</span>' : ''}
                        </div>
                    </div>
                    <div class="text-right">
                        <div class="text-sm font-black font-mono ${isWinner ? 'text-indigo-400' : 'text-slate-200'}">${item.score}</div>
                        <div class="text-[10px] text-slate-500">Nilai Preferensi</div>
                    </div>
                </div>
            `;
        });

        container.innerHTML = html;

        // Populate Save Form fields if present
        const saveForm = document.getElementById('saveSimulationForm');
        if (saveForm) {
            saveForm.classList.remove('hidden');
            document.getElementById('saveMethodInput').value = currentMethod;
            document.getElementById('saveInputData').value = JSON.stringify({ criteria, alternatives });
            document.getElementById('saveResultData').value = JSON.stringify(result);
        }

        // Populate Breakdown table
        const breakdownSection = document.getElementById('stepBreakdownSection');
        if (breakdownSection) {
            breakdownSection.classList.remove('hidden');

            const headRow = document.getElementById('stepNormMatrixHead');
            let headHtml = '<th class="p-3">Alternatif</th>';
            criteria.forEach(c => {
                headHtml += `<th class="p-3 text-center">${c.code}</th>`;
            });
            headRow.innerHTML = headHtml;

            const body = document.getElementById('stepNormMatrixBody');
            let bodyHtml = '';
            if (result.normalized_matrix) {
                alternatives.forEach(alt => {
                    bodyHtml += `<tr><td class="p-3 font-semibold text-slate-100">${alt.name} (${alt.code})</td>`;
                    criteria.forEach(c => {
                        const val = result.normalized_matrix[alt.code] ? result.normalized_matrix[alt.code][c.code] : 0;
                        bodyHtml += `<td class="p-3 text-center font-mono text-indigo-300">${val}</td>`;
                    });
                    bodyHtml += '</tr>';
                });
            } else if (result.vector_s) {
                // WP Vector S
                alternatives.forEach(alt => {
                    const sVal = result.vector_s[alt.code] || 0;
                    bodyHtml += `<tr><td class="p-3 font-semibold text-slate-100">${alt.name} (${alt.code})</td>`;
                    criteria.forEach(c => {
                        bodyHtml += `<td class="p-3 text-center font-mono text-slate-400">${alt.values[c.code]}</td>`;
                    });
                    bodyHtml += `<td class="p-3 text-right font-mono text-indigo-400 font-bold">Vektor S: ${sVal}</td></tr>`;
                });
            }
            body.innerHTML = bodyHtml;
        }
    }

    // Auto-run on initial load
    document.addEventListener('DOMContentLoaded', () => {
        runCalculation();
    });
</script>
@endpush

