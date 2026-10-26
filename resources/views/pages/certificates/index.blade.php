@extends('layouts.app', ['title' => 'Portal E-Sertifikat Digital PKM AI'])

@section('content')
<div class="py-12 bg-slate-950">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-10">
        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div class="space-y-2">
                <span class="text-xs font-bold uppercase tracking-wider text-emerald-400">Pusat Sertifikasi Kompetensi</span>
                <h1 class="text-3xl font-black text-white">E-Sertifikat Digital Resmi PKM AI</h1>
                <p class="text-sm text-slate-400 max-w-2xl">
                    Sertifikat resmi kelulusan pelatihan Artificial Intelligence untuk Sistem Pendukung Keputusan dan Sistem Terdistribusi yang dilengkapi QR verifikasi keaslian digital.
                </p>
            </div>
            <div class="flex flex-wrap items-center gap-3">
                <a href="{{ route('certificates.sample') }}" target="_blank" class="px-5 py-2.5 rounded-xl text-xs font-bold bg-gradient-to-r from-emerald-500 to-teal-500 text-white shadow-lg shadow-emerald-500/25 hover:opacity-95 transition-all flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                    <span>Buka Contoh Sertifikat Live &rarr;</span>
                </a>
                <a href="{{ route('certificates.verify') }}" class="px-4 py-2.5 rounded-xl text-xs font-semibold bg-slate-900 hover:bg-slate-800 text-slate-200 border border-slate-700 transition-colors">
                    Verifikasi Dokumen
                </a>
            </div>
        </div>

        @auth
            <!-- Authenticated User Certificates -->
            <div class="space-y-4">
                <h2 class="text-lg font-bold text-white flex items-center gap-2">
                    <span>Sertifikat Milik Saya:</span>
                    <span class="px-2 py-0.5 rounded-full text-xs bg-indigo-500/10 text-indigo-400 border border-indigo-500/20">
                        {{ count($certificates) }} Diterbitkan
                    </span>
                </h2>

                @if(count($certificates) > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @foreach($certificates as $cert)
                            <div class="rounded-3xl bg-slate-900 border border-emerald-500/30 p-8 flex flex-col justify-between hover:border-emerald-500/60 transition-all shadow-xl space-y-6">
                                <div class="space-y-4">
                                    <div class="flex items-center justify-between">
                                        <span class="px-3 py-1 rounded-full text-xs font-bold {{ $cert->status === 'valid' ? 'bg-emerald-500/10 text-emerald-400 border border-emerald-500/30' : 'bg-rose-500/10 text-rose-400 border border-rose-500/30' }}">
                                            STATUS: {{ strtoupper($cert->status) }}
                                        </span>
                                        <span class="font-mono text-xs text-indigo-400 font-bold">{{ $cert->certificate_number }}</span>
                                    </div>

                                    <h3 class="text-xl font-bold text-white leading-snug">
                                        {{ $cert->track->title }}
                                    </h3>

                                    <div class="grid grid-cols-2 gap-3 p-3.5 rounded-xl bg-slate-950 border border-slate-800/80 text-xs">
                                        <div>
                                            <div class="text-slate-500 text-[10px]">Nilai Kelulusan:</div>
                                            <div class="text-base font-bold text-emerald-400 font-mono">{{ $cert->final_score }}%</div>
                                        </div>
                                        <div>
                                            <div class="text-slate-500 text-[10px]">Tanggal Terbit:</div>
                                            <div class="text-slate-200 font-medium">{{ $cert->issue_date->format('d M Y') }}</div>
                                        </div>
                                    </div>
                                </div>

                                <div class="pt-4 border-t border-slate-800 flex flex-wrap items-center justify-between gap-4">
                                    <div class="text-[11px] text-slate-400 font-mono">
                                        Kode Verifikasi: <strong class="text-white">{{ $cert->verify_code }}</strong>
                                    </div>
                                    <a href="{{ route('certificates.show', $cert->certificate_number) }}" class="px-5 py-2.5 rounded-xl text-xs font-bold bg-indigo-600 hover:bg-indigo-500 text-white shadow-md shadow-indigo-600/20 transition-all flex items-center gap-1.5">
                                        <span>Buka & Cetak Sertifikat</span>
                                        <span>&rarr;</span>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="rounded-3xl bg-slate-900 border border-slate-800 p-8 text-center space-y-4">
                        <div class="text-base font-bold text-white">Anda Belum Memiliki Sertifikat</div>
                        <p class="text-xs text-slate-400 max-w-md mx-auto">
                            Selesaikan modul pada salah satu jalur pelatihan dan raih skor minimal 70% pada ujian evaluasi untuk otomatis menerbitkan sertifikat atas nama Anda.
                        </p>
                        <div class="pt-2 flex justify-center gap-3">
                            <a href="{{ route('tracks.index') }}" class="px-5 py-2.5 rounded-xl text-xs font-bold bg-indigo-600 hover:bg-indigo-500 text-white transition-colors">
                                Pilih Jalur Pelatihan & Ujian &rarr;
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        @else
            <!-- Guest Prompt Box -->
            <div class="rounded-3xl bg-gradient-to-r from-indigo-950 via-slate-900 to-sky-950 border border-indigo-500/30 p-8 flex flex-col md:flex-row items-center justify-between gap-6">
                <div class="space-y-2 text-center md:text-left">
                    <div class="text-lg font-bold text-white">Ingin Melihat Sertifikat Milik Anda atau Menguji Akun Demo?</div>
                    <p class="text-xs text-slate-300 max-w-xl">
                        Masuk menggunakan akun peserta demo untuk melihat sertifikat terverifikasi atas nama <strong>Ahmad Fauzan</strong>.
                    </p>
                </div>
                <div class="flex flex-wrap items-center gap-3 shrink-0">
                    <a href="{{ route('quick-login', 'participant') }}" class="px-5 py-2.5 rounded-xl text-xs font-bold bg-emerald-600 hover:bg-emerald-500 text-white shadow-lg shadow-emerald-600/20 transition-all">
                        Login Cepat Peserta Demo &rarr;
                    </a>
                    <a href="{{ route('login') }}" class="px-4 py-2.5 rounded-xl text-xs font-semibold bg-slate-800 hover:bg-slate-700 text-slate-200 border border-slate-700 transition-colors">
                        Masuk Akun Sendiri
                    </a>
                </div>
            </div>
        @endauth

        <!-- Sample Certificates Gallery (Always visible so anyone can preview!) -->
        <div class="space-y-4 pt-6 border-t border-slate-900">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-lg font-bold text-white">Galeri E-Sertifikat Terverifikasi</h2>
                    <p class="text-xs text-slate-400">Contoh sertifikat resmi yang telah diterbitkan pada kegiatan PKM AI.</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @foreach($sampleCertificates as $sample)
                    <div class="rounded-3xl bg-slate-900/60 border border-slate-800 p-6 flex flex-col justify-between hover:border-slate-700 transition-all">
                        <div class="space-y-3">
                            <div class="flex items-center justify-between">
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">
                                    TERVERIFIKASI
                                </span>
                                <span class="font-mono text-xs text-slate-400">{{ $sample->certificate_number }}</span>
                            </div>

                            <div class="text-base font-bold text-white">
                                {{ $sample->track->title }}
                            </div>

                            <div class="text-xs text-slate-300 flex items-center justify-between pt-1">
                                <span>Penerima: <strong class="text-white">{{ $sample->user->name }}</strong></span>
                                <span class="font-mono text-emerald-400 font-bold">Skor: {{ $sample->final_score }}%</span>
                            </div>
                        </div>

                        <div class="pt-4 border-t border-slate-800/80 flex items-center justify-between gap-2 mt-4">
                            <span class="text-[11px] text-slate-500 font-mono">Kode: {{ $sample->verify_code }}</span>
                            <a href="{{ route('certificates.show', $sample->certificate_number) }}" target="_blank" class="px-4 py-2 rounded-xl text-xs font-bold bg-slate-800 hover:bg-slate-700 text-sky-400 border border-slate-700 transition-colors">
                                Lihat Dokumen Sertifikat &rarr;
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
