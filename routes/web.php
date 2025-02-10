<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Admin\KategoriController;
use App\Http\Controllers\Admin\BeritaController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Index User
Route::get('/', function () {
    return view('index.index');
});

// Bagian Authentication
Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
Route::post('/login', [AuthenticatedSessionController::class, 'store']);
Route::post('/logout', [AuthenticatedSessionController::class, 'logout']);

// Bagian Dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

// Bagian Berita
Route::get('/berita', [BeritaController::class, 'index'])->middleware(['auth', 'verified'])->name('berita');


// Bagian Kategori
Route::post('/kategori', [KategoriController::class, 'store'])->middleware(['auth', 'verified'])->name('kategori');



// Bagian Admin


// Bagian Bawaan Laravel
// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });


require __DIR__.'/auth.php';
