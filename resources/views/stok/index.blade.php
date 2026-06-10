@extends('layouts.template')

@section('content')
<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">{{ $page->title }}</h3>
        <div class="card-tools">
            <a class="btn btn-sm btn-primary mt-1" href="{{ url('stok/create') }}">Tambah</a>
            
            <button onclick="modalAction('{{ url('/stok/create_ajax') }}')" class="btn btn-sm btn-success mt-1">Tambah (AJAX)</button>
        </div>
    </div>
    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
        
        <table class="table table-bordered table-striped table-hover table-sm" id="table_stok">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Barang</th>
                    <th>Tanggal Stok</th>
                    <th>Jumlah</th>
                    <th>Diinput Oleh</th>
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
    // Deklarasi variabel global agar bisa di-reload oleh berkas modal create/edit/delete_ajax
    var tableStok; 

    // Fungsi untuk memicu kemunculan modal Bootstrap dan memuat konten form AJAX
    function modalAction(url = ''){
        $('#myModal').load(url, function(){
            $('#myModal').modal('show');
        });
    }

    $(document).ready(function() {
        tableStok = $('#table_stok').DataTable({
            serverSide: true,
            ajax: {
                "url": "{{ url('stok/list') }}",
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
                },
                { 
                    data: "barang.barang_nama",
                    orderable: false,
                    searchable: true 
                },
                { 
                    data: "stok_tanggal",
                    orderable: true,
                    searchable: true 
                },
                { 
                    data: "stok_jumlah",
                    className: "text-right",
                    orderable: true,
                    searchable: false 
                },
                { 
                    data: "user.nama", // Disesuaikan dengan kolom nama user di database
                    orderable: false,
                    searchable: true 
                },
                { 
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