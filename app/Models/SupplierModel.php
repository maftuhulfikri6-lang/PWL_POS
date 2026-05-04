<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SupplierModel extends Model
{
    protected $table = 'm_supplier';
    protected $primaryKey = 'supplier_id';

    // Field yang boleh diisi (mass assignment)
    protected $fillable = ['supplier_kode', 'supplier_nama', 'supplier_alamat'];
}