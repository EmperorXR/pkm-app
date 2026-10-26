<?php

namespace App\Http\Controllers;

use App\Models\Registration;
use App\Models\TrainingTrack;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class RegistrationController extends Controller
{
    /**
     * Display user's training registrations.
     */
    public function index(): View
    {
        $registrations = [];
        if (Auth::check()) {
            $registrations = Registration::with('track')
                ->where('user_id', Auth::id())
                ->latest()
                ->get();
        }

        return view('pages.registration.index', compact('registrations'));
    }

    /**
     * Show registration form.
     */
    public function create(Request $request): View
    {
        $tracks = TrainingTrack::where('is_active', true)->get();
        $selectedTrackId = $request->query('track_id');

        return view('pages.registration.create', compact('tracks', 'selectedTrackId'));
    }

    /**
     * Store new registration.
     */
    public function store(Request $request): RedirectResponse
    {
        if (! Auth::check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu untuk mendaftar pelatihan.');
        }

        $validated = $request->validate([
            'training_track_id' => 'required|exists:training_tracks,id',
            'prior_experience' => 'required|string',
            'motivation_reason' => 'required|string|min:10',
            'phone' => 'nullable|string',
            'institution' => 'nullable|string',
        ]);

        // Update user profile if provided
        $user = Auth::user();
        $user->update([
            'phone' => $validated['phone'] ?? $user->phone,
            'institution' => $validated['institution'] ?? $user->institution,
        ]);

        $existing = Registration::where('user_id', $user->id)
            ->where('training_track_id', $validated['training_track_id'])
            ->first();

        if ($existing) {
            return redirect()->route('registration.index')->with('info', 'Anda sudah terdaftar pada jalur pelatihan ini sebelumnya.');
        }

        $code = 'REG-PKM-'.date('y').'-'.strtoupper(Str::random(5));

        Registration::create([
            'user_id' => $user->id,
            'training_track_id' => $validated['training_track_id'],
            'registration_code' => $code,
            'status' => 'approved',
            'registered_at' => now(),
            'attended' => true,
            'motivation_reason' => $validated['motivation_reason'],
            'prior_experience' => $validated['prior_experience'],
        ]);

        return redirect()->route('registration.index')->with('success', 'Selamat! Pendaftaran pelatihan Anda berhasil dan langsung aktif.');
    }
}
