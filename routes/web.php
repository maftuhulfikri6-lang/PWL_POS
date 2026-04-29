<?php

use App\Http\Controllers\KategoriController;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\UserController; 
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

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