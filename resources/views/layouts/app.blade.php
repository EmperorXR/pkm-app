<!DOCTYPE html>
<html lang="id" class="h-full bg-slate-900 text-slate-100">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'PKM AI Training' }} - Pelatihan AI SPK & Sistem Terdistribusi</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=JetBrains+Mono:wght@400;500;600&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Plus Jakarta Sans', system-ui, -apple-system, sans-serif;
        }
        code, pre, .font-mono {
            font-family: 'JetBrains Mono', monospace;
        }
        .gradient-text {
            background: linear-gradient(135deg, #38bdf8 0%, #818cf8 50%, #c084fc 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .gradient-border {
            border-image: linear-gradient(135deg, #38bdf8, #818cf8, #c084fc) 1;
        }
        .glow-node {
            box-shadow: 0 0 25px -5px rgba(56, 189, 248, 0.35);
        }
    </style>
    @stack('styles')
</head>
<body class="min-h-full flex flex-col bg-slate-950 text-slate-200 antialiased selection:bg-indigo-500 selection:text-white">

    <!-- Top Announcement Bar -->
    <div class="bg-gradient-to-r from-indigo-950 via-slate-900 to-sky-950 border-b border-indigo-500/20 px-4 py-2 text-xs no-print">
        <div class="max-w-7xl mx-auto flex flex-wrap items-center justify-between gap-2">
            <div class="flex items-center gap-2 text-slate-300">
                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-semibold bg-emerald-500/10 text-emerald-400 border border-emerald-500/30">
                    LIVE PKM 2026
                </span>
                <span>Program Kemitraan Masyarakat: Pelatihan AI untuk Sistem Pendukung Keputusan & Sistem Terdistribusi</span>
            </div>
            <div class="flex items-center gap-3 text-slate-400">
                <span>Demo Akses Cepat:</span>
                <a href="{{ route('quick-login', 'admin') }}" class="hover:text-indigo-400 text-[11px] underline">Admin</a>
                <span>•</span>
                <a href="{{ route('quick-login', 'instructor') }}" class="hover:text-sky-400 text-[11px] underline">Instruktur</a>
                <span>•</span>
                <a href="{{ route('quick-login', 'participant') }}" class="hover:text-emerald-400 text-[11px] underline">Peserta</a>
            </div>
        </div>
    </div>

    <!-- Navigation Header -->
    <header class="sticky top-0 z-50 backdrop-blur-xl bg-slate-950/80 border-b border-slate-800/80">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <!-- Brand Logo -->
                <div class="flex items-center gap-3">
                    <a href="{{ route('home') }}" class="flex items-center gap-3 group">
                        <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-indigo-600 via-sky-500 to-cyan-400 p-0.5 glow-node transition-transform group-hover:scale-105">
                            <div class="w-full h-full bg-slate-950 rounded-[10px] flex items-center justify-center">
                                <svg class="w-5 h-5 text-sky-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                </svg>
                            </div>
                        </div>
                        <div>
                            <div class="font-extrabold text-base tracking-tight text-white flex items-center gap-1.5">
                                PKM <span class="gradient-text font-black">AI & DIST</span>
                            </div>
                            <div class="text-[10px] text-slate-400 uppercase tracking-widest font-medium">DSS & Cloud Cluster</div>
                        </div>
                    </a>
                </div>

                <!-- Desktop Navigation Links -->
                <nav class="hidden md:flex items-center gap-1">
                    <a href="{{ route('home') }}" class="px-3 py-2 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('home') ? 'bg-indigo-600/10 text-indigo-400 border border-indigo-500/20' : 'text-slate-300 hover:text-white hover:bg-slate-900' }}">
                        Beranda
                    </a>
                    <a href="{{ route('tracks.index') }}" class="px-3 py-2 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('tracks.*') || request()->routeIs('modules.*') ? 'bg-indigo-600/10 text-indigo-400 border border-indigo-500/20' : 'text-slate-300 hover:text-white hover:bg-slate-900' }}">
                        Jalur Pelatihan
                    </a>
                    <a href="{{ route('labs.spk') }}" class="px-3 py-2 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('labs.spk*') ? 'bg-indigo-600/10 text-indigo-400 border border-indigo-500/20' : 'text-slate-300 hover:text-white hover:bg-slate-900' }}">
                        Lab AI DSS
                    </a>
                    <a href="{{ route('labs.distributed') }}" class="px-3 py-2 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('labs.distributed*') ? 'bg-indigo-600/10 text-indigo-400 border border-indigo-500/20' : 'text-slate-300 hover:text-white hover:bg-slate-900' }}">
                        Lab Klaster Terdistribusi
                    </a>
                    <a href="{{ route('discussions.index') }}" class="px-3 py-2 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('discussions.*') ? 'bg-indigo-600/10 text-indigo-400 border border-indigo-500/20' : 'text-slate-300 hover:text-white hover:bg-slate-900' }}">
                        Forum Diskusi
                    </a>
                    <a href="{{ route('certificates.index') }}" class="px-3 py-2 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('certificates.index') || request()->routeIs('certificates.show') || request()->routeIs('certificates.sample') ? 'bg-indigo-600/10 text-indigo-400 border border-indigo-500/20' : 'text-slate-300 hover:text-white hover:bg-slate-900' }}">
                        E-Sertifikat
                    </a>
                    <a href="{{ route('certificates.verify') }}" class="px-3 py-2 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('certificates.verify') ? 'bg-indigo-600/10 text-indigo-400 border border-indigo-500/20' : 'text-slate-300 hover:text-white hover:bg-slate-900' }}">
                        Verifikasi
                    </a>
                </nav>

                <!-- User Profile / Auth Area -->
                <div class="flex items-center gap-3">
                    @auth
                        @if(Auth::user()->isInstructor() || Auth::user()->isAdmin())
                            <a href="{{ route('admin.dashboard') }}" class="hidden sm:inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-semibold bg-purple-500/10 text-purple-300 border border-purple-500/30 hover:bg-purple-500/20 transition-colors">
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                </svg>
                                Dashboard {{ Auth::user()->isAdmin() ? 'Admin' : 'Instruktur' }}
                            </a>
                        @endif

                        <div class="relative group">
                            <button type="button" class="flex items-center gap-2 p-1.5 rounded-xl hover:bg-slate-900 border border-transparent hover:border-slate-800 transition-colors">
                                <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-indigo-500 to-sky-500 flex items-center justify-center text-white font-bold text-xs uppercase shadow-inner">
                                    {{ substr(Auth::user()->name, 0, 2) }}
                                </div>
                                <div class="text-left hidden lg:block">
                                    <div class="text-xs font-semibold text-white leading-tight">{{ Str::limit(Auth::user()->name, 16) }}</div>
                                    <div class="text-[10px] text-slate-400 capitalize">{{ Auth::user()->role }}</div>
                                </div>
                                <svg class="w-4 h-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>

                            <!-- Dropdown Menu -->
                            <div class="absolute right-0 mt-1 w-52 bg-slate-900 rounded-xl shadow-2xl border border-slate-800 py-2 hidden group-hover:block hover:block z-50">
                                <div class="px-4 py-2 border-b border-slate-800">
                                    <div class="text-xs font-medium text-slate-400">Masuk sebagai:</div>
                                    <div class="text-xs font-bold text-white truncate">{{ Auth::user()->email }}</div>
                                </div>
                                <a href="{{ route('registration.index') }}" class="block px-4 py-2 text-xs text-slate-300 hover:text-white hover:bg-slate-800">
                                    Pendaftaran Saya
                                </a>
                                <a href="{{ route('certificates.index') }}" class="block px-4 py-2 text-xs text-slate-300 hover:text-white hover:bg-slate-800">
                                    Sertifikat Saya
                                </a>
                                @if(Auth::user()->isInstructor())
                                    <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 text-xs text-purple-300 hover:bg-slate-800">
                                        Panel Dashboard
                                    </a>
                                @endif
                                <div class="border-t border-slate-800 my-1"></div>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="w-full text-left px-4 py-2 text-xs text-rose-400 hover:bg-rose-500/10">
                                        Keluar (Logout)
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="px-3.5 py-1.5 rounded-lg text-xs font-semibold text-slate-200 hover:text-white hover:bg-slate-900 border border-slate-800 transition-colors">
                            Masuk
                        </a>
                        <a href="{{ route('register') }}" class="px-3.5 py-1.5 rounded-lg text-xs font-semibold bg-gradient-to-r from-indigo-500 to-sky-500 text-white hover:from-indigo-400 hover:to-sky-400 shadow-md shadow-indigo-500/20 transition-all">
                            Daftar Pelatihan
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </header>

    <!-- Global Notification Alerts -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4 w-full">
        @if(session('success'))
            <div class="flex items-center gap-3 p-4 rounded-xl bg-emerald-950/80 border border-emerald-500/30 text-emerald-200 text-sm shadow-lg mb-4">
                <svg class="w-5 h-5 text-emerald-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <div class="flex-1">{{ session('success') }}</div>
            </div>
        @endif

        @if(session('error'))
            <div class="flex items-center gap-3 p-4 rounded-xl bg-rose-950/80 border border-rose-500/30 text-rose-200 text-sm shadow-lg mb-4">
                <svg class="w-5 h-5 text-rose-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <div class="flex-1">{{ session('error') }}</div>
            </div>
        @endif

        @if(session('warning'))
            <div class="flex items-center gap-3 p-4 rounded-xl bg-amber-950/80 border border-amber-500/30 text-amber-200 text-sm shadow-lg mb-4">
                <svg class="w-5 h-5 text-amber-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
                <div class="flex-1">{{ session('warning') }}</div>
            </div>
        @endif

        @if(session('info'))
            <div class="flex items-center gap-3 p-4 rounded-xl bg-sky-950/80 border border-sky-500/30 text-sky-200 text-sm shadow-lg mb-4">
                <svg class="w-5 h-5 text-sky-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <div class="flex-1">{{ session('info') }}</div>
            </div>
        @endif
    </div>

    <!-- Main Body Content -->
    <main class="flex-1">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="mt-20 border-t border-slate-800 bg-slate-950/90 text-slate-400 text-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div class="md:col-span-2 space-y-4">
                    <div class="flex items-center gap-2">
                        <div class="w-8 h-8 rounded-lg bg-indigo-600 flex items-center justify-center text-white font-bold text-sm">AI</div>
                        <span class="font-extrabold text-white text-base">Program Pelatihan PKM AI 2026</span>
                    </div>
                    <p class="text-xs text-slate-400 leading-relaxed max-w-lg">
                        Kegiatan Pengabdian kepada Masyarakat (PKM) berfokus pada peningkatan kompetensi talenta digital di bidang <strong>Artificial Intelligence untuk Sistem Pendukung Keputusan (SPK/DSS)</strong> serta perancangan <strong>Arsitektur Sistem Terdistribusi (Distributed Systems)</strong> berkinerja tinggi.
                    </p>
                    <div class="flex items-center gap-3 text-xs text-slate-500">
                        <span>Pusat Riset Kecerdasan Artifisial</span>
                        <span>•</span>
                        <span>Laboratorium Cloud & Terdistribusi</span>
                    </div>
                </div>

                <div>
                    <h4 class="text-xs font-semibold text-white uppercase tracking-wider mb-3">Menu Pelatihan</h4>
                    <ul class="space-y-2 text-xs">
                        <li><a href="{{ route('tracks.show', 'ai-sistem-pendukung-keputusan') }}" class="hover:text-indigo-400 transition-colors">Track AI untuk SPK (SAW & TOPSIS)</a></li>
                        <li><a href="{{ route('tracks.show', 'sistem-terdistribusi-komputasi-ai') }}" class="hover:text-sky-400 transition-colors">Track Arsitektur Sistem Terdistribusi</a></li>
                        <li><a href="{{ route('labs.spk') }}" class="hover:text-indigo-400 transition-colors">Kalkulator & Simulator SPK AI</a></li>
                        <li><a href="{{ route('labs.distributed') }}" class="hover:text-sky-400 transition-colors">Simulator Klaster & Konsensus Raft</a></li>
                        <li><a href="{{ route('registration.create') }}" class="hover:text-emerald-400 transition-colors">Pendaftaran Peserta Baru</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="text-xs font-semibold text-white uppercase tracking-wider mb-3">Layanan & Validasi</h4>
                    <ul class="space-y-2 text-xs">
                        <li><a href="{{ route('certificates.verify') }}" class="hover:text-indigo-400 transition-colors">Verifikasi Sertifikat Digital</a></li>
                        <li><a href="{{ route('discussions.index') }}" class="hover:text-indigo-400 transition-colors">Forum Tanya Jawab Ilmiah</a></li>
                        <li><a href="{{ route('login') }}" class="hover:text-indigo-400 transition-colors">Login Portal Peserta</a></li>
                        <li><span class="text-slate-500">Email: pkm-ai@universitas.ac.id</span></li>
                    </ul>
                </div>
            </div>

            <div class="mt-8 pt-6 border-t border-slate-900 flex flex-wrap items-center justify-between gap-4 text-xs text-slate-500">
                <div>&copy; 2026 Program PKM Artificial Intelligence & Sistem Terdistribusi. Hak cipta dilindungi.</div>
                <div class="flex items-center gap-4">
                    <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full bg-slate-900 border border-slate-800 text-[11px] text-slate-400">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                        Cluster Nodes Online
                    </span>
                    <span>Laravel v13 & PHP 8.5</span>
                </div>
            </div>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>

