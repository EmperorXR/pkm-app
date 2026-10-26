@extends('layouts.app', ['title' => 'Hasil Evaluasi - ' . $quiz->title])

@section('content')
<div class="py-12 bg-slate-950">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Results Hero Banner -->
        <div class="rounded-3xl {{ $attempt->is_passed ? 'bg-gradient-to-br from-emerald-950 via-slate-900 to-slate-950 border-emerald-500/40' : 'bg-gradient-to-br from-amber-950 via-slate-900 to-slate-950 border-amber-500/40' }} border p-8 sm:p-12 text-center space-y-6 shadow-2xl mb-10">
            <div class="w-20 h-20 rounded-full {{ $attempt->is_passed ? 'bg-emerald-500/20 text-emerald-400 border border-emerald-500/30' : 'bg-amber-500/20 text-amber-400 border border-amber-500/30' }} mx-auto flex items-center justify-center font-black text-3xl shadow-inner">
                {{ $attempt->is_passed ? '✓' : '!' }}
            </div>

            <div class="space-y-2">
                <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $attempt->is_passed ? 'bg-emerald-500/10 text-emerald-400 border border-emerald-500/30' : 'bg-amber-500/10 text-amber-400 border border-amber-500/30' }}">
                    {{ $attempt->is_passed ? 'KOMPETEN / LULUS' : 'BELUM MEMENUHI PASSING GRADE' }}
                </span>
                <h1 class="text-3xl sm:text-4xl font-black text-white">
                    {{ $attempt->is_passed ? 'Selamat, Anda Lulus Evaluasi!' : 'Tetap Semangat, Anda Belum Lulus' }}
                </h1>
                <p class="text-xs sm:text-sm text-slate-300 max-w-lg mx-auto">
                    {{ $attempt->is_passed 
                        ? 'Kompetensi Anda di bidang ' . $quiz->track->title . ' telah terverifikasi memenuhi standar kelulusan PKM AI.' 
                        : 'Nilai kelulusan minimum adalah ' . $quiz->passing_score . '%. Anda dapat mempelajari kembali modul silabus dan mengulang evaluasi.' }}
                </p>
            </div>

            <!-- Score Pill Cards -->
            <div class="grid grid-cols-3 gap-4 max-w-md mx-auto p-4 rounded-2xl bg-slate-950 border border-slate-800 text-center">
                <div>
                    <div class="text-2xl font-black {{ $attempt->is_passed ? 'text-emerald-400' : 'text-amber-400' }} font-mono">
                        {{ $attempt->score }}%
                    </div>
                    <div class="text-[10px] text-slate-400 mt-0.5">Nilai Akhir</div>
                </div>
                <div>
                    <div class="text-2xl font-black text-white font-mono">
                        {{ $attempt->correct_count }} / {{ $attempt->total_questions }}
                    </div>
                    <div class="text-[10px] text-slate-400 mt-0.5">Jawaban Benar</div>
                </div>
                <div>
                    <div class="text-2xl font-black text-sky-400 font-mono">
                        {{ $quiz->passing_score }}%
                    </div>
                    <div class="text-[10px] text-slate-400 mt-0.5">Passing Grade</div>
                </div>
            </div>

            <!-- Certificate Action CTA -->
            <div class="pt-2 flex flex-wrap items-center justify-center gap-4">
                @if($certificate)
                    <a href="{{ route('certificates.show', $certificate->certificate_number) }}" class="px-6 py-3.5 rounded-xl font-bold text-xs bg-gradient-to-r from-emerald-500 to-teal-400 text-white shadow-lg shadow-emerald-500/25 hover:opacity-95 transition-all flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>Lihat & Cetak E-Sertifikat Resmi &rarr;</span>
                    </a>
                @endif
                <a href="{{ route('quiz.show', $quiz->slug) }}" class="px-5 py-3 rounded-xl text-xs font-semibold bg-slate-800 hover:bg-slate-700 text-slate-200 border border-slate-700 transition-colors">
                    Ulangi Tes
                </a>
                <a href="{{ route('tracks.show', $quiz->track->slug) }}" class="px-5 py-3 rounded-xl text-xs font-semibold bg-slate-900 hover:bg-slate-800 text-indigo-300 border border-slate-800 transition-colors">
                    Kembali ke Silabus Track
                </a>
            </div>
        </div>

        <!-- Question-by-Question Review with Explanations -->
        <div class="space-y-6">
            <h2 class="text-xl font-bold text-white flex items-center gap-2">
                <span>Pembahasan Kunci Jawaban & Penjelasan Ilmiah</span>
                <span class="text-xs text-slate-400 font-normal">({{ $quiz->questions->count() }} Soal)</span>
            </h2>

            @foreach($quiz->questions as $q)
                @php
                    $userAnswer = strtoupper((string) ($attempt->answers_payload[$q->id] ?? ''));
                    $isCorrect = $userAnswer === strtoupper($q->correct_answer);
                @endphp
                <div class="rounded-2xl bg-slate-900 border {{ $isCorrect ? 'border-emerald-500/30' : 'border-rose-500/30' }} p-6 sm:p-8 space-y-4 shadow-lg">
                    <div class="flex items-start justify-between gap-4">
                        <div class="flex items-start gap-3">
                            <span class="w-7 h-7 rounded-lg {{ $isCorrect ? 'bg-emerald-500/20 text-emerald-400' : 'bg-rose-500/20 text-rose-400' }} flex items-center justify-center font-bold text-xs shrink-0">
                                {{ $q->order_number }}
                            </span>
                            <div class="space-y-2">
                                <h3 class="text-sm sm:text-base font-semibold text-white leading-relaxed">
                                    {{ $q->question_text }}
                                </h3>
                            </div>
                        </div>
                        <span class="px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider shrink-0 {{ $isCorrect ? 'bg-emerald-500/10 text-emerald-400 border border-emerald-500/30' : 'bg-rose-500/10 text-rose-400 border border-rose-500/30' }}">
                            {{ $isCorrect ? 'Jawaban Benar' : 'Jawaban Salah' }}
                        </span>
                    </div>

                    <!-- Options Display -->
                    <div class="space-y-2 pt-2">
                        @foreach(['A' => $q->option_a, 'B' => $q->option_b, 'C' => $q->option_c, 'D' => $q->option_d] as $k => $opt)
                            @php
                                $isOptionCorrect = $k === strtoupper($q->correct_answer);
                                $isOptionUserChosen = $k === $userAnswer;
                            @endphp
                            <div class="p-3 rounded-xl border text-xs flex items-center justify-between gap-2 {{ $isOptionCorrect ? 'bg-emerald-950/40 border-emerald-500/50 text-emerald-200 font-semibold' : ($isOptionUserChosen ? 'bg-rose-950/40 border-rose-500/50 text-rose-200' : 'bg-slate-950/60 border-slate-800 text-slate-400') }}">
                                <div class="flex items-center gap-2">
                                    <span class="font-mono font-bold">{{ $k }}.</span>
                                    <span>{{ $opt }}</span>
                                </div>
                                <div>
                                    @if($isOptionCorrect)
                                        <span class="text-[10px] font-bold text-emerald-400 uppercase tracking-wider">&check; Kunci Benar</span>
                                    @elseif($isOptionUserChosen)
                                        <span class="text-[10px] font-bold text-rose-400 uppercase tracking-wider">&cross; Pilihan Anda</span>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Explanation -->
                    @if($q->explanation)
                        <div class="p-4 rounded-xl bg-slate-950 border border-slate-800 text-xs text-slate-300 space-y-1">
                            <div class="font-bold text-sky-400 text-[11px] uppercase tracking-wider">Penjelasan Ilmiah:</div>
                            <p class="leading-relaxed text-slate-400">{{ $q->explanation }}</p>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection

