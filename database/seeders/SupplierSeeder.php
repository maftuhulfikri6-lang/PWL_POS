<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
public function run(): void {
    $data = [
        ['supplier_id' => 1, 'supplier_kode' => 'S001', 'supplier_nama' => 'PT Sumber Makmur', 'supplier_alamat' => 'Malang'],
        ['supplier_id' => 2, 'supplier_kode' => 'S002', 'supplier_nama' => 'CV Maju Jaya', 'supplier_alamat' => 'Surabaya'],
        ['supplier_id' => 3, 'supplier_kode' => 'S003', 'supplier_nama' => 'UD Berkah Mandiri', 'supplier_alamat' => 'Gondanglegi'],
    ];
    DB::table('m_supplier')->insert($data);
}
}
