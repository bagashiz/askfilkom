<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// Guest Routes
Route::middleware('guest')->group(function () {
    Route::get('/register', [UserController::class, 'create']);
    Route::post('/users', [UserController::class, 'store']);
    Route::get('/login', [UserController::class, 'login'])->name('login');
    Route::post('/auth', [UserController::class, 'auth']);
});

// Authenticated Routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [UserController::class, 'profile']);
    Route::get('/users/{id_user}', [UserController::class, 'show']);
    Route::get('/profile/edit', [UserController::class, 'edit']);
    Route::patch('/profile/reset', [UserController::class, 'reset']);
    Route::post('/logout', [UserController::class, 'logout']);
});

// Admin Routes
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/users/manage', [UserController::class, 'manage']);
    Route::patch('/users/{id_user}', [UserController::class, 'update']);
    Route::delete('/users/{id_user}', [UserController::class, 'destroy']);
});
