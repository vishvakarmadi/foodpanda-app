<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\OAuthController;

// Landing page
Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('dashboard');
    }
    return view('welcome');
})->name('home');

// Auth Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::post('/register', [AuthController::class, 'storeRegister'])->name('register.store');

// Protected routes
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // OAuth authorize routes (user must be logged in)
    Route::get('/oauth/authorize/form', [OAuthController::class, 'showAuthorizeForm'])->name('oauth.authorize.form');
    Route::post('/oauth/authorize/approve', [OAuthController::class, 'approveAuthorize'])->name('oauth.authorize.approve');
    Route::post('/oauth/authorize/deny', [OAuthController::class, 'denyAuthorize'])->name('oauth.authorize.deny');
});

// OAuth routes (public)
Route::get('/oauth/authorize', [OAuthController::class, 'authorize'])->name('oauth.authorize');
Route::post('/oauth/token', [OAuthController::class, 'token'])->name('oauth.token');
Route::get('/api/user', [OAuthController::class, 'userInfo'])->name('api.user');
