@extends('layouts.app', ['title' => $module->title])

@section('content')
<div class="py-10 bg-slate-950">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Breadcrumbs -->
        <nav class="flex items-center gap-2 text-xs text-slate-400 mb-6">
            <a href="{{ route('home') }}" class="hover:text-white">Beranda</a>
            <span>/</span>
            <a href="{{ route('tracks.index') }}" class="hover:text-white">Jalur Pelatihan</a>
            <span>/</span>
            <a href="{{ route('tracks.show', $track->slug) }}" class="hover:text-white">{{ $track->title }}</a>
            <span>/</span>
            <span class="text-slate-200 truncate">{{ $module->title }}</span>
        </nav>

        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
            <!-- Sidebar: Modules Index (1 col) -->
            <aside class="lg:col-span-1 space-y-4">
                <div class="rounded-2xl bg-slate-900 border border-slate-800 p-5 sticky top-24">
                    <div class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Silabus Pembelajaran</div>
                    <div class="text-sm font-bold text-white mb-4 line-clamp-1">{{ $track->title }}</div>

                    <div class="space-y-1">
                        @foreach($track->modules as $m)
                            <a href="{{ route('modules.show', ['trackSlug' => $track->slug, 'moduleSlug' => $m->slug]) }}" 
                               class="flex items-center gap-2.5 p-2.5 rounded-xl text-xs transition-colors {{ $m->id === $module->id ? 'bg-indigo-600 text-white font-bold' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                                <span class="w-5 h-5 rounded-md flex items-center justify-center text-[10px] shrink-0 {{ $m->id === $module->id ? 'bg-white/20 text-white' : 'bg-slate-800 text-slate-400' }}">
                                    {{ $m->order_number }}
                                </span>
                                <span class="truncate">{{ $m->title }}</span>
                            </a>
                        @endforeach
                    </div>

                    @if($track->quizzes->isNotEmpty())
                        <div class="mt-4 pt-4 border-t border-slate-800">
                            <a href="{{ route('quiz.show', $track->quizzes->first()->slug) }}" class="flex items-center gap-2 p-2.5 rounded-xl text-xs font-semibold bg-indigo-500/10 text-indigo-400 border border-indigo-500/20 hover:bg-indigo-500/20 transition-colors">
                                <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                                </svg>
                                <span>Ujian Evaluasi Kelulusan</span>
                            </a>
                        </div>
                    @endif
                </div>
            </aside>

            <!-- Main Content Area (3 cols) -->
            <main class="lg:col-span-3 space-y-8">
                <article class="rounded-3xl bg-slate-900 border border-slate-800 p-8 sm:p-10 shadow-2xl space-y-6">
                    <!-- Module Meta -->
                    <div class="space-y-3 border-b border-slate-800 pb-6">
                        <div class="flex items-center gap-3">
                            <span class="px-3 py-1 rounded-full text-xs font-semibold bg-indigo-500/10 text-indigo-400 border border-indigo-500/30">
                                Modul {{ $module->order_number }}
                            </span>
                            <span class="text-xs text-slate-400">Durasi: &plusmn; {{ $module->duration_minutes }} Menit</span>
                            <span class="text-xs text-slate-400 capitalize">&bull; Tipe: {{ $module->resource_type }}</span>
                        </div>

                        <h1 class="text-2xl sm:text-3xl font-extrabold text-white leading-tight">
                            {{ $module->title }}
                        </h1>

                        <p class="text-sm text-slate-300 leading-relaxed italic bg-slate-950/60 p-4 rounded-xl border border-slate-800/80">
                            {{ $module->summary }}
                        </p>
                    </div>

                    <!-- Module Body Content -->
                    <div class="prose prose-invert prose-slate max-w-none text-sm leading-relaxed space-y-4">
                        {!! $module->content !!}
                    </div>

                    <!-- Key Takeaways Box -->
                    @if(! empty($module->key_takeaways))
                        <div class="rounded-2xl bg-indigo-950/30 border border-indigo-500/30 p-6 space-y-3">
                            <div class="text-xs font-bold text-indigo-300 uppercase tracking-wider flex items-center gap-2">
                                <svg class="w-4 h-4 text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                </svg>
                                Poin Kunci Pembelajaran (Key Takeaways):
                            </div>
                            <ul class="space-y-2">
                                @foreach($module->key_takeaways as $takeaway)
                                    <li class="flex items-start gap-2.5 text-xs text-slate-300">
                                        <svg class="w-4 h-4 text-emerald-400 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                        </svg>
                                        <span>{{ $takeaway }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- Hands-on Lab Integration Banner -->
                    @if(Str::contains($module->title, ['SAW', 'TOPSIS', 'Weighted Product', 'Infrastruktur', 'SPK']))
                        <div class="rounded-2xl bg-gradient-to-r from-indigo-900/60 to-purple-900/60 border border-indigo-500/30 p-5 flex flex-wrap items-center justify-between gap-4">
                            <div>
                                <div class="text-sm font-bold text-white">Praktikkan Algoritma Ini di Lab SPK AI!</div>
                                <div class="text-xs text-indigo-200">Gunakan simulator interaktif kami untuk menghitung matriks keputusan secara real-time.</div>
                            </div>
                            <a href="{{ route('labs.spk') }}" class="px-4 py-2 rounded-xl bg-indigo-600 hover:bg-indigo-500 text-white font-bold text-xs transition-colors">
                                Buka Lab SPK AI &rarr;
                            </a>
                        </div>
                    @elseif(Str::contains($module->title, ['CAP', 'Load Balancing', 'Raft', 'Klaster', 'Terdistribusi']))
                        <div class="rounded-2xl bg-gradient-to-r from-sky-900/60 to-cyan-900/60 border border-sky-500/30 p-5 flex flex-wrap items-center justify-between gap-4">
                            <div>
                                <div class="text-sm font-bold text-white">Praktikkan di Simulator Klaster Terdistribusi!</div>
                                <div class="text-xs text-sky-200">Uji failover konsensus Raft dan round-robin request distribution pada 4 node AI.</div>
                            </div>
                            <a href="{{ route('labs.distributed') }}" class="px-4 py-2 rounded-xl bg-sky-600 hover:bg-sky-500 text-white font-bold text-xs transition-colors">
                                Buka Simulator Klaster &rarr;
                            </a>
                        </div>
                    @endif

                    <!-- Resource PDF / Material -->
                    @if($module->resource_url)
                        <div class="p-4 rounded-xl bg-slate-950 border border-slate-800 flex items-center justify-between gap-4">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-lg bg-rose-500/10 text-rose-400 flex items-center justify-center font-bold text-xs">
                                    PDF
                                </div>
                                <div>
                                    <div class="text-xs font-semibold text-white">Dokumen Materi & Handout Resmi</div>
                                    <div class="text-[10px] text-slate-500">Materi Pelatihan PKM AI & Sistem Terdistribusi</div>
                                </div>
                            </div>
                            <a href="{{ $module->resource_url }}" target="_blank" class="px-3 py-1.5 rounded-lg text-xs font-semibold text-indigo-400 hover:text-white hover:bg-slate-800 transition-colors">
                                Unduh Materi &darr;
                            </a>
                        </div>
                    @endif

                    <!-- Navigation Footer (Prev / Next) -->
                    <div class="pt-6 border-t border-slate-800 flex items-center justify-between gap-4">
                        @if($prevModule)
                            <a href="{{ route('modules.show', ['trackSlug' => $track->slug, 'moduleSlug' => $prevModule->slug]) }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-xs font-semibold bg-slate-800 hover:bg-slate-700 text-slate-200 transition-colors">
                                &larr; Modul Sebelumnya ({{ $prevModule->order_number }})
                            </a>
                        @else
                            <div></div>
                        @endif

                        @if($nextModule)
                            <a href="{{ route('modules.show', ['trackSlug' => $track->slug, 'moduleSlug' => $nextModule->slug]) }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-xs font-bold bg-indigo-600 hover:bg-indigo-500 text-white transition-colors">
                                Lanjut Modul {{ $nextModule->order_number }} &rarr;
                            </a>
                        @else
                            @if($track->quizzes->isNotEmpty())
                                <a href="{{ route('quiz.show', $track->quizzes->first()->slug) }}" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-xs font-bold bg-emerald-600 hover:bg-emerald-500 text-white transition-colors shadow-lg shadow-emerald-600/20">
                                    Ikuti Ujian Evaluasi & Dapatkan Sertifikat &rarr;
                                </a>
                            @endif
                        @endif
                    </div>
                </article>
            </main>
        </div>
    </div>
</div>
@endsection

