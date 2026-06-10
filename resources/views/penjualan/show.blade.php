@extends('layouts.template')

@section('content')
<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">{{ $page->title }}</h3>
    </div>
    <div class="card-body">
        @empty($penjualan)
            <div class="alert alert-danger"><h5><i class="icon fas fa-ban"></i> Kesalahan!</h5>Data tidak ditemukan.</div>
        @else
            <table class="table table-bordered table-striped">
                <tr><th>ID Transaksi</th><td>{{ $penjualan->penjualan_id }}</td></tr>
                <tr><th>Nama Pembeli</th><td>{{ $penjualan->pembeli }}</td></tr>
                <tr><th>Tanggal Transaksi</th><td>{{ $penjualan->penjualan_tanggal }}</td></tr>
                <tr><th>Kasir (User)</th><td>{{ $penjualan->user->username }}</td></tr>
            </table>

            <h5 class="mt-4">Detail Barang</h5>
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Barang</th>
                        <th>Jumlah</th>
                        <th>Harga Satuan</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($penjualan->detail as $index => $d)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $d->barang->barang_nama }}</td>
                        <td>{{ $d->jumlah }}</td>
                        <td>Rp {{ number_format($d->harga, 0, ',', '.') }}</td>
                        <td>Rp {{ number_format($d->jumlah * $d->harga, 0, ',', '.') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @endempty
        <a href="{{ url('penjualan') }}" class="btn btn-sm btn-default mt-2">Kembali</a>
    </div>
</div>
@endsection