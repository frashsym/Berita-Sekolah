<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\KategoriController;
use App\Http\Controllers\Admin\CommentController;
use App\Http\Controllers\Admin\BeritaController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Index\IndexController;
use App\Http\Controllers\Admin\RoleController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\SuperAdmin;

// Index User
Route::get('/', [IndexController::class, 'index'])->name('index');
Route::get('/about', [IndexController::class, 'about'])->name('about');
Route::get('/readmore/{id}', [IndexController::class, 'readmore'])->name('readmore');
Route::get('/search', [IndexController::class, 'search'])->name('berita.search');
Route::get('/berita/more', [IndexController::class, 'loadMore'])->name('berita.more');
Route::post('/komentar', [IndexController::class, 'komentar'])->name('komentar');
Route::get('/kategori/berita', [IndexController::class, 'kategori'])->name('kategori.berita');
Route::get('/berita/kategori/{id}', [IndexController::class, 'beritaByKategori'])->name('berita.kategori');

// Bagian Authentication
Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
Route::post('/login', [AuthenticatedSessionController::class, 'store']);
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy']);

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
    Route::get('/', [KategoriController::class, 'index'])->name('kategori.index'); // Menampilkan daftar kategori
    Route::post('/', [KategoriController::class, 'store'])->name('kategori.store'); // Membuat data kategori baru
    Route::get('/{id}', [KategoriController::class, 'show'])->name('kategori.show'); // Menampilkan detail kategori
    Route::put('/{id}', [KategoriController::class, 'update'])->name('kategori.update'); // Mengedit data kategori
    Route::delete('/{id}', [KategoriController::class, 'delete'])->name('kategori.delete'); // Menghapus data kategori
});

// Bagian Komentar
Route::prefix('comments')->middleware(['auth', 'verified'])->group(function () {
    Route::get('/', [CommentController::class, 'index'])->name('comments.index'); // Menampilkan daftar komentar
    Route::post('/', [CommentController::class, 'store'])->name('comments.store'); // Membuat komentar baru
    Route::get('/{id}', [CommentController::class, 'show'])->name('comments.show'); // Menampilkan detail komentar
    Route::put('/{id}', [CommentController::class, 'update'])->name('comments.update'); // Mengedit komentar
    Route::delete('/{id}', [CommentController::class, 'delete'])->name('comments.delete'); // Menghapus komentar
});

// Bagian Admin
Route::prefix('admin')->middleware(['auth', 'verified', SuperAdmin::class])->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('admin.index'); // Menampilkan daftar admin
    Route::post('/', [AdminController::class, 'store'])->name('admin.store'); // Membuat data admin baru
    Route::get('/{id}', [AdminController::class, 'show'])->name('admin.show'); // Menampilkan detail admin
    Route::put('/{id}', [AdminController::class, 'update'])->name('admin.update'); // Mengedit data admin
    Route::delete('/{id}', [AdminController::class, 'delete'])->name('admin.delete'); // Menghapus data admin
});

// Bagian Role
Route::prefix('role')->middleware(['auth', 'verified', SuperAdmin::class])->group(function () {
    Route::get('/', [RoleController::class, 'index'])->name('role.index'); // Menampilkan daftar role
    Route::post('/', [RoleController::class, 'store'])->name('role.store'); // Membuat data role baru
    Route::get('/{id}', [RoleController::class, 'show'])->name('role.show'); // Menampilkan detail role
    Route::put('/{id}', [RoleController::class, 'update'])->name('role.update'); // Mengedit data role
    Route::delete('/{id}', [RoleController::class, 'delete'])->name('role.delete'); // Menghapus data role
});

require __DIR__.'/auth.php';
