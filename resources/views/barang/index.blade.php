@extends('layouts.template')

@section('content')
<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">{{ $page->title }}</h3>
        <div class="card-tools">
            <a class="btn btn-sm btn-primary mt-1" href="{{ url('barang/create') }}">Tambah</a>
            
            <button onclick="modalAction('{{ url('/barang/create_ajax') }}')" class="btn btn-sm btn-success mt-1">Tambah (AJAX)</button>
        </div>
    </div>
    <div class="card-body">
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <table class="table table-bordered table-striped table-hover table-sm" id="table_barang">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Kode Barang</th>
                    <th>Nama Barang</th>
                    <th>Kategori</th>
                    <th>Harga Beli</th>
                    <th>Harga Jual</th>
                    <th>Aksi</th>
                </tr>
            </thead>
        </table>
    </div>
</div>

<div id="myModal" class="modal fade animate easeInBack" tabindex="-1" role="dialog" aria-hidden="true"></div>
@endsection

@push('js')
<script>
    // Deklarasi variabel global agar bisa di-reload oleh file modal create/edit/delete_ajax
    var tableBarang; 

    // Fungsi untuk memicu kemunculan modal Bootstrap dan memuat konten form AJAX
    function modalAction(url = ''){
        $('#myModal').load(url, function(){
            $('#myModal').modal('show');
        });
    }

    $(document).ready(function() {
        tableBarang = $('#table_barang').DataTable({
            serverSide: true,
            ajax: {
                "url": "{{ url('barang/list') }}",
                "dataType": "json",
                "type": "POST",
                "headers": {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            },
            columns: [
                {
                    data: "DT_RowIndex",
                    className: "text-center",
                    orderable: false,
                    searchable: false
                },{
                    data: "barang_kode",
                    orderable: true,
                    searchable: true
                },{
                    data: "barang_nama",
                    orderable: true,
                    searchable: true
                },{
                    data: "kategori.kategori_nama", // Menampilkan relasi nama kategori
                    orderable: false,
                    searchable: false
                },{
                    data: "harga_beli",
                    className: "text-right",
                    render: function(data) { return 'Rp ' + new Intl.NumberFormat('id-ID').format(data); }
                },{
                    data: "harga_jual",
                    className: "text-right",
                    render: function(data) { return 'Rp ' + new Intl.NumberFormat('id-ID').format(data); }
                },{
                    data: "aksi",
                    className: "text-center",
                    orderable: false,
                    searchable: false
                }
            ]
        });
    });
</script>
@endpush