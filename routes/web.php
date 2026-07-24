<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\TrajetController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => redirect()->route('trajets.index'));

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('trajets', TrajetController::class)->except(['create', 'store'])->parameters([
        'trajets' => 'trajet',
    ]);
    Route::get('/trajets-creer', [TrajetController::class, 'create'])->name('trajets.create');
    Route::post('/trajets', [TrajetController::class, 'store'])->name('trajets.store');

    Route::post('/trajets/{trajet}/reserver', [ReservationController::class, 'store'])->name('reservations.store');
    Route::get('/mes-reservations', [ReservationController::class, 'index'])->name('reservations.index');
    Route::patch('/reservations/{reservation}/statut', [ReservationController::class, 'updateStatus'])->name('reservations.update-status');
});

require __DIR__.'/auth.php';