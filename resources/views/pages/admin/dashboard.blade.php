@extends('layouts.app', ['title' => 'Dashboard Manajemen - Portal PKM AI'])

@section('content')
<div class="py-10 bg-slate-950">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <span class="text-xs font-bold uppercase tracking-wider text-purple-400">Panel Instruktur & Administrator</span>
                <h1 class="text-3xl font-black text-white">Dashboard Monitoring Pelatihan PKM</h1>
                <p class="text-sm text-slate-400">
                    Pantau metrik peserta, kemajuan evaluasi, penerbitan sertifikat digital, dan keikutsertaan kelas.
                </p>
            </div>
            <div class="flex items-center gap-2">
                <span class="px-3 py-1.5 rounded-xl bg-purple-500/10 text-purple-300 border border-purple-500/30 text-xs font-bold">
                    Role: {{ strtoupper(Auth::user()->role) }}
                </span>
            </div>
        </div>

        <!-- KPI Grid -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <div class="rounded-2xl bg-slate-900 border border-slate-800 p-5 shadow-lg">
                <div class="text-xs font-semibold text-slate-400">Total Peserta Terdaftar</div>
                <div class="text-2xl font-black text-white mt-1">{{ $stats['total_participants'] }}</div>
                <div class="text-[10px] text-slate-500 mt-1">Akun aktif portal</div>
            </div>

            <div class="rounded-2xl bg-slate-900 border border-slate-800 p-5 shadow-lg">
                <div class="text-xs font-semibold text-slate-400">Pendaftaran Jalur</div>
                <div class="text-2xl font-black text-sky-400 mt-1">{{ $stats['total_registrations'] }}</div>
                <div class="text-[10px] text-slate-500 mt-1">Keikutsertaan kelas</div>
            </div>

            <div class="rounded-2xl bg-slate-900 border border-slate-800 p-5 shadow-lg">
                <div class="text-xs font-semibold text-slate-400">Ujian Evaluasi Dikerjakan</div>
                <div class="text-2xl font-black text-indigo-400 mt-1">{{ $stats['total_quiz_attempts'] }}</div>
                <div class="text-[10px] text-emerald-400 mt-1">{{ $stats['passed_attempts'] }} dinyatakan lulus</div>
            </div>

            <div class="rounded-2xl bg-slate-900 border border-slate-800 p-5 shadow-lg">
                <div class="text-xs font-semibold text-slate-400">Sertifikat Resmi Diterbitkan</div>
                <div class="text-2xl font-black text-emerald-400 mt-1">{{ $stats['total_certificates'] }}</div>
                <div class="text-[10px] text-slate-500 mt-1">Terverifikasi digital</div>
            </div>
        </div>

        <!-- Tracks Summary Table -->
        <div class="rounded-3xl bg-slate-900 border border-slate-800 p-6 shadow-xl space-y-4">
            <div class="border-b border-slate-800 pb-3">
                <h2 class="text-base font-bold text-white">Ringkasan Jalur Kurikulum PKM</h2>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-xs text-left">
                    <thead class="text-slate-400 bg-slate-950 uppercase text-[10px] border-b border-slate-800">
                        <tr>
                            <th class="p-3">Jalur Pelatihan</th>
                            <th class="p-3">Instruktur</th>
                            <th class="p-3 text-center">Modul</th>
                            <th class="p-3 text-center">Pendaftar</th>
                            <th class="p-3 text-center">Lulus & Bersertifikat</th>
                            <th class="p-3 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-800 text-slate-200">
                        @foreach($tracks as $t)
                            <tr>
                                <td class="p-3 font-bold text-white">{{ $t->title }}</td>
                                <td class="p-3 text-slate-400">{{ $t->instructor_name }}</td>
                                <td class="p-3 text-center font-mono">{{ $t->modules_count }}</td>
                                <td class="p-3 text-center font-mono font-bold text-sky-400">{{ $t->registrations_count }}</td>
                                <td class="p-3 text-center font-mono font-bold text-emerald-400">{{ $t->certificates_count }}</td>
                                <td class="p-3 text-right">
                                    <a href="{{ route('tracks.show', $t->slug) }}" class="text-indigo-400 hover:text-white font-semibold">
                                        Lihat Silabus &rarr;
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Recent Registrations -->
            <div class="rounded-3xl bg-slate-900 border border-slate-800 p-6 shadow-xl space-y-4">
                <div class="border-b border-slate-800 pb-3">
                    <h3 class="text-base font-bold text-white">Pendaftaran Peserta Terkini</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-xs text-left">
                        <thead class="text-slate-400 bg-slate-950 uppercase text-[10px] border-b border-slate-800">
                            <tr>
                                <th class="p-2.5">Kode</th>
                                <th class="p-2.5">Nama Peserta</th>
                                <th class="p-2.5">Track</th>
                                <th class="p-2.5">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-800 text-slate-300">
                            @foreach($recentRegistrations as $reg)
                                <tr>
                                    <td class="p-2.5 font-mono text-[10px] text-sky-400">{{ $reg->registration_code }}</td>
                                    <td class="p-2.5 font-medium text-white">{{ $reg->user->name }}</td>
                                    <td class="p-2.5 truncate max-w-[150px] text-slate-400">{{ $reg->track->title }}</td>
                                    <td class="p-2.5">
                                        <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase {{ $reg->status === 'approved' ? 'bg-emerald-500/10 text-emerald-400 border border-emerald-500/30' : 'bg-slate-800 text-slate-400' }}">
                                            {{ $reg->status }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Recent Quiz Attempts & Certificates -->
            <div class="rounded-3xl bg-slate-900 border border-slate-800 p-6 shadow-xl space-y-4">
                <div class="border-b border-slate-800 pb-3">
                    <h3 class="text-base font-bold text-white">Riwayat Evaluasi Ujian Terkini</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-xs text-left">
                        <thead class="text-slate-400 bg-slate-950 uppercase text-[10px] border-b border-slate-800">
                            <tr>
                                <th class="p-2.5">Peserta</th>
                                <th class="p-2.5">Kuis</th>
                                <th class="p-2.5 text-center">Skor</th>
                                <th class="p-2.5 text-right">Hasil</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-800 text-slate-300">
                            @foreach($recentAttempts as $att)
                                <tr>
                                    <td class="p-2.5 font-medium text-white">{{ $att->user->name }}</td>
                                    <td class="p-2.5 truncate max-w-[150px] text-slate-400">{{ $att->quiz->title }}</td>
                                    <td class="p-2.5 text-center font-mono font-bold {{ $att->is_passed ? 'text-emerald-400' : 'text-amber-400' }}">
                                        {{ $att->score }}%
                                    </td>
                                    <td class="p-2.5 text-right">
                                        <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase {{ $att->is_passed ? 'bg-emerald-500/10 text-emerald-400 border border-emerald-500/30' : 'bg-amber-500/10 text-amber-400 border border-amber-500/30' }}">
                                            {{ $att->is_passed ? 'Lulus' : 'Gagal' }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Recent Issued Certificates with Status Toggle -->
        <div class="rounded-3xl bg-slate-900 border border-slate-800 p-6 shadow-xl space-y-4">
            <div class="border-b border-slate-800 pb-3">
                <h3 class="text-base font-bold text-white">Daftar Sertifikat Terbit</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-xs text-left">
                    <thead class="text-slate-400 bg-slate-950 uppercase text-[10px] border-b border-slate-800">
                        <tr>
                            <th class="p-3">Nomor Sertifikat</th>
                            <th class="p-3">Nama Penerima</th>
                            <th class="p-3">Jalur Pelatihan</th>
                            <th class="p-3 text-center">Nilai</th>
                            <th class="p-3 text-center">Status</th>
                            <th class="p-3 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-800 text-slate-300">
                        @foreach($recentCertificates as $c)
                            <tr>
                                <td class="p-3 font-mono font-bold text-indigo-400">{{ $c->certificate_number }}</td>
                                <td class="p-3 font-medium text-white">{{ $c->user->name }}</td>
                                <td class="p-3 text-slate-300">{{ $c->track->title }}</td>
                                <td class="p-3 text-center font-mono font-bold text-emerald-400">{{ $c->final_score }}%</td>
                                <td class="p-3 text-center">
                                    <span class="px-2 py-0.5 rounded text-[10px] font-bold uppercase {{ $c->status === 'valid' ? 'bg-emerald-500/10 text-emerald-400 border border-emerald-500/30' : 'bg-rose-500/10 text-rose-400 border border-rose-500/30' }}">
                                        {{ $c->status }}
                                    </span>
                                </td>
                                <td class="p-3 text-right space-x-2">
                                    <a href="{{ route('certificates.show', $c->certificate_number) }}" class="text-xs text-sky-400 hover:underline">
                                        Lihat
                                    </a>
                                    @if(Auth::user()->isAdmin())
                                        <form method="POST" action="{{ route('admin.certificate.toggle', $c->id) }}" class="inline">
                                            @csrf
                                            <button type="submit" class="text-xs {{ $c->status === 'valid' ? 'text-rose-400 hover:text-rose-300' : 'text-emerald-400 hover:text-emerald-300' }} underline">
                                                {{ $c->status === 'valid' ? 'Cabut' : 'Aktifkan' }}
                                            </button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

