<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PersonController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AkunUserController;
use App\Http\Controllers\TokoController;
use App\Http\Controllers\UserController;

// User authentication routes
Route::post("/register", [AuthController::class, 'register']);
Route::post("/login", [AuthController::class, 'login']);

// Protected routes requiring authentication
Route::middleware('auth:sanctum')->group(function () {
    // User profile routes
    Route::get('/user-profil', [AkunUserController::class, 'getUserProfile']);
    Route::post('/update-profile', [AkunUserController::class, 'updateProfile']);
    Route::post('/update-profile-image', [AkunUserController::class, 'updateProfileImage']);
    Route::post('/update-profile-image-url', [AkunUserController::class, 'updateProfileImageUrl']);
    
    // Default user route
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    // Profile Image Upload Route
    Route::post('/upload-profile-image', [UserController::class, 'uploadProfileImage']);

    // Route untuk mendaftar toko
    Route::post("/store", [TokoController::class, 'store']);
    Route::post("/update-store", [TokoController::class, 'update']);

    // Route untuk mendaftar toko
    Route::get("/index-toko", [TokoController::class, 'index']);

    //Route untuk mengupload bukti pembayaran
    Route::post('/upload-bukti-bayar', [TokoController::class, 'uploadBuktiPembayaran']);



});

// Test routes for Postman
Route::get("/index", [AuthController::class, 'index']);
Route::get("/show/{id}", [AuthController::class, 'show']);

