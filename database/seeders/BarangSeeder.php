<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BarangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
public function run(): void
{
    $data = [
        // Kategori 1: Makanan
        ['barang_id' => 1, 'kategori_id' => 1, 'barang_kode' => 'MKN01', 'barang_nama' => 'Roti Tawar', 'harga_beli' => 10000, 'harga_jual' => 12000],
        ['barang_id' => 2, 'kategori_id' => 1, 'barang_kode' => 'MKN02', 'barang_nama' => 'Indomie Goreng', 'harga_beli' => 2500, 'harga_jual' => 3000],
        ['barang_id' => 3, 'kategori_id' => 1, 'barang_kode' => 'MKN03', 'barang_nama' => 'Biskuit Roma', 'harga_beli' => 7000, 'harga_jual' => 8500],
        
        // Kategori 2: Minuman
        ['barang_id' => 4, 'kategori_id' => 2, 'barang_kode' => 'MNM01', 'barang_nama' => 'Aqua 600ml', 'harga_beli' => 3000, 'harga_jual' => 4000],
        ['barang_id' => 5, 'kategori_id' => 2, 'barang_kode' => 'MNM02', 'barang_nama' => 'Susu Kotak Ultra', 'harga_beli' => 5000, 'harga_jual' => 6500],
        ['barang_id' => 6, 'kategori_id' => 2, 'barang_kode' => 'MNM03', 'barang_nama' => 'Kopi Kapal Api', 'harga_beli' => 1500, 'harga_jual' => 2000],
        
        // Kategori 3: Kosmetik
        ['barang_id' => 7, 'kategori_id' => 3, 'barang_kode' => 'KOS01', 'barang_nama' => 'Sabun Mandi Lifebuoy', 'harga_beli' => 4000, 'harga_jual' => 5000],
        ['barang_id' => 8, 'kategori_id' => 3, 'barang_kode' => 'KOS02', 'barang_nama' => 'Pepsodent 190g', 'harga_beli' => 12000, 'harga_jual' => 14500],
        ['barang_id' => 9, 'kategori_id' => 3, 'barang_kode' => 'KOS03', 'barang_nama' => 'Shampoo Sunsilk', 'harga_beli' => 18000, 'harga_jual' => 21000],
        
        // Kategori 4: Elektronik
        ['barang_id' => 10, 'kategori_id' => 4, 'barang_kode' => 'ELK01', 'barang_nama' => 'Mouse Logitech', 'harga_beli' => 120000, 'harga_jual' => 150000],
        ['barang_id' => 11, 'kategori_id' => 4, 'barang_kode' => 'ELK02', 'barang_nama' => 'Keyboard Mechanical', 'harga_beli' => 350000, 'harga_jual' => 420000],
        ['barang_id' => 12, 'kategori_id' => 4, 'barang_kode' => 'ELK03', 'barang_nama' => 'Flashdisk 32GB', 'harga_beli' => 65000, 'harga_jual' => 85000],
        
        // Kategori 5: Peralatan Rumah
        ['barang_id' => 13, 'kategori_id' => 5, 'barang_kode' => 'PRT01', 'barang_nama' => 'Sapu Lantai', 'harga_beli' => 15000, 'harga_jual' => 20000],
        ['barang_id' => 14, 'kategori_id' => 5, 'barang_kode' => 'PRT02', 'barang_nama' => 'Panci Masak', 'harga_beli' => 45000, 'harga_jual' => 55000],
        ['barang_id' => 15, 'kategori_id' => 5, 'barang_kode' => 'PRT03', 'barang_nama' => 'Lampu LED 10W', 'harga_beli' => 25000, 'harga_jual' => 32000],
    ];

    \Illuminate\Support\Facades\DB::table('m_barang')->insert($data);
}
}
