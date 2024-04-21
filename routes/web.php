<?php

use App\Http\Controllers\AdmissionController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
})->name('home');

Route::get('/patient_dashboard', function () {
    return Inertia::render('PatientDashboard');
})->middleware(['auth', 'verified'])->name('patients');

Route::get('/admission_dashboard', function () {
    return Inertia::render('AdmissionDashboard');
})->middleware(['auth', 'verified'])->name('admissions');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Patients
    Route::get('/patients', [PatientController::class, 'getAll'])->name('patient.all');
    Route::post('/add_patient', [PatientController::class, 'add'])->name('patient.add');
    Route::patch('/update_patient', [PatientController::class, 'update'])->name('patient.update');
    Route::delete('/delete_patient', [PatientController::class, 'delete'])->name('patient.delete');

    // Admissions
    Route::get('/admissions', [AdmissionController::class, 'getAdmissionsPerDay'])->name('admission.all.day');
    Route::post('/add_admission', [AdmissionController::class, 'addAdmission'])->name('admission.add');
    Route::post('/discharge_admission', [AdmissionController::class, 'dischargeAdmission'])->name('admission.discharge');
});

require __DIR__ . '/auth.php';
