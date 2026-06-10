@empty($supplier)
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Kesalahan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger">
                    <h5><i class="icon fas fa-ban"></i> Kesalahan!</h5>
                    Data supplier tidak ditemukan.
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-primary">Tutup</button>
            </div>
        </div>
    </div>
@else
    <form action="{{ url('/supplier/' . $supplier->supplier_id . '/update_ajax') }}" method="POST" id="form-edit-supplier">
        @csrf
        @method('PUT')
        <div id="modal-master" class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Data Supplier (AJAX)</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        <label class="col-2 col-form-label text-right">Kode Supplier</label>
                        <div class="col-10">
                            <input value="{{ $supplier->supplier_kode }}" type="text" name="supplier_kode" id="supplier_kode" class="form-control" required>
                            <small id="error-supplier_kode" class="error-text text-danger"></small>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-2 col-form-label text-right">Nama Supplier</label>
                        <div class="col-10">
                            <input value="{{ $supplier->supplier_nama }}" type="text" name="supplier_nama" id="supplier_nama" class="form-control" required>
                            <small id="error-supplier_nama" class="error-text text-danger"></small>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-2 col-form-label text-right">Alamat</label>
                        <div class="col-10">
                            <textarea name="supplier_alamat" id="supplier_alamat" class="form-control" rows="3" required>{{ $supplier->supplier_alamat }}</textarea>
                            <small id="error-supplier_alamat" class="error-text text-danger"></small>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn btn-warning">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </div>
        </div>
    </form>

    <script>
        $(document).ready(function() {
            $("#form-edit-supplier").validate({
                rules: {
                    supplier_kode: {
                        required: true, 
                        minlength: 3, 
                        maxlength: 10
                    },
                    supplier_nama: {
                        required: true, 
                        minlength: 3, 
                        maxlength: 100
                    },
                    supplier_alamat: {
                        required: true, 
                        minlength: 5, 
                        maxlength: 255
                    }
                },
                submitHandler: function(form) {
                    $.ajax({
                        url: form.action,
                        type: form.method,
                        data: $(form).serialize(),
                        success: function(response) {
                            if(response.status){
                                // Tutup modal jika pembaruan data berhasil
                                $('#myModal').modal('hide');
                                
                                // Berikan feedback visual sukses menggunakan SweetAlert2
                                Swal.fire({ 
                                    icon: 'success', 
                                    title: 'Berhasil', 
                                    text: response.message 
                                });
                                
                                // Segarkan / reload DataTable supplier di halaman index secara realtime
                                tableSupplier.ajax.reload();
                            } else {
                                // Bersihkan teks pesan error lama
                                $('.error-text').text('');
                                
                                // Tampilkan pesan error validasi unik dari controller (jika kode supplier duplikat)
                                $.each(response.msgField, function(prefix, val) {
                                    $('#error-'+prefix).text(val[0]);
                                });
                                
                                Swal.fire({ 
                                    icon: 'error', 
                                    title: 'Terjadi Kesalahan', 
                                    text: response.message 
                                });
                            }
                        },
                        error: function(xhr) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Terjadi kegagalan sistem pada server.'
                            });
                        }
                    });
                    return false; // Blokir submit bawaan HTML form browser
                }
            });
        });
    </script>
@endempty