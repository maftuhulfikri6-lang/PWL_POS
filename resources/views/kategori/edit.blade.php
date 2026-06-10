@extends('layouts.template')

@section('content')
<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">{{ $page->title }}</h3>
    </div>
    <div class="card-body">
        @empty($kategori)
            <div class="alert alert-danger"><h5>Kesalahan!</h5>Data tidak ditemukan.</div>
        @else
            <form method="POST" action="{{ url('/kategori/'.$kategori->kategori_id) }}" class="form-horizontal">
                @csrf
                {!! method_field('PUT') !!} <div class="form-group row">
                    <label class="col-1 control-label">Kode Kategori</label>
                    <div class="col-11">
                        <input type="text" class="form-control" name="kategori_kode" 
                               value="{{ old('kategori_kode', $kategori->kategori_kode) }}" required>
                        @error('kategori_kode') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-1 control-label">Nama Kategori</label>
                    <div class="col-11">
                        <input type="text" class="form-control" name="kategori_nama" 
                               value="{{ old('kategori_nama', $kategori->kategori_nama) }}" required>
                        @error('kategori_nama') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-11 offset-1">
                        <button type="submit" class="btn btn-primary btn-sm">Simpan Perubahan</button>
                        <a class="btn btn-sm btn-default ml-1" href="{{ url('kategori') }}">Kembali</a>
                    </div>
                </div>
            </form>
        @endempty
    </div>
</div>
@endsection