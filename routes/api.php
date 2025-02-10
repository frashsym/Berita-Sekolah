<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\KategoriController;


Route::post('/kategori', [KategoriController::class, 'store']);
