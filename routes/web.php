<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DossierMedicalController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RendezVousController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'role:admin,medecin,secretaire'])->group(function () {
    Route::resource('patients', PatientController::class);
    Route::get('/admin/users', [UserController::class, 'index'])->name('admin.users');
    Route::post('/admin/users/{user}/role', [UserController::class, 'updateRole'])->name('admin.users.updateRole');
});

Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

Route::post('/logout', [AuthController::class, 'logout'])
    ->name('logout')
    ->middleware('auth');

Route::middleware('auth')->group(function () {
    Route::get('/patient/dashboard', fn() => view('dashboard.patient'))->name('patient.dashboard');
    Route::get('/medecin/dashboard', fn() => view('dashboard.medecin'))->name('medecin.dashboard');
    Route::get('/secretaire/dashboard', fn() => view('dashboard.secretaire'))->name('secretaire.dashboard');
    Route::get('/admin/dashboard', fn() => view('dashboard.admin'))->name('admin.dashboard');
});

Route::middleware(['auth', 'role:admin,medecin'])->group(function () {
    Route::resource('dossiers', DossierMedicalController::class);
});

// ============================================================
// [Amine] ROUTES RENDEZ-VOUS - Sprint 2
// ============================================================
Route::middleware(['auth', 'role:admin,medecin,secretaire'])->group(function () {
    Route::resource('rendezvous', RendezVousController::class)
        ->parameters(['rendezvous' => 'rendezVous']);
    Route::get('/rendezvous-calendar', [RendezVousController::class, 'calendar'])
        ->name('rendezvous.calendar');
    Route::get('/api/rendezvous/events', [RendezVousController::class, 'calendarData'])
        ->name('rendezvous.calendar.data');
});
