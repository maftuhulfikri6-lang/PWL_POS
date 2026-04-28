<?php

namespace App\Http\Controllers;

use App\Models\UserModel;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        // Mencari data pertama dengan username 'manager9'
        // Jika tidak ada, otomatis melempar error 404
        $user = UserModel::where('username', 'manager9')->firstOrFail();

        return view('user', ['data' => $user]);
    }
}