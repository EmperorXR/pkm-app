@extends('layouts.app', ['title' => 'Daftar Akun Baru - Portal PKM AI'])

@section('content')
<div class="py-16 bg-slate-950 flex items-center justify-center min-h-[75vh]">
    <div class="w-full max-w-md px-4 sm:px-6 space-y-6">
        <!-- Header -->
        <div class="text-center space-y-2">
            <h1 class="text-2xl font-black text-white">Buat Akun Peserta Baru</h1>
            <p class="text-xs text-slate-400">
                Bergabung dalam pelatihan kecerdasan buatan, sistem pendukung keputusan, dan sistem terdistribusi.
            </p>
        </div>

        <div class="rounded-3xl bg-slate-900 border border-slate-800 p-8 shadow-2xl space-y-5">
            <form method="POST" action="{{ route('register.post') }}" class="space-y-4">
                @csrf

                <div>
                    <label class="block text-xs font-bold text-slate-300 uppercase tracking-wider mb-1">Nama Lengkap: *</label>
                    <input type="text" name="name" value="{{ old('name') }}" placeholder="Contoh: Budi Santoso" class="w-full px-4 py-2.5 rounded-xl bg-slate-950 border border-slate-700 text-xs text-white focus:ring-1 focus:ring-indigo-500" required>
                    @error('name')
                        <p class="text-[11px] text-rose-400 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-300 uppercase tracking-wider mb-1">Alamat Email: *</label>
                    <input type="email" name="email" value="{{ old('email') }}" placeholder="email@instansi.ac.id" class="w-full px-4 py-2.5 rounded-xl bg-slate-950 border border-slate-700 text-xs text-white focus:ring-1 focus:ring-indigo-500" required>
                    @error('email')
                        <p class="text-[11px] text-rose-400 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-300 uppercase tracking-wider mb-1">Institusi / Universitas / Lembaga:</label>
                    <input type="text" name="institution" value="{{ old('institution') }}" placeholder="Contoh: Institut Teknologi Bandung" class="w-full px-4 py-2.5 rounded-xl bg-slate-950 border border-slate-700 text-xs text-white focus:ring-1 focus:ring-indigo-500">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-300 uppercase tracking-wider mb-1">Nomor WhatsApp / Telepon:</label>
                    <input type="text" name="phone" value="{{ old('phone') }}" placeholder="08123456789" class="w-full px-4 py-2.5 rounded-xl bg-slate-950 border border-slate-700 text-xs text-white focus:ring-1 focus:ring-indigo-500">
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-bold text-slate-300 uppercase tracking-wider mb-1">Kata Sandi: *</label>
                        <input type="password" name="password" class="w-full px-4 py-2.5 rounded-xl bg-slate-950 border border-slate-700 text-xs text-white focus:ring-1 focus:ring-indigo-500" required>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-300 uppercase tracking-wider mb-1">Ulangi Sandi: *</label>
                        <input type="password" name="password_confirmation" class="w-full px-4 py-2.5 rounded-xl bg-slate-950 border border-slate-700 text-xs text-white focus:ring-1 focus:ring-indigo-500" required>
                    </div>
                </div>
                @error('password')
                    <p class="text-[11px] text-rose-400 mt-1">{{ $message }}</p>
                @enderror

                <button type="submit" class="w-full py-3 rounded-xl font-bold text-xs bg-indigo-600 hover:bg-indigo-500 text-white shadow-lg shadow-indigo-600/25 transition-all">
                    Daftar Sekarang &rarr;
                </button>
            </form>

            <div class="text-center text-xs text-slate-400 border-t border-slate-800 pt-4">
                Sudah memiliki akun? 
                <a href="{{ route('login') }}" class="text-indigo-400 font-bold hover:underline">
                    Masuk di sini
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

