<?php

namespace App\Http\Controllers;

use App\Models\Certificate;
use App\Models\Quiz;
use App\Models\QuizAttempt;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class QuizController extends Controller
{
    /**
     * Show quiz examination page.
     */
    public function show(string $slug): View|RedirectResponse
    {
        $quiz = Quiz::with(['track', 'questions'])
            ->where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        $latestAttempt = null;
        if (Auth::check()) {
            $latestAttempt = QuizAttempt::where('user_id', Auth::id())
                ->where('quiz_id', $quiz->id)
                ->latest()
                ->first();
        }

        return view('pages.quiz.show', compact('quiz', 'latestAttempt'));
    }

    /**
     * Submit quiz answers and grade.
     */
    public function submit(Request $request, string $slug): RedirectResponse
    {
        if (! Auth::check()) {
            $demoUser = User::where('role', 'participant')->first();
            if ($demoUser) {
                Auth::login($demoUser);
                $request->session()->regenerate();
            } else {
                return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu untuk mengikuti kuis evaluasi.');
            }
        }

        $quiz = Quiz::with(['questions', 'track'])
            ->where('slug', $slug)
            ->firstOrFail();

        $answers = $request->input('answers', []);
        $questions = $quiz->questions;
        $totalQuestions = $questions->count();
        $correctCount = 0;

        foreach ($questions as $question) {
            $userAns = strtoupper((string) ($answers[$question->id] ?? ''));
            if ($userAns === strtoupper($question->correct_answer)) {
                $correctCount++;
            }
        }

        $score = $totalQuestions > 0 ? round(($correctCount / $totalQuestions) * 100, 2) : 0;
        $isPassed = $score >= $quiz->passing_score;

        $attempt = QuizAttempt::create([
            'user_id' => Auth::id(),
            'quiz_id' => $quiz->id,
            'score' => $score,
            'correct_count' => $correctCount,
            'total_questions' => $totalQuestions,
            'is_passed' => $isPassed,
            'answers_payload' => $answers,
            'completed_at' => now(),
        ]);

        // If passed, auto-issue certificate if not yet issued or update score
        if ($isPassed) {
            $existingCertificate = Certificate::where('user_id', Auth::id())
                ->where('training_track_id', $quiz->training_track_id)
                ->first();

            $trackCode = Str::contains($quiz->track->slug ?? '', 'spk') ? 'SPK' : 'DIST';

            if (! $existingCertificate) {
                $maxSeq = Certificate::count();
                $seq = $maxSeq + 1;
                do {
                    $certNumber = 'CERT/PKM-AI/'.$trackCode.'/'.date('Y').'/'.str_pad((string) $seq, 4, '0', STR_PAD_LEFT);
                    $seq++;
                } while (Certificate::where('certificate_number', $certNumber)->exists());

                do {
                    $verifyCode = 'PKM-'.$trackCode.'-'.strtoupper(Str::random(6));
                } while (Certificate::where('verify_code', $verifyCode)->exists());

                Certificate::create([
                    'certificate_number' => $certNumber,
                    'verify_code' => $verifyCode,
                    'user_id' => Auth::id(),
                    'training_track_id' => $quiz->training_track_id,
                    'quiz_attempt_id' => $attempt->id,
                    'final_score' => $score,
                    'issue_date' => now()->toDateString(),
                    'status' => 'valid',
                ]);
            } else {
                if ($score >= $existingCertificate->final_score) {
                    $existingCertificate->update([
                        'quiz_attempt_id' => $attempt->id,
                        'final_score' => $score,
                    ]);
                }
            }
        }

        return redirect()->route('quiz.result', ['slug' => $quiz->slug, 'attemptId' => $attempt->id])
            ->with($isPassed ? 'success' : 'warning', $isPassed ? 'Selamat! Anda lulus ujian evaluasi kompetensi.' : 'Nilai Anda belum mencapai passing grade (70%). Anda dapat mengulang tes kembali.');
    }

    /**
     * Display quiz result & review.
     */
    public function result(string $slug, int $attemptId): View
    {
        $quiz = Quiz::with(['track', 'questions'])
            ->where('slug', $slug)
            ->firstOrFail();

        $attempt = QuizAttempt::where('id', $attemptId)
            ->where('quiz_id', $quiz->id)
            ->firstOrFail();

        $certificate = null;
        if ($attempt->is_passed) {
            $certificate = Certificate::where('user_id', $attempt->user_id)
                ->where('training_track_id', $quiz->training_track_id)
                ->first();
        }

        return view('pages.quiz.result', compact('quiz', 'attempt', 'certificate'));
    }
}
