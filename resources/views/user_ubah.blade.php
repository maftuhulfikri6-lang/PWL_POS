<!DOCTYPE html>
<html>
<head>
    <title>Ubah Data User</title>
</head>
<body>
    <h1>Form Ubah Data User</h1>
    <a href="{{ url('/user') }}">Kembali</a>
    <br><br>

    {{-- Pastikan route ini sesuai dengan yang ada di web.php --}}
    <form method="post" action="{{ url('/user/ubah_simpan/' . $data->user_id) }}">
        {{ csrf_field() }}
        {{ method_field('PUT') }} {{-- WAJIB untuk method spoofing di Laravel --}}

        <label>Username</label>
        <input type="text" name="username" placeholder="Masukkan Username" value="{{ $data->username }}">
        <br>

        <label>Nama</label>
        <input type="text" name="nama" placeholder="Masukkan Nama" value="{{ $data->nama }}">
        <br>

        <label>Password</label>
        {{-- Jangan tampilkan password asli di value demi keamanan, biarkan kosong jika tidak ingin diubah --}}
        <input type="password" name="password" placeholder="Masukkan Password Baru">
        <br>

        <label>Level ID</label>
        <input type="number" name="level_id" placeholder="Masukkan ID Level" value="{{ $data->level_id }}">
        <br><br>

        <input type="submit" class="btn btn-success" value="Ubah">
    </form>
</body>
</html>