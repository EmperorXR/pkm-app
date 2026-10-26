@extends('layouts.app', ['title' => 'Verifikasi Sertifikat Digital PKM AI'])

@section('content')
<div class="py-12 bg-slate-950">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
        <!-- Header -->
        <div class="text-center space-y-3">
            <span class="text-xs font-bold uppercase tracking-wider text-indigo-400">Public Document Verification</span>
            <h1 class="text-3xl font-black text-white">Verifikasi Keaslian E-Sertifikat</h1>
            <p class="text-sm text-slate-400 max-w-xl mx-auto">
                Sistem verifikasi terbuka untuk memastikan keaslian sertifikat kelulusan yang diterbitkan oleh Program Pengabdian kepada Masyarakat (PKM) AI 2026.
            </p>
        </div>

        <!-- Verification Search Card -->
        <div class="rounded-3xl bg-slate-900 border border-slate-800 p-8 shadow-2xl space-y-4">
            <form method="GET" action="{{ route('certificates.verify') }}" class="space-y-4">
                <div>
                    <label class="block text-xs font-bold text-slate-300 uppercase tracking-wider mb-2">
                        Masukkan Nomor Sertifikat atau Kode Verifikasi:
                    </label>
                    <div class="flex gap-2">
                        <input type="text" name="code" value="{{ $code }}" placeholder="Contoh: PKM-SPK-V9B71C atau CERT/PKM-AI/SPK/2026/0089" class="flex-1 px-4 py-3 rounded-xl bg-slate-950 border border-slate-700 text-sm text-white font-mono focus:ring-2 focus:ring-indigo-500 focus:outline-none" required>
                        <button type="submit" class="px-6 py-3 rounded-xl font-bold text-xs bg-indigo-600 hover:bg-indigo-500 text-white shadow-lg shadow-indigo-600/25 transition-all">
                            Cek Validitas
                        </button>
                    </div>
                </div>

                <!-- Sample Clickable Codes for Evaluator -->
                <div class="flex flex-wrap items-center gap-2 text-xs text-slate-400 pt-2 border-t border-slate-800">
                    <span>Contoh Kode Uji Coba:</span>
                    <a href="{{ route('certificates.verify', ['code' => 'PKM-SPK-V9B71C']) }}" class="px-2 py-0.5 rounded bg-slate-950 border border-slate-800 font-mono text-[11px] text-indigo-300 hover:text-white">
                        PKM-SPK-V9B71C
                    </a>
                    <a href="{{ route('certificates.verify', ['code' => 'CERT/PKM-AI/SPK/2026/0089']) }}" class="px-2 py-0.5 rounded bg-slate-950 border border-slate-800 font-mono text-[11px] text-sky-300 hover:text-white">
                        CERT/PKM-AI/SPK/2026/0089
                    </a>
                </div>
            </form>
        </div>

        <!-- Verification Result -->
        @if($searched)
            @if($certificate)
                <div class="rounded-3xl {{ $certificate->status === 'valid' ? 'bg-gradient-to-br from-emerald-950/70 via-slate-900 to-slate-950 border-emerald-500/40' : 'bg-gradient-to-br from-rose-950/70 via-slate-900 to-slate-950 border-rose-500/40' }} border p-8 shadow-2xl space-y-6">
                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 rounded-2xl {{ $certificate->status === 'valid' ? 'bg-emerald-500/20 text-emerald-400' : 'bg-rose-500/20 text-rose-400' }} flex items-center justify-center font-bold text-2xl shrink-0">
                            {{ $certificate->status === 'valid' ? '✓' : '!' }}
                        </div>
                        <div>
                            <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider {{ $certificate->status === 'valid' ? 'bg-emerald-500/10 text-emerald-400 border border-emerald-500/30' : 'bg-rose-500/10 text-rose-400 border border-rose-500/30' }}">
                                STATUS: {{ strtoupper($certificate->status) }}
                            </span>
                            <h2 class="text-xl font-bold text-white mt-1">
                                {{ $certificate->status === 'valid' ? 'Dokumen Sertifikat Asli & Terverifikasi' : 'Sertifikat Telah Dicabut (Revoked)' }}
                            </h2>
                        </div>
                    </div>

                    <!-- Certificate Metadata Details -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 p-5 rounded-2xl bg-slate-950 border border-slate-800 text-xs">
                        <div>
                            <div class="text-slate-500 text-[10px]">Nama Penerima:</div>
                            <div class="text-sm font-bold text-white mt-0.5">{{ $certificate->user->name }}</div>
                            <div class="text-[11px] text-slate-400">{{ $certificate->user->institution ?? 'Peserta PKM AI' }}</div>
                        </div>

                        <div>
                            <div class="text-slate-500 text-[10px]">Nomor Sertifikat:</div>
                            <div class="font-mono text-xs font-bold text-indigo-400 mt-0.5">{{ $certificate->certificate_number }}</div>
                            <div class="text-[11px] text-slate-400">Kode Unik: {{ $certificate->verify_code }}</div>
                        </div>

                        <div>
                            <div class="text-slate-500 text-[10px]">Kurikulum Pelatihan:</div>
                            <div class="text-xs font-semibold text-white mt-0.5">{{ $certificate->track->title }}</div>
                        </div>

                        <div>
                            <div class="text-slate-500 text-[10px]">Tanggal Penerbitan & Nilai:</div>
                            <div class="text-xs text-slate-200 mt-0.5">
                                {{ $certificate->issue_date->format('d F Y') }} &bull; Nilai: <strong class="text-emerald-400 font-mono">{{ $certificate->final_score }}%</strong>
                            </div>
                        </div>
                    </div>

                    @if($certificate->status === 'valid')
                        <div class="text-center pt-2">
                            <a href="{{ route('certificates.show', $certificate->certificate_number) }}" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl text-xs font-bold bg-indigo-600 hover:bg-indigo-500 text-white transition-colors">
                                Lihat Dokumen Sertifikat Lengkap &rarr;
                            </a>
                        </div>
                    @endif
                </div>
            @else
                <div class="rounded-3xl bg-slate-900 border border-rose-500/30 p-8 text-center space-y-3">
                    <div class="w-12 h-12 rounded-full bg-rose-500/10 text-rose-400 mx-auto flex items-center justify-center font-bold text-xl">
                        &cross;
                    </div>
                    <div class="text-base font-bold text-white">Sertifikat Tidak Ditemukan</div>
                    <p class="text-xs text-slate-400 max-w-md mx-auto">
                        Nomor atau kode verifikasi <strong>"{{ $code }}"</strong> tidak terdaftar dalam database sertifikasi PKM AI 2026. Mohon periksa kembali karakter yang Anda masukkan.
                    </p>
                </div>
            @endif
        @endif
    </div>
</div>
@endsection

