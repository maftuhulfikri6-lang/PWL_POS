<?php

namespace App\Http\Controllers;

use App\Models\UserModel;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
    // Menghitung jumlah user dengan level_id = 2
    $user = UserModel::where('level_id', 2)->count();

    // Mengirim hasil hitungan (angka) ke view
    return view('user', ['data' => $user]);
}
    }
