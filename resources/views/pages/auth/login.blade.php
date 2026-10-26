@extends('layouts.app', ['title' => 'Masuk - Portal PKM AI'])

@section('content')
<div class="py-16 bg-slate-950 flex items-center justify-center min-h-[75vh]">
    <div class="w-full max-w-md px-4 sm:px-6 space-y-6">
        <!-- Brand / Header -->
        <div class="text-center space-y-2">
            <div class="w-12 h-12 rounded-2xl bg-gradient-to-tr from-indigo-600 via-sky-500 to-cyan-400 p-0.5 mx-auto glow-node">
                <div class="w-full h-full bg-slate-950 rounded-[14px] flex items-center justify-center">
                    <svg class="w-6 h-6 text-sky-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                </div>
            </div>
            <h1 class="text-2xl font-black text-white">Masuk ke Portal PKM AI</h1>
            <p class="text-xs text-slate-400">
                Akses modul pembelajaran, laboratorium simulasi, dan sertifikat digital.
            </p>
        </div>

        <!-- Quick 1-Click Demo Login Box (For Evaluators) -->
        <div class="rounded-2xl bg-gradient-to-br from-indigo-950/60 via-slate-900 to-sky-950/60 border border-indigo-500/30 p-4 space-y-3 shadow-xl">
            <div class="flex items-center justify-between text-xs font-bold text-indigo-300">
                <span>⚡ Akses Cepat Demo (1-Click Login):</span>
                <span class="text-[10px] text-slate-500">Evaluator / Tester</span>
            </div>
            <div class="grid grid-cols-3 gap-2">
                <a href="{{ route('quick-login', 'participant') }}" class="p-2 rounded-xl bg-emerald-500/10 hover:bg-emerald-500/20 text-emerald-400 border border-emerald-500/30 text-center text-xs font-bold transition-all">
                    <div>Peserta</div>
                    <div class="text-[9px] font-normal text-emerald-300/70">Ahmad Fauzan</div>
                </a>
                <a href="{{ route('quick-login', 'instructor') }}" class="p-2 rounded-xl bg-purple-500/10 hover:bg-purple-500/20 text-purple-400 border border-purple-500/30 text-center text-xs font-bold transition-all">
                    <div>Instruktur</div>
                    <div class="text-[9px] font-normal text-purple-300/70">Dr. Eng. Rian</div>
                </a>
                <a href="{{ route('quick-login', 'admin') }}" class="p-2 rounded-xl bg-sky-500/10 hover:bg-sky-500/20 text-sky-400 border border-sky-500/30 text-center text-xs font-bold transition-all">
                    <div>Admin</div>
                    <div class="text-[9px] font-normal text-sky-300/70">Prof. Koordinator</div>
                </a>
            </div>
        </div>

        <!-- Login Form -->
        <div class="rounded-3xl bg-slate-900 border border-slate-800 p-8 shadow-2xl space-y-5">
            <form method="POST" action="{{ route('login.post') }}" class="space-y-4">
                @csrf

                <div>
                    <label class="block text-xs font-bold text-slate-300 uppercase tracking-wider mb-1">Email:</label>
                    <input type="email" name="email" value="{{ old('email', 'peserta@pkm-ai.ac.id') }}" class="w-full px-4 py-2.5 rounded-xl bg-slate-950 border border-slate-700 text-xs text-white focus:ring-1 focus:ring-indigo-500" required>
                    @error('email')
                        <p class="text-[11px] text-rose-400 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <div class="flex justify-between items-center mb-1">
                        <label class="block text-xs font-bold text-slate-300 uppercase tracking-wider">Kata Sandi:</label>
                        <span class="text-[11px] text-slate-500">Default: password</span>
                    </div>
                    <input type="password" name="password" value="password" class="w-full px-4 py-2.5 rounded-xl bg-slate-950 border border-slate-700 text-xs text-white focus:ring-1 focus:ring-indigo-500" required>
                </div>

                <div class="flex items-center justify-between text-xs">
                    <label class="flex items-center gap-2 cursor-pointer text-slate-400">
                        <input type="checkbox" name="remember" class="w-4 h-4 rounded bg-slate-950 border-slate-700 text-indigo-600 focus:ring-indigo-500">
                        <span>Ingat saya di perangkat ini</span>
                    </label>
                </div>

                <button type="submit" class="w-full py-3 rounded-xl font-bold text-xs bg-indigo-600 hover:bg-indigo-500 text-white shadow-lg shadow-indigo-600/25 transition-all">
                    Masuk ke Akun &rarr;
                </button>
            </form>

            <div class="text-center text-xs text-slate-400 border-t border-slate-800 pt-4">
                Belum memiliki akun peserta? 
                <a href="{{ route('register') }}" class="text-indigo-400 font-bold hover:underline">
                    Daftar di sini
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

