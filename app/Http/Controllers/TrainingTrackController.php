<?php

namespace App\Http\Controllers;

use App\Models\TrainingTrack;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;

class TrainingTrackController extends Controller
{
    /**
     * Display listing of training tracks.
     */
    public function index(): View
    {
        $tracks = TrainingTrack::with(['modules', 'quizzes'])
            ->where('is_active', true)
            ->get();

        $userRegistrations = [];
        if (Auth::check()) {
            $userRegistrations = Auth::user()->registrations()
                ->pluck('training_track_id')
                ->toArray();
        }

        return view('pages.tracks.index', compact('tracks', 'userRegistrations'));
    }

    /**
     * Display a single training track with modules and quiz.
     */
    public function show(string $slug): View
    {
        $track = TrainingTrack::with(['modules', 'quizzes.attempts' => function ($query): void {
            if (Auth::check()) {
                $query->where('user_id', Auth::id());
            }
        }])
            ->where('slug', $slug)
            ->firstOrFail();

        $isEnrolled = false;
        $certificate = null;
        if (Auth::check()) {
            $isEnrolled = Auth::user()->registrations()
                ->where('training_track_id', $track->id)
                ->exists();

            $certificate = Auth::user()->certificates()
                ->where('training_track_id', $track->id)
                ->first();
        }

        return view('pages.tracks.show', compact('track', 'isEnrolled', 'certificate'));
    }
}
