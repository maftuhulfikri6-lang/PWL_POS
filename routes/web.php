<?php

use App\Http\Controllers\KategoriController;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WelcomeController; // Pastikan ini ditambahkan
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Mengubah route '/' untuk menggunakan WelcomeController sesuai gambar
Route::get('/', [WelcomeController::class, 'index']);

Route::get('/level', [LevelController::class, 'index']);
Route::get('/kategori', [KategoriController::class, 'index']);

// --- Bagian CRUD User ---
Route::get('/user', [UserController::class, 'index']);

// Penting: Taruh route /tambah DI ATAS route yang menggunakan {id} 
// agar 'tambah' tidak dianggap sebagai sebuah ID
Route::get('/user/tambah', [UserController::class, 'tambah']);
Route::post('/user/tambah_simpan', [UserController::class, 'tambah_simpan']);

// Route Ubah (Update)
Route::get('/user/ubah/{id}', [UserController::class, 'ubah']);
Route::put('/user/ubah_simpan/{id}', [UserController::class, 'ubah_simpan']);

// Route Hapus (Delete)
Route::get('/user/hapus/{id}', [UserController::class, 'hapus']);