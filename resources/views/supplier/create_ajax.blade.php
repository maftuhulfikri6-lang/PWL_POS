<form action="{{ url('/supplier/ajax') }}" method="POST" id="form-create-supplier">
    @csrf
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Data Supplier (AJAX)</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group row">
                    <label class="col-2 col-form-label text-right">Kode Supplier</label>
                    <div class="col-10">
                        <input type="text" name="supplier_kode" id="supplier_kode" class="form-control" placeholder="Contoh: SPL01" required>
                        <small id="error-supplier_kode" class="error-text text-danger"></small>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-2 col-form-label text-right">Nama Supplier</label>
                    <div class="col-10">
                        <input type="text" name="supplier_nama" id="supplier_nama" class="form-control" placeholder="Nama perusahaan / perorangan" required>
                        <small id="error-supplier_nama" class="error-text text-danger"></small>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-2 col-form-label text-right">Alamat</label>
                    <div class="col-10">
                        <textarea name="supplier_alamat" id="supplier_alamat" class="form-control" rows="3" placeholder="Alamat lengkap supplier" required></textarea>
                        <small id="error-supplier_alamat" class="error-text text-danger"></small>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-warning">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </div>
    </div>
</form>

<script>
    $(document).ready(function() {
        $("#form-create-supplier").validate({
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
                            // Menyembunyikan modal setelah berhasil
                            $('#myModal').modal('hide');
                            
                            // Menampilkan notifikasi sukses berupa SweetAlert2
                            Swal.fire({ 
                                icon: 'success', 
                                title: 'Berhasil', 
                                text: response.message 
                            });
                            
                            // Memuat ulang data di tabel supplier tanpa refresh halaman
                            tableSupplier.ajax.reload();
                        } else {
                            // Membersihkan pesan error lama
                            $('.error-text').text('');
                            
                            // Menampilkan pesan error validasi dari Laravel Controller
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
                            text: 'Terjadi kesalahan sistem. Silakan coba lagi.'
                        });
                    }
                });
                return false; // Mencegah form melakukan submit bawaan browser
            }
        });
    });
</script>