@extends('layouts.app', ['title' => 'Beranda - Sistem Pelatihan AI untuk SPK dan Sistem Terdistribusi'])

@section('content')
<!-- Hero Section -->
<section class="relative overflow-hidden py-16 lg:py-24 border-b border-slate-800/80 bg-gradient-to-b from-slate-950 via-slate-900 to-slate-950">
    <div class="absolute inset-0 bg-[radial-gradient(ellipse_80%_80%_at_50%_-20%,rgba(99,102,241,0.25),rgba(255,255,255,0))]"></div>
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
        <div class="max-w-3xl mx-auto text-center space-y-6">
            <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full text-xs font-semibold bg-indigo-500/10 text-indigo-300 border border-indigo-500/20 backdrop-blur-md">
                <span class="w-2 h-2 rounded-full bg-indigo-400 animate-ping"></span>
                Program Pengabdian & Kemitraan Masyarakat (PKM) 2026
            </div>

            <h1 class="text-3xl sm:text-5xl lg:text-6xl font-black tracking-tight text-white leading-tight">
                Pelatihan <span class="gradient-text">Artificial Intelligence</span> untuk SPK & Sistem Terdistribusi
            </h1>

            <p class="text-base sm:text-lg text-slate-300 leading-relaxed max-w-2xl mx-auto">
                Tingkatkan kompetensi Anda dalam menerapkan algoritma cerdas multi-kriteria (SAW, TOPSIS, Weighted Product) dan arsitektur klaster komputasi AI terdistribusi skala enterprise yang andal dan <em>fault-tolerant</em>.
            </p>

            <div class="flex flex-wrap items-center justify-center gap-4 pt-4">
                <a href="{{ route('tracks.index') }}" class="px-6 py-3.5 rounded-xl font-bold text-sm bg-gradient-to-r from-indigo-500 via-sky-500 to-cyan-400 text-white shadow-lg shadow-indigo-500/25 hover:opacity-95 transition-all transform hover:-translate-y-0.5">
                    Mulai Belajar Sekarang &rarr;
                </a>
                <a href="{{ route('labs.spk') }}" class="px-6 py-3.5 rounded-xl font-bold text-sm bg-slate-900 hover:bg-slate-800 text-slate-200 border border-slate-700/80 transition-all">
                    Coba Lab Kalkulator SPK
                </a>
                <a href="{{ route('labs.distributed') }}" class="px-6 py-3.5 rounded-xl font-bold text-sm bg-slate-900 hover:bg-slate-800 text-slate-200 border border-slate-700/80 transition-all">
                    Coba Simulator Klaster
                </a>
            </div>

            <!-- Demo Login shortcut -->
            <div class="pt-6 flex flex-wrap items-center justify-center gap-2 text-xs text-slate-400">
                <span>Ingin mencoba fitur penuh tanpa mendaftar manual?</span>
                <a href="{{ route('quick-login', 'participant') }}" class="px-2.5 py-1 rounded-md bg-emerald-500/10 text-emerald-400 border border-emerald-500/30 font-medium hover:bg-emerald-500/20 transition-colors">
                    Login Cepat Peserta Demo
                </a>
                <a href="{{ route('quick-login', 'instructor') }}" class="px-2.5 py-1 rounded-md bg-purple-500/10 text-purple-400 border border-purple-500/30 font-medium hover:bg-purple-500/20 transition-colors">
                    Login Instruktur Demo
                </a>
            </div>
        </div>

        <!-- Quick Stats -->
        <div class="mt-16 grid grid-cols-2 md:grid-cols-5 gap-4">
            <div class="bg-slate-900/60 backdrop-blur-md rounded-2xl p-5 border border-slate-800 text-center">
                <div class="text-2xl sm:text-3xl font-extrabold text-white">{{ $stats['total_participants'] }}</div>
                <div class="text-xs text-slate-400 mt-1">Peserta Terdaftar</div>
            </div>
            <div class="bg-slate-900/60 backdrop-blur-md rounded-2xl p-5 border border-slate-800 text-center">
                <div class="text-2xl sm:text-3xl font-extrabold text-sky-400">{{ count($tracks) }}</div>
                <div class="text-xs text-slate-400 mt-1">Jalur Kurikulum</div>
            </div>
            <div class="bg-slate-900/60 backdrop-blur-md rounded-2xl p-5 border border-slate-800 text-center">
                <div class="text-2xl sm:text-3xl font-extrabold text-indigo-400">{{ $stats['total_modules'] }}</div>
                <div class="text-xs text-slate-400 mt-1">Modul Pembelajaran</div>
            </div>
            <div class="bg-slate-900/60 backdrop-blur-md rounded-2xl p-5 border border-slate-800 text-center">
                <div class="text-2xl sm:text-3xl font-extrabold text-emerald-400">{{ $stats['total_certificates'] }}</div>
                <div class="text-xs text-slate-400 mt-1">Sertifikat Terbit</div>
            </div>
            <div class="bg-slate-900/60 backdrop-blur-md rounded-2xl p-5 border border-slate-800 text-center col-span-2 md:col-span-1">
                <div class="text-2xl sm:text-3xl font-extrabold text-purple-400">{{ $stats['total_discussions'] }}</div>
                <div class="text-xs text-slate-400 mt-1">Diskusi Ilmiah</div>
            </div>
        </div>
    </div>
</section>

<!-- Curriculum Tracks Section -->
<section class="py-16 bg-slate-950">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row md:items-end justify-between mb-12 gap-4">
            <div>
                <span class="text-xs font-bold uppercase tracking-wider text-indigo-400">Kurikulum Unggulan PKM</span>
                <h2 class="text-2xl sm:text-4xl font-black text-white mt-1">2 Pilar Utama Pelatihan</h2>
                <p class="text-sm text-slate-400 mt-2 max-w-xl">
                    Kurikulum komprehensif dirancang khusus oleh akademisi dan praktisi industri untuk membekali peserta dengan skill teknis nyata.
                </p>
            </div>
            <a href="{{ route('tracks.index') }}" class="inline-flex items-center gap-1.5 text-xs font-bold text-indigo-400 hover:text-indigo-300">
                Lihat Seluruh Silabus &rarr;
            </a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            @foreach($tracks as $track)
                <div class="rounded-3xl bg-slate-900/80 border border-slate-800 p-8 flex flex-col justify-between hover:border-slate-700 transition-all hover:shadow-2xl hover:shadow-indigo-500/10">
                    <div>
                        <div class="flex items-center justify-between gap-4 mb-4">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold {{ $loop->first ? 'bg-indigo-500/10 text-indigo-400 border border-indigo-500/30' : 'bg-sky-500/10 text-sky-400 border border-sky-500/30' }}">
                                {{ $track->level }}
                            </span>
                            <span class="text-xs text-slate-400 flex items-center gap-1">
                                <svg class="w-4 h-4 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                {{ $track->duration_hours }} Jam Pelatihan
                            </span>
                        </div>

                        <h3 class="text-xl sm:text-2xl font-bold text-white mb-3">
                            {{ $track->title }}
                        </h3>

                        <p class="text-xs sm:text-sm text-slate-300 leading-relaxed mb-6">
                            {{ $track->description }}
                        </p>

                        <!-- Module List Highlights -->
                        <div class="border-t border-slate-800 pt-4 mb-6">
                            <div class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-3">Daftar Modul Pembelajaran:</div>
                            <ul class="space-y-2">
                                @foreach($track->modules->take(3) as $mod)
                                    <li class="flex items-start gap-2 text-xs text-slate-300">
                                        <span class="w-5 h-5 rounded-md bg-slate-800 text-slate-400 flex items-center justify-center text-[10px] shrink-0 font-bold mt-0.5">
                                            {{ $loop->iteration }}
                                        </span>
                                        <span class="truncate">{{ $mod->title }}</span>
                                    </li>
                                @endforeach
                                @if($track->modules->count() > 3)
                                    <li class="text-[11px] text-slate-500 pl-7">
                                        + {{ $track->modules->count() - 3 }} modul lainnya & uji evaluasi
                                    </li>
                                @endif
                            </ul>
                        </div>
                    </div>

                    <div class="pt-4 border-t border-slate-800 flex items-center justify-between gap-4">
                        <div class="text-xs">
                            <div class="text-slate-400">Instruktur:</div>
                            <div class="text-white font-semibold">{{ $track->instructor_name }}</div>
                        </div>
                        <a href="{{ route('tracks.show', $track->slug) }}" class="px-4 py-2 rounded-xl text-xs font-bold bg-indigo-600 hover:bg-indigo-500 text-white transition-colors">
                            Buka Detail Track &rarr;
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Interactive Labs Highlight Section -->
<section class="py-16 border-y border-slate-800/80 bg-gradient-to-b from-slate-900 to-slate-950">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-2xl mx-auto mb-12">
            <span class="text-xs font-bold uppercase tracking-wider text-sky-400">Hands-on Laboratory</span>
            <h2 class="text-2xl sm:text-4xl font-black text-white mt-1">Laboratorium Komputasi Interaktif</h2>
            <p class="text-sm text-slate-400 mt-2">
                Eksperimen langsung dengan data dan skenario riil di browser Anda. Tidak perlu instalasi server yang rumit.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Lab 1: SPK AI -->
            <div class="rounded-3xl bg-slate-900 border border-indigo-500/30 p-8 relative overflow-hidden group">
                <div class="absolute -right-10 -bottom-10 w-48 h-48 bg-indigo-600/10 rounded-full blur-3xl pointer-events-none"></div>
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-10 h-10 rounded-xl bg-indigo-500/20 text-indigo-400 flex items-center justify-center font-bold">
                        &Sigma;
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-white">Simulator & Kalkulator AI DSS</h3>
                        <div class="text-xs text-indigo-400">Multi-Criteria Decision Making (MCDM)</div>
                    </div>
                </div>
                <p class="text-xs text-slate-300 leading-relaxed mb-6">
                    Bandingkan secara presisi algoritma <strong>SAW (Simple Additive Weighting)</strong>, <strong>TOPSIS</strong>, dan <strong>Weighted Product (WP)</strong>. Masukkan kriteria benefit/cost, atur bobot, dan dapatkan perankingan otomatis beserta matriks normalisasi langkah demi langkah.
                </p>
                <div class="bg-slate-950 rounded-xl p-4 border border-slate-800 font-mono text-xs text-slate-400 space-y-1 mb-6">
                    <div class="text-emerald-400">$ saw.normalizeMatrix(benefit, cost)</div>
                    <div class="text-sky-400">$ topsis.calculateEuclideanDistance(A+, A-)</div>
                    <div class="text-indigo-400">&gt; Alternatif Optimal: Cloud Elastic Inference (C_i = 0.841)</div>
                </div>
                <a href="{{ route('labs.spk') }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl text-xs font-bold bg-indigo-600 hover:bg-indigo-500 text-white transition-colors">
                    Buka Lab SPK AI Sekarang &rarr;
                </a>
            </div>

            <!-- Lab 2: Distributed System -->
            <div class="rounded-3xl bg-slate-900 border border-sky-500/30 p-8 relative overflow-hidden group">
                <div class="absolute -right-10 -bottom-10 w-48 h-48 bg-sky-600/10 rounded-full blur-3xl pointer-events-none"></div>
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-10 h-10 rounded-xl bg-sky-500/20 text-sky-400 flex items-center justify-center font-bold">
                        &infin;
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-white">Simulator Klaster AI Terdistribusi</h3>
                        <div class="text-xs text-sky-400">Raft Consensus, Load Balancer & Failover</div>
                    </div>
                </div>
                <p class="text-xs text-slate-300 leading-relaxed mb-6">
                    Simulasikan klaster 4 node GPU AI. Uji algoritma <strong>Round-Robin</strong>, <strong>Least Connections</strong>, dan <strong>Weighted Capacity</strong>. Matikan node secara sengaja (Chaos Testing) untuk mengamati pemilihan Leader baru via konsensus Raft tanpa downtime!
                </p>
                <div class="bg-slate-950 rounded-xl p-4 border border-slate-800 font-mono text-xs text-slate-400 space-y-1 mb-6">
                    <div class="text-amber-400">! Warning: Node-1 Crashed (Heartbeat Timeout)</div>
                    <div class="text-sky-400">&gt; Raft Election: Node-2 terpilih sebagai Leader baru (Quorum 3/3)</div>
                    <div class="text-emerald-400">&gt; Throughput: 420 RPS | P99 Latency: 34.2 ms</div>
                </div>
                <a href="{{ route('labs.distributed') }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl text-xs font-bold bg-sky-600 hover:bg-sky-500 text-white transition-colors">
                    Buka Simulator Klaster &rarr;
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Certification & Evaluation Flow -->
<section class="py-16 bg-slate-950">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="rounded-3xl bg-gradient-to-r from-indigo-950 via-slate-900 to-sky-950 border border-indigo-500/20 p-8 sm:p-12">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-center">
                <div class="lg:col-span-2 space-y-4">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-emerald-500/10 text-emerald-400 border border-emerald-500/30">
                        E-Sertifikat Terverifikasi
                    </span>
                    <h2 class="text-2xl sm:text-4xl font-extrabold text-white">
                        Dapatkan Sertifikat Kompetensi Digital Resmi
                    </h2>
                    <p class="text-sm text-slate-300 leading-relaxed">
                        Selesaikan modul pembelajaran, kerjakan kuis evaluasi komprehensif, dan raih nilai kelulusan minimal 70. Sertifikat digital Anda akan langsung diterbitkan secara otomatis dengan nomor registrasi unik dan kode verifikasi publik.
                    </p>
                    <div class="flex flex-wrap gap-4 pt-2">
                        <a href="{{ route('tracks.index') }}" class="px-5 py-2.5 rounded-xl text-xs font-bold bg-emerald-600 hover:bg-emerald-500 text-white transition-colors">
                            Mulai Pelatihan & Ujian
                        </a>
                        <a href="{{ route('certificates.sample') }}" target="_blank" class="px-5 py-2.5 rounded-xl text-xs font-bold bg-indigo-600 hover:bg-indigo-500 text-white shadow-lg shadow-indigo-600/25 transition-colors">
                            Lihat Contoh E-Sertifikat &rarr;
                        </a>
                        <a href="{{ route('certificates.verify') }}" class="px-5 py-2.5 rounded-xl text-xs font-bold bg-slate-800 hover:bg-slate-700 text-slate-200 border border-slate-700 transition-colors">
                            Cek Validitas Sertifikat
                        </a>
                    </div>
                </div>

                <div class="bg-slate-900/90 rounded-2xl p-6 border border-slate-800 text-center shadow-xl">
                    <div class="w-16 h-16 rounded-full bg-indigo-500/10 text-indigo-400 mx-auto flex items-center justify-center font-bold text-2xl mb-3 border border-indigo-500/20">
                        &starf;
                    </div>
                    <div class="text-xs uppercase tracking-widest text-slate-400 font-semibold">Passing Grade Kelulusan</div>
                    <div class="text-4xl font-black text-white mt-1">70%</div>
                    <div class="text-[11px] text-slate-400 mt-2">
                        Evaluasi 5 soal studi kasus per track kurikulum. Dilengkapi pembahasan kunci jawaban lengkap.
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Latest Discussion Forum Preview -->
<section class="py-16 bg-slate-950 border-t border-slate-900">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between mb-8">
            <div>
                <span class="text-xs font-bold uppercase tracking-wider text-purple-400">Komunitas & Tanya Jawab</span>
                <h2 class="text-2xl font-bold text-white mt-1">Diskusi Ilmiah Terkini</h2>
            </div>
            <a href="{{ route('discussions.index') }}" class="text-xs font-semibold text-purple-400 hover:text-purple-300">
                Buka Forum Lengkap &rarr;
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @forelse($latestDiscussions as $disc)
                <a href="{{ route('discussions.show', $disc->id) }}" class="block p-5 rounded-2xl bg-slate-900/60 border border-slate-800 hover:border-slate-700 hover:bg-slate-900 transition-all">
                    <div class="flex items-center justify-between gap-2 mb-2">
                        <span class="px-2 py-0.5 rounded text-[10px] font-semibold bg-indigo-500/10 text-indigo-400 border border-indigo-500/20">
                            {{ $disc->category }}
                        </span>
                        <span class="text-[11px] text-slate-500">{{ $disc->created_at->diffForHumans() }}</span>
                    </div>
                    <h3 class="text-sm font-bold text-white line-clamp-1 mb-2">{{ $disc->title }}</h3>
                    <p class="text-xs text-slate-400 line-clamp-2 mb-3">{{ $disc->content }}</p>
                    <div class="flex items-center justify-between text-[11px] text-slate-500 border-t border-slate-800/80 pt-2">
                        <span>Oleh: {{ $disc->user->name }}</span>
                        <span>{{ $disc->replies->count() }} tanggapan</span>
                    </div>
                </a>
            @empty
                <div class="col-span-2 text-center py-8 text-xs text-slate-500">
                    Belum ada diskusi terbuka saat ini.
                </div>
            @endforelse
        </div>
    </div>
</section>
@endsection

