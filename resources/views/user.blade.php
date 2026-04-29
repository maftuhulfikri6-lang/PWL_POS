<!DOCTYPE html>
<html>
<head>
    <title>Daftar User</title>
</head>
<body>
    <h1>Data User</h1>
    
    <a href="{{ url('/user/tambah') }}" style="display: inline-block; padding: 10px; background: #28a745; color: white; text-decoration: none; border-radius: 5px; margin-bottom: 10px;">
        + Tambah User
    </a>
    <br>

    <table border="1" cellpadding="5" cellspacing="0">
        <tr>
            <th>ID</th>
            <th>Username</th>
            <th>Nama</th>
            <th>ID Level</th>
            <th>Aksi</th>
        </tr>
        @foreach($data as $d)
        <tr>
            <td>{{ $d->user_id }}</td>
            <td>{{ $d->username }}</td>
            <td>{{ $d->nama }}</td>
            <td>{{ $d->level_id }}</td>
            <td>
                <a href="{{ url('/user/ubah/' . $d->user_id) }}">Ubah</a> | 
                <a href="{{ url('/user/hapus/' . $d->user_id) }}" onclick="return confirm('Yakin mau hapus?')">Hapus</a>
            </td>
        </tr>
        @endforeach
    </table>
</body>
</html>