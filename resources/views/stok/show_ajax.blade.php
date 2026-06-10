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
                    Data stok barang tidak ditemukan atau telah dihapus.
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-primary">Tutup</button>
            </div>
        </div>
    </div>
@else
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Data Stok Barang (AJAX)</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-sm table-bordered table-striped">
                    <tr>
                        <th class="text-right" style="width: 30%;">ID Transaksi Stok :</th>
                        <td style="width: 70%;">{{ $stok->stok_id }}</td>
                    </tr>
                    <tr>
                        <th class="text-right">Nama Barang :</th>
                        <td>{{ $stok->barang->barang_nama }}</td>
                    </tr>
                    <tr>
                        <th class="text-right">Diinput Oleh (User) :</th>
                        <td><span class="badge badge-info">{{ $stok->user->nama }}</span></td>
                    </tr>
                    <tr>
                        <th class="text-right">Tanggal Log Stok :</th>
                        <td>{{ date('d-m-Y H:i', strtotime($stok->stok_tanggal)) }} WIB</td>
                    </tr>
                    <tr>
                        <th class="text-right">Jumlah Pasokan :</th>
                        <td><strong>{{ number_format($stok->stok_jumlah, 0, ',', '.') }}</strong> unit</td>
                    </tr>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-primary">Tutup</button>
            </div>
        </div>
    </div>
@endempty