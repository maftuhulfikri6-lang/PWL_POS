<?php

namespace App\Http\Controllers;

use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        // Ganti create() menjadi firstOrCreate agar tidak error duplikat
        // Pakai username yang unik, misalnya 'manager_baru_1'
        $user = UserModel::firstOrCreate([
            'username' => 'manager_baru_1',
            'nama' => 'Manager Baru Satu',
            'password' => Hash::make('12345'),
            'level_id' => 2,
        ]);

        // Simulasi perubahan data untuk mengetes wasChanged()
        $user->username = 'manager_baru_updated';
        
        // Simpan ke database
        $user->save();

        // Cek riwayat perubahan setelah proses save()
        // Karena username diubah dari 'manager_baru_1' ke 'manager_baru_updated',
        // maka hasil wasChanged() pasti true.
        dd($user->wasChanged()); 
    }
}