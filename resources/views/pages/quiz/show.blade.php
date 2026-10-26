@extends('layouts.app', ['title' => 'Ujian Evaluasi - ' . $quiz->title])

@section('content')
<div class="py-10 bg-slate-950">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Breadcrumb -->
        <nav class="flex items-center gap-2 text-xs text-slate-400 mb-6">
            <a href="{{ route('home') }}" class="hover:text-white">Beranda</a>
            <span>/</span>
            <a href="{{ route('tracks.show', $quiz->track->slug) }}" class="hover:text-white">{{ $quiz->track->title }}</a>
            <span>/</span>
            <span class="text-slate-200">Ujian Evaluasi</span>
        </nav>

        <!-- Quiz Header Card -->
        <div class="rounded-3xl bg-slate-900 border border-slate-800 p-8 shadow-2xl mb-8 space-y-4">
            <div class="flex flex-wrap items-center justify-between gap-4">
                <span class="px-3 py-1 rounded-full text-xs font-semibold bg-indigo-500/10 text-indigo-400 border border-indigo-500/30">
                    Evaluasi Kompetensi Resmi
                </span>
                <div class="flex items-center gap-2 px-3 py-1.5 rounded-xl bg-slate-950 border border-slate-800 text-xs text-slate-300 font-mono" id="quizTimerBox">
                    <svg class="w-4 h-4 text-amber-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>Sisa Waktu: <strong id="timerText">20:00</strong></span>
                </div>
            </div>

            <h1 class="text-2xl sm:text-3xl font-black text-white leading-tight">
                {{ $quiz->title }}
            </h1>

            <p class="text-xs sm:text-sm text-slate-300 leading-relaxed">
                {{ $quiz->description }}
            </p>

            <div class="pt-2 flex flex-wrap items-center gap-6 text-xs text-slate-400 border-t border-slate-800">
                <span>Total Soal: <strong class="text-white">{{ $quiz->questions->count() }} Pilihan Ganda</strong></span>
                <span>Passing Grade: <strong class="text-emerald-400">{{ $quiz->passing_score }}%</strong></span>
                <span>Sertifikasi: <strong class="text-sky-400">Otomatis Diterbitkan jika Lulus</strong></span>
            </div>
        </div>

        @guest
            <div class="rounded-2xl bg-amber-950/60 border border-amber-500/30 p-6 text-center space-y-3 mb-8">
                <div class="text-sm font-bold text-amber-200">Anda Belum Masuk ke Akun Peserta</div>
                <p class="text-xs text-slate-300 max-w-md mx-auto">
                    Untuk menyimpan nilai ujian evaluasi dan mendapatkan E-Sertifikat digital terverifikasi atas nama Anda, silakan masuk terlebih dahulu.
                </p>
                <div class="flex justify-center gap-3 pt-2">
                    <a href="{{ route('quick-login', 'participant') }}" class="px-4 py-2 rounded-xl text-xs font-bold bg-emerald-600 hover:bg-emerald-500 text-white transition-colors">
                        Masuk Cepat Peserta Demo &rarr;
                    </a>
                    <a href="{{ route('login') }}" class="px-4 py-2 rounded-xl text-xs font-bold bg-slate-800 hover:bg-slate-700 text-slate-200 border border-slate-700 transition-colors">
                        Login Akun Sendiri
                    </a>
                </div>
            </div>
        @endguest

        <!-- Quiz Form -->
        <form method="POST" action="{{ route('quiz.submit', $quiz->slug) }}" id="quizForm" class="space-y-6">
            @csrf

            @foreach($quiz->questions as $q)
                <div class="rounded-2xl bg-slate-900 border border-slate-800 p-6 sm:p-8 space-y-4 hover:border-slate-700 transition-all">
                    <div class="flex items-start gap-4">
                        <span class="w-8 h-8 rounded-xl bg-indigo-500/10 text-indigo-400 border border-indigo-500/20 flex items-center justify-center font-bold text-xs shrink-0">
                            {{ $q->order_number }}
                        </span>
                        <div class="space-y-4 flex-1">
                            <h3 class="text-sm sm:text-base font-semibold text-white leading-relaxed">
                                {{ $q->question_text }}
                            </h3>

                            <!-- Options -->
                            <div class="space-y-2">
                                @foreach(['A' => $q->option_a, 'B' => $q->option_b, 'C' => $q->option_c, 'D' => $q->option_d] as $key => $opt)
                                    <label class="flex items-center gap-3 p-3.5 rounded-xl bg-slate-950 border border-slate-800 hover:border-indigo-500/50 hover:bg-slate-800/60 cursor-pointer transition-all group">
                                        <input type="radio" name="answers[{{ $q->id }}]" value="{{ $key }}" class="w-4 h-4 text-indigo-600 bg-slate-900 border-slate-700 focus:ring-indigo-500" required>
                                        <span class="font-mono font-bold text-xs text-indigo-400 group-hover:text-indigo-300">{{ $key }}.</span>
                                        <span class="text-xs text-slate-300 group-hover:text-white">{{ $opt }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach

            <!-- Submit Button Bar -->
            <div class="rounded-2xl bg-slate-900 border border-slate-800 p-6 flex flex-wrap items-center justify-between gap-4 sticky bottom-6 shadow-2xl backdrop-blur-md">
                <div class="text-xs text-slate-400">
                    Pastikan seluruh jawaban telah terisi sebelum menekan tombol kirim.
                </div>
                <button type="submit" class="px-8 py-3 rounded-xl font-bold text-xs bg-gradient-to-r from-emerald-500 to-teal-500 text-white shadow-lg shadow-emerald-500/25 hover:opacity-95 transition-all">
                    Kirim Jawaban & Selesaikan Evaluasi &rarr;
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // 20 Minutes countdown
    let timeLeft = {{ $quiz->time_limit_minutes }} * 60;
    const timerText = document.getElementById('timerText');

    const countdown = setInterval(() => {
        if (timeLeft <= 0) {
            clearInterval(countdown);
            alert('Waktu ujian telah berakhir! Jawaban Anda akan dikirimkan otomatis.');
            document.getElementById('quizForm').submit();
            return;
        }

        timeLeft--;
        const minutes = Math.floor(timeLeft / 60);
        const seconds = timeLeft % 60;
        timerText.innerText = (minutes < 10 ? '0' : '') + minutes + ':' + (seconds < 10 ? '0' : '') + seconds;

        if (timeLeft < 180) {
            timerText.classList.add('text-rose-400');
        }
    }, 1000);
</script>
@endpush

