<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Registrasi Pengguna</title>

    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
</head>

<body class="hold-transition register-page">

<div class="register-box">

    <div class="card card-outline card-primary">

        <div class="card-header text-center">
            <a href="{{ url('/') }}">
                <h2><b>Admin</b>LTE</h2>
            </a>
        </div>

        <div class="card-body">

            <p class="login-box-msg">
                Registrasi Pengguna Baru
            </p>

            <form action="{{ url('register') }}" method="POST">
                @csrf

                <div class="input-group mb-3">
                    <input type="text"
                           name="username"
                           class="form-control"
                           placeholder="Username">

                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-user"></span>
                        </div>
                    </div>
                </div>

                <div class="input-group mb-3">
                    <input type="text"
                           name="nama"
                           class="form-control"
                           placeholder="Nama Lengkap">

                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-id-card"></span>
                        </div>
                    </div>
                </div>

                <div class="input-group mb-3">
                    <select name="level_id" class="form-control">
                        <option value="">-- Pilih Level --</option>

                        @foreach($level as $l)
                            <option value="{{ $l->level_id }}">
                                {{ $l->level_nama }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="input-group mb-3">
                    <input type="password"
                           name="password"
                           class="form-control"
                           placeholder="Password">

                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                </div>

                <div class="input-group mb-3">
                    <input type="password"
                           name="password_confirmation"
                           class="form-control"
                           placeholder="Konfirmasi Password">

                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                </div>

                <button type="submit"
                        class="btn btn-primary btn-block">
                    Registrasi
                </button>

            </form>

            <div class="text-center mt-3">
                <a href="{{ url('login') }}">
                    Sudah punya akun? Login
                </a>
            </div>

        </div>
    </div>

</div>

<script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('dist/js/adminlte.min.js') }}"></script>

</body>
</html>