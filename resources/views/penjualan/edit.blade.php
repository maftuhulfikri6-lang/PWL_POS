@extends('layouts.template')

@section('content')
<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">{{ $page->title }}</h3>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ url('/penjualan/' . $penjualan->penjualan_id) }}" class="form-horizontal">
            @csrf
            {!! method_field('PUT') !!}

            <div class="form-group row">
                <label class="col-2">Pembeli</label>
                <div class="col-10">
                    <input type="text" name="pembeli" class="form-control" value="{{ old('pembeli', $penjualan->pembeli) }}" required>
                </div>
            </div>

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Barang</th>
                        <th>Jumlah</th>
                        <th>Harga</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($penjualan->detail as $item)
                    <tr>
                        <td>
                            <select name="barang_id[]" class="form-control" required>
                                @foreach($barang as $b)
                                    <option value="{{ $b->barang_id }}" {{ $item->barang_id == $b->barang_id ? 'selected' : '' }}>
                                        {{ $b->barang_nama }}
                                    </option>
                                @endforeach
                            </select>
                        </td>
                        <td><input type="number" name="jumlah[]" class="form-control" value="{{ $item->jumlah }}" required></td>
                        <td><input type="number" name="harga[]" class="form-control" value="{{ $item->harga }}" required></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="form-group row">
                <div class="col-12">
                    <button type="submit" class="btn btn-primary btn-sm">Simpan Perubahan</button>
                    <a class="btn btn-sm btn-default ml-1" href="{{ url('penjualan') }}">Kembali</a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection