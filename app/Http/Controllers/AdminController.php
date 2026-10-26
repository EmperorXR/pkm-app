<?php

namespace App\Http\Controllers;

use App\Models\Certificate;
use App\Models\Discussion;
use App\Models\QuizAttempt;
use App\Models\Registration;
use App\Models\SimulationRecord;
use App\Models\TrainingTrack;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    /**
     * Display the Admin & Instructor management dashboard.
     */
    public function dashboard(): View|RedirectResponse
    {
        if (! Auth::check() || (! Auth::user()->isAdmin() && ! Auth::user()->isInstructor())) {
            return redirect()->route('home')->with('error', 'Akses dibatasi hanya untuk Administrator atau Instruktur.');
        }

        $stats = [
            'total_users' => User::count(),
            'total_participants' => User::where('role', 'participant')->count(),
            'total_registrations' => Registration::count(),
            'total_quiz_attempts' => QuizAttempt::count(),
            'passed_attempts' => QuizAttempt::where('is_passed', true)->count(),
            'total_certificates' => Certificate::count(),
            'total_discussions' => Discussion::count(),
            'total_simulations' => SimulationRecord::count(),
        ];

        $tracks = TrainingTrack::withCount(['modules', 'quizzes', 'registrations', 'certificates'])->get();
        $recentRegistrations = Registration::with(['user', 'track'])->latest()->take(10)->get();
        $recentAttempts = QuizAttempt::with(['user', 'quiz.track'])->latest()->take(10)->get();
        $recentCertificates = Certificate::with(['user', 'track'])->latest()->take(10)->get();

        return view('pages.admin.dashboard', compact('stats', 'tracks', 'recentRegistrations', 'recentAttempts', 'recentCertificates'));
    }

    /**
     * Update participant registration status.
     */
    public function updateRegistrationStatus(int $id, string $status): RedirectResponse
    {
        if (! Auth::check() || ! Auth::user()->isInstructor()) {
            return redirect()->route('home')->with('error', 'Akses ditolak.');
        }

        $registration = Registration::findOrFail($id);
        $registration->update(['status' => $status]);

        return back()->with('success', "Status pendaftaran {$registration->registration_code} diubah menjadi {$status}.");
    }

    /**
     * Revoke or reactivate certificate.
     */
    public function toggleCertificate(int $id): RedirectResponse
    {
        if (! Auth::check() || ! Auth::user()->isAdmin()) {
            return redirect()->route('home')->with('error', 'Akses ditolak.');
        }

        $certificate = Certificate::findOrFail($id);
        $newStatus = $certificate->status === 'valid' ? 'revoked' : 'valid';
        $certificate->update(['status' => $newStatus]);

        return back()->with('success', "Status sertifikat {$certificate->certificate_number} diubah menjadi {$newStatus}.");
    }
}
