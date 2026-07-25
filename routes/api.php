<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\ApiAuthenticatedSessionController;
use Illuminate\Support\Facades\Route;

Route::post('/login', [ApiAuthenticatedSessionController::class, 'store']);
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [ApiAuthenticatedSessionController::class, 'destroy']);
    Route::get('/admin/statistiques', [AdminController::class, 'statistiques']);
});
