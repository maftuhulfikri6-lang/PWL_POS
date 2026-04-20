<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function show($id, $name) {
    return "<h1>Profil Pengguna</h1><p>ID: $id</p><p>Nama: $name</p>";
}
}
