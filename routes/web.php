<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\PertanyaanController;
use App\Http\Controllers\JawabanController;
use App\Http\Controllers\TopikController;
use App\Http\Controllers\VoteController;
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

    // Jawaban Routes
    Route::get('/jawaban/create/{pertanyaan}', [JawabanController::class, 'create']);
    Route::post('/jawaban', [JawabanController::class, 'store']);
    Route::get('/jawaban/{jawaban}/edit', [JawabanController::class, 'edit']);
    Route::patch('/jawaban/{jawaban}', [JawabanController::class, 'update']);
    Route::delete('/jawaban/{jawaban}', [JawabanController::class, 'destroy']);

    //Vote Routes
    Route::post('vote/{pertanyaan}/vote', [VoteController::class, 'votePertanyaan']);
    Route::post('vote/{jawaban}/vote', [VoteController::class, 'voteJawaban']);
    Route::post('vote/{pertanyaan}/unvote', [VoteController::class, 'unvotePertanyaan']);
    Route::post('vote/{jawaban}/unvote', [VoteController::class, 'unvoteJawaban']);
});

// Admin Routes
Route::middleware(['auth', 'admin'])->group(function () {
    // User Routes
    Route::get('/users/manage', [UserController::class, 'manage']);
    Route::get('/users/{user}/edit', [UserController::class, 'editByAdmin']);
    Route::patch('/users/{user}', [UserController::class, 'update']);
    Route::delete('/users/{user}', [UserController::class, 'destroy']);

    // Topik Routes
    Route::get('/topik', [TopikController::class, 'index']);
    Route::get('/topik/create', [TopikController::class, 'create']);
    Route::post('/topik', [TopikController::class, 'store']);
    Route::get('/topik/{topik}/edit', [TopikController::class, 'edit']);
    Route::patch('/topik/{topik}', [TopikController::class, 'update']);
    Route::delete('/topik/{topik}', [TopikController::class, 'destroy']);
});

// Without Middleware Routes
Route::get('/', [PertanyaanController::class, 'index']);
Route::get('/pertanyaan/{pertanyaan}', [PertanyaanController::class, 'show']);
