<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Admin\KategoriController;
use App\Http\Controllers\Admin\BeritaController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Index\IndexController;
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
Route::prefix('berita')->middleware(['auth', 'verified'])->group(function () {
    Route::get('/', [BeritaController::class, 'index'])->name('berita.index'); // Menampilkan daftar berita
    Route::post('/', [BeritaController::class, 'store'])->name('berita.store'); // Membuat data berita baru
    Route::get('/{id}', [BeritaController::class, 'show'])->name('berita.show'); // Menampilkan detail berita
    Route::put('/{id}', [BeritaController::class, 'update'])->name('berita.update'); // Mengedit data berita
    Route::delete('/{id}', [BeritaController::class, 'delete'])->name('berita.delete'); // Menghapus data berita
});

// Bagian Kategori
Route::prefix('kategori')->middleware(['auth', 'verified'])->group(function () {
    Route::get('/', [KategoriController::class, 'index'])->name('kategori.index'); // Menampilkan daftar berita
    Route::post('/', [KategoriController::class, 'store'])->name('kategori.store'); // Membuat data berita baru
    Route::get('/{id}', [KategoriController::class, 'show'])->name('kategori.show'); // Menampilkan detail berita
    Route::put('/{id}', [KategoriController::class, 'update'])->name('kategori.update'); // Mengedit data berita
    Route::delete('/{id}', [KategoriController::class, 'delete'])->name('kategori.delete'); // Menghapus data berita
});

Route::get('layouts.Index', [IndexController::class, 'index']);


    



// Bagian Admin


// Bagian Bawaan Laravel
// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });


require __DIR__.'/auth.php';
