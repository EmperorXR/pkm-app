<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Show login form.
     */
    public function showLogin(): View
    {
        return view('pages.auth.login');
    }

    /**
     * Authenticate user.
     */
    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            return redirect()->intended(route('home'))->with('success', 'Selamat datang kembali, '.Auth::user()->name.'!');
        }

        return back()->withErrors([
            'email' => 'Email atau password yang Anda masukkan tidak sesuai.',
        ])->onlyInput('email');
    }

    /**
     * One-click quick login for testing/demo roles.
     */
    public function quickLogin(string $role): RedirectResponse
    {
        $email = match ($role) {
            'admin' => 'admin@pkm-ai.ac.id',
            'instructor' => 'instruktur@pkm-ai.ac.id',
            default => 'peserta@pkm-ai.ac.id',
        };

        $user = User::where('email', $email)->first();
        if ($user) {
            Auth::login($user);
            request()->session()->regenerate();

            return redirect()->route('home')->with('success', "Berhasil masuk sebagai demo role: {$user->role} ({$user->name}).");
        }

        return redirect()->route('login')->with('error', 'Akun demo tidak ditemukan.');
    }

    /**
     * Show registration form.
     */
    public function showRegister(): View
    {
        return view('pages.auth.register');
    }

    /**
     * Register new participant.
     */
    public function register(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'institution' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'institution' => $validated['institution'] ?? null,
            'phone' => $validated['phone'] ?? null,
            'role' => 'participant',
            'password' => Hash::make($validated['password']),
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('home')->with('success', 'Akun Anda berhasil didaftarkan. Selamat belajar!');
    }

    /**
     * Log the user out.
     */
    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')->with('info', 'Anda telah berhasil keluar dari akun.');
    }
}
