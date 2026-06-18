<?php

use App\Http\Controllers\BarangController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\StokController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\AuthController; // Tambahkan ini
use Illuminate\Support\Facades\Route;

// --- RUTE AUTHENTIKASI ---
Route::pattern('id', '[0-9]+'); // Aturan global untuk ID berupa angka
Route::get('login', [AuthController::class, 'login'])->name('login');
Route::post('login', [AuthController::class, 'postlogin']);
Route::get('logout', [AuthController::class, 'logout'])->middleware('auth');

// Group rute untuk Level (HANYA ADMIN)
Route::middleware(['auth'])->group(function () {

    Route::get('/', [WelcomeController::class, 'index']);


    Route::middleware(['authorize:ADM'])->group(function(){
    // Group rute untuk User
    Route::group(['prefix' => 'user'], function () {
        Route::get('/', [UserController::class, 'index']);          
        Route::post('/list', [UserController::class, 'list']);      
        
        Route::get('/create', [UserController::class, 'create']);   
        Route::post('/', [UserController::class, 'store']);         
        Route::get('/create_ajax', [UserController::class, 'createAjax']); 
        Route::post('/create_ajax', [UserController::class, 'store_ajax']); 

        Route::get('/{id}/show_ajax', [UserController::class, 'show_ajax']);
        Route::get('/{id}/edit_ajax', [UserController::class, 'edit_ajax']); 
        Route::put('/{id}/update_ajax', [UserController::class, 'update_ajax']); 
        Route::get('/{id}/delete_ajax', [UserController::class, 'confirm_ajax']); 
        Route::delete('/{id}/delete_ajax', [UserController::class, 'delete_ajax']); 

        Route::get('/{id}', [UserController::class, 'show']);       
        Route::get('/{id}/edit', [UserController::class, 'edit']);  
        Route::put('/{id}', [UserController::class, 'update']);     
        Route::delete('/{id}', [UserController::class, 'destroy']); 
    });

        Route::get('/level', [LevelController::class,'index']);
        Route::post('/level/list', [LevelController::class,'list']); // untuk list json datatables
        Route::get('/level/create', [LevelController::class,'create']);
        Route::post('/level', [LevelController::class,'store']);
        Route::get('/level/{id}/edit', [LevelController::class,'edit']); // untuk tampilkan form edit
        Route::put('/level/{id}', [LevelController::class,'update']); // untuk proses update data
        Route::delete('/level/{id}', [LevelController::class,'destroy']); // untuk proses hapus data
    });

});




 

    // Group rute untuk Kategori
    Route::group(['prefix' => 'kategori'], function () {
        Route::get('/', [KategoriController::class, 'index']);
        Route::post('/list', [KategoriController::class, 'list']);

        Route::get('/create', [KategoriController::class, 'create']);
        Route::post('/', [KategoriController::class, 'store']);
        Route::get('/create_ajax', [KategoriController::class, 'create_ajax']);
        Route::post('/ajax', [KategoriController::class, 'store_ajax']);

        Route::get('/{id}/show_ajax', [KategoriController::class, 'show_ajax']);
        Route::get('/{id}/edit_ajax', [KategoriController::class, 'edit_ajax']);
        Route::put('/{id}/update_ajax', [KategoriController::class, 'update_ajax']);
        Route::get('/{id}/delete_ajax', [KategoriController::class, 'confirm_ajax']);
        Route::delete('/{id}/delete_ajax', [KategoriController::class, 'delete_ajax']);
        
        Route::get('/{id}', [KategoriController::class, 'show']);
        Route::get('/{id}/edit', [KategoriController::class, 'edit']);
        Route::put('/{id}', [KategoriController::class, 'update']);
        Route::delete('/{id}', [KategoriController::class, 'destroy']);
    });

    // Group rute untuk Supplier
    Route::group(['prefix' => 'supplier'], function () {
        Route::get('/', [SupplierController::class, 'index']);
        Route::post('/list', [SupplierController::class, 'list']); 

        Route::get('/create_ajax', [SupplierController::class, 'create_ajax']);
        Route::post('/ajax', [SupplierController::class, 'store_ajax']);

        Route::get('/{id}/show_ajax', [SupplierController::class, 'show_ajax']);
        Route::get('/{id}/edit_ajax', [SupplierController::class, 'edit_ajax']);
        Route::put('/{id}/update_ajax', [SupplierController::class, 'update_ajax']);
        Route::get('/{id}/delete_ajax', [SupplierController::class, 'confirm_ajax']);
        Route::delete('/{id}/delete_ajax', [SupplierController::class, 'delete_ajax']);

        Route::get('/create', [SupplierController::class, 'create']);
        Route::post('/', [SupplierController::class, 'store']);
        Route::get('/{id}', [SupplierController::class, 'show']);
        Route::get('/{id}/edit', [SupplierController::class, 'edit']);
        Route::put('/{id}', [SupplierController::class, 'update']);
        Route::delete('/{id}', [SupplierController::class, 'destroy']);
    });

    // Group rute untuk Barang
    Route::group(['prefix' => 'barang'], function () {
        Route::get('/', [BarangController::class, 'index']);
        Route::post('/list', [BarangController::class, 'list']);
        
        Route::get('/create', [BarangController::class, 'create']);
        Route::post('/', [BarangController::class, 'store']);
        Route::get('/create_ajax', [BarangController::class, 'create_ajax']);
        Route::post('/ajax', [BarangController::class, 'store_ajax']);

        Route::get('/{id}/show_ajax', [BarangController::class, 'show_ajax']);
        Route::get('/{id}/edit_ajax', [BarangController::class, 'edit_ajax']);
        Route::put('/{id}/update_ajax', [BarangController::class, 'update_ajax']);
        Route::get('/{id}/delete_ajax', [BarangController::class, 'confirm_ajax']);
        Route::delete('/{id}/delete_ajax', [BarangController::class, 'delete_ajax']);

        Route::get('/{id}', [BarangController::class, 'show']);
        Route::get('/{id}/edit', [BarangController::class, 'edit']);
        Route::put('/{id}', [BarangController::class, 'update']);
        Route::delete('/{id}', [BarangController::class, 'destroy']);
    });

    // Group rute untuk Stok Barang
    Route::group(['prefix' => 'stok'], function () {
        Route::get('/', [StokController::class, 'index']);
        Route::post('/list', [StokController::class, 'list']); 
        
        Route::get('/create', [StokController::class, 'create']);
        Route::post('/', [StokController::class, 'store']);
        Route::get('/create_ajax', [StokController::class, 'create_ajax']); 
        Route::post('/ajax', [StokController::class, 'store_ajax']);      

        Route::get('/{id}/show_ajax', [StokController::class, 'show_ajax']);
        Route::get('/{id}/edit_ajax', [StokController::class, 'edit_ajax']);
        Route::put('/{id}/update_ajax', [StokController::class, 'update_ajax']);
        Route::get('/{id}/delete_ajax', [StokController::class, 'confirm_ajax']);
        Route::delete('/{id}/delete_ajax', [StokController::class, 'delete_ajax']);

        Route::get('/{id}', [StokController::class, 'show']);
        Route::get('/{id}/edit', [StokController::class, 'edit']);
        Route::put('/{id}', [StokController::class, 'update']);
        Route::delete('/{id}', [StokController::class, 'destroy']);
    });

    // Group rute untuk Transaksi Penjualan
    Route::group(['prefix' => 'penjualan'], function () {
        Route::get('/', [SalesController::class, 'index']);
        Route::post('/list', [SalesController::class, 'list']); 

        Route::get('/{id}/confirm_ajax', [SalesController::class, 'confirm_ajax']);
        Route::delete('/{id}/delete_ajax', [SalesController::class, 'delete_ajax']);
        
        Route::get('/create_ajax', [SalesController::class, 'create_ajax']);
        Route::post('/store_ajax', [SalesController::class, 'store_ajax']);
        Route::get('/{id}/show_ajax', [SalesController::class, 'show_ajax']);
        Route::get('/{id}/edit_ajax', [SalesController::class, 'edit_ajax']);
        Route::put('/{id}/update_ajax', [SalesController::class, 'update_ajax']);
        Route::get('/{id}/delete_ajax', [SalesController::class, 'delete_ajax']);
        Route::delete('/{id}/destroy_ajax', [SalesController::class, 'destroy_ajax']);

        Route::get('/create', [SalesController::class, 'create']);
        Route::post('/', [SalesController::class, 'store']);
        Route::get('/{id}', [SalesController::class, 'show']);
        Route::get('/{id}/edit', [SalesController::class, 'edit']);
        Route::put('/{id}', [SalesController::class, 'update']);
        Route::delete('/{id}', [SalesController::class, 'destroy']);
    });
