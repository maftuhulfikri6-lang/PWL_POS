<!DOCTYPE html>
<html>
<head>
    <title>Ubah Data User</title>
</head>
<body>
    <h1>Form Ubah Data User</h1>
    <a href="{{ url('/user') }}">Kembali</a>
    <br><br>

    {{-- Form Action mengarah ke route PUT di web.php --}}
    <form method="post" action="{{ url('/user/ubah_simpan/' . $data->user_id) }}">
        {{ csrf_field() }}
        {{ method_field('PUT') }}

        <label>Username</label>
        <input type="text" name="username" value="{{ $data->username }}" required>
        <br>

        <label>Nama</label>
        <input type="text" name="nama" value="{{ $data->nama }}" required>
        <br>

        <label>Password</label>
        {{-- Kosongkan saja agar tidak menimpa password lama jika tidak diisi --}}
        <input type="password" name="password" placeholder="Isi jika ingin ubah password">
        <br>

        <label>Level ID</label>
        {{-- Menggunakan number sesuai praktikum --}}
        <input type="number" name="level_id" value="{{ $data->level_id }}" required>
        <br><br>

        <button type="submit">Simpan Perubahan</button>
    </form>
</body>
</html>