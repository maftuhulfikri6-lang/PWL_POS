@extends('layouts.template')

@section('content')
<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">{{ $page->title }}</h3>
    </div>
    <div class="card-body">
        @empty($supplier)
            <div class="alert alert-danger"><h5>Kesalahan!</h5>Data tidak ditemukan.</div>
        @else
            <form method="POST" action="{{ url('/supplier/'.$supplier->supplier_id) }}" class="form-horizontal">
                @csrf
                {!! method_field('PUT') !!} <div class="form-group row">
                    <label class="col-2 control-label">Kode Supplier</label>
                    <div class="col-10">
                        <input type="text" class="form-control" name="supplier_kode" 
                               value="{{ old('supplier_kode', $supplier->supplier_kode) }}" required>
                        @error('supplier_kode') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-2 control-label">Nama Supplier</label>
                    <div class="col-10">
                        <input type="text" class="form-control" name="supplier_nama" 
                               value="{{ old('supplier_nama', $supplier->supplier_nama) }}" required>
                        @error('supplier_nama') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-2 control-label">Alamat</label>
                    <div class="col-10">
                        <textarea class="form-control" name="supplier_alamat" required>{{ old('supplier_alamat', $supplier->supplier_alamat) }}</textarea>
                        @error('supplier_alamat') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-10 offset-2">
                        <button type="submit" class="btn btn-primary btn-sm">Simpan Perubahan</button>
                        <a class="btn btn-sm btn-default ml-1" href="{{ url('supplier') }}">Kembali</a>
                    </div>
                </div>
            </form>
        @endempty
    </div>
</div>
@endsection