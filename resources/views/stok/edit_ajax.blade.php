@empty($stok)
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
                    Data transaksi stok yang Anda cari tidak ditemukan.
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-primary">Tutup</button>
            </div>
        </div>
    </div>
@else
    <form action="{{ url('/stok/' . $stok->stok_id . '/update_ajax') }}" method="POST" id="form-edit-stok">
        @csrf
        @method('PUT')
        <div id="modal-master" class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Data Stok Barang (AJAX)</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        <label class="col-2 col-form-label text-right">Barang</label>
                        <div class="col-10">
                            <select name="barang_id" id="barang_id" class="form-control" required>
                                <option value="">- Pilih Barang -</option>
                                @foreach ($barang as $item)
                                    <option value="{{ $item->barang_id }}" {{ $item->barang_id == $stok->barang_id ? 'selected' : '' }}>
                                        {{ $item->barang_nama }}
                                    </option>
                                @endforeach </select>
                            <small id="error-barang_id" class="error-text text-danger"></small>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-2 col-form-label text-right">User (Petugas)</label>
                        <div class="col-10">
                            <select name="user_id" id="user_id" class="form-control" required>
                                <option value="">- Pilih User -</option>
                                @foreach ($user as $u)
                                    <option value="{{ $u->user_id }}" {{ $u->user_id == $stok->user_id ? 'selected' : '' }}>
                                        {{ $u->nama }}
                                    </option>
                                @endforeach </select>
                            <small id="error-user_id" class="error-text text-danger"></small>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-2 col-form-label text-right">Tanggal</label>
                        <div class="col-10">
                            <input type="datetime-local" name="stok_tanggal" id="stok_tanggal" 
                                   value="{{ date('Y-m-d\TH:i', strtotime($stok->stok_tanggal)) }}" class="form-control" required>
                            <small id="error-stok_tanggal" class="error-text text-danger"></small>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-2 col-form-label text-right">Jumlah</label>
                        <div class="col-10">
                            <input type="number" name="stok_jumlah" id="stok_jumlah" value="{{ $stok->stok_jumlah }}" class="form-control" required>
                            <small id="error-stok_jumlah" class="error-text text-danger"></small>
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
            $("#form-edit-stok").validate({
                rules: {
                    barang_id: { required: true, number: true },
                    user_id: { required: true, number: true },
                    stok_tanggal: { required: true },
                    stok_jumlah: { required: true, number: true, min: 1 }
                },
                submitHandler: function(form) {
                    $.ajax({
                        url: form.action,
                        type: form.method,
                        data: $(form).serialize(),
                        success: function(response) {
                            if(response.status){
                                $('#myModal').modal('hide');
                                
                                Swal.fire({ 
                                    icon: 'success', 
                                    title: 'Berhasil', 
                                    text: response.message 
                                });
                                
                                tableStok.ajax.reload();
                            } else {
                                $('.error-text').text('');
                                
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
                                text: 'Gagal memperbarui data. Terjadi kesalahan pada server.'
                            });
                        }
                    });
                    return false;
                }
            });
        });
    </script>
@endempty