@extends('layouts.app', ['title' => $track->title])

@section('content')
<div class="py-10 bg-slate-950">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Breadcrumb -->
        <nav class="flex items-center gap-2 text-xs text-slate-400 mb-6">
            <a href="{{ route('home') }}" class="hover:text-white">Beranda</a>
            <span>/</span>
            <a href="{{ route('tracks.index') }}" class="hover:text-white">Jalur Pelatihan</a>
            <span>/</span>
            <span class="text-slate-200 truncate">{{ $track->title }}</span>
        </nav>

        <!-- Track Header Banner -->
        <div class="rounded-3xl bg-gradient-to-br from-indigo-950 via-slate-900 to-slate-950 border border-indigo-500/30 p-8 sm:p-10 mb-10 shadow-2xl relative overflow-hidden">
            <div class="max-w-3xl space-y-4">
                <div class="flex flex-wrap items-center gap-3">
                    <span class="px-3 py-1 rounded-full text-xs font-semibold bg-indigo-500/10 text-indigo-400 border border-indigo-500/30">
                        {{ $track->level }}
                    </span>
                    <span class="text-xs text-slate-400">Total Durasi: {{ $track->duration_hours }} Jam</span>
                    @if($isEnrolled)
                        <span class="px-3 py-1 rounded-full text-xs font-semibold bg-emerald-500/10 text-emerald-400 border border-emerald-500/30 flex items-center gap-1.5">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span> Status: Terdaftar Aktif
                        </span>
                    @endif
                </div>

                <h1 class="text-2xl sm:text-4xl font-black text-white leading-tight">
                    {{ $track->title }}
                </h1>

                <p class="text-sm text-slate-300 leading-relaxed">
                    {{ $track->description }}
                </p>

                <div class="pt-2 flex flex-wrap items-center gap-4">
                    @if($track->modules->isNotEmpty())
                        <a href="{{ route('modules.show', ['trackSlug' => $track->slug, 'moduleSlug' => $track->modules->first()->slug]) }}" class="px-5 py-2.5 rounded-xl text-xs font-bold bg-indigo-600 hover:bg-indigo-500 text-white transition-all shadow-md shadow-indigo-600/30">
                            Mulai Modul 1 &rarr;
                        </a>
                    @endif

                    @if(! $isEnrolled)
                        <a href="{{ route('registration.create', ['track_id' => $track->id]) }}" class="px-5 py-2.5 rounded-xl text-xs font-bold bg-emerald-600 hover:bg-emerald-500 text-white transition-all">
                            Daftarkan Diri ke Jalur Ini
                        </a>
                    @endif

                    @if(Str::contains($track->slug, 'spk'))
                        <a href="{{ route('labs.spk') }}" class="px-5 py-2.5 rounded-xl text-xs font-bold bg-slate-800 hover:bg-slate-700 text-indigo-300 border border-slate-700 transition-all">
                            Buka Simulator SPK AI
                        </a>
                    @else
                        <a href="{{ route('labs.distributed') }}" class="px-5 py-2.5 rounded-xl text-xs font-bold bg-slate-800 hover:bg-slate-700 text-sky-300 border border-slate-700 transition-all">
                            Buka Simulator Klaster Terdistribusi
                        </a>
                    @endif
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left 2 Cols: Syllabus Modules List -->
            <div class="lg:col-span-2 space-y-6">
                <div class="flex items-center justify-between">
                    <h2 class="text-xl font-bold text-white flex items-center gap-2">
                        <span>Modul Pembelajaran</span>
                        <span class="text-xs px-2.5 py-0.5 rounded-full bg-slate-800 text-slate-300 font-normal">
                            {{ $track->modules->count() }} Modul
                        </span>
                    </h2>
                </div>

                <div class="space-y-4">
                    @foreach($track->modules as $module)
                        <div class="rounded-2xl bg-slate-900 border border-slate-800 p-6 hover:border-slate-700 transition-all">
                            <div class="flex items-start justify-between gap-4">
                                <div class="flex items-start gap-4">
                                    <div class="w-10 h-10 rounded-xl bg-indigo-500/10 text-indigo-400 border border-indigo-500/20 flex items-center justify-center font-bold text-sm shrink-0">
                                        {{ $module->order_number }}
                                    </div>
                                    <div class="space-y-2">
                                        <div class="flex items-center gap-2">
                                            <span class="text-[10px] uppercase font-bold tracking-wider px-2 py-0.5 rounded bg-slate-800 text-slate-400">
                                                {{ ucfirst($module->resource_type) }}
                                            </span>
                                            <span class="text-xs text-slate-500">Estimasi: {{ $module->duration_minutes }} Menit</span>
                                        </div>
                                        <h3 class="text-base font-bold text-white hover:text-indigo-400 transition-colors">
                                            <a href="{{ route('modules.show', ['trackSlug' => $track->slug, 'moduleSlug' => $module->slug]) }}">
                                                {{ $module->title }}
                                            </a>
                                        </h3>
                                        <p class="text-xs text-slate-300 leading-relaxed">
                                            {{ $module->summary }}
                                        </p>
                                    </div>
                                </div>

                                <a href="{{ route('modules.show', ['trackSlug' => $track->slug, 'moduleSlug' => $module->slug]) }}" class="shrink-0 p-2.5 rounded-xl bg-slate-800 hover:bg-indigo-600 text-slate-300 hover:text-white transition-colors">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                    </svg>
                                </a>
                            </div>

                            @if(! empty($module->key_takeaways))
                                <div class="mt-4 pt-4 border-t border-slate-800/80 flex flex-wrap gap-2">
                                    @foreach($module->key_takeaways as $item)
                                        <span class="inline-flex items-center gap-1 text-[11px] text-slate-400 bg-slate-950 px-2.5 py-1 rounded-md border border-slate-800">
                                            <span class="text-indigo-400">&bull;</span> {{ $item }}
                                        </span>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Right Col: Quiz & Instructor & Lab Widget -->
            <div class="space-y-6">
                <!-- Evaluation & Quiz Card -->
                @if($track->quizzes->isNotEmpty())
                    @php
                        $quiz = $track->quizzes->first();
                        $userAttempt = $quiz->attempts->first();
                    @endphp
                    <div class="rounded-3xl bg-gradient-to-b from-slate-900 to-indigo-950/40 border border-indigo-500/30 p-6 shadow-xl space-y-4">
                        <div class="flex items-center justify-between">
                            <span class="px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider bg-indigo-500/10 text-indigo-400 border border-indigo-500/30">
                                Evaluasi Akhir
                            </span>
                            <span class="text-xs text-slate-400">{{ $quiz->time_limit_minutes }} Menit</span>
                        </div>

                        <h3 class="text-lg font-bold text-white">
                            {{ $quiz->title }}
                        </h3>

                        <p class="text-xs text-slate-300 leading-relaxed">
                            {{ $quiz->description }}
                        </p>

                        <div class="p-3 rounded-xl bg-slate-950 border border-slate-800 text-xs space-y-1">
                            <div class="flex justify-between text-slate-400">
                                <span>Passing Grade:</span>
                                <span class="font-bold text-white">{{ $quiz->passing_score }}%</span>
                            </div>
                            <div class="flex justify-between text-slate-400">
                                <span>Jumlah Soal:</span>
                                <span class="font-bold text-white">{{ $quiz->questions->count() }} Soal</span>
                            </div>
                            @if($userAttempt)
                                <div class="flex justify-between border-t border-slate-800 pt-1 mt-1 font-semibold">
                                    <span class="text-slate-300">Skor Terakhir:</span>
                                    <span class="{{ $userAttempt->is_passed ? 'text-emerald-400' : 'text-amber-400' }}">
                                        {{ $userAttempt->score }}% ({{ $userAttempt->is_passed ? 'LULUS' : 'REMEDIAL' }})
                                    </span>
                                </div>
                            @endif
                        </div>

                        @if($certificate)
                            <div class="p-3 rounded-xl bg-emerald-950/60 border border-emerald-500/30 text-xs text-emerald-200 text-center space-y-2">
                                <div class="font-bold">Sertifikat Resmi Telah Diterbitkan!</div>
                                <a href="{{ route('certificates.show', $certificate->certificate_number) }}" class="block w-full py-2 rounded-lg bg-emerald-600 hover:bg-emerald-500 text-white font-bold transition-colors">
                                    Lihat Sertifikat Kelulusan &rarr;
                                </a>
                            </div>
                        @else
                            <a href="{{ route('quiz.show', $quiz->slug) }}" class="block w-full py-2.5 rounded-xl bg-indigo-600 hover:bg-indigo-500 text-white font-bold text-xs text-center transition-colors shadow-lg shadow-indigo-600/20">
                                {{ $userAttempt ? 'Ulangi Ujian Evaluasi' : 'Mulai Ujian Evaluasi Sekarang' }} &rarr;
                            </a>
                        @endif
                    </div>
                @endif

                <!-- Instructor Card -->
                <div class="rounded-2xl bg-slate-900 border border-slate-800 p-6 space-y-3">
                    <div class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Profil Narasumber</div>
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 rounded-xl bg-gradient-to-tr from-indigo-500 to-sky-500 flex items-center justify-center text-white font-bold text-base shadow-inner">
                            {{ substr($track->instructor_name, 0, 2) }}
                        </div>
                        <div>
                            <div class="text-sm font-bold text-white">{{ $track->instructor_name }}</div>
                            <div class="text-xs text-slate-400">{{ $track->instructor_title }}</div>
                        </div>
                    </div>
                    <p class="text-xs text-slate-400 leading-relaxed pt-2 border-t border-slate-800">
                        Tim pelaksana kegiatan Pengabdian kepada Masyarakat (PKM) dari Pusat Riset Kecerdasan Artifisial dan Laboratorium Komputasi Cerdas.
                    </p>
                </div>

                <!-- Discussion Quick CTA -->
                <div class="rounded-2xl bg-slate-900/60 border border-slate-800 p-5 text-center space-y-2">
                    <div class="text-xs font-bold text-white">Punya Pertanyaan tentang Materi?</div>
                    <p class="text-[11px] text-slate-400">
                        Ajukan pertanyaan di forum diskusi kami untuk dijawab langsung oleh narasumber dan sesama peserta.
                    </p>
                    <a href="{{ route('discussions.index', ['category' => Str::contains($track->slug, 'spk') ? 'SPK / DSS' : 'Sistem Terdistribusi']) }}" class="inline-block text-xs font-semibold text-purple-400 hover:text-purple-300">
                        Buka Forum Diskusi Jalur Ini &rarr;
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

