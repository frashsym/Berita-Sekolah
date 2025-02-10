<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\BeritaController;
use App\Http\Controllers\Admin\KategoriController;

// Bagian berita
Route::prefix('berita')->group(function () {
    Route::get('/', [BeritaController::class, 'index']); // Mendapatkan daftar berita
    Route::post('/', [BeritaController::class, 'store']); // Menambahkan berita baru
    Route::get('/{id}', [BeritaController::class, 'show']); // Menampilkan detail berita
    Route::put('/{id}', [BeritaController::class, 'update']); // Mengupdate berita
    Route::delete('/{id}', [BeritaController::class, 'delete']); // Menghapus berita
});

// Bagian Kategori
Route::prefix('kategori')->group(function () {
    Route::get('/', [KategoriController::class, 'index']); // Mendapatkan daftar kategori
    Route::post('/', [KategoriController::class, 'store']); // Menambahkan kategori baru
    Route::get('/{id}', [KategoriController::class, 'show']); // Menampilkan detail kategori
    Route::put('/{id}', [KategoriController::class, 'update']); // Mengupdate kategori
    Route::delete('/{id}', [KategoriController::class, 'delete']); // Menghapus kategori
});

// Bagian Admin
Route::prefix('admin')->group(function () {
    Route::get('/', [AdminController::class, 'index']); // Mendapatkan daftar user
    Route::post('/', [AdminController::class, 'store']); // Menambahkan user baru
    Route::get('/{id}', [AdminController::class, 'show']); // Menampilkan detail user
    Route::put('/{id}', [AdminController::class, 'update']); // Mengupdate user
    Route::delete('/{id}', [AdminController::class, 'delete']); // Menghapus user
});

