<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Login Admin - UIS Grand Academic Challenge</title>
    <meta content="Portal Login Admin Cerdas Cermat UIS" name="description">
    <meta content="cerdas cermat, UIS, Grand Academic Challenge, batam" name="keywords">

    <!-- Favicons -->
    <link href="{{ asset('assets/img/logouis.png') }}" rel="icon">
    <link href="{{ asset('assets/img/logouis.png') }}" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link
        href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700;800;900&family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #064e3b 0%, #065f46 50%, #022c22 100%);
            min-height: 100vh;
            position: relative;
        }

        .login-card {
            border: none;
            border-radius: 18px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.35);
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(10px);
            overflow: hidden;
        }

        .login-header {
            background: linear-gradient(135deg, #047857 0%, #065f46 100%);
            color: #fff;
            padding: 25px 20px;
            text-align: center;
            border-bottom: 3px solid #fbbf24;
        }

        .login-header img {
            max-height: 65px;
            filter: drop-shadow(0 4px 6px rgba(0,0,0,0.3));
        }

        .btn-uis {
            background: linear-gradient(135deg, #059669 0%, #047857 100%);
            border: none;
            color: #fff;
            font-weight: 600;
            padding: 12px;
            border-radius: 10px;
            transition: all 0.3s ease;
        }

        .btn-uis:hover {
            background: linear-gradient(135deg, #047857 0%, #065f46 100%);
            color: #fbbf24;
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(4, 120, 87, 0.4);
        }

        .form-control:focus {
            border-color: #10b981;
            box-shadow: 0 0 0 0.25rem rgba(16, 185, 129, 0.25);
        }

        .input-group-text {
            background-color: #f0fdf4;
            border-color: #dee2e6;
            color: #047857;
        }
    </style>
</head>

<body>
    @include('sweetalert::alert')

    <main>
        <div class="container">
            <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-5 col-md-7 d-flex flex-column align-items-center justify-content-center">

                            <div class="card login-card w-100 mb-3">
                                <div class="login-header">
                                    <img src="{{ asset('assets/img/logouis.png') }}" alt="Logo UIS" class="mb-2">
                                    <h5 class="fw-bold mb-0 text-uppercase tracking-wider">UIS Grand Academic Challenge</h5>
                                    <small class="text-warning fw-semibold">Portal Administrator Cerdas Cermat 2026</small>
                                </div>

                                <div class="card-body p-4 pt-4">
                                    <div class="pb-3 text-center">
                                        <h5 class="card-title text-center pb-0 fs-5 text-dark fw-bold">Login ke Dashboard</h5>
                                        <p class="text-muted small mb-0">Masukkan akun admin Anda untuk mengelola lomba</p>
                                    </div>

                                    @if ($errors->any())
                                        <div class="alert alert-danger alert-dismissible fade show small" role="alert">
                                            <i class="bi bi-exclamation-octagon me-1"></i>
                                            {{ $errors->first() }}
                                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                        </div>
                                    @endif

                                    <form class="row g-3" method="POST" action="{{ route('login.post') }}">
                                        @csrf

                                        <div class="col-12">
                                            <label for="loginInput" class="form-label fw-semibold text-secondary small">Email atau Username</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="bi bi-person-fill"></i></span>
                                                <input type="text" name="login" class="form-control @error('login') is-invalid @enderror"
                                                    id="loginInput" placeholder="admin@gmail.com" value="{{ old('login', 'admin@gmail.com') }}" required autofocus>
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <label for="yourPassword" class="form-label fw-semibold text-secondary small">Kata Sandi</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                                                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
                                                    id="yourPassword" placeholder="••••••••" required>
                                            </div>
                                        </div>

                                        <div class="col-12 d-flex justify-content-between align-items-center">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="remember" value="true" id="rememberMe">
                                                <label class="form-check-label text-muted small" for="rememberMe">Ingat Saya</label>
                                            </div>
                                        </div>

                                        <div class="col-12 mt-4">
                                            <button class="btn btn-uis w-100 text-uppercase fw-bold" type="submit">
                                                <i class="bi bi-box-arrow-in-right me-1"></i> Masuk Sekarang
                                            </button>
                                        </div>

                                        <div class="col-12 text-center mt-3">
                                            <a href="{{ route('beranda') }}" class="btn btn-outline-secondary btn-sm rounded-pill px-3">
                                                <i class="bi bi-arrow-left me-1"></i> Kembali ke Layar Panggung
                                            </a>
                                        </div>
                                    </form>

                                </div>
                            </div>

                            <div class="text-center text-white-50 small mt-2">
                                &copy; 2026 <strong>Universitas Ibnu Sina</strong>. Grand Academic Challenge.
                            </div>

                        </div>
                    </div>
                </div>
            </section>
        </div>
    </main>

    <!-- Vendor JS Files -->
    <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/main.js') }}"></script>
</body>

</html>
