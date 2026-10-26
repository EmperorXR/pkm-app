@extends('layouts.app', ['title' => 'Daftar Jalur Pelatihan PKM AI'])

@section('content')
<div class="py-12 bg-slate-950">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="text-center max-w-3xl mx-auto mb-12 space-y-3">
            <span class="text-xs font-bold uppercase tracking-wider text-indigo-400">Silabus & Jalur Belajar</span>
            <h1 class="text-3xl sm:text-4xl font-black text-white">Kurikulum Pelatihan Artificial Intelligence</h1>
            <p class="text-sm text-slate-400 leading-relaxed">
                Pilih jalur pelatihan yang ingin Anda dalami. Setiap jalur dilengkapi materi komprehensif, laboratorium interaktif, kuis evaluasi berkurikulum, dan sertifikat kelulusan digital.
            </p>
        </div>

        <!-- Tracks Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            @foreach($tracks as $track)
                @php
                    $isRegistered = in_array($track->id, $userRegistrations ?? []);
                @endphp
                <div class="rounded-3xl bg-slate-900 border border-slate-800 p-8 flex flex-col justify-between hover:border-slate-700 transition-all shadow-xl">
                    <div>
                        <div class="flex items-center justify-between gap-4 mb-4">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold {{ $loop->first ? 'bg-indigo-500/10 text-indigo-400 border border-indigo-500/30' : 'bg-sky-500/10 text-sky-400 border border-sky-500/30' }}">
                                {{ $track->level }}
                            </span>
                            @if($isRegistered)
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-emerald-500/10 text-emerald-400 border border-emerald-500/30">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>
                                    Terdaftar
                                </span>
                            @endif
                        </div>

                        <h2 class="text-2xl font-bold text-white mb-3">
                            <a href="{{ route('tracks.show', $track->slug) }}" class="hover:text-indigo-400 transition-colors">
                                {{ $track->title }}
                            </a>
                        </h2>

                        <p class="text-xs sm:text-sm text-slate-300 leading-relaxed mb-6">
                            {{ $track->description }}
                        </p>

                        <!-- Highlights Stats -->
                        <div class="grid grid-cols-3 gap-3 p-4 rounded-2xl bg-slate-950 border border-slate-800/80 text-center mb-6">
                            <div>
                                <div class="text-base font-bold text-white">{{ $track->modules->count() }}</div>
                                <div class="text-[10px] text-slate-400">Modul Belajar</div>
                            </div>
                            <div>
                                <div class="text-base font-bold text-sky-400">{{ $track->duration_hours }} Jam</div>
                                <div class="text-[10px] text-slate-400">Total Durasi</div>
                            </div>
                            <div>
                                <div class="text-base font-bold text-emerald-400">70 Poin</div>
                                <div class="text-[10px] text-slate-400">Passing Grade</div>
                            </div>
                        </div>

                        <!-- Modules Accordion-like list -->
                        <div class="space-y-2 mb-6">
                            <div class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2">Daftar Modul Silabus:</div>
                            @foreach($track->modules as $mod)
                                <a href="{{ route('modules.show', ['trackSlug' => $track->slug, 'moduleSlug' => $mod->slug]) }}" class="flex items-center justify-between p-3 rounded-xl bg-slate-950/60 hover:bg-slate-800/80 border border-slate-800 text-xs transition-colors group">
                                    <div class="flex items-center gap-3">
                                        <span class="w-6 h-6 rounded-lg bg-slate-800 group-hover:bg-indigo-600 text-slate-300 group-hover:text-white flex items-center justify-center font-bold text-[11px] shrink-0 transition-colors">
                                            {{ $mod->order_number }}
                                        </span>
                                        <span class="font-medium text-slate-200 group-hover:text-white truncate">{{ $mod->title }}</span>
                                    </div>
                                    <span class="text-[11px] text-slate-500 shrink-0">{{ $mod->duration_minutes }} mnt &rarr;</span>
                                </a>
                            @endforeach
                        </div>
                    </div>

                    <div class="pt-6 border-t border-slate-800 flex flex-wrap items-center justify-between gap-4">
                        <div>
                            <div class="text-[11px] text-slate-400">Narasumber / Instruktur:</div>
                            <div class="text-xs font-semibold text-white">{{ $track->instructor_name }}</div>
                        </div>

                        <div class="flex items-center gap-2">
                            @if(! $isRegistered)
                                <a href="{{ route('registration.create', ['track_id' => $track->id]) }}" class="px-4 py-2 rounded-xl text-xs font-bold bg-slate-800 hover:bg-slate-700 text-slate-200 border border-slate-700 transition-colors">
                                    Daftar Jalur Ini
                                </a>
                            @endif
                            <a href="{{ route('tracks.show', $track->slug) }}" class="px-4 py-2 rounded-xl text-xs font-bold bg-indigo-600 hover:bg-indigo-500 text-white transition-colors">
                                Masuk Kelas &rarr;
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection

