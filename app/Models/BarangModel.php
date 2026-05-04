<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\KategoriModel;

class BarangModel extends Model
{
    protected $table = 'm_barang';
    protected $primaryKey = 'barang_id';

    // Mendefinisikan field yang boleh diisi
    protected $fillable = ['kategori_id', 'barang_kode', 'barang_nama', 'harga_beli', 'harga_jual'];

    // Relasi ke KategoriModel (m_kategori)
    public function kategori(): BelongsTo
    {
        return $this->belongsTo(KategoriModel::class, 'kategori_id', 'kategori_id');
    }
}