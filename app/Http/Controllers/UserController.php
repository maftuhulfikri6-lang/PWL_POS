<?php

namespace App\Http\Controllers;

use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        // 1. Membuat instance objek baru di memori jika 'manager33' tidak ditemukan
        $user = UserModel::firstOrNew(
            [
                'username' => 'manager33',
                'nama' => 'Manager Tiga Tiga',
                'password' => Hash::make('12345'),
                'level_id' => 2
            ],
        );

        // 2. Menyimpan objek tersebut dari memori ke database secara permanen
        $user->save();

        return view('user', ['data' => $user]);
    }
}