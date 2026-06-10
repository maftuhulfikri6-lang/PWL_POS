<form action="{{ url('/penjualan/store_ajax') }}" method="POST" id="form-tambah-penjualan">
    @csrf
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Transaksi Penjualan (AJAX)</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group row">
                    <label class="col-2 col-form-label text-right">Pembeli</label>
                    <div class="col-10">
                        <input type="text" name="pembeli" id="pembeli" class="form-control" placeholder="Nama Pembeli" required>
                        <small id="error-pembeli" class="error-text text-danger"></small>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-2 col-form-label text-right">Petugas / User</label>
                    <div class="col-10">
                        <select name="user_id" id="user_id" class="form-control" required>
                            <option value="">- Pilih Petugas -</option>
                            @foreach($user as $u)
                                <option value="{{ $u->user_id }}">{{ $u->nama }}</option>
                            @endforeach
                        </select>
                        <small id="error-user_id" class="error-text text-danger"></small>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-2 col-form-label text-right">Tanggal</label>
                    <div class="col-10">
                        <input type="datetime-local" name="penjualan_tanggal" id="penjualan_tanggal" class="form-control" value="{{ date('Y-m-d\TH:i') }}" required>
                        <small id="error-penjualan_tanggal" class="error-text text-danger"></small>
                    </div>
                </div>

                <hr>
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h5>Daftar Item Barang</h5>
                    <button type="button" class="btn btn-success btn-sm" id="add-row-ajax">
                        <i class="fas fa-plus"></i> Tambah Barang
                    </button>
                </div>

                <table class="table table-sm table-bordered" id="table-barang-ajax">
                    <thead class="bg-light">
                        <tr>
                            <th>Barang</th>
                            <th style="width: 15%">Jumlah</th>
                            <th style="width: 25%">Harga (Rp)</th>
                            <th style="width: 10%" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="barang-body-ajax">
                        <tr class="barang-row">
                            <td>
                                <select name="barang_id[]" class="form-control select-barang" required>
                                    <option value="">- Pilih Barang -</option>
                                    @foreach($barang as $b)
                                        <option value="{{ $b->barang_id }}" data-harga="{{ $b->harga_jual }}">{{ $b->barang_nama }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                <input type="number" name="jumlah[]" class="form-control" min="1" value="1" required>
                            </td>
                            <td>
                                <input type="number" name="harga[]" class="form-control input-harga" readonly required>
                            </td>
                            <td class="text-center">
                                <button type="button" class="btn btn-danger btn-sm remove-row-ajax" disabled>
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-warning">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan Transaksi</button>
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

        // Mekanisme Tambah Baris Dinamis di dalam Modal
        $('#add-row-ajax').click(function() {
            let newRow = $('#barang-body-ajax tr:first').clone();
            newRow.find('select, input').val('');
            newRow.find('input[name="jumlah[]"]').val('1');
            newRow.find('.remove-row-ajax').removeAttr('disabled');
            $('#barang-body-ajax').append(newRow);
        });

        // Mekanisme Hapus Baris Item Belanjaan
        $(document).on('click', '.remove-row-ajax', function() {
            if($('#barang-body-ajax tr').length > 1) {
                $(this).closest('tr').remove();
            }
        });

        // Validasi dan Handler Submit AJAX
        $("#form-tambah-penjualan").validate({
            rules: {
                pembeli: { required: true, maxlength: 100 },
                user_id: { required: true, number: true },
                penjualan_tanggal: { required: true }
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
                            tablePenjualan.ajax.reload(); // Reload tabel utama halaman indeks
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
                            text: 'Gagal memproses transaksi. Periksa kembali inputan Anda.'
                        });
                    }
                });
                return false;
            }
        });
    });
</script>