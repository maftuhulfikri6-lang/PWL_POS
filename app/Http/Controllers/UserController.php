<?php

namespace App\Http\Controllers;

use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
  public function index()
{
    // Mengambil data user beserta relasi level-nya
    $user = UserModel::with('level')->get();
    
    // Menampilkan ke view 'user' dengan data tersebut
    return view('user', ['data' => $user]);
}
    public function tambah() 
    {
        return view('user_tambah');
    }

    public function tambah_simpan(Request $request) 
    {
        UserModel::create([
            'username' => $request->username,
            'nama'     => $request->nama,
            'password' => Hash::make($request->password), 
            'level_id' => $request->level_id
        ]);
        return redirect('/user');
    }

    public function ubah(string $id) 
    {
        // find() mengembalikan objek tunggal agar tidak error di view
        $user = UserModel::find($id);
        return view('user_ubah', ['data' => $user]);
    }

    public function ubah_simpan(string $id, Request $request) 
    {
        $user = UserModel::find($id);
        $user->username = $request->username;
        $user->nama = $request->nama;
        
        // Update password hanya jika diisi di form
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }
        
        $user->level_id = $request->level_id;
        $user->save(); 

        return redirect('/user');
    }

    public function hapus(string $id) 
    {
        $user = UserModel::find($id);
        if($user) { 
            $user->delete(); 
        }
        return redirect('/user');
    }
}