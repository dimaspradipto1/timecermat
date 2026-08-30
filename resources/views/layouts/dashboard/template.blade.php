<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Dashboard') - Cerdas Cermat UIS {{ date('Y') }}</title>
    <meta content="Dashboard Administrator Cerdas Cermat UIS Grand Academic Challenge" name="description">

    <!-- Favicons -->
    <link href="{{ asset('assets/img/logouis.png') }}" rel="icon">
    <link href="{{ asset('assets/img/logouis.png') }}" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link
        href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800&family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/remixicon/remixicon.css') }}" rel="stylesheet">

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">

    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    <!-- Template Main CSS File -->
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">

    <style>
        :root {
            --uis-green-dark: #064e3b;
            --uis-green-primary: #047857;
            --uis-green-light: #10b981;
            --uis-gold: #fbbf24;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f6f9ff;
        }

        .header {
            border-bottom: 2px solid #10b981;
        }

        .sidebar-nav .nav-link {
            border-radius: 8px;
            margin-bottom: 4px;
        }

        .sidebar-nav .nav-link.active,
        .sidebar-nav .nav-link:not(.collapsed) {
            background-color: #ecfdf5;
            color: #047857;
            font-weight: 600;
        }

        .sidebar-nav .nav-link i {
            font-size: 18px;
        }

        .btn-uis-primary {
            background: linear-gradient(135deg, #059669 0%, #047857 100%);
            border: none;
            color: #fff;
            font-weight: 600;
        }

        .btn-uis-primary:hover {
            background: linear-gradient(135deg, #047857 0%, #065f46 100%);
            color: #fbbf24;
        }

        .badge-slot-1 { background-color: #2563eb; }
        .badge-slot-2 { background-color: #16a34a; }
        .badge-slot-3 { background-color: #ea580c; }
    </style>

    @stack('styles')
</head>

<body>

    @include('layouts.dashboard.header')
    @include('layouts.dashboard.sidebar')

    <main id="main" class="main">
        @include('sweetalert::alert')

        @yield('content')
    </main><!-- End #main -->

    <!-- Modal Ubah Password Akun Sendiri -->
    <div class="modal fade" id="changePasswordModal" tabindex="-1" aria-labelledby="changePasswordModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <div class="modal-header bg-dark text-white">
                    <h5 class="modal-title fw-bold" id="changePasswordModalLabel"><i class="bi bi-key-fill text-warning me-2"></i> Ubah Password Akun</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="formGlobalChangePassword" action="{{ route('dashboard.change-password') }}" method="POST">
                    @csrf
                    <div class="modal-body p-4">
                        <div class="mb-3">
                            <label for="myCurrentPassword" class="form-label fw-semibold">Password Saat Ini <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="password" class="form-control" id="myCurrentPassword" name="current_password" placeholder="Masukkan password saat ini..." required>
                                <button class="btn btn-outline-secondary btn-toggle-password" type="button" title="Lihat/Sembunyikan">
                                    <i class="bi bi-eye"></i>
                                </button>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="myNewPassword" class="form-label fw-semibold">Password Baru <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="password" class="form-control" id="myNewPassword" name="password" placeholder="Minimal 6 karakter" required minlength="6">
                                <button class="btn btn-outline-secondary btn-toggle-password" type="button" title="Lihat/Sembunyikan">
                                    <i class="bi bi-eye"></i>
                                </button>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="myNewPasswordConfirmation" class="form-label fw-semibold">Konfirmasi Password Baru <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="password" class="form-control" id="myNewPasswordConfirmation" name="password_confirmation" placeholder="Ulangi password baru..." required minlength="6">
                                <button class="btn btn-outline-secondary btn-toggle-password" type="button" title="Lihat/Sembunyikan">
                                    <i class="bi bi-eye"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer bg-light">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-warning text-dark fw-bold px-4"><i class="bi bi-check-circle me-1"></i> Perbarui Password</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @include('layouts.dashboard.footer')

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center">
        <i class="bi bi-arrow-up-short"></i>
    </a>

    <!-- jQuery (Needed for Yajra DataTables) -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <!-- Vendor JS Files -->
    <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>

    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Template Main JS File -->
    <script src="{{ asset('assets/js/main.js') }}"></script>

    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // Global Password Toggle Handler
        $(document).on('click', '.btn-toggle-password', function() {
            let input = $(this).closest('.input-group').find('input');
            let icon = $(this).find('i');
            if (input.attr('type') === 'password') {
                input.attr('type', 'text');
                icon.removeClass('bi-eye').addClass('bi-eye-slash');
            } else {
                input.attr('type', 'password');
                icon.removeClass('bi-eye-slash').addClass('bi-eye');
            }
        });

        // Handle Global Change Password Form
        $('#formGlobalChangePassword').submit(function(e) {
            e.preventDefault();
            let form = $(this);
            let actionUrl = form.attr('action');

            $.ajax({
                url: actionUrl,
                type: "POST",
                data: form.serialize(),
                success: function(res) {
                    $('#changePasswordModal').modal('hide');
                    form[0].reset();

                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: res.message || 'Password Anda telah berhasil diperbarui.',
                        timer: 2000,
                        showConfirmButton: false
                    });
                },
                error: function(xhr) {
                    let errorMsg = 'Terjadi kesalahan saat mengubah password.';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMsg = xhr.responseJSON.message;
                    } else if (xhr.responseJSON && xhr.responseJSON.errors) {
                        let firstErrorKey = Object.keys(xhr.responseJSON.errors)[0];
                        errorMsg = xhr.responseJSON.errors[firstErrorKey][0];
                    }
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal Memperbarui Password',
                        text: errorMsg
                    });
                }
            });
        });
    </script>

    @stack('scripts')

</body>

</html>
