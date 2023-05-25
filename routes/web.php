<?php

use App\Http\Controllers\PertanyaanController;
use App\Http\Controllers\UserController;
use App\Models\Pertanyaan;
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
    // User Routes
    Route::get('/profile', [UserController::class, 'profile']);
    Route::get('/users/{user}', [UserController::class, 'show']);
    Route::get('/profile/edit', [UserController::class, 'edit']);
    Route::patch('/profile/reset', [UserController::class, 'reset']);
    Route::post('/logout', [UserController::class, 'logout']);

    // Pertanyaan Routes
    Route::get('/pertanyaan/create', [PertanyaanController::class, 'create']);
    Route::post('/pertanyaan', [PertanyaanController::class, 'store']);
    Route::get('/pertanyaan/{pertanyaan}/edit', [PertanyaanController::class, 'edit']);
    Route::patch('/pertanyaan/{pertanyaan}', [PertanyaanController::class, 'update']);
    Route::delete('/pertanyaan/{pertanyaan}', [PertanyaanController::class, 'destroy']);
});

// Admin Routes
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/users/manage', [UserController::class, 'manage']);
    Route::get('/users/{user}/edit', [UserController::class, 'editByAdmin']);
    Route::patch('/users/{user}', [UserController::class, 'update']);
    Route::delete('/users/{user}', [UserController::class, 'destroy']);
});

// Without Middleware Routes
Route::get('/', [PertanyaanController::class, 'index']);
