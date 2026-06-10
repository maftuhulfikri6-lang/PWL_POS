@empty($penjualan)
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
                    Data transaksi penjualan yang Anda cari tidak ditemukan.
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-primary">Tutup</button>
            </div>
        </div>
    </div>
@else
    <form action="{{ url('/penjualan/' . $penjualan->penjualan_id . '/update_ajax') }}" method="POST" id="form-edit-penjualan">
        @csrf
        @method('PUT')
        <div id="modal-master" class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Transaksi Penjualan (AJAX)</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        <label class="col-2 col-form-label text-right">Pembeli</label>
                        <div class="col-10">
                            <input type="text" name="pembeli" id="pembeli" class="form-control" value="{{ old('pembeli', $penjualan->pembeli) }}" required>
                            <small id="error-pembeli" class="error-text text-danger"></small>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-2 col-form-label text-right">Petugas / User</label>
                        <div class="col-10">
                            <input type="text" class="form-control" value="{{ $penjualan->user->nama }}" readonly>
                            <small class="form-text text-muted">*Petugas penginput awal tidak dapat diubah.</small>
                        </div>
                    </div>

                    <hr>
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h5>Daftar Item Barang</h5>
                        <button type="button" class="btn btn-success btn-sm" id="add-row-edit-ajax">
                            <i class="fas fa-plus"></i> Tambah Barang
                        </button>
                    </div>

                    <table class="table table-sm table-bordered" id="table-barang-edit-ajax">
                        <thead class="bg-light">
                            <tr>
                                <th>Barang</th>
                                <th style="width: 15%">Jumlah</th>
                                <th style="width: 25%">Harga (Rp)</th>
                                <th style="width: 10%" class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="barang-body-edit-ajax">
                            @foreach($penjualan->detail as $item)
                                <tr class="barang-row">
                                    <td>
                                        <select name="barang_id[]" class="form-control select-barang" required>
                                            <option value="">- Pilih Barang -</option>
                                            @foreach($barang as $b)
                                                <option value="{{ $b->barang_id }}" data-harga="{{ $b->harga_jual }}" {{ $item->barang_id == $b->barang_id ? 'selected' : '' }}>
                                                    {{ $b->barang_nama }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        <input type="number" name="jumlah[]" class="form-control" min="1" value="{{ $item->jumlah }}" required>
                                    </td>
                                    <td>
                                        <input type="number" name="harga[]" class="form-control input-harga" value="{{ $item->harga }}" readonly required>
                                    </td>
                                    <td class="text-center">
                                        <button type="button" class="btn btn-danger btn-sm remove-row-edit-ajax" {{ count($penjualan->detail) == 1 ? 'disabled' : '' }}>
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
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
            // Otomatis isi harga jual saat produk/barang diubah
            $(document).on('change', '.select-barang', function() {
                let harga = $(this).find(':selected').data('harga');
                $(this).closest('tr').find('.input-harga').val(harga ? harga : '');
            });

            // Mekanisme Tambah Baris Dinamis di dalam Modal Edit
            $('#add-row-edit-ajax').click(function() {
                let newRow = $('#barang-body-edit-ajax tr:first').clone();
                newRow.find('select, input').val('');
                newRow.find('input[name="jumlah[]"]').val('1');
                newRow.find('.remove-row-edit-ajax').removeAttr('disabled');
                $('#barang-body-edit-ajax').append(newRow);
                
                // Aktifkan tombol hapus di baris lain jika baris bertambah dari 1
                if($('#barang-body-edit-ajax tr').length > 1) {
                    $('.remove-row-edit-ajax').removeAttr('disabled');
                }
            });

            // Mekanisme Hapus Baris Item Belanjaan
            $(document).on('click', '.remove-row-edit-ajax', function() {
                if($('#barang-body-edit-ajax tr').length > 1) {
                    $(this).closest('tr').remove();
                }
                
                // Jika baris sisa 1, kunci tombol hapus agar tidak kosong total
                if($('#barang-body-edit-ajax tr').length == 1) {
                    $('.remove-row-edit-ajax').attr('disabled', 'disabled');
                }
            });

            // Validasi dan Handler Submit AJAX
            $("#form-edit-penjualan").validate({
                rules: {
                    pembeli: { required: true, maxlength: 100 }
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
                                tablePenjualan.ajax.reload(); // Reload DataTable utama
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
                                text: 'Gagal memperbarui transaksi. Terjadi kesalahan pada server.'
                            });
                        }
                    });
                    return false;
                }
            });
        });
    </script>
@endempty