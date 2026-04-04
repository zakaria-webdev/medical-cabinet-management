<?php

use Illuminate\Support\Facades\Route;
// Importer le Controller pour pouvoir l'utiliser dans la route
use App\Http\Controllers\PatientController;
// [Houcine] Ajout de AuthController pour gérer l'inscription, connexion et déconnexion
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return view('welcome');
});

/**
 * Route pour afficher la liste des patients
 * URL: http://localhost:8000/patients
 */
// Route::get('/patients', [PatientController::class, 'index']);

// // هادي باش تفتح صفحة "إضافة مريض"
// Route::get('/patients/create', [PatientController::class, 'create'])->name('patients.create');

// // هادي باش تسجل البيانات (POST)
// Route::post('/patients', [PatientController::class, 'store'])->name('patients.store');

// // ونزيدو سمية (Name) للرابط القديم باش نسهلو الخدمة
// Route::get('/patients', [PatientController::class, 'index'])->name('patients.index');

// هاد السطر السحري كيعوض 7 ديال الروابط دقة وحدة
// (index, create, store, show, edit, update, destroy)
Route::resource('patients', PatientController::class);

// ============================================================
// [Houcine] ROUTES D'AUTHENTIFICATION
// Tâche Sprint 1: Inscription, Connexion, Déconnexion
// ============================================================

// [Houcine] middleware('guest') = ces routes sont accessibles UNIQUEMENT
// si l'utilisateur n'est PAS connecté
// Si déjà connecté → redirige automatiquement vers son dashboard
Route::middleware('guest')->group(function () {

    // [Houcine] GET /register → affiche le formulaire d'inscription
    // POST /register → traite les données soumises
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);

    // [Houcine] GET /login → affiche le formulaire de connexion
    // POST /login → vérifie les credentials et crée la session
    // name('login') est OBLIGATOIRE: Laravel redirige vers cette route
    // automatiquement quand un utilisateur non connecté tente d'accéder
    // à une page protégée par middleware('auth')
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

// [Houcine] POST /logout → détruit la session et redirige vers /login
// middleware('auth') = accessible uniquement si connecté
// POST (pas GET) → empêche la déconnexion accidentelle via un simple lien URL
Route::post('/logout', [AuthController::class, 'logout'])
    ->name('logout')
    ->middleware('auth');

// ============================================================
// [Houcine] DASHBOARDS TEMPORAIRES
// Placeholders pour que redirectByRole() dans AuthController
// ne génère pas d'erreur "route not found"
// Ces routes seront remplacées par de vrais controllers en Sprint 2/3
// ============================================================
Route::middleware('auth')->group(function () {
    Route::get('/patient/dashboard', fn() => view('dashboard.patient'))->name('patient.dashboard');
    Route::get('/medecin/dashboard', fn() => view('dashboard.medecin'))->name('medecin.dashboard');
    Route::get('/secretaire/dashboard', fn() => view('dashboard.secretaire'))->name('secretaire.dashboard');
    Route::get('/admin/dashboard', fn() => view('dashboard.admin'))->name('admin.dashboard');
});