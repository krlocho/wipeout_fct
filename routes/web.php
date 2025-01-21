<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TablaController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\ReparacionController;
use App\Models\User;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\GoogleController;

Route::get('verify-email', EmailVerificationPromptController::class);

Route::get('/', function () {
    $users = User::all(['latitud', 'longitud', 'name', 'phone', 'email']);

    return view('/welcome', ['users' => $users]);
});

Route::get('/buscar_reparaciones', [ReparacionController::class, 'show'])->name('reparaciones.buscar');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('/tablas', TablaController::class);
    Route::resource('/clientes', ClienteController::class);
    Route::resource('/reparaciones', ReparacionController::class);
});




Route::get('login/google', [GoogleController::class, 'redirectToGoogle'])->name('login.google');
Route::get('login/google/callback', [GoogleController::class, 'handleGoogleCallback']);
Route::get('/test', function () {
    return 'Test route';
});



require __DIR__ . '/auth.php';
