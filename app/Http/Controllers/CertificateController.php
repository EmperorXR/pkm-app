<?php

namespace App\Http\Controllers;

use App\Models\Certificate;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CertificateController extends Controller
{
    /**
     * Display certificates earned by the authenticated user or sample showcase.
     */
    public function index(): View
    {
        $certificates = [];
        if (Auth::check()) {
            $certificates = Certificate::with('track')
                ->where('user_id', Auth::id())
                ->latest()
                ->get();
        }

        $sampleCertificates = Certificate::with(['user', 'track'])
            ->where('status', 'valid')
            ->latest()
            ->take(4)
            ->get();

        return view('pages.certificates.index', compact('certificates', 'sampleCertificates'));
    }

    /**
     * Display digital certificate printable view.
     */
    public function show(string $certificateNumber): View
    {
        $decoded = urldecode($certificateNumber);
        $certificate = Certificate::with(['user', 'track', 'quizAttempt'])
            ->where('certificate_number', $certificateNumber)
            ->orWhere('certificate_number', $decoded)
            ->orWhere('verify_code', $certificateNumber)
            ->orWhere('verify_code', $decoded)
            ->orWhere('id', is_numeric($certificateNumber) ? (int) $certificateNumber : 0)
            ->firstOrFail();

        return view('pages.certificates.show', compact('certificate'));
    }

    /**
     * Direct sample certificate viewer.
     */
    public function sample(): View
    {
        $certificate = Certificate::with(['user', 'track', 'quizAttempt'])
            ->where('status', 'valid')
            ->firstOrFail();

        return view('pages.certificates.show', compact('certificate'));
    }

    /**
     * Public verification page for certificates.
     */
    public function verify(Request $request): View
    {
        $code = trim((string) $request->query('code', ''));
        $certificate = null;
        $searched = false;

        if ($code !== '') {
            $searched = true;
            $decoded = urldecode($code);
            $certificate = Certificate::with(['user', 'track'])
                ->where('certificate_number', $code)
                ->orWhere('certificate_number', $decoded)
                ->orWhere('verify_code', $code)
                ->orWhere('verify_code', strtoupper($code))
                ->orWhere('verify_code', strtoupper($decoded))
                ->first();
        }

        return view('pages.certificates.verify', compact('certificate', 'code', 'searched'));
    }
}
