<?php

namespace App\Http\Controllers;

use App\Models\Certificate;
use App\Models\Discussion;
use App\Models\Registration;
use App\Models\TrainingModule;
use App\Models\TrainingTrack;
use App\Models\User;
use Illuminate\Contracts\View\View;

class HomeController extends Controller
{
    /**
     * Display the main landing page for the PKM AI training program.
     */
    public function index(): View
    {
        $tracks = TrainingTrack::withCount(['modules', 'quizzes'])
            ->where('is_active', true)
            ->get();

        $stats = [
            'total_participants' => User::where('role', 'participant')->count(),
            'total_registrations' => Registration::count(),
            'total_modules' => TrainingModule::count(),
            'total_certificates' => Certificate::where('status', 'valid')->count(),
            'total_discussions' => Discussion::count(),
        ];

        $latestDiscussions = Discussion::with(['user', 'track'])
            ->latest()
            ->take(4)
            ->get();

        return view('pages.home', compact('tracks', 'stats', 'latestDiscussions'));
    }
}
