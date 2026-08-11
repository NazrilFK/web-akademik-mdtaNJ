<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\JadwalController;
use App\Http\Controllers\Api\KalenderAkademikController;
use App\Http\Controllers\Api\NoteController;
use App\Http\Controllers\Api\PengumumanController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\RegisterController;
use App\Http\Controllers\Api\KelasController;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'login']);

Route::post('/register', [RegisterController::class, 'register']);

Route::get('/kelas', [KelasController::class, 'index']);

Route::middleware('auth:sanctum')->group(function () {

    Route::post('/logout', [AuthController::class, 'logout']);

    // ==========================
    // Notes
    // ==========================
    Route::get('/notes', [NoteController::class, 'index']);
    Route::post('/notes', [NoteController::class, 'store']);
    Route::put('/notes/{id}', [NoteController::class, 'update']);
    Route::delete('/notes/{id}', [NoteController::class, 'destroy']);

    // ==========================
    // Jadwal
    // ==========================
    Route::get('/jadwal-hari-ini', [JadwalController::class, 'hariIni']);

    // ==========================
    // Kalender Akademik
    // ==========================
    Route::get('/kalender-akademik', [KalenderAkademikController::class, 'index']);

    // ==========================
    // Pengumuman
    // ==========================
    Route::get('/pengumuman', [PengumumanController::class, 'index']);

    // ==========================
    // PROFILE
    // ==========================
    Route::get('/profile', [ProfileController::class, 'index']);

    Route::put('/profile', [ProfileController::class, 'update']);

    Route::put('/change-password', [ProfileController::class, 'changePassword']);

});