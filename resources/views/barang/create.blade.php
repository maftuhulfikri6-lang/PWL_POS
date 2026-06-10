@extends('layouts.template')

@section('content')
<div class="card card-outline card-primary">
    <div class="card-header"><h3 class="card-title">{{ $page->title }}</h3></div>
    <div class="card-body">
        <form method="POST" action="{{ url('barang') }}" class="form-horizontal">
            @csrf
            <div class="form-group row">
                <label class="col-2 control-label">Kategori</label>
                <div class="col-10">
                    <select class="form-control" name="kategori_id" required>
                        <option value="">- Pilih Kategori -</option>
                        @foreach($kategori as $item)
                            <option value="{{ $item->kategori_id }}">{{ $item->kategori_nama }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-2 control-label">Kode Barang</label>
                <div class="col-10">
                    <input type="text" class="form-control" name="barang_kode" required>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-2 control-label">Nama Barang</label>
                <div class="col-10">
                    <input type="text" class="form-control" name="barang_nama" required>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-2 control-label">Harga Beli</label>
                <div class="col-10">
                    <input type="number" class="form-control" name="harga_beli" required>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-2 control-label">Harga Jual</label>
                <div class="col-10">
                    <input type="number" class="form-control" name="harga_jual" required>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-10 offset-2">
                    <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
                    <a class="btn btn-sm btn-default" href="{{ url('barang') }}">Kembali</a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection