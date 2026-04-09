<?php

use Illuminate\Support\Facades\Route;
// Importer le Controller pour pouvoir l'utiliser dans la route
use App\Http\Controllers\PatientController;
// [Houcine] Ajout de AuthController pour gérer l'inscription, connexion et déconnexion
use App\Http\Controllers\AuthController;

use App\Http\Controllers\DossierMedicalController;
// [Houcine] Ajout de UserController pour la gestion des rôles
use App\Http\Controllers\UserController;

use App\Http\Controllers\RendezVousController;


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
// [Houcine] Route originale commentée — remplacée par la version protégée par rôle ci-dessous
// Route::resource('patients', PatientController::class);

// [Houcine] Protection des routes patients par rôle :
// - Admin : accès complet (CRUD)
// - Médecin + Secrétaire : lecture seule (index + show)
Route::middleware(['auth', 'role:admin,medecin,secretaire'])->group(function () {
    Route::resource('patients', PatientController::class);

    // [Houcine] Gestion des rôles — accessible uniquement par l'admin
    // GET  /admin/users          → liste tous les utilisateurs avec dropdown de rôle
    // POST /admin/users/{user}/role → met à jour le rôle d'un utilisateur
    Route::get('/admin/users', [UserController::class, 'index'])->name('admin.users');
    Route::post('/admin/users/{user}/role', [UserController::class, 'updateRole'])->name('admin.users.updateRole');
});

// [Houcine] Médecin et Secrétaire ont accès via le groupe ci-dessus (role:admin,medecin,secretaire)
// Le controller PatientController gère les permissions fines (ex: destroy réservé à admin)

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

// [ZAKARIA] : J'ai généré toutes les routes CRUD pour le dossier médical d'un coup.
// @Haucine : Quand tu auras terminé le système de Connexion/Sécurité,
// n'oublie pas d'envelopper cette route avec le middleware 'auth' pour la protéger !
// [Houcine] Route originale commentée — remplacée par la version protégée par rôle ci-dessous
// Route::resource('dossiers', DossierMedicalController::class);

// [Houcine] Protection des routes dossiers par rôle :
// - Admin + Médecin : accès complet (CRUD)
// - Secrétaire et Patient : accès refusé, redirigé vers leur dashboard
Route::middleware(['auth', 'role:admin,medecin'])->group(function () {
    Route::resource('dossiers', DossierMedicalController::class);
});

// [Amine] redez-vous:
Route::get('/rendezvous/calendar', [RendezVousController::class, 'calendar'])
    ->name('rendezvous.calendar');

Route::get('/api/rendezvous/events', [RendezVousController::class, 'calendarData'])
    ->name('rendezvous.calendar.data');

//---------------------------------------------



Route::middleware(['auth'])->group(function() {

    // CRUD complet (index, create, store, edit, update, destroy)
    //Route::resource('rendezvous', RendezVousController::class);
    /********************************************* */

    Route::resource('rendezvous', RendezVousController::class)
    ->parameters([
        'rendezvous' => 'rendezVous'
    ]);
    /********************************************* */

    // Routes supplémentaires pour le calendrier
    Route::get('/rendezvous-calendar',
        [RendezVousController::class, 'calendar'])->name('rendezvous.calendar');

    Route::get('/api/rdv-events',
        [RendezVousController::class, 'calendarData'])->name('rendezvous.calendar.data');
});