<?php

namespace App\Http\Controllers;

use App\Models\UserModel;
use Illuminate\Http\Request; // Tambahkan ini agar standar controller lengkap

class UserController extends Controller
{
    public function index()
    {
        // Mencari user dengan ID 20. 
        // Jika data tidak ditemukan, maka fungsi abort(404) akan dijalankan.
        $user = UserModel::findOr(20, ['username', 'nama'], function () {
            abort(404);
        });

        return view('user', ['data' => $user]);
    }
}