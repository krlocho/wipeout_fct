<?php // PHP opening tag

use App\Http\Controllers\ProfileController; // Import ProfileController
use App\Http\Controllers\TablaController; // Import TablaController
use Illuminate\Support\Facades\Route; // Import Route facade
use App\Http\Controllers\ClienteController; // Import ClienteController
use App\Http\Controllers\ReparacionController; // Import ReparacionController
use App\Models\User; // Import User model
use App\Http\Controllers\Auth\EmailVerificationPromptController; // Import EmailVerificationPromptController
use App\Http\Controllers\GoogleController; // Import GoogleController

Route::get('verify-email', EmailVerificationPromptController::class); // Verification prompt route

Route::get('/', function () { // Home route rendering landing and public workshop map
    $users = User::whereNotNull('latitud') // Filter users with valid latitude
        ->whereNotNull('longitud') // Filter users with valid longitude
        ->get(['latitud', 'longitud', 'name']); // Expose only public location and name without personal PII
    return view('welcome', ['users' => $users]); // Render welcome blade view
})->name('welcome'); // Named welcome route

Route::get('/tracking/{code?}', [ReparacionController::class, 'track'])->name('reparaciones.track'); // Clean public tracking route
Route::get('/buscar_reparaciones', [ReparacionController::class, 'track'])->name('reparaciones.buscar'); // Backward compatible search route

Route::get('/dashboard', [ReparacionController::class, 'dashboard'])->middleware(['auth', 'verified'])->name('dashboard'); // Workshop analytics dashboard

Route::middleware('auth')->group(function () { // Group routes requiring active user authentication
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit'); // Profile edit screen
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update'); // Update profile details
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy'); // Remove user profile account

    Route::get('/reparaciones/tablero', [ReparacionController::class, 'kanban'])->name('reparaciones.kanban'); // Interactive Kanban board route
    Route::patch('/reparaciones/{id}/estado', [ReparacionController::class, 'update_estado'])->name('reparaciones.update_estado'); // Quick status update endpoint
    Route::get('/reparaciones/estado/{estado}', [ReparacionController::class, 'filtrar_por_estado'])->name('reparaciones.estado'); // Filter repairs by status
    Route::resource('/reparaciones', ReparacionController::class); // RESTful resource routes for repairs
    Route::resource('/tablas', TablaController::class); // RESTful resource routes for surfboards
    Route::resource('/clientes', ClienteController::class); // RESTful resource routes for clients
}); // Close authenticated routes group

Route::get('login/google', [GoogleController::class, 'redirect_to_google'])->name('login.google'); // OAuth Google redirect route
Route::get('login/google/callback', [GoogleController::class, 'handle_google_callback']); // OAuth Google callback route

require __DIR__ . '/auth.php'; // Include default Laravel Breeze authentication routes
