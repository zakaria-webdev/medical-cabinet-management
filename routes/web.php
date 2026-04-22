<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DossierMedicalController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RendezVousController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\SecretaireController;
use App\Http\Controllers\ConsultationController;

// [Houcine] Route racine - redirige vers login si non connecté, dashboard si connecté
Route::get('/', function () {
    if (auth()->check()) {
        $role = auth()->user()->role;
        return match($role) {
            'admin'      => redirect()->route('admin.dashboard'),
            'medecin'    => redirect()->route('medecin.dashboard'),
            'secretaire' => redirect()->route('secretaire.dashboard'),
            'patient'    => redirect()->route('patient.dashboard'),
            default      => redirect()->route('login'),
        };
    }
    // return redirect()->route('login');
    return view('welcome');
});

// [Houcine] Routes dashboard par rôle - Sprint 1
    Route::get('/admin/dashboard', [UserController::class, 'dashboard'])
        ->middleware('role:admin')
        ->name('admin.dashboard');

    Route::get('/medecin/dashboard', function () {
        return view('dashboard.medecin');
    })->middleware('role:medecin')->name('medecin.dashboard');

    Route::get('/secretaire/dashboard', [SecretaireController::class, 'dashboard'])
        ->middleware('role:secretaire')
        ->name('secretaire.dashboard');

    Route::get('/patient/dashboard', function () {
        return view('dashboard.patient');
    })->middleware('role:patient')->name('patient.dashboard');


Route::middleware(['auth', 'role:admin,medecin,secretaire'])->group(function () {
    Route::resource('patients', PatientController::class);

    // ============================================================
    // [Houcine] Routes Gestion des Utilisateurs (Admin)
    // ============================================================
    Route::get('/admin/users', [UserController::class, 'index'])->name('admin.users');
    Route::post('/admin/users/{user}/role', [UserController::class, 'updateRole'])->name('admin.users.updateRole');

    // [NOUVEAU] Routes pour la Gestion des Profils (Création, Modification & Suppression de Staff)
    Route::post('/admin/users', [UserController::class, 'store'])->name('admin.users.store');

    // ✅ هادا هو السطر اللي كان ناقص ديال التعديل (Modifier)
    Route::put('/admin/users/{id}/profile', [UserController::class, 'updateProfile'])->name('admin.users.updateProfile');

    Route::delete('/admin/users/{id}', [UserController::class, 'destroy'])->name('admin.users.destroy');
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



Route::middleware(['auth', 'role:admin,medecin'])->group(function () {
    Route::resource('dossiers', DossierMedicalController::class);
});

// ============================================================
// [Amine] ROUTES RENDEZ-VOUS - Sprint 2
// ============================================================
// RDV accessible à tous les rôles authentifiés -
Route::middleware(['auth'])->group(function () {

    // ✅ الجديد — حدد اسم الـ parameter يدوياً
    Route::resource('rendezvous', RendezVousController::class)
        ->parameters(['rendezvous' => 'rendezVous']);

    Route::get('rendezvous-calendar', [RendezVousController::class, 'calendar'])
        ->name('rendezvous.calendar');
    Route::get('api/rendezvous/events', [RendezVousController::class, 'calendarData'])
        ->name('rendezvous.calendar.data');
});

// ============================================================
// [Houcine] ROUTES NOTIFICATIONS - Sprint 2
// ============================================================
Route::middleware('auth')->group(function () {
    Route::get('/notifications', [NotificationController::class, 'index'])
        ->name('notifications.index');

    Route::post('/notifications/read-all', [NotificationController::class, 'markAllAsRead'])
        ->name('notifications.markAllAsRead');

    Route::post('/notifications/{id}/read', [NotificationController::class, 'markAsRead'])
        ->name('notifications.markAsRead');
});


// Zakaria : Routes pour les consultations et ordonnances
// Protégées par le middleware d'authentification de Houcine
Route::resource('consultations', ConsultationController::class)->middleware(['auth']);
// Zakaria : Routes pour generer en PDF
Route::get('/consultations/{id}/pdf', [ConsultationController::class, 'generatePDF'])->name('consultations.pdf');


Route::get('/install-db', function () {
    \Illuminate\Support\Facades\Artisan::call('migrate:fresh', [
        '--seed' => true,
        '--force' => true
    ]);
    return 'Mabrouk! Database is ready. Sir dir Login daba.';
});
