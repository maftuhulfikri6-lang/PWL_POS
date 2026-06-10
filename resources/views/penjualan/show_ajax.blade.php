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
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Transaksi Penjualan (AJAX)</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-sm table-bordered table-striped json-table mb-4">
                    <tr>
                        <th class="bg-light" style="width: 30%">ID Transaksi</th>
                        <td>#PJ-{{ $penjualan->penjualan_id }}</td>
                    </tr>
                    <tr>
                        <th class="bg-light">Nama Pembeli</th>
                        <td>{{ $penjualan->pembeli }}</td>
                    </tr>
                    <tr>
                        <th class="bg-light">Tanggal Transaksi</th>
                        <td>{{ date('d-m-Y H:i', strtotime($penjualan->penjualan_tanggal)) }} WIB</td>
                    </tr>
                    <tr>
                        <th class="bg-light">Kasir / Petugas</th>
                        <td>{{ $penjualan->user->nama }} ({{ $penjualan->user->username }})</td>
                    </tr>
                </table>

                <h5>Rincian Item Barang</h5>
                <table class="table table-sm table-bordered table-striped text-sm">
                    <thead class="bg-light">
                        <tr>
                            <th class="text-center" style="width: 5%">No</th>
                            <th>Nama Barang</th>
                            <th class="text-right" style="width: 20%">Harga Satuan</th>
                            <th class="text-center" style="width: 12%">Jumlah</th>
                            <th class="text-right" style="width: 22%">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $totalSemua = 0; @endphp
                        @foreach($penjualan->detail as $index => $d)
                            @php 
                                $subtotal = $d->jumlah * $d->harga; 
                                $totalSemua += $subtotal;
                            @endphp
                            <tr>
                                <td class="text-center">{{ $index + 1 }}</td>
                                <td>{{ $d->barang->barang_nama }}</td>
                                <td class="text-right">Rp {{ number_format($d->harga, 0, ',', '.') }}</td>
                                <td class="text-center">{{ $d->jumlah }}</td>
                                <td class="text-right">Rp {{ number_format($subtotal, 0, ',', '.') }}</td>
                            </tr>
                        @endforeach
                        <tr class="bg-light">
                            <th colspan="4" class="text-right">Total Bayar :</th>
                            <th class="text-right text-primary font-weight-bold">
                                Rp {{ number_format($totalSemua, 0, ',', '.') }}
                            </th>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-default">Tutup</button>
            </div>
        </div>
    </div>
@endempty