<?php

use App\Http\Controllers\LevelController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Baris kode yang ditambahkan sesuai praktikum:
Route::get('/level', [LevelController::class, 'index']);