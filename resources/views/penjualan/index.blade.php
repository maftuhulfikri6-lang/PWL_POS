@extends('layouts.template')

@section('content')
<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">{{ $page->title }}</h3>
        <div class="card-tools">
            <a class="btn btn-sm btn-primary mt-1" href="{{ url('penjualan/create') }}">Tambah</a>
            
            <button onclick="modalAction('{{ url('/penjualan/create_ajax') }}')" class="btn btn-sm btn-success mt-1 ml-1">Tambah (AJAX)</button>
        </div>
    </div>
    <div class="card-body">
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <div class="row mb-3">
            <div class="col-md-12">
                <div class="form-group row">
                    <label class="col-1 col-form-label">Filter:</label>
                    <div class="col-3">
                        <select class="form-control" id="filter_user" name="filter_user">
                            <option value="">- Semua Petugas -</option>
                            @foreach($user as $u)
                                <option value="{{ $u->user_id }}">{{ $u->nama }}</option>
                            @endforeach
                        </select>
                        <small class="form-text text-muted">Filter berdasarkan petugas input</small>
                    </div>
                </div>
            </div>
        </div>

        <table class="table table-bordered table-striped table-hover table-sm" id="table_penjualan">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Pembeli</th>
                    <th>Tanggal Penjualan</th>
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
    // Deklarasi variabel global agar bisa dibaca oleh file modal create_ajax, edit_ajax, dll.
    var tablePenjualan; 

    // Fungsi untuk memicu kemunculan modal Bootstrap dan memuat konten form AJAX
    function modalAction(url = ''){
        $('#myModal').load(url, function(){
            $('#myModal').modal('show');
        });
    }

    $(document).ready(function() {
        tablePenjualan = $('#table_penjualan').DataTable({
            serverSide: true,
            ajax: {
                "url": "{{ url('penjualan/list') }}",
                "dataType": "json",
                "type": "POST",
                "headers": {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                "data": function (d) {
                    d.user_id = $('#filter_user').val(); // Mengirim parameter filter ke server-side
                }
            },
            columns: [
                {
                    data: "DT_RowIndex",
                    className: "text-center",
                    orderable: false,
                    searchable: false
                },{
                    data: "pembeli",
                    orderable: true,
                    searchable: true
                },{
                    data: "penjualan_tanggal",
                    orderable: true,
                    searchable: true
                },{
                    data: "user.username",
                    orderable: true,
                    searchable: true
                },{
                    data: "aksi",
                    className: "text-center",
                    orderable: false,
                    searchable: false
                }
            ]
        });

        // Trigger reload tabel saat filter dropdown diubah
        $('#filter_user').on('change', function() {
            tablePenjualan.ajax.reload();
        });
    });
</script>
@endpush