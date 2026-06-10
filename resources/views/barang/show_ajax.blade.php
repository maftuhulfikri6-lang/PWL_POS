<div id="modal-master" class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Detail Data Barang (AJAX)</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <table class="table table-sm table-bordered table-striped">
                <tr>
                    <th class="text-right" style="width: 30%;">ID Barang :</th>
                    <td style="width: 70%;">{{ $barang->barang_id }}</td>
                </tr>
                <tr>
                    <th class="text-right">Kategori Barang :</th>
                    <td>{{ $barang->kategori->kategori_nama ?? 'Tidak Ada' }}</td>
                </tr>
                <tr>
                    <th class="text-right">Kode Barang :</th>
                    <td>{{ $barang->barang_kode }}</td>
                </tr>
                <tr>
                    <th class="text-right">Nama Barang :</th>
                    <td>{{ $barang->barang_nama }}</td>
                </tr>
                <tr>
                    <th class="text-right">Harga Beli :</th>
                    <td>Rp {{ number_format($barang->harga_beli, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <th class="text-right">Harga Jual :</th>
                    <td>Rp {{ number_format($barang->harga_jual, 0, ',', '.') }}</td>
                </tr>
            </table>
        </div>
        <div class="modal-footer">
            <button type="button" data-dismiss="modal" class="btn btn-primary">Tutup</button>
        </div>
    </div>
</div>