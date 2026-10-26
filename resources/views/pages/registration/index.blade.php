@extends('layouts.app', ['title' => 'Pendaftaran Pelatihan Saya'])

@section('content')
<div class="py-12 bg-slate-950">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <span class="text-xs font-bold uppercase tracking-wider text-indigo-400">Status Keikutsertaan</span>
                <h1 class="text-3xl font-black text-white">Pendaftaran Pelatihan Saya</h1>
                <p class="text-sm text-slate-400">
                    Daftar jalur kurikulum PKM AI yang telah Anda ikuti dan status kelas aktif.
                </p>
            </div>
            <a href="{{ route('registration.create') }}" class="px-5 py-2.5 rounded-xl text-xs font-bold bg-indigo-600 hover:bg-indigo-500 text-white shadow-lg shadow-indigo-600/25 transition-all">
                + Daftar Jalur Lain
            </a>
        </div>

        @if(count($registrations) > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @foreach($registrations as $reg)
                    <div class="rounded-3xl bg-slate-900 border border-slate-800 p-8 flex flex-col justify-between hover:border-slate-700 transition-all shadow-xl">
                        <div class="space-y-4">
                            <div class="flex items-center justify-between">
                                <span class="px-3 py-1 rounded-full text-xs font-bold bg-emerald-500/10 text-emerald-400 border border-emerald-500/30 uppercase">
                                    {{ $reg->status }}
                                </span>
                                <span class="font-mono text-xs text-slate-400 font-bold">{{ $reg->registration_code }}</span>
                            </div>

                            <h3 class="text-xl font-bold text-white">
                                {{ $reg->track->title }}
                            </h3>

                            <div class="grid grid-cols-2 gap-3 p-3.5 rounded-xl bg-slate-950 border border-slate-800/80 text-xs">
                                <div>
                                    <div class="text-slate-500 text-[10px]">Tanggal Terdaftar:</div>
                                    <div class="text-slate-200 font-medium">{{ $reg->registered_at->format('d M Y') }}</div>
                                </div>
                                <div>
                                    <div class="text-slate-500 text-[10px]">Tingkat Kemampuan:</div>
                                    <div class="text-slate-200 font-medium">{{ $reg->prior_experience }}</div>
                                </div>
                            </div>

                            <p class="text-xs text-slate-400 italic">
                                "{{ $reg->motivation_reason }}"
                            </p>
                        </div>

                        <div class="pt-6 border-t border-slate-800 flex items-center justify-between gap-4 mt-6">
                            <span class="text-xs text-slate-400">
                                Instruktur: <strong class="text-white">{{ $reg->track->instructor_name }}</strong>
                            </span>
                            <a href="{{ route('tracks.show', $reg->track->slug) }}" class="px-4 py-2 rounded-xl text-xs font-bold bg-indigo-600 hover:bg-indigo-500 text-white transition-colors">
                                Masuk ke Kelas &rarr;
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="rounded-3xl bg-slate-900 border border-slate-800 p-12 text-center space-y-4 max-w-lg mx-auto">
                <div class="w-16 h-16 rounded-full bg-slate-800 text-slate-500 mx-auto flex items-center justify-center font-bold text-2xl">
                    &plus;
                </div>
                <div class="text-lg font-bold text-white">Anda Belum Terdaftar pada Jalur Pelatihan</div>
                <p class="text-xs text-slate-400 leading-relaxed">
                    Pilih jalur pelatihan AI untuk SPK atau Sistem Terdistribusi untuk mendapatkan materi, modul praktikum, dan sertifikat kompetensi.
                </p>
                <div class="pt-2">
                    <a href="{{ route('registration.create') }}" class="px-5 py-2.5 rounded-xl text-xs font-bold bg-indigo-600 hover:bg-indigo-500 text-white transition-colors">
                        Daftar Pelatihan Sekarang &rarr;
                    </a>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection

