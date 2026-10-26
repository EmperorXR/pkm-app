@extends('layouts.app', ['title' => $discussion->title])

@section('content')
<div class="py-10 bg-slate-950">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
        <!-- Breadcrumbs -->
        <nav class="flex items-center gap-2 text-xs text-slate-400 mb-6">
            <a href="{{ route('home') }}" class="hover:text-white">Beranda</a>
            <span>/</span>
            <a href="{{ route('discussions.index') }}" class="hover:text-white">Forum Diskusi</a>
            <span>/</span>
            <span class="text-slate-200 truncate">{{ $discussion->title }}</span>
        </nav>

        <!-- Main Question Card -->
        <div class="rounded-3xl bg-slate-900 border border-slate-800 p-8 shadow-2xl space-y-6">
            <div class="flex items-center justify-between gap-4">
                <span class="px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider bg-purple-500/10 text-purple-400 border border-purple-500/20">
                    {{ $discussion->category }}
                </span>
                <span class="text-xs text-slate-500">{{ $discussion->created_at->format('d M Y H:i') }}</span>
            </div>

            <h1 class="text-2xl font-black text-white leading-tight">
                {{ $discussion->title }}
            </h1>

            <div class="text-sm text-slate-300 leading-relaxed space-y-2 border-y border-slate-800 py-4">
                {!! nl2br(e($discussion->content)) !!}
            </div>

            <div class="flex items-center justify-between text-xs text-slate-400 pt-2">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg bg-gradient-to-tr from-purple-600 to-indigo-600 flex items-center justify-center font-bold text-white text-xs">
                        {{ substr($discussion->user->name, 0, 1) }}
                    </div>
                    <div>
                        <div class="font-bold text-white">{{ $discussion->user->name }}</div>
                        <div class="text-[10px] text-slate-500">{{ $discussion->user->institution ?? 'Peserta PKM' }}</div>
                    </div>
                </div>

                <div class="flex items-center gap-3 text-[11px] text-slate-500">
                    <span>{{ $discussion->views_count }} views</span>
                    <span class="font-bold text-purple-400">{{ $discussion->replies->count() }} tanggapan</span>
                </div>
            </div>
        </div>

        <!-- Replies List -->
        <div class="space-y-4">
            <h2 class="text-lg font-bold text-white flex items-center gap-2">
                <span>Tanggapan & Jawaban</span>
                <span class="text-xs px-2 py-0.5 rounded-full bg-slate-800 text-slate-400">
                    {{ $discussion->replies->count() }}
                </span>
            </h2>

            @forelse($discussion->replies as $reply)
                <div class="rounded-2xl p-6 transition-all {{ $reply->is_instructor_answer ? 'bg-gradient-to-r from-purple-950/40 via-slate-900 to-indigo-950/40 border border-purple-500/40 shadow-xl' : 'bg-slate-900 border border-slate-800' }} space-y-4">
                    <div class="flex items-center justify-between gap-2">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg {{ $reply->is_instructor_answer ? 'bg-purple-600 text-white font-bold' : 'bg-slate-800 text-slate-300' }} flex items-center justify-center text-xs">
                                {{ substr($reply->user->name, 0, 1) }}
                            </div>
                            <div>
                                <div class="text-xs font-bold text-white flex items-center gap-2">
                                    <span>{{ $reply->user->name }}</span>
                                    @if($reply->is_instructor_answer)
                                        <span class="px-2 py-0.5 rounded text-[9px] font-black uppercase tracking-wider bg-purple-500 text-white">
                                            &check; JAWABAN RESMI INSTRUKTUR
                                        </span>
                                    @endif
                                </div>
                                <div class="text-[10px] text-slate-500">{{ $reply->user->institution ?? 'Peserta' }}</div>
                            </div>
                        </div>

                        <span class="text-[11px] text-slate-500">{{ $reply->created_at->diffForHumans() }}</span>
                    </div>

                    <div class="text-xs sm:text-sm text-slate-300 leading-relaxed pl-11">
                        {!! nl2br(e($reply->content)) !!}
                    </div>
                </div>
            @empty
                <div class="rounded-2xl bg-slate-900 border border-slate-800 p-8 text-center text-xs text-slate-400">
                    Belum ada tanggapan untuk diskusi ini. Jadilah yang pertama memberikan jawaban!
                </div>
            @endforelse
        </div>

        <!-- Post Reply Form -->
        <div class="rounded-3xl bg-slate-900 border border-slate-800 p-6 sm:p-8 shadow-xl space-y-4">
            <h3 class="text-base font-bold text-white">Tulis Tanggapan Anda</h3>
            @auth
                <form method="POST" action="{{ route('discussions.reply', $discussion->id) }}" class="space-y-4">
                    @csrf
                    <textarea name="content" rows="4" placeholder="Tuliskan analisis, solusi, atau penjelasan tambahan di sini..." class="w-full px-4 py-3 rounded-2xl bg-slate-950 border border-slate-700 text-xs sm:text-sm text-white focus:ring-1 focus:ring-purple-500 focus:outline-none" required></textarea>

                    <div class="flex justify-end">
                        <button type="submit" class="px-6 py-2.5 rounded-xl font-bold text-xs bg-purple-600 hover:bg-purple-500 text-white shadow-lg shadow-purple-600/25 transition-all">
                            Kirim Tanggapan &rarr;
                        </button>
                    </div>
                </form>
            @else
                <div class="p-6 rounded-2xl bg-slate-950 border border-slate-800 text-center space-y-3">
                    <p class="text-xs text-slate-400">Silakan masuk ke akun Anda untuk menanggapi diskusi ini.</p>
                    <a href="{{ route('login') }}" class="inline-block px-4 py-2 rounded-xl text-xs font-bold bg-purple-600 hover:bg-purple-500 text-white transition-colors">
                        Masuk Sekarang &rarr;
                    </a>
                </div>
            @endauth
        </div>
    </div>
</div>
@endsection

