<?php

use App\Http\Controllers\BarangController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\StokController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\SalesController;
use Illuminate\Support\Facades\Route;

Route::get('/', [WelcomeController::class, 'index']);

// Group rute untuk User
Route::group(['prefix' => 'user'], function () {
    Route::get('/', [UserController::class, 'index']);          
    Route::post('/list', [UserController::class, 'list']);      
    
    // 1. Rute Statis
    Route::get('/create', [UserController::class, 'create']);   
    Route::post('/', [UserController::class, 'store']);         
    Route::get('/create_ajax', [UserController::class, 'createAjax']); // Sesuaikan dengan nama method di controller
    Route::post('/create_ajax', [UserController::class, 'store_ajax']); // Konsistenkan path-nya

    // 2. Rute Dinamis Khusus AJAX
    Route::get('/{id}/show_ajax', [UserController::class, 'show_ajax']);
    Route::get('/{id}/edit_ajax', [UserController::class, 'edit_ajax']); 
    Route::put('/{id}/update_ajax', [UserController::class, 'update_ajax']); 
    Route::get('/{id}/delete_ajax', [UserController::class, 'confirm_ajax']); 
    Route::delete('/{id}/delete_ajax', [UserController::class, 'delete_ajax']); 

    // 3. Rute Dinamis Standar
    Route::get('/{id}', [UserController::class, 'show']);       
    Route::get('/{id}/edit', [UserController::class, 'edit']);  
    Route::put('/{id}', [UserController::class, 'update']);     
    Route::delete('/{id}', [UserController::class, 'destroy']); 
});

Route::group(['prefix' => 'level'], function () {
    // 1. Rute Index & List (Statik)
    Route::get('/', [LevelController::class, 'index']);          
    Route::post('/list', [LevelController::class, 'list']);      
    
    // 2. Rute AJAX (Statik - tanpa {id})
    Route::get('/create_ajax', [LevelController::class, 'create_ajax']); 
    Route::post('/ajax', [LevelController::class, 'store_ajax']); 

    // 3. Rute AJAX (Dinamis - menggunakan {id})
    Route::get('/{id}/show_ajax', [LevelController::class, 'show_ajax']);
    Route::get('/{id}/edit_ajax', [LevelController::class, 'edit_ajax']);
    Route::put('/{id}/update_ajax', [LevelController::class, 'update_ajax']); 
    Route::get('/{id}/delete_ajax', [LevelController::class, 'confirm_ajax']); 
    Route::delete('/{id}/delete_ajax', [LevelController::class, 'delete_ajax']); 

    // 4. Rute Konvensional (Statis)
    Route::get('/create', [LevelController::class, 'create']);   
    Route::post('/', [LevelController::class, 'store']);         

    // 5. Rute Konvensional (Dinamis - selalu diletakkan paling bawah agar tidak membajak rute lain)
    Route::get('/{id}', [LevelController::class, 'show']);       
    Route::get('/{id}/edit', [LevelController::class, 'edit']);  
    Route::put('/{id}', [LevelController::class, 'update']);     
    Route::delete('/{id}', [LevelController::class, 'destroy']); 
});


// Group rute untuk Kategori (Sudah dilengkapi rute AJAX untuk Tugas Jobsheet)
Route::group(['prefix' => 'kategori'], function () {
    // 1. Rute Halaman Utama & DataTables JSON
    Route::get('/', [KategoriController::class, 'index']);
    Route::post('/list', [KategoriController::class, 'list']);

    // 2. Rute Statis / Teks Tetap (Harus di ATAS rute berlambang {id})
    Route::get('/create', [KategoriController::class, 'create']);
    Route::post('/', [KategoriController::class, 'store']);
    Route::get('/create_ajax', [KategoriController::class, 'create_ajax']);
    Route::post('/ajax', [KategoriController::class, 'store_ajax']);

    // 3. Rute Dinamis / Pakai Parameter ID (Ditaruh di BAWAH)
    Route::get('/{id}/show_ajax', [KategoriController::class, 'show_ajax']); // <-- Rute Baru Show AJAX
    Route::get('/{id}/edit_ajax', [KategoriController::class, 'edit_ajax']);
    Route::put('/{id}/update_ajax', [KategoriController::class, 'update_ajax']);
    Route::get('/{id}/delete_ajax', [KategoriController::class, 'confirm_ajax']);
    Route::delete('/{id}/delete_ajax', [KategoriController::class, 'delete_ajax']);
    
    // 4. Rute Fallback Standar bawaan CRUD konvensional
    Route::get('/{id}', [KategoriController::class, 'show']);
    Route::get('/{id}/edit', [KategoriController::class, 'edit']);
    Route::put('/{id}', [KategoriController::class, 'update']);
    Route::delete('/{id}', [KategoriController::class, 'destroy']);
});

Route::group(['prefix' => 'supplier'], function () {
    // 1. Rute Utama (DataTables)
    Route::get('/', [SupplierController::class, 'index']);
    Route::post('/list', [SupplierController::class, 'list']); 

    // 2. Rute AJAX (Spesifik/Statik harus di atas agar tidak dianggap sebagai ID)
    Route::get('/create_ajax', [SupplierController::class, 'create_ajax']);
    Route::post('/ajax', [SupplierController::class, 'store_ajax']);

    // 3. Rute AJAX Dinamis (Gunakan {id} di posisi yang tepat)
    Route::get('/{id}/show_ajax', [SupplierController::class, 'show_ajax']);
    Route::get('/{id}/edit_ajax', [SupplierController::class, 'edit_ajax']);
    Route::put('/{id}/update_ajax', [SupplierController::class, 'update_ajax']);
    Route::get('/{id}/delete_ajax', [SupplierController::class, 'confirm_ajax']);
    Route::delete('/{id}/delete_ajax', [SupplierController::class, 'delete_ajax']);

    // 4. Rute Konvensional (Input/Form non-AJAX)
    Route::get('/create', [SupplierController::class, 'create']);
    Route::post('/', [SupplierController::class, 'store']);
    Route::get('/{id}', [SupplierController::class, 'show']);
    Route::get('/{id}/edit', [SupplierController::class, 'edit']);
    Route::put('/{id}', [SupplierController::class, 'update']);
    Route::delete('/{id}', [SupplierController::class, 'destroy']);
});
// Group rute untuk Barang (Sudah dilengkapi rute AJAX untuk Tugas Jobsheet)
Route::group(['prefix' => 'barang'], function () {
    Route::get('/', [BarangController::class, 'index']);
    Route::post('/list', [BarangController::class, 'list']);
    
    // 1. Rute Statis (Tanpa Parameter ID) ditaruh di atas
    Route::get('/create', [BarangController::class, 'create']);
    Route::post('/', [BarangController::class, 'store']);
    Route::get('/create_ajax', [BarangController::class, 'create_ajax']);
    Route::post('/ajax', [BarangController::class, 'store_ajax']);

    // 2. Rute Dinamis Khusus AJAX (Ditaruh di atas rute dinamis standar)
    Route::get('/{id}/show_ajax', [BarangController::class, 'show_ajax']); // <-- Tambahan: Rute Baru Show AJAX Barang
    Route::get('/{id}/edit_ajax', [BarangController::class, 'edit_ajax']);
    Route::put('/{id}/update_ajax', [BarangController::class, 'update_ajax']);
    Route::get('/{id}/delete_ajax', [BarangController::class, 'confirm_ajax']);
    Route::delete('/{id}/delete_ajax', [BarangController::class, 'delete_ajax']);

    // 3. Rute Dinamis Standar (Konvensional) ditaruh paling bawah
    Route::get('/{id}', [BarangController::class, 'show']);
    Route::get('/{id}/edit', [BarangController::class, 'edit']);
    Route::put('/{id}', [BarangController::class, 'update']);
    Route::delete('/{id}', [BarangController::class, 'destroy']);
});

// Group rute untuk Stok Barang
Route::group(['prefix' => 'stok'], function () {
    Route::get('/', [StokController::class, 'index']);
    Route::post('/list', [StokController::class, 'list']); 
    
    /* === 1. RUTE STATIS (Wajib di Atas Rute Parameter {id}) === */
    Route::get('/create', [StokController::class, 'create']);
    Route::post('/', [StokController::class, 'store']);
    Route::get('/create_ajax', [StokController::class, 'create_ajax']); // Rute AJAX Tambah
    Route::post('/ajax', [StokController::class, 'store_ajax']);        // Rute AJAX Simpan

    /* === 2. RUTE DINAMIS AJAX (Menggunakan Parameter) === */
    Route::get('/{id}/show_ajax', [StokController::class, 'show_ajax']);
    Route::get('/{id}/edit_ajax', [StokController::class, 'edit_ajax']);
    Route::put('/{id}/update_ajax', [StokController::class, 'update_ajax']);
    Route::get('/{id}/delete_ajax', [StokController::class, 'confirm_ajax']);
    Route::delete('/{id}/delete_ajax', [StokController::class, 'delete_ajax']);

    /* === 3. RUTE DINAMIS STANDAR / KONVENSIONAL (Paling Bawah) === */
    Route::get('/{id}', [StokController::class, 'show']);
    Route::get('/{id}/edit', [StokController::class, 'edit']);
    Route::put('/{id}', [StokController::class, 'update']);
    Route::delete('/{id}', [StokController::class, 'destroy']);
});

// Group route untuk Transaksi Penjualan
Route::group(['prefix' => 'penjualan'], function () {
    // Halaman Utama & Server-side Datatables
    Route::get('/', [SalesController::class, 'index']);
    Route::post('/list', [SalesController::class, 'list']); 

    // Rute untuk menampilkan modal konfirmasi (GET)
    Route::get('/{id}/confirm_ajax', [SalesController::class, 'confirm_ajax']);
    
    // Rute untuk memproses hapus (DELETE)
    Route::delete('/{id}/delete_ajax', [SalesController::class, 'delete_ajax']);
    
    // ... rute lainnya 

    // Fitur berbasis AJAX Modal (Wajib di atas Rute Wildcard/ID)
    Route::get('/create_ajax', [SalesController::class, 'create_ajax']);
    Route::post('/store_ajax', [SalesController::class, 'store_ajax']);
    Route::get('/{id}/show_ajax', [SalesController::class, 'show_ajax']);
    Route::get('/{id}/edit_ajax', [SalesController::class, 'edit_ajax']);
    Route::put('/{id}/update_ajax', [SalesController::class, 'update_ajax']);
    Route::get('/{id}/delete_ajax', [SalesController::class, 'delete_ajax']);
    Route::delete('/{id}/destroy_ajax', [SalesController::class, 'destroy_ajax']);

    // Fitur Konvensional / Non-AJAX (Backup)
    Route::get('/create', [SalesController::class, 'create']);
    Route::post('/', [SalesController::class, 'store']);
    Route::get('/{id}', [SalesController::class, 'show']);
    Route::get('/{id}/edit', [SalesController::class, 'edit']);
    Route::put('/{id}', [SalesController::class, 'update']);
    Route::delete('/{id}', [SalesController::class, 'destroy']);
});