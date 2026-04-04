<?php

use Illuminate\Support\Facades\Route;
// Importer le Controller pour pouvoir l'utiliser dans la route
use App\Http\Controllers\PatientController;

Route::get('/', function () {
    return view('welcome');
});

/**
 * Route pour afficher la liste des patients
 * URL: http://localhost:8000/patients
 */
Route::get('/patients', [PatientController::class, 'index']);

// هادي باش تفتح صفحة "إضافة مريض"
Route::get('/patients/create', [PatientController::class, 'create'])->name('patients.create');

// هادي باش تسجل البيانات (POST)
Route::post('/patients', [PatientController::class, 'store'])->name('patients.store');

// ونزيدو سمية (Name) للرابط القديم باش نسهلو الخدمة
Route::get('/patients', [PatientController::class, 'index'])->name('patients.index');
