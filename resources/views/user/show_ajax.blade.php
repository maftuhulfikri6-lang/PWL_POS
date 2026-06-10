<div id="modal-master" class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Detail Data User (AJAX)</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <table class="table table-sm table-bordered table-striped">
                <tr>
                    <th class="text-right" style="width: 30%;">ID User :</th>
                    <td style="width: 70%;">{{ $user->user_id }}</td>
                </tr>
                <tr>
                    <th class="text-right">Level Pengguna :</th>
                    <td>{{ $user->level->level_nama ?? 'Tidak Ada' }}</td>
                </tr>
                <tr>
                    <th class="text-right">Username :</th>
                    <td>{{ $user->username }}</td>
                </tr>
                <tr>
                    <th class="text-right">Nama Lengkap :</th>
                    <td>{{ $user->nama }}</td>
                </tr>
                <tr>
                    <th class="text-right">Status Akun :</th>
                    <td>
                        <span class="badge badge-success">Aktif</span>
                    </td>
                </tr>
            </table>
        </div>
        <div class="modal-footer">
            <button type="button" data-dismiss="modal" class="btn btn-primary">Tutup</button>
        </div>
    </div>
</div>