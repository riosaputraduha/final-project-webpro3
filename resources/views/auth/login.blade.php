<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login | ABSENSI SEKOLAH</title>

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>

<body class="bg-body-tertiary" style="overflow-x: hidden">
    <div class="container-fluid p-0">
        <div class="row align-items-center px-0 g-5">
            <div class="col-md-6">
                <img src="{{ asset('images/login.jpg') }}" alt="Login page" style="width: 100%; height: 100vh; object-fit: cover; object-position: left;">
            </div>
            <div class="col-md-6">
                <div class="row justify-content-center">
                    <div class="col-lg-9">
                        <h2 class="fw-bold mb-2">Selamat Datang Kembali</h2>
                        <p class="mb-4">Silahkan login untuk melanjutkan</p>

                        <form action="{{ route('login') }}" method="post">
                            @csrf

                            <div class="mb-3">
                                <label for="email">Alamat Email</label>
                                <input type="email" name="email" id="email"
                                    class="form-control @error('email') is-invalid @enderror"
                                    value="{{ old('email') }}" placeholder="Masukkan Alamat Email" required autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="password">Password</label>
                                <input type="password" name="password" id="password"
                                    class="form-control @error('password') is-invalid @enderror"
                                    placeholder="Masukkan Password" required>

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <button class="btn btn-primary justify-content-center w-100" type="submit">
                                Log In
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
