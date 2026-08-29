@extends('layouts.dashboard.template')

@section('title', 'Data Pengguna')

@section('content')
<style>
    div.dataTables_processing {
        display: none !important;
    }
</style>
<div class="pagetitle d-flex justify-content-between align-items-center">
    <div>
        <h1>Data Pengguna Sistem</h1>
        <nav>
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Home</a></li>
                <li class="breadcrumb-item active">Data Pengguna</li>
            </ol>
        </nav>
    </div>
    <div>
        <button type="button" class="btn btn-uis-primary shadow-sm" data-bs-toggle="modal" data-bs-target="#addUserModal">
            <i class="bi bi-person-plus-fill me-1"></i> Tambah Pengguna
        </button>
    </div>
</div><!-- End Page Title -->

<section class="section mt-3">
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="card-title p-0 m-0 fw-bold text-dark">
                            <i class="bi bi-people-fill text-success me-2"></i> Daftar Pengguna & Hak Akses
                        </h5>
                        <button type="button" class="btn btn-sm btn-outline-secondary" id="btnRefreshUsersTable">
                            <i class="bi bi-arrow-clockwise me-1"></i> Refresh Data
                        </button>
                    </div>

                    <div class="table-responsive">
                        {!! $dataTable->table(['class' => 'table table-hover align-middle w-100', 'id' => 'users-table']) !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Modal Tambah Pengguna -->
<div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title fw-bold" id="addUserModalLabel"><i class="bi bi-person-plus me-2"></i> Tambah Pengguna Baru</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formAddUser" action="{{ route('dashboard.users.store') }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label for="addUserName" class="form-label fw-semibold">Nama Lengkap <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="addUserName" name="name" placeholder="Contoh: Budi Santoso" required>
                    </div>

                    <div class="mb-3">
                        <label for="addUserEmail" class="form-label fw-semibold">Email / Username <span class="text-danger">*</span></label>
                        <input type="email" class="form-control" id="addUserEmail" name="email" placeholder="budi@example.com" required>
                    </div>

                    <div class="mb-3">
                        <label for="addUserPassword" class="form-label fw-semibold">Password <span class="text-danger">*</span></label>
                        <input type="password" class="form-control" id="addUserPassword" name="password" placeholder="Minimal 6 karakter" required minlength="6">
                    </div>

                    <div class="mb-3">
                        <label for="addUserRole" class="form-label fw-semibold">Role Akses <span class="text-danger">*</span></label>
                        <select class="form-select" id="addUserRole" name="role" required>
                            <option value="admin">Admin (Akses Penuh)</option>
                            <option value="operator">Operator (Pengatur Lomba)</option>
                            <option value="juri">Juri (Pencatat Skor)</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success fw-bold px-4"><i class="bi bi-check-circle me-1"></i> Simpan Pengguna</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit Pengguna -->
<div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title fw-bold" id="editUserModalLabel"><i class="bi bi-pencil-square me-2"></i> Edit Data Pengguna</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formEditUser" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label for="editUserName" class="form-label fw-semibold">Nama Lengkap <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="editUserName" name="name" required>
                    </div>

                    <div class="mb-3">
                        <label for="editUserEmail" class="form-label fw-semibold">Email / Username <span class="text-danger">*</span></label>
                        <input type="email" class="form-control" id="editUserEmail" name="email" required>
                    </div>

                    <div class="mb-3">
                        <label for="editUserPassword" class="form-label fw-semibold">Password Baru <small class="text-muted">(Kosongkan jika tidak diubah)</small></label>
                        <input type="password" class="form-control" id="editUserPassword" name="password" placeholder="Minimal 6 karakter" minlength="6">
                    </div>

                    <div class="mb-3">
                        <label for="editUserRole" class="form-label fw-semibold">Role Akses <span class="text-danger">*</span></label>
                        <select class="form-select" id="editUserRole" name="role" required>
                            <option value="admin">Admin (Akses Penuh)</option>
                            <option value="operator">Operator (Pengatur Lomba)</option>
                            <option value="juri">Juri (Pencatat Skor)</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary fw-bold px-4"><i class="bi bi-save me-1"></i> Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('scripts')
    @if(app()->environment('production'))
        {!! str_replace('http:', 'https:', $dataTable->scripts()) !!}
    @else
        {!! $dataTable->scripts() !!}
    @endif

    <script>
    function reloadUsersTable() {
        if (window.LaravelDataTables && window.LaravelDataTables['users-table']) {
            window.LaravelDataTables['users-table'].ajax.reload(null, false);
        } else if ($.fn.DataTable.isDataTable('#users-table')) {
            $('#users-table').DataTable().ajax.reload(null, false);
        }
    }

    $(document).ready(function() {
        $('#btnRefreshUsersTable').click(function() {
            reloadUsersTable();
        });

        // Handle Add User Form Submit via AJAX
        $('#formAddUser').submit(function(e) {
            e.preventDefault();
            let form = $(this);
            let actionUrl = form.attr('action');

            $.ajax({
                url: actionUrl,
                type: "POST",
                data: form.serialize(),
                success: function(res) {
                    $('#addUserModal').modal('hide');
                    form[0].reset();
                    reloadUsersTable();

                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: res.message || 'Pengguna baru berhasil ditambahkan.',
                        timer: 1500,
                        showConfirmButton: false
                    });
                },
                error: function(xhr) {
                    let errorMsg = 'Terjadi kesalahan saat menyimpan data.';
                    if (xhr.responseJSON && xhr.responseJSON.errors) {
                        let firstErrorKey = Object.keys(xhr.responseJSON.errors)[0];
                        errorMsg = xhr.responseJSON.errors[firstErrorKey][0];
                    }
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal Menyimpan',
                        text: errorMsg
                    });
                }
            });
        });

        // Handle Edit User button click
        $(document).on('click', '.btn-edit-user', function() {
            let id = $(this).data('id');
            let name = $(this).data('name');
            let email = $(this).data('email');
            let role = $(this).data('role');
            let updateUrl = $(this).data('url');

            $('#formEditUser').attr('action', updateUrl);
            $('#editUserName').val(name);
            $('#editUserEmail').val(email);
            $('#editUserRole').val(role);
            $('#editUserPassword').val('');

            $('#editUserModal').modal('show');
        });

        // Handle Edit User Form Submit via AJAX
        $('#formEditUser').submit(function(e) {
            e.preventDefault();
            let form = $(this);
            let actionUrl = form.attr('action');

            $.ajax({
                url: actionUrl,
                type: "POST",
                data: form.serialize(),
                success: function(res) {
                    $('#editUserModal').modal('hide');
                    reloadUsersTable();

                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil Diperbarui!',
                        text: res.message || 'Data pengguna berhasil diperbarui.',
                        timer: 1500,
                        showConfirmButton: false
                    });
                },
                error: function(xhr) {
                    let errorMsg = 'Terjadi kesalahan saat memperbarui data.';
                    if (xhr.responseJSON && xhr.responseJSON.errors) {
                        let firstErrorKey = Object.keys(xhr.responseJSON.errors)[0];
                        errorMsg = xhr.responseJSON.errors[firstErrorKey][0];
                    }
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal Memperbarui',
                        text: errorMsg
                    });
                }
            });
        });

        // Handle Delete with SweetAlert2
        $(document).on('click', '.btn-delete-user', function() {
            let name = $(this).data('name');
            let deleteUrl = $(this).data('url');

            Swal.fire({
                title: 'Hapus Pengguna?',
                html: `Apakah Anda yakin ingin menghapus pengguna <strong>${name}</strong>?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: deleteUrl,
                        type: "POST",
                        data: {
                            _method: 'DELETE'
                        },
                        success: function(res) {
                            reloadUsersTable();
                            Swal.fire({
                                icon: 'success',
                                title: 'Terhapus!',
                                text: res.message || 'Pengguna berhasil dihapus.',
                                timer: 1500,
                                showConfirmButton: false
                            });
                        },
                        error: function(xhr) {
                            let msg = (xhr.responseJSON && xhr.responseJSON.message) ? xhr.responseJSON.message : 'Terjadi kesalahan saat menghapus pengguna.';
                            Swal.fire('Gagal', msg, 'error');
                        }
                    });
                }
            });
        });
    });
    </script>
@endpush
