<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CertificateController;
use App\Http\Controllers\DiscussionController;
use App\Http\Controllers\DistributedLabController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\SpkLabController;
use App\Http\Controllers\TrainingModuleController;
use App\Http\Controllers\TrainingTrackController;
use Illuminate\Support\Facades\Route;

// Public & Landing Routes
Route::get('/', [HomeController::class, 'index'])->name('home');

// Training Tracks & Modules
Route::get('/tracks', [TrainingTrackController::class, 'index'])->name('tracks.index');
Route::get('/tracks/{slug}', [TrainingTrackController::class, 'show'])->name('tracks.show');
Route::get('/tracks/{trackSlug}/modules/{moduleSlug}', [TrainingModuleController::class, 'show'])->name('modules.show');

// Hands-on Interactive Labs
Route::get('/labs/spk', [SpkLabController::class, 'index'])->name('labs.spk');
Route::post('/labs/spk/calculate', [SpkLabController::class, 'calculate'])->name('labs.spk.calculate');
Route::post('/labs/spk/save', [SpkLabController::class, 'save'])->name('labs.spk.save');

Route::get('/labs/distributed', [DistributedLabController::class, 'index'])->name('labs.distributed');
Route::post('/labs/distributed/simulate', [DistributedLabController::class, 'simulate'])->name('labs.distributed.simulate');
Route::post('/labs/distributed/save', [DistributedLabController::class, 'save'])->name('labs.distributed.save');

// Quizzes & Assessments
Route::get('/quiz/{slug}', [QuizController::class, 'show'])->name('quiz.show');
Route::post('/quiz/{slug}/submit', [QuizController::class, 'submit'])->name('quiz.submit');
Route::get('/quiz/{slug}/result/{attemptId}', [QuizController::class, 'result'])->name('quiz.result');

// Certificates
Route::get('/certificates', [CertificateController::class, 'index'])->name('certificates.index');
Route::get('/certificates/sample', [CertificateController::class, 'sample'])->name('certificates.sample');
Route::get('/certificates/view/{certificateNumber}', [CertificateController::class, 'show'])->where('certificateNumber', '.*')->name('certificates.show');
Route::get('/verify-certificate', [CertificateController::class, 'verify'])->name('certificates.verify');

// Training Registrations
Route::get('/registrations', [RegistrationController::class, 'index'])->name('registration.index');
Route::get('/register-training', [RegistrationController::class, 'create'])->name('registration.create');
Route::post('/register-training', [RegistrationController::class, 'store'])->name('registration.store');
Route::redirect('/registration', '/register-training');
Route::redirect('/pendaftaran', '/register-training');
Route::redirect('/daftar', '/register-training');
Route::redirect('/sertifikat', '/certificates');
Route::redirect('/verifikasi', '/verify-certificate');

// Discussion Forum
Route::get('/discussions', [DiscussionController::class, 'index'])->name('discussions.index');
Route::get('/discussions/{id}', [DiscussionController::class, 'show'])->name('discussions.show');
Route::post('/discussions', [DiscussionController::class, 'store'])->name('discussions.store');
Route::post('/discussions/{id}/reply', [DiscussionController::class, 'reply'])->name('discussions.reply');

// Authentication & Quick Demo Login
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/quick-login/{role}', [AuthController::class, 'quickLogin'])->name('quick-login');

// Admin & Instructor Dashboard
Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
Route::post('/admin/registrations/{id}/status/{status}', [AdminController::class, 'updateRegistrationStatus'])->name('admin.registration.status');
Route::post('/admin/certificates/{id}/toggle', [AdminController::class, 'toggleCertificate'])->name('admin.certificate.toggle');
