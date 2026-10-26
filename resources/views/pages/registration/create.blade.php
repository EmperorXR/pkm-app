@extends('layouts.app', ['title' => 'Formulir Pendaftaran Pelatihan PKM AI'])

@section('content')
<div class="py-12 bg-slate-950">
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
        <!-- Header -->
        <div class="text-center space-y-3">
            <span class="text-xs font-bold uppercase tracking-wider text-emerald-400">Registrasi Peserta Baru</span>
            <h1 class="text-3xl font-black text-white">Formulir Pendaftaran Pelatihan</h1>
            <p class="text-sm text-slate-400">
                Program Pengabdian kepada Masyarakat: Kecerdasan Artifisial untuk Sistem Pendukung Keputusan dan Sistem Terdistribusi.
            </p>
        </div>

        @guest
            <div class="rounded-2xl bg-slate-900 border border-indigo-500/30 p-6 text-center space-y-3">
                <div class="text-xs font-bold text-white">Sudah Punya Akun atau Ingin Coba Demo Langsung?</div>
                <p class="text-xs text-slate-400">
                    Gunakan login instan peserta demo untuk mencoba tanpa mengisi form dari awal.
                </p>
                <div class="flex justify-center gap-3 pt-1">
                    <a href="{{ route('quick-login', 'participant') }}" class="px-4 py-2 rounded-xl text-xs font-bold bg-indigo-600 hover:bg-indigo-500 text-white transition-colors">
                        Masuk sebagai Peserta Demo &rarr;
                    </a>
                    <a href="{{ route('login') }}" class="px-4 py-2 rounded-xl text-xs font-semibold bg-slate-800 text-slate-200 border border-slate-700">
                        Login Akun
                    </a>
                </div>
            </div>
        @endguest

        <div class="rounded-3xl bg-slate-900 border border-slate-800 p-8 shadow-2xl space-y-6">
            <form method="POST" action="{{ route('registration.store') }}" class="space-y-5">
                @csrf

                <!-- Track Selection -->
                <div class="space-y-2">
                    <label class="block text-xs font-bold text-slate-300 uppercase tracking-wider">
                        Pilih Jalur Kurikulum Pelatihan: *
                    </label>
                    <div class="space-y-2">
                        @foreach($tracks as $t)
                            <label class="flex items-start gap-3 p-4 rounded-2xl bg-slate-950 border border-slate-800 hover:border-indigo-500/50 cursor-pointer transition-all">
                                <input type="radio" name="training_track_id" value="{{ $t->id }}" class="mt-1 w-4 h-4 text-indigo-600 bg-slate-900 border-slate-700 focus:ring-indigo-500" {{ (old('training_track_id', $selectedTrackId) == $t->id || $loop->first) ? 'checked' : '' }} required>
                                <div>
                                    <div class="text-xs font-bold text-white">{{ $t->title }}</div>
                                    <div class="text-[11px] text-slate-400 mt-1">{{ Str::limit($t->description, 110) }}</div>
                                    <div class="text-[10px] text-indigo-400 mt-1 font-semibold">{{ $t->duration_hours }} Jam &bull; {{ $t->level }}</div>
                                </div>
                            </label>
                        @endforeach
                    </div>
                </div>

                <!-- Prior Experience -->
                <div class="space-y-2">
                    <label class="block text-xs font-bold text-slate-300 uppercase tracking-wider">
                        Tingkat Pengalaman Sebelumnya: *
                    </label>
                    <select name="prior_experience" class="w-full px-4 py-2.5 rounded-xl bg-slate-950 border border-slate-700 text-xs text-white focus:ring-1 focus:ring-indigo-500" required>
                        <option value="Pemula (Dasar)">Pemula (Belum pernah belajar AI / Sistem Terdistribusi)</option>
                        <option value="Menengah" selected>Menengah (Memahami dasar pemrograman & basis data)</option>
                        <option value="Mahir">Mahir (Sudah terbiasa dengan Python, Docker, atau Machine Learning)</option>
                    </select>
                </div>

                <!-- Institution & Phone -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="space-y-2">
                        <label class="block text-xs font-bold text-slate-300 uppercase tracking-wider">
                            Institusi / Universitas / Lembaga:
                        </label>
                        <input type="text" name="institution" value="{{ old('institution', Auth::user()->institution ?? '') }}" placeholder="Contoh: Universitas Indonesia" class="w-full px-4 py-2.5 rounded-xl bg-slate-950 border border-slate-700 text-xs text-white focus:ring-1 focus:ring-indigo-500">
                    </div>

                    <div class="space-y-2">
                        <label class="block text-xs font-bold text-slate-300 uppercase tracking-wider">
                            Nomor WhatsApp / Kontak:
                        </label>
                        <input type="text" name="phone" value="{{ old('phone', Auth::user()->phone ?? '') }}" placeholder="Contoh: 081234567890" class="w-full px-4 py-2.5 rounded-xl bg-slate-950 border border-slate-700 text-xs text-white focus:ring-1 focus:ring-indigo-500">
                    </div>
                </div>

                <!-- Motivation -->
                <div class="space-y-2">
                    <label class="block text-xs font-bold text-slate-300 uppercase tracking-wider">
                        Motivasi / Alasan Mengikuti Pelatihan: *
                    </label>
                    <textarea name="motivation_reason" rows="3" placeholder="Tuliskan tujuan dan harapan Anda mengikuti pelatihan ini..." class="w-full px-4 py-2.5 rounded-xl bg-slate-950 border border-slate-700 text-xs text-white focus:ring-1 focus:ring-indigo-500" required>{{ old('motivation_reason', 'Ingin mendalami kecerdasan artifisial dan arsitektur sistem terdistribusi untuk pengembangan riset dan aplikasi praktis.') }}</textarea>
                </div>

                <!-- Submit Button -->
                <div class="pt-4">
                    <button type="submit" class="w-full py-3.5 rounded-xl font-bold text-xs bg-gradient-to-r from-emerald-500 to-teal-500 text-white shadow-lg shadow-emerald-500/25 hover:opacity-95 transition-all">
                        Daftarkan Diri Sekarang &rarr;
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

