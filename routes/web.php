<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DossierMedicalController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RendezVousController;
use App\Http\Controllers\NotificationController;



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
    return redirect()->route('login');
});

// [Houcine] Routes dashboard par rôle - Sprint 1
Route::middleware('auth')->group(function () {
    Route::get('/admin/dashboard', function () {
        return view('dashboard.admin');
    })->middleware('role:admin')->name('admin.dashboard');

    Route::get('/medecin/dashboard', function () {
        return view('dashboard.medecin');
    })->middleware('role:medecin')->name('medecin.dashboard');

    Route::get('/secretaire/dashboard', function () {
        return view('dashboard.secretaire');
    })->middleware('role:secretaire')->name('secretaire.dashboard');

    Route::get('/patient/dashboard', function () {
        return view('dashboard.patient');
    })->middleware('role:patient')->name('patient.dashboard');
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
// RDV accessible à tous les rôles authentifiés -
Route::middleware(['auth'])->group(function () {
    Route::resource('rendezvous', RendezVousController::class);
    Route::get('rendezvous-calendar', [RendezVousController::class, 'calendar'])
        ->name('rendezvous.calendar');
    Route::get('api/rendezvous/events', [RendezVousController::class, 'calendarData'])
        ->name('rendezvous.calendar.data');
});

// ============================================================
// [Houcine] ROUTES NOTIFICATIONS - Sprint 2
// ============================================================
// Ces routes permettent à l'utilisateur connecté de :
//   - voir toutes ses notifications         → GET  /notifications
//   - marquer une notification comme lue    → POST /notifications/{id}/read
//   - marquer toutes comme lues             → POST /notifications/read-all
//
// Protégées par middleware 'auth' uniquement :
// toutes les rôles ont accès à leurs propres notifications
// (médecin, secrétaire, admin, patient)
// ============================================================
Route::middleware('auth')->group(function () {
    Route::get('/notifications', [NotificationController::class, 'index'])
        ->name('notifications.index');

    // IMPORTANT : la route read-all doit être AVANT {id}/read
    // sinon Laravel interpréterait "read-all" comme un {id}
    Route::post('/notifications/read-all', [NotificationController::class, 'markAllAsRead'])
        ->name('notifications.markAllAsRead');

    Route::post('/notifications/{id}/read', [NotificationController::class, 'markAsRead'])
        ->name('notifications.markAsRead');
});


use App\Http\Controllers\ConsultationController;

// Zakaria : Routes pour les consultations et ordonnances
// Protégées par le middleware d'authentification de Houcine
Route::resource('consultations', ConsultationController::class)->middleware(['auth']);
// Zakaria : Routes pour generer en PDF
Route::get('/consultations/{id}/pdf', [ConsultationController::class, 'generatePDF'])->name('consultations.pdf');
