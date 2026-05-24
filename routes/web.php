<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\ParticipantController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;

// Redirect root to dashboard or login
Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('dashboard');
    }
    return redirect()->route('login');
});

// Authentication routes - Public routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/login', [AuthenticatedSessionController::class, 'store'])->name('login.store');
    
    Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('/register', [RegisteredUserController::class, 'store'])->name('register.store');
});

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout')->middleware('auth');

// Protected routes - require authentication
Route::middleware('auth')->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Events Resource Routes
    Route::resource('events', EventController::class);

    // Participants Routes (nested under events)
    Route::prefix('/events/{event}/participants')->group(function () {
        Route::get('/', [ParticipantController::class, 'index'])->name('participants.index');
        Route::get('/create', [ParticipantController::class, 'create'])->name('participants.create');
        Route::post('/', [ParticipantController::class, 'store'])->name('participants.store');
        Route::get('/{participant}/edit', [ParticipantController::class, 'edit'])->name('participants.edit');
        Route::put('/{participant}', [ParticipantController::class, 'update'])->name('participants.update');
        Route::delete('/{participant}', [ParticipantController::class, 'destroy'])->name('participants.destroy');
    });
});
