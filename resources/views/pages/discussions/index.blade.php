@extends('layouts.app', ['title' => 'Forum Diskusi Ilmiah PKM AI'])

@section('content')
<div class="py-12 bg-slate-950">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <span class="text-xs font-bold uppercase tracking-wider text-purple-400">Tanya Jawab & Diskusi Akademik</span>
                <h1 class="text-3xl font-black text-white">Forum Diskusi Komunitas PKM AI</h1>
                <p class="text-sm text-slate-400">
                    Diskusikan teori SPK, implementasi algoritma AI, arsitektur sistem terdistribusi, dan kendala praktikum bersama tim instruktur.
                </p>
            </div>
            <a href="#newDiscussionForm" class="px-5 py-2.5 rounded-xl text-xs font-bold bg-purple-600 hover:bg-purple-500 text-white shadow-lg shadow-purple-600/25 transition-all">
                + Buat Pertanyaan Baru
            </a>
        </div>

        <!-- Filter & Search Bar -->
        <div class="rounded-2xl bg-slate-900 border border-slate-800 p-4 flex flex-wrap items-center justify-between gap-4">
            <!-- Category Pills -->
            <div class="flex flex-wrap items-center gap-2">
                @foreach(['Semua', 'SPK / DSS', 'Sistem Terdistribusi', 'Hands-on Lab', 'Umum'] as $cat)
                    <a href="{{ route('discussions.index', ['category' => $cat, 'search' => $search]) }}" 
                       class="px-3 py-1.5 rounded-xl text-xs font-semibold transition-colors {{ ($category === $cat || (! $category && $cat === 'Semua')) ? 'bg-purple-600 text-white' : 'bg-slate-950 text-slate-400 hover:text-white border border-slate-800' }}">
                        {{ $cat }}
                    </a>
                @endforeach
            </div>

            <!-- Search Input -->
            <form method="GET" action="{{ route('discussions.index') }}" class="flex items-center gap-2">
                <input type="hidden" name="category" value="{{ $category }}">
                <input type="text" name="search" value="{{ $search }}" placeholder="Cari topik diskusi..." class="px-3 py-1.5 rounded-xl bg-slate-950 border border-slate-700 text-xs text-white placeholder-slate-500 focus:ring-1 focus:ring-purple-500">
                <button type="submit" class="px-3 py-1.5 rounded-xl bg-slate-800 hover:bg-slate-700 text-xs font-semibold text-slate-200">
                    Cari
                </button>
            </form>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left 2 Cols: Discussion List -->
            <div class="lg:col-span-2 space-y-4">
                @forelse($discussions as $disc)
                    <div class="rounded-2xl bg-slate-900 border border-slate-800 p-6 hover:border-slate-700 transition-all space-y-3">
                        <div class="flex items-center justify-between gap-2">
                            <div class="flex items-center gap-2">
                                <span class="px-2.5 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider bg-purple-500/10 text-purple-400 border border-purple-500/20">
                                    {{ $disc->category }}
                                </span>
                                @if($disc->is_resolved)
                                    <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">
                                        &check; Terjawab Instruktur
                                    </span>
                                @endif
                            </div>
                            <span class="text-[11px] text-slate-500">{{ $disc->created_at->diffForHumans() }}</span>
                        </div>

                        <h3 class="text-base font-bold text-white hover:text-purple-400 transition-colors">
                            <a href="{{ route('discussions.show', $disc->id) }}">
                                {{ $disc->title }}
                            </a>
                        </h3>

                        <p class="text-xs text-slate-300 line-clamp-2 leading-relaxed">
                            {{ $disc->content }}
                        </p>

                        <div class="flex items-center justify-between text-xs text-slate-400 border-t border-slate-800/80 pt-3">
                            <div class="flex items-center gap-2">
                                <span class="w-6 h-6 rounded-md bg-purple-600/20 text-purple-300 flex items-center justify-center font-bold text-[10px]">
                                    {{ substr($disc->user->name, 0, 1) }}
                                </span>
                                <span>{{ $disc->user->name }}</span>
                                <span class="text-[10px] text-slate-500">({{ $disc->user->institution ?? 'Peserta' }})</span>
                            </div>

                            <div class="flex items-center gap-4 text-slate-500 text-[11px]">
                                <span>{{ $disc->views_count }} views</span>
                                <span class="font-bold text-purple-400">{{ $disc->replies_count }} tanggapan</span>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="rounded-2xl bg-slate-900 border border-slate-800 p-8 text-center text-xs text-slate-400">
                        Tidak ada topik diskusi yang sesuai dengan kriteria pencarian.
                    </div>
                @endforelse

                <div class="pt-4">
                    {{ $discussions->links() }}
                </div>
            </div>

            <!-- Right 1 Col: New Discussion Form -->
            <div class="space-y-6" id="newDiscussionForm">
                <div class="rounded-3xl bg-slate-900 border border-purple-500/30 p-6 shadow-xl space-y-4">
                    <div class="border-b border-slate-800 pb-3">
                        <h2 class="text-base font-bold text-white">Ajukan Pertanyaan Baru</h2>
                        <p class="text-xs text-slate-400">Konsultasikan materi pelatihan langsung kepada pengajar.</p>
                    </div>

                    @auth
                        <form method="POST" action="{{ route('discussions.store') }}" class="space-y-4">
                            @csrf

                            <div>
                                <label class="block text-xs font-semibold text-slate-300 mb-1">Kategori Topik: *</label>
                                <select name="category" class="w-full px-3 py-2 rounded-xl bg-slate-950 border border-slate-700 text-xs text-white focus:ring-1 focus:ring-purple-500" required>
                                    <option value="SPK / DSS">SPK / Decision Support System</option>
                                    <option value="Sistem Terdistribusi">Sistem Terdistribusi & Klaster</option>
                                    <option value="Hands-on Lab">Kendala Praktikum Lab</option>
                                    <option value="Umum">Umum / Administratif</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-xs font-semibold text-slate-300 mb-1">Terkait Jalur Pelatihan:</label>
                                <select name="training_track_id" class="w-full px-3 py-2 rounded-xl bg-slate-950 border border-slate-700 text-xs text-white focus:ring-1 focus:ring-purple-500">
                                    <option value="">-- Umum / Tanpa Track Khusus --</option>
                                    @foreach($tracks as $t)
                                        <option value="{{ $t->id }}">{{ $t->title }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label class="block text-xs font-semibold text-slate-300 mb-1">Judul Pertanyaan: *</label>
                                <input type="text" name="title" placeholder="Contoh: Mengapa nilai C_i pada TOPSIS bisa mendekati 1?" class="w-full px-3 py-2 rounded-xl bg-slate-950 border border-slate-700 text-xs text-white focus:ring-1 focus:ring-purple-500" required>
                            </div>

                            <div>
                                <label class="block text-xs font-semibold text-slate-300 mb-1">Penjelasan Detail Pertanyaan: *</label>
                                <textarea name="content" rows="4" placeholder="Jelaskan pertanyaan, konteks modul, atau kode yang ingin didiskusikan..." class="w-full px-3 py-2 rounded-xl bg-slate-950 border border-slate-700 text-xs text-white focus:ring-1 focus:ring-purple-500" required></textarea>
                            </div>

                            <button type="submit" class="w-full py-2.5 rounded-xl font-bold text-xs bg-purple-600 hover:bg-purple-500 text-white shadow-lg shadow-purple-600/25 transition-all">
                                Publikasikan Pertanyaan &rarr;
                            </button>
                        </form>
                    @else
                        <div class="p-6 rounded-2xl bg-slate-950 border border-slate-800 text-center space-y-3">
                            <div class="text-xs text-slate-300 font-semibold">Silakan Masuk untuk Bertanya</div>
                            <p class="text-[11px] text-slate-500">
                                Anda harus memiliki akun peserta atau instruktur untuk dapat mengirim pertanyaan ke forum.
                            </p>
                            <a href="{{ route('login') }}" class="inline-block px-4 py-2 rounded-xl text-xs font-bold bg-purple-600 hover:bg-purple-500 text-white transition-colors">
                                Masuk Portal &rarr;
                            </a>
                        </div>
                    @endauth
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

