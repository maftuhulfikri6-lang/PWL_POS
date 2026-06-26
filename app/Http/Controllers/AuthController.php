<?php

namespace App\Http\Controllers;

use App\Models\UserModel;
use App\Models\LevelModel;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login()
    {
        if (Auth::check()) { // jika sudah login, maka redirect ke halaman home
            return redirect('/');
        }
        return view('auth.login');
    }

    public function postlogin(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $credentials = $request->only('username', 'password');

            if (Auth::attempt($credentials)) {
                return response()->json([
                    'status' => true,
                    'message' => 'Login Berhasil',
                    'redirect' => url('/')
                ]);
            }
            return response()->json([
                'status' => false,
                'message' => 'Login Gagal'
            ]);
        }
        return redirect('login');
    }

public function register()
{
    $level = LevelModel::all();
    
    // Siapkan object untuk breadcrumb
    $breadcrumb = (object) [
        'title' => 'Registrasi Pengguna',
        'list' => ['Home', 'Registrasi']
    ];

    return view('auth.register', compact('level', 'breadcrumb'));
}
public function storeRegister(Request $request)
{
    $request->validate([
        'username' => 'required|unique:m_user,username',
        'nama' => 'required',
        'password' => 'required|min:6|confirmed',
        'level_id' => 'required'
    ]);

    UserModel::create([
        'username' => $request->username,
        'nama' => $request->nama,
        'password' => Hash::make($request->password),
        'level_id' => $request->level_id
    ]);

    return redirect('login')->with('success', 'Registrasi berhasil');
}

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('login');
    }
}