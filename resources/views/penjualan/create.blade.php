@extends('layouts.template')

@section('content')
<div class="card card-outline card-primary">
    <div class="card-header"><h3 class="card-title">{{ $page->title }}</h3></div>
    <div class="card-body">
        <form method="POST" action="{{ url('penjualan') }}" class="form-horizontal">
            @csrf
            <div class="form-group row">
                <label class="col-2">Pembeli</label>
                <div class="col-10"><input type="text" name="pembeli" class="form-control" required></div>
            </div>

            <table class="table table-bordered" id="table-barang">
                <thead>
                    <tr>
                        <th>Barang</th>
                        <th>Jumlah</th>
                        <th>Harga</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody id="barang-body">
                    <tr>
                        <td>
                            <select name="barang_id[]" class="form-control" required>
                                <option value="">- Pilih Barang -</option>
                                @foreach($barang as $b)
                                    <option value="{{ $b->barang_id }}">{{ $b->barang_nama }}</option>
                                @endforeach
                            </select>
                        </td>
                        <td><input type="number" name="jumlah[]" class="form-control" required></td>
                        <td><input type="number" name="harga[]" class="form-control" required></td>
                        <td><button type="button" class="btn btn-danger btn-sm remove-row">Hapus</button></td>
                    </tr>
                </tbody>
            </table>
            <button type="button" class="btn btn-success mt-2" id="add-row">Tambah Barang</button>
            <button type="submit" class="btn btn-primary mt-2">Simpan Transaksi</button>
        </form>
    </div>
</div>
@endsection

@push('js')
<script>
    // Tambah baris baru
    $('#add-row').click(function() {
        let newRow = $('#barang-body tr:first').clone();
        newRow.find('input').val('');
        $('#barang-body').append(newRow);
    });

    // Hapus baris
    $(document).on('click', '.remove-row', function() {
        if($('#barang-body tr').length > 1) $(this).closest('tr').remove();
    });
</script>
@endpush