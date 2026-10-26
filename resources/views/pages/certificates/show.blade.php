@extends('layouts.app', ['title' => 'E-Sertifikat - ' . $certificate->certificate_number])

@push('styles')
<!-- Luxury & Academic Typography -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@500;700;800;900&family=Playfair+Display:ital,wght@0,600;0,700;0,900;1,600&family=Alex+Brush&family=Montserrat:wght@400;500;600;700;800&display=swap" rel="stylesheet">

<style>
    .font-cinzel { font-family: 'Cinzel', serif; }
    .font-playfair { font-family: 'Playfair Display', serif; }
    .font-script { font-family: 'Alex Brush', cursive; }
    .font-montserrat { font-family: 'Montserrat', sans-serif; }

    /* Metallic Gold Shimmer Gradients */
    .gold-gradient-text {
        background: linear-gradient(135deg, #fef08a 0%, #facc15 30%, #d97706 70%, #fef08a 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }
    .gold-border {
        border-image: linear-gradient(135deg, #fef08a 0%, #eab308 35%, #b45309 70%, #fde047 100%) 1;
    }
    .gold-shine-box {
        background: radial-gradient(circle at 50% 0%, rgba(250, 204, 21, 0.15), transparent 70%);
    }

    /* Subtle Geometric Background Watermark */
    .cert-bg-pattern {
        background-color: #0b0f19;
        background-image: 
            radial-gradient(at 0% 0%, rgba(99, 102, 241, 0.12) 0px, transparent 50%),
            radial-gradient(at 100% 100%, rgba(217, 119, 6, 0.12) 0px, transparent 50%),
            radial-gradient(circle, rgba(255, 255, 255, 0.03) 1px, transparent 1px);
        background-size: 100% 100%, 100% 100%, 24px 24px;
    }

    /* Traditional Light Ivory Mode */
    .cert-light-mode {
        background-color: #faf9f5 !important;
        background-image: radial-gradient(circle, rgba(0, 0, 0, 0.04) 1px, transparent 1px) !important;
        background-size: 20px 20px !important;
        color: #0f172a !important;
    }
    .cert-light-mode .text-white { color: #0f172a !important; }
    .cert-light-mode .text-slate-200 { color: #1e293b !important; }
    .cert-light-mode .text-slate-300 { color: #334155 !important; }
    .cert-light-mode .text-slate-400 { color: #475569 !important; }
    .cert-light-mode .bg-slate-900\/80,
    .cert-light-mode .bg-slate-900,
    .cert-light-mode .bg-slate-950 { background-color: #f1f0ea !important; border-color: #e2e0d8 !important; }
    .cert-light-mode .border-slate-800 { border-color: #dcd9cf !important; }
    .cert-light-mode .cert-inner-border { border-color: #ca8a04 !important; }

    /* =================================================================== */
    /* Strict 1-Page A4 Landscape Print Styles                             */
    /* =================================================================== */
    @page {
        size: A4 landscape;
        margin: 0;
    }

    @media print {
        /* Hide all website navigation, announcement bars, headers, footers */
        header, footer, nav, aside, .no-print, body > div.bg-gradient-to-r {
            display: none !important;
        }

        /* Enforce root document to single-page A4 landscape */
        html, body {
            width: 297mm !important;
            height: 210mm !important;
            max-width: 297mm !important;
            max-height: 210mm !important;
            min-height: 210mm !important;
            margin: 0 !important;
            padding: 0 !important;
            overflow: hidden !important;
            background: #ffffff !important;
            color: #0f172a !important;
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
            page-break-after: avoid !important;
            page-break-before: avoid !important;
            page-break-inside: avoid !important;
            break-inside: avoid !important;
            break-after: avoid !important;
        }

        main {
            margin: 0 !important;
            padding: 0 !important;
            width: 297mm !important;
            height: 210mm !important;
            max-height: 210mm !important;
            overflow: hidden !important;
            display: block !important;
        }

        .cert-page-container {
            margin: 0 !important;
            padding: 0 !important;
            width: 297mm !important;
            height: 210mm !important;
            max-height: 210mm !important;
            min-height: 0 !important;
            background: #ffffff !important;
            overflow: hidden !important;
        }

        .cert-wrapper {
            margin: 0 !important;
            padding: 0 !important;
            width: 297mm !important;
            height: 210mm !important;
            max-height: 210mm !important;
            max-width: 297mm !important;
            overflow: hidden !important;
        }

        /* Certificate Master Frame strictly calibrated for 210mm page height */
        .cert-canvas {
            width: 297mm !important;
            height: 210mm !important;
            max-height: 210mm !important;
            box-sizing: border-box !important;
            margin: 0 !important;
            padding: 7mm 12mm 5mm 12mm !important;
            border: 5px solid #b45309 !important;
            background: #ffffff !important;
            background-image: none !important;
            color: #0f172a !important;
            box-shadow: none !important;
            border-radius: 0 !important;
            page-break-inside: avoid !important;
            page-break-after: avoid !important;
            page-break-before: avoid !important;
            break-inside: avoid !important;
            break-after: avoid !important;
            overflow: hidden !important;
            display: flex !important;
            flex-direction: column !important;
            justify-content: space-between !important;
        }

        /* Ornate borders in print */
        .cert-inner-border {
            inset: 3mm 5mm !important;
            border-width: 1.5px !important;
            border-color: #ca8a04 !important;
            border-radius: 6px !important;
        }
        .cert-outer-border {
            inset: 4.5mm 6.5mm !important;
            border-width: 1px !important;
            border-color: rgba(202, 138, 4, 0.4) !important;
            border-radius: 4px !important;
        }
        .cert-corner-ornament {
            width: 28px !important;
            height: 28px !important;
            color: #ca8a04 !important;
        }
        .cert-corner-tl { top: 6mm !important; left: 8mm !important; }
        .cert-corner-tr { top: 6mm !important; right: 8mm !important; }
        .cert-corner-bl { bottom: 6mm !important; left: 8mm !important; }
        .cert-corner-br { bottom: 6mm !important; right: 8mm !important; }

        /* Inner Content Flow */
        .cert-inner-content {
            height: 100% !important;
            max-width: 100% !important;
            padding: 0 !important;
            margin: 0 auto !important;
            display: flex !important;
            flex-direction: column !important;
            justify-content: space-between !important;
            gap: 0 !important;
        }
        .cert-inner-content > * {
            margin-top: 0 !important;
            margin-bottom: 0 !important;
        }

        /* Text colors in print */
        .text-white { color: #0f172a !important; }
        .text-slate-200, .text-slate-300 { color: #334155 !important; }
        .text-slate-400 { color: #475569 !important; }
        .gold-gradient-text {
            color: #b45309 !important;
            -webkit-text-fill-color: #b45309 !important;
            background: none !important;
        }

        /* 1. Header Section */
        .cert-sec-header {
            margin-bottom: 1.5mm !important;
        }
        .cert-sec-header .w-12 {
            width: 26px !important;
            height: 26px !important;
        }
        .cert-sec-header svg {
            width: 14px !important;
            height: 14px !important;
        }
        .cert-sec-header .font-cinzel {
            font-size: 8pt !important;
            color: #b45309 !important;
            letter-spacing: 0.25em !important;
        }
        .cert-sec-header .font-montserrat {
            font-size: 7pt !important;
            color: #475569 !important;
            letter-spacing: 0.15em !important;
        }
        .cert-sec-header .text-\[10px\] {
            font-size: 6.5pt !important;
            color: #64748b !important;
        }

        /* 2. Title Section */
        .cert-sec-title {
            margin-bottom: 1.5mm !important;
        }
        .cert-sec-title h1 {
            font-size: 20pt !important;
            line-height: 1.1 !important;
            color: #b45309 !important;
            -webkit-text-fill-color: #b45309 !important;
            letter-spacing: 0.12em !important;
            margin-bottom: 0.5mm !important;
        }
        .cert-sec-title .font-montserrat {
            font-size: 7pt !important;
            letter-spacing: 0.2em !important;
            color: #334155 !important;
        }
        .cert-sec-title .font-mono {
            font-size: 7pt !important;
            background: #faf8f0 !important;
            color: #b45309 !important;
            border-color: #ca8a04 !important;
            padding: 1px 8px !important;
        }

        /* 3. Recipient Section */
        .cert-sec-recipient {
            margin-bottom: 1.5mm !important;
        }
        .cert-sec-recipient p {
            font-size: 7pt !important;
            color: #64748b !important;
            margin-bottom: 0.5mm !important;
        }
        .cert-sec-recipient .font-playfair {
            font-size: 21pt !important;
            line-height: 1.1 !important;
            color: #0f172a !important;
        }
        .cert-sec-recipient .w-48 {
            width: 130px !important;
            height: 1.5px !important;
            background: #d97706 !important;
            margin-top: 1mm !important;
            margin-bottom: 1mm !important;
        }
        .cert-sec-recipient .text-slate-300 {
            font-size: 7.5pt !important;
            color: #334155 !important;
        }

        /* 4. Statement & Track Highlight */
        .cert-sec-badge {
            margin-bottom: 2mm !important;
            max-width: 90% !important;
        }
        .cert-sec-badge > p {
            font-size: 7pt !important;
            line-height: 1.25 !important;
            color: #334155 !important;
            margin-bottom: 1mm !important;
        }
        .cert-sec-badge .bg-slate-900\/90 {
            background-color: #faf9f5 !important;
            border: 1.5px solid #d97706 !important;
            border-radius: 8px !important;
            padding: 2mm 4mm !important;
            box-shadow: none !important;
        }
        .cert-sec-badge .font-cinzel.text-base {
            font-size: 10.5pt !important;
            color: #0f172a !important;
            line-height: 1.2 !important;
        }
        .cert-sec-badge .text-\[10px\] {
            font-size: 6.5pt !important;
            color: #b45309 !important;
        }
        .cert-sec-badge .rounded-full {
            font-size: 6.5pt !important;
            padding: 1px 6px !important;
            border-color: #cbd5e1 !important;
            background: #ffffff !important;
            color: #0f172a !important;
        }

        /* 5. Signatures, 3D Seal Medal & Verification */
        .cert-sec-signatures {
            margin-top: auto !important;
            padding-top: 2mm !important;
            border-top: 1px solid rgba(217, 119, 6, 0.3) !important;
            display: grid !important;
            grid-template-columns: repeat(3, minmax(0, 1fr)) !important;
            gap: 3mm !important;
            align-items: flex-end !important;
        }
        .cert-sec-signatures .font-script {
            font-size: 18pt !important;
            color: #1e293b !important;
            height: 24px !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
        }
        .cert-sec-signatures .border-t {
            border-top-color: #cbd5e1 !important;
            padding-top: 1mm !important;
        }
        .cert-sec-signatures .font-montserrat.font-bold {
            font-size: 7.5pt !important;
            color: #0f172a !important;
        }
        .cert-sec-signatures .text-slate-400 {
            font-size: 6.5pt !important;
            color: #475569 !important;
        }
        .cert-sec-signatures .font-mono {
            font-size: 6pt !important;
            color: #64748b !important;
        }

        /* 3D Seal Medal sizing in print */
        .cert-sec-signatures .w-28 {
            width: 48px !important;
            height: 48px !important;
        }
        .cert-sec-signatures .w-20 {
            width: 38px !important;
            height: 38px !important;
            border-width: 1.5px !important;
        }
        .cert-sec-signatures .w-28 svg {
            width: 11px !important;
            height: 11px !important;
        }
        .cert-sec-signatures .font-cinzel.text-\[7px\] {
            font-size: 4.5pt !important;
            line-height: 1 !important;
        }
        .cert-sec-signatures .text-\[6px\] {
            font-size: 4pt !important;
        }
        .cert-sec-signatures .text-\[10px\].font-mono {
            font-size: 6.5pt !important;
            color: #b45309 !important;
        }
        .cert-sec-signatures .text-\[9px\] {
            font-size: 6pt !important;
            color: #64748b !important;
        }

        /* 6. Footer verification microtext bar */
        .cert-sec-footer {
            margin-top: 1.5mm !important;
            padding-top: 1.5mm !important;
            border-top: 1px solid #e2e8f0 !important;
            font-size: 5.5pt !important;
            color: #64748b !important;
            display: flex !important;
            flex-direction: row !important;
            justify-content: space-between !important;
            align-items: center !important;
        }
        .cert-sec-footer .w-2 {
            width: 4px !important;
            height: 4px !important;
            background-color: #059669 !important;
        }
    }
</style>
@endpush

@section('content')
<div class="cert-page-container py-10 bg-slate-950 text-slate-100 min-h-screen">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6 cert-wrapper">
        
        <!-- Control Header & Theme Switcher (Screen only) -->
        <div class="flex flex-wrap items-center justify-between gap-4 no-print bg-slate-900/90 border border-slate-800/80 p-4 rounded-2xl backdrop-blur-md shadow-xl">
            <div class="flex items-center gap-3">
                <a href="{{ route('certificates.index') }}" class="px-3 py-1.5 rounded-xl bg-slate-800 hover:bg-slate-700 text-xs font-semibold text-slate-300 hover:text-white transition-colors flex items-center gap-1.5">
                    &larr; <span>Daftar Sertifikat</span>
                </a>
                <span class="text-xs text-slate-500 hidden sm:inline">&bull;</span>
                <span class="text-xs text-slate-400 font-mono hidden sm:inline">{{ $certificate->certificate_number }}</span>
            </div>

            <!-- Action buttons -->
            <div class="flex items-center gap-2">
                <!-- Theme toggle: Dark Cyber Gold vs Classic Ivory -->
                <button type="button" onclick="toggleTheme()" id="themeBtn" class="px-3.5 py-2 rounded-xl text-xs font-bold bg-slate-800 hover:bg-slate-700 text-amber-300 border border-amber-500/30 transition-all flex items-center gap-1.5">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                    <span id="themeBtnText">Mode Kertas Klasik</span>
                </button>

                <!-- Copy Link -->
                <button type="button" onclick="copyCertLink()" id="copyBtn" class="px-3.5 py-2 rounded-xl text-xs font-semibold bg-slate-800 hover:bg-slate-700 text-slate-200 border border-slate-700 transition-colors flex items-center gap-1.5">
                    <svg class="w-4 h-4 text-sky-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                    </svg>
                    <span id="copyText">Salin Tautan</span>
                </button>

                <!-- Print / Save as PDF -->
                <button type="button" onclick="window.print()" class="px-4 py-2 rounded-xl text-xs font-bold bg-gradient-to-r from-amber-500 via-yellow-500 to-amber-600 text-slate-950 shadow-lg shadow-amber-500/25 hover:brightness-110 transition-all flex items-center gap-1.5" title="Format cetak otomatis 1 halaman A4 Landscape">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                    </svg>
                    <span>Cetak / Unduh PDF (1 Halaman A4)</span>
                </button>
            </div>
        </div>

        <!-- =================================================================== -->
        <!-- THE CERTIFICATE MASTER CANVAS (Prestige Edition)                    -->
        <!-- =================================================================== -->
        <div id="certCanvas" class="cert-canvas cert-bg-pattern relative rounded-[32px] p-6 sm:p-12 md:p-16 shadow-[0_25px_60px_-15px_rgba(0,0,0,0.9)] overflow-hidden transition-all duration-300 border-2 border-amber-500/40">

            <!-- Ornate Double Gold Outer Border Frame -->
            <div class="absolute inset-3 sm:inset-5 border-2 border-amber-500/50 rounded-[24px] pointer-events-none cert-inner-border"></div>
            <div class="absolute inset-5 sm:inset-7 border border-amber-400/20 rounded-[20px] pointer-events-none cert-outer-border"></div>

            <!-- Intricate Gold Corner Ornaments (SVG) -->
            <!-- Top-Left Corner -->
            <div class="absolute top-6 left-6 w-16 h-16 pointer-events-none text-amber-400/70 cert-corner-ornament cert-corner-tl">
                <svg viewBox="0 0 100 100" fill="currentColor">
                    <path d="M0 0 L50 0 L50 6 L6 6 L6 50 L0 50 Z M12 12 L38 12 L38 16 L16 16 L16 38 L12 38 Z" />
                    <circle cx="26" cy="26" r="4" />
                </svg>
            </div>
            <!-- Top-Right Corner -->
            <div class="absolute top-6 right-6 w-16 h-16 pointer-events-none text-amber-400/70 rotate-90 cert-corner-ornament cert-corner-tr">
                <svg viewBox="0 0 100 100" fill="currentColor">
                    <path d="M0 0 L50 0 L50 6 L6 6 L6 50 L0 50 Z M12 12 L38 12 L38 16 L16 16 L16 38 L12 38 Z" />
                    <circle cx="26" cy="26" r="4" />
                </svg>
            </div>
            <!-- Bottom-Left Corner -->
            <div class="absolute bottom-6 left-6 w-16 h-16 pointer-events-none text-amber-400/70 -rotate-90 cert-corner-ornament cert-corner-bl">
                <svg viewBox="0 0 100 100" fill="currentColor">
                    <path d="M0 0 L50 0 L50 6 L6 6 L6 50 L0 50 Z M12 12 L38 12 L38 16 L16 16 L16 38 L12 38 Z" />
                    <circle cx="26" cy="26" r="4" />
                </svg>
            </div>
            <!-- Bottom-Right Corner -->
            <div class="absolute bottom-6 right-6 w-16 h-16 pointer-events-none text-amber-400/70 rotate-180 cert-corner-ornament cert-corner-br">
                <svg viewBox="0 0 100 100" fill="currentColor">
                    <path d="M0 0 L50 0 L50 6 L6 6 L6 50 L0 50 Z M12 12 L38 12 L38 16 L16 16 L16 38 L12 38 Z" />
                    <circle cx="26" cy="26" r="4" />
                </svg>
            </div>

            <!-- Certificate Inner Content Container -->
            <div class="cert-inner-content relative z-10 text-center space-y-8 py-4 sm:py-6 max-w-4xl mx-auto">

                <!-- 1. Top Institutional Crest & Seal -->
                <div class="cert-sec-header space-y-3">
                    <div class="flex items-center justify-center gap-3">
                        <div class="w-12 h-12 rounded-2xl bg-gradient-to-tr from-amber-500 via-indigo-600 to-sky-400 p-0.5 shadow-lg shadow-amber-500/20">
                            <div class="w-full h-full bg-slate-950 rounded-[14px] flex items-center justify-center">
                                <svg class="w-6 h-6 text-amber-400" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-1">
                        <div class="font-cinzel text-[11px] sm:text-xs tracking-[0.3em] font-extrabold uppercase text-amber-400">
                            KEMENTERIAN PENDIDIKAN, KEBUDAYAAN, RISET, DAN TEKNOLOGI
                        </div>
                        <div class="font-montserrat text-[10px] sm:text-[11px] uppercase tracking-[0.2em] text-slate-400">
                            PROGRAM PENGABDIAN KEPADA MASYARAKAT (PKM) 2026
                        </div>
                        <div class="text-[10px] text-slate-500 font-medium">
                            Pusat Riset Kecerdasan Artifisial &bull; Laboratorium Sistem Cerdas & Terdistribusi
                        </div>
                    </div>

                    <!-- Decorative Gold Divider Line -->
                    <div class="flex items-center justify-center gap-4 py-1">
                        <div class="w-16 sm:w-28 h-px bg-gradient-to-r from-transparent to-amber-400"></div>
                        <div class="text-amber-400 font-cinzel text-xs">&starf; &starf; &starf;</div>
                        <div class="w-16 sm:w-28 h-px bg-gradient-to-l from-transparent to-amber-400"></div>
                    </div>
                </div>

                <!-- 2. Certificate Title -->
                <div class="cert-sec-title space-y-2">
                    <h1 class="font-cinzel text-3xl sm:text-5xl lg:text-6xl font-black tracking-[0.15em] gold-gradient-text uppercase drop-shadow-sm">
                        SERTIFIKAT KELULUSAN
                    </h1>
                    <div class="font-montserrat text-xs sm:text-sm font-semibold tracking-[0.25em] uppercase text-slate-300">
                        CERTIFICATE OF COMPETENCY & EXCELLENCE
                    </div>
                    <div class="pt-1">
                        <span class="inline-block px-4 py-1 rounded-full bg-slate-900/90 border border-amber-500/30 text-[11px] font-mono text-amber-300 tracking-wider">
                            REG. NO: {{ $certificate->certificate_number }}
                        </span>
                    </div>
                </div>

                <!-- 3. Recipient Presentation -->
                <div class="cert-sec-recipient space-y-3 pt-2">
                    <p class="font-montserrat text-xs sm:text-sm uppercase tracking-[0.2em] text-slate-400 italic">
                        Diberikan dengan penuh kehormatan kepada:
                    </p>

                    <!-- Student Name in Magnificent Calligraphy / Serif -->
                    <div class="py-2">
                        <div class="font-playfair text-3xl sm:text-5xl lg:text-6xl font-bold text-white tracking-wide leading-tight drop-shadow-md">
                            {{ $certificate->user->name }}
                        </div>
                        <div class="w-48 sm:w-72 h-1 bg-gradient-to-r from-transparent via-amber-400 to-transparent mx-auto mt-2 rounded-full"></div>
                    </div>

                    @if($certificate->user->institution)
                        <div class="font-montserrat text-xs sm:text-sm font-medium text-slate-300">
                            {{ $certificate->user->institution }}
                        </div>
                    @endif
                </div>

                <!-- 4. Course Recognition Statement -->
                <div class="cert-sec-badge max-w-3xl mx-auto space-y-4 px-4">
                    <p class="text-xs sm:text-sm text-slate-300 leading-relaxed font-montserrat">
                        Atas keberhasilan dan dedikasi menyelesaikan seluruh kurikulum teori, praktikum hands-on laboratorium, serta dinyatakan <strong class="text-amber-300 font-bold uppercase tracking-wide">LULUS & KOMPETEN</strong> pada pelatihan:
                    </p>

                    <!-- Track Highlight Badge -->
                    <div class="p-5 sm:p-6 rounded-2xl bg-slate-900/90 border-2 border-amber-500/40 shadow-inner space-y-2">
                        <div class="text-[10px] font-cinzel tracking-[0.2em] uppercase text-amber-400 font-bold">
                            BIDANG KEAHLIAN KOMPETENSI
                        </div>
                        <div class="font-cinzel text-base sm:text-2xl font-black text-white tracking-wide">
                            "{{ $certificate->track->title }}"
                        </div>
                        <div class="flex flex-wrap items-center justify-center gap-3 pt-2 text-xs text-slate-300 font-montserrat">
                            <span class="inline-flex items-center gap-1.5 px-3 py-0.5 rounded-full bg-amber-500/10 text-amber-300 border border-amber-500/30 font-semibold text-[11px]">
                                Skor Evaluasi: <strong class="font-mono text-white">{{ $certificate->final_score }}%</strong>
                            </span>
                            <span class="inline-flex items-center gap-1.5 px-3 py-0.5 rounded-full bg-emerald-500/10 text-emerald-300 border border-emerald-500/30 font-semibold text-[11px]">
                                Predikat: <strong>Sangat Memuaskan</strong>
                            </span>
                            <span class="inline-flex items-center gap-1.5 px-3 py-0.5 rounded-full bg-sky-500/10 text-sky-300 border border-sky-500/30 font-semibold text-[11px]">
                                Durasi: <strong>{{ $certificate->track->duration_hours }} Jam Pelatihan</strong>
                            </span>
                        </div>
                    </div>
                </div>

                <!-- 5. Signatures, Golden Foil Emblem & QR Verification Seal -->
                <div class="cert-sec-signatures pt-8 border-t border-amber-500/20 grid grid-cols-1 md:grid-cols-3 gap-8 items-end">
                    
                    <!-- Left: Instruktur Utama Signature -->
                    <div class="space-y-3 text-center md:text-left">
                        <div class="h-16 flex items-center justify-center md:justify-start">
                            <div class="font-script text-3xl sm:text-4xl text-amber-300 transform -rotate-3 select-none">
                                Rian Pratama
                            </div>
                        </div>
                        <div class="border-t border-slate-700/80 pt-2 space-y-0.5">
                            <div class="font-montserrat font-bold text-xs sm:text-sm text-white">{{ $certificate->track->instructor_name }}</div>
                            <div class="text-[10px] sm:text-[11px] text-slate-400">Ketua Bidang Kurikulum & Modul AI</div>
                            <div class="text-[9px] font-mono text-slate-500">NIP: 198409152010121003</div>
                        </div>
                    </div>

                    <!-- Center: 3D Holographic Foil Emblem & Digital Seal -->
                    <div class="flex flex-col items-center justify-center space-y-3">
                        <!-- Golden Starburst Seal Medal -->
                        <div class="relative w-28 h-28 flex items-center justify-center">
                            <!-- Outer 32-point rosette -->
                            <div class="absolute inset-0 rounded-full bg-gradient-to-tr from-amber-600 via-yellow-400 to-amber-700 p-1 shadow-2xl animate-pulse">
                                <div class="w-full h-full rounded-full border-2 border-dashed border-slate-950 flex items-center justify-center bg-gradient-to-b from-yellow-300 via-amber-400 to-yellow-500">
                                </div>
                            </div>
                            <!-- Inner medal disc -->
                            <div class="relative z-10 w-20 h-20 rounded-full bg-gradient-to-b from-amber-700 via-yellow-500 to-amber-900 border-2 border-yellow-200 shadow-inner flex flex-col items-center justify-center text-slate-950 p-2">
                                <svg class="w-5 h-5 text-slate-950 mb-0.5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                </svg>
                                <div class="font-cinzel text-[7px] font-black tracking-widest text-center leading-tight uppercase">
                                    PKM AI<br>RESMI
                                </div>
                                <div class="text-[6px] font-bold tracking-tighter uppercase font-mono mt-0.5">
                                    2026
                                </div>
                            </div>
                        </div>

                        <!-- Cryptographic verification snippet -->
                        <div class="text-center space-y-1">
                            <div class="text-[10px] font-mono text-amber-300 font-bold tracking-wider">
                                {{ $certificate->verify_code }}
                            </div>
                            <div class="text-[9px] text-slate-400">
                                Diterbitkan: {{ $certificate->issue_date->format('d F Y') }}
                            </div>
                        </div>
                    </div>

                    <!-- Right: Koordinator PKM Signature & QR Code -->
                    <div class="space-y-3 text-center md:text-right">
                        <div class="h-16 flex items-center justify-center md:justify-end">
                            <div class="font-script text-3xl sm:text-4xl text-amber-300 transform -rotate-1 select-none">
                                Prof. Administrator
                            </div>
                        </div>
                        <div class="border-t border-slate-700/80 pt-2 space-y-0.5">
                            <div class="font-montserrat font-bold text-xs sm:text-sm text-white">Prof. Dr. Ir. Administrator PKM</div>
                            <div class="text-[10px] sm:text-[11px] text-slate-400">Koordinator Pelaksana Pengabdian</div>
                            <div class="text-[9px] font-mono text-slate-500">NIP: 197503201999031002</div>
                        </div>
                    </div>
                </div>

                <!-- 6. Footer Verification Microtext Bar -->
                <div class="cert-sec-footer pt-6 border-t border-slate-800/60 flex flex-col sm:flex-row items-center justify-between gap-3 text-[10px] text-slate-500 font-mono">
                    <div class="flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                        <span>KEASLIAN DOKUMEN DAPAT DIVERIFIKASI SECARA ELEKTRONIK PADA PORTAL RESMI PKM AI</span>
                    </div>
                    <div>
                        HASH: SHA256_{{ strtoupper(substr(hash('sha256', $certificate->certificate_number . $certificate->verify_code), 0, 16)) }}
                    </div>
                </div>

            </div>
        </div>

        <!-- Verification Banner below Certificate (Screen only) -->
        <div class="rounded-2xl bg-slate-900 border border-slate-800 p-6 no-print flex flex-col sm:flex-row items-center justify-between gap-4 shadow-xl">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-emerald-500/10 text-emerald-400 flex items-center justify-center font-bold text-xl shrink-0">
                    &check;
                </div>
                <div>
                    <div class="text-sm font-bold text-white">Sertifikat Sah & Terdaftar Resmi</div>
                    <div class="text-xs text-slate-400">
                        Siapa pun dapat memeriksa validitas sertifikat ini secara publik dengan kode verifikasi <strong class="text-amber-400 font-mono">{{ $certificate->verify_code }}</strong>.
                    </div>
                </div>
            </div>

            <a href="{{ route('certificates.verify', ['code' => $certificate->verify_code]) }}" target="_blank" class="px-5 py-2.5 rounded-xl text-xs font-bold bg-slate-800 hover:bg-slate-700 text-sky-400 border border-slate-700 transition-colors whitespace-nowrap">
                Uji Halaman Verifikasi Publik &rarr;
            </a>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    let isLightMode = false;

    function toggleTheme() {
        const canvas = document.getElementById('certCanvas');
        const btnText = document.getElementById('themeBtnText');
        
        if (!isLightMode) {
            canvas.classList.add('cert-light-mode');
            canvas.classList.remove('cert-bg-pattern');
            btnText.innerText = 'Mode Gelap Cyber';
            isLightMode = true;
        } else {
            canvas.classList.remove('cert-light-mode');
            canvas.classList.add('cert-bg-pattern');
            btnText.innerText = 'Mode Kertas Klasik';
            isLightMode = false;
        }
    }

    function copyCertLink() {
        const url = window.location.href;
        navigator.clipboard.writeText(url).then(() => {
            const copyText = document.getElementById('copyText');
            copyText.innerText = 'Tersalin!';
            setTimeout(() => {
                copyText.innerText = 'Salin Tautan';
            }, 2500);
        }).catch(err => {
            console.error('Failed to copy link', err);
        });
    }
</script>
@endpush
