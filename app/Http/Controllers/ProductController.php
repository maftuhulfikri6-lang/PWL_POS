<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function foodBeverage() { return "<h1>Daftar Produk: Food & Beverage</h1>"; }
public function beautyHealth() { return "<h1>Daftar Produk: Beauty & Health</h1>"; }
public function homeCare() { return "<h1>Daftar Produk: Home Care</h1>"; }
public function babyKid() { return "<h1>Daftar Produk: Baby & Kid</h1>"; }
}
