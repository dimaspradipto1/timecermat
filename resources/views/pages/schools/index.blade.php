@extends('layouts.dashboard.template')

@section('title', 'Data Sekolah')

@section('content')
<style>
    div.dataTables_processing {
        display: none !important;
    }
</style>
<div class="pagetitle d-flex justify-content-between align-items-center">
    <div>
        <h1>Data Sekolah Peserta</h1>
        <nav>
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Home</a></li>
                <li class="breadcrumb-item active">Data Sekolah</li>
            </ol>
        </nav>
    </div>
    <div>
        <button type="button" class="btn btn-uis-primary shadow-sm" data-bs-toggle="modal" data-bs-target="#addSchoolModal">
            <i class="bi bi-plus-circle me-1"></i> Tambah Sekolah
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
                            <i class="bi bi-mortarboard-fill text-success me-2"></i> Daftar Sekolah & Skor
                        </h5>
                        <button type="button" class="btn btn-sm btn-outline-secondary" id="btnRefreshTable">
                            <i class="bi bi-arrow-clockwise me-1"></i> Refresh Data
                        </button>
                    </div>

                    <div class="table-responsive">
                        {!! $dataTable->table(['class' => 'table table-hover align-middle w-100', 'id' => 'schools-table']) !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Modal Tambah Sekolah -->
<div class="modal fade" id="addSchoolModal" tabindex="-1" aria-labelledby="addSchoolModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title fw-bold" id="addSchoolModalLabel"><i class="bi bi-building-add me-2"></i> Tambah Sekolah Baru</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formAddSchool" action="{{ route('dashboard.schools.store') }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label for="addName" class="form-label fw-semibold">Nama Sekolah <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="addName" name="name" placeholder="Contoh: SMA Negeri 1 Batam" required>
                    </div>

                    <div class="mb-3">
                        <label for="addRegu" class="form-label fw-semibold">Nama Regu / Tim</label>
                        <select class="form-select" id="addRegu" name="regu">
                            <option value="">-- Pilih Regu (Opsional) --</option>
                            <option value="Regu A">Regu A</option>
                            <option value="Regu B">Regu B</option>
                            <option value="Regu C">Regu C</option>
                            <option value="Regu D">Regu D</option>
                            <option value="Regu E">Regu E</option>
                            <option value="Regu F">Regu F</option>
                        </select>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="addScore" class="form-label fw-semibold">Skor Awal</label>
                            <input type="number" class="form-control" id="addScore" name="score" value="0" min="0">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="addSlot" class="form-label fw-semibold">Slot Panggung</label>
                            <select class="form-select" id="addSlot" name="slot">
                                <option value="">Standby (Bukan di panggung)</option>
                                <option value="1">Slot 1 (Kiri)</option>
                                <option value="2">Slot 2 (Tengah)</option>
                                <option value="3">Slot 3 (Kanan)</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success fw-bold px-4"><i class="bi bi-check-circle me-1"></i> Simpan Data</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Edit Sekolah -->
<div class="modal fade" id="editSchoolModal" tabindex="-1" aria-labelledby="editSchoolModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title fw-bold" id="editSchoolModalLabel"><i class="bi bi-pencil-square me-2"></i> Edit Data Sekolah</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formEditSchool" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label for="editName" class="form-label fw-semibold">Nama Sekolah <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="editName" name="name" required>
                    </div>

                    <div class="mb-3">
                        <label for="editRegu" class="form-label fw-semibold">Nama Regu / Tim</label>
                        <select class="form-select" id="editRegu" name="regu">
                            <option value="">-- Pilih Regu (Opsional) --</option>
                            <option value="Regu A">Regu A</option>
                            <option value="Regu B">Regu B</option>
                            <option value="Regu C">Regu C</option>
                            <option value="Regu D">Regu D</option>
                            <option value="Regu E">Regu E</option>
                            <option value="Regu F">Regu F</option>
                        </select>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="editScore" class="form-label fw-semibold">Skor</label>
                            <input type="number" class="form-control" id="editScore" name="score" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="editSlot" class="form-label fw-semibold">Slot Panggung</label>
                            <select class="form-select" id="editSlot" name="slot">
                                <option value="">Standby (Bukan di panggung)</option>
                                <option value="1">Slot 1 (Kiri)</option>
                                <option value="2">Slot 2 (Tengah)</option>
                                <option value="3">Slot 3 (Kanan)</option>
                            </select>
                        </div>
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

<!-- Modal Quick Adjust Score -->
<div class="modal fade" id="quickScoreModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-dark text-white py-2">
                <h6 class="modal-title fw-bold m-0"><i class="bi bi-calculator me-1"></i> Sesuaikan Skor</h6>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center p-3">
                <div class="fw-bold text-dark mb-1" id="quickScoreSchoolName">Nama Sekolah</div>
                <div class="display-5 fw-bold text-success my-2" id="quickScoreCurrent">0</div>
                <div class="d-flex flex-wrap gap-2 justify-content-center mt-3">
                    <button type="button" class="btn btn-sm btn-outline-success btn-modal-adj" data-act="add" data-val="10">+10</button>
                    <button type="button" class="btn btn-sm btn-outline-success btn-modal-adj" data-act="add" data-val="50">+50</button>
                    <button type="button" class="btn btn-sm btn-outline-success btn-modal-adj" data-act="add" data-val="100">+100</button>
                    <button type="button" class="btn btn-sm btn-outline-danger btn-modal-adj" data-act="subtract" data-val="5">-5</button>
                    <button type="button" class="btn btn-sm btn-outline-danger btn-modal-adj" data-act="subtract" data-val="10">-10</button>
                    <button type="button" class="btn btn-sm btn-outline-secondary btn-modal-adj" data-act="reset" data-val="0">Reset 0</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Set Slot -->
<div class="modal fade" id="setSlotModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-info text-dark py-2">
                <h6 class="modal-title fw-bold m-0"><i class="bi bi-display me-1"></i> Posisi Slot Panggung</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center p-3">
                <div class="fw-bold text-dark mb-3" id="slotModalSchoolName">Nama Sekolah</div>
                <div class="d-grid gap-2">
                    <button type="button" class="btn btn-outline-primary btn-modal-set-slot" data-slot="1">
                        <i class="bi bi-display me-1"></i> Slot 1 (Kiri)
                    </button>
                    <button type="button" class="btn btn-outline-success btn-modal-set-slot" data-slot="2">
                        <i class="bi bi-display me-1"></i> Slot 2 (Tengah)
                    </button>
                    <button type="button" class="btn btn-outline-warning btn-modal-set-slot" data-slot="3">
                        <i class="bi bi-display me-1"></i> Slot 3 (Kanan)
                    </button>
                    <button type="button" class="btn btn-outline-secondary btn-modal-set-slot" data-slot="">
                        <i class="bi bi-x-circle me-1"></i> Standby (Bukan di Panggung)
                    </button>
                </div>
            </div>
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
    function reloadDataTable() {
        if (window.LaravelDataTables && window.LaravelDataTables['schools-table']) {
            window.LaravelDataTables['schools-table'].ajax.reload(null, false);
        } else if ($.fn.DataTable.isDataTable('#schools-table')) {
            $('#schools-table').DataTable().ajax.reload(null, false);
        }
    }

    $(document).ready(function() {
        let currentSchoolId = null;
        let currentScoreUrl = null;
        let currentSlotUrl = null;

        $('#btnRefreshTable').click(function() {
            reloadDataTable();
        });

        // Handle Add School Form Submit via AJAX
        $('#formAddSchool').submit(function(e) {
            e.preventDefault();
            let form = $(this);
            let actionUrl = form.attr('action');

            $.ajax({
                url: actionUrl,
                type: "POST",
                data: form.serialize(),
                success: function(res) {
                    $('#addSchoolModal').modal('hide');
                    form[0].reset();
                    reloadDataTable();

                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: res.message || 'Data sekolah baru berhasil ditambahkan.',
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

        // Handle Edit School Form Submit via AJAX
        $('#formEditSchool').submit(function(e) {
            e.preventDefault();
            let form = $(this);
            let actionUrl = form.attr('action');

            $.ajax({
                url: actionUrl,
                type: "POST",
                data: form.serialize(),
                success: function(res) {
                    $('#editSchoolModal').modal('hide');
                    reloadDataTable();

                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil Diperbarui!',
                        text: res.message || 'Data sekolah berhasil diperbarui.',
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

        // Handle Edit button click
        $(document).on('click', '.btn-edit', function() {
            let id = $(this).data('id');
            let name = $(this).data('name');
            let regu = $(this).data('regu');
            let score = $(this).data('score');
            let slot = $(this).data('slot');
            let updateUrl = $(this).data('url');

            $('#formEditSchool').attr('action', updateUrl);
            $('#editName').val(name);
            $('#editRegu').val(regu);
            $('#editScore').val(score);
            $('#editSlot').val(slot);

            $('#editSchoolModal').modal('show');
        });

        // Handle Quick Score button click
        $(document).on('click', '.btn-quick-score', function() {
            currentSchoolId = $(this).data('id');
            let name = $(this).data('name');
            let score = $(this).data('score');
            currentScoreUrl = $(this).data('url');

            $('#quickScoreSchoolName').text(name);
            $('#quickScoreCurrent').text(score);
            $('#quickScoreModal').modal('show');
        });

        // Handle Quick Score in modal
        $('.btn-modal-adj').click(function() {
            let act = $(this).data('act');
            let val = $(this).data('val');

            if (!currentScoreUrl) return;

            $.ajax({
                url: currentScoreUrl,
                type: "POST",
                data: {
                    action: act,
                    amount: val
                },
                success: function(res) {
                    if (res.success) {
                        $('#quickScoreCurrent').text(res.score);
                        reloadDataTable();

                        const Toast = Swal.mixin({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 1500,
                            timerProgressBar: true
                        });
                        Toast.fire({
                            icon: 'success',
                            title: res.message
                        });
                    }
                }
            });
        });

        // Handle Set Slot button click
        $(document).on('click', '.btn-set-slot', function() {
            currentSchoolId = $(this).data('id');
            let name = $(this).data('name');
            currentSlotUrl = $(this).data('url');

            $('#slotModalSchoolName').text(name);
            $('#setSlotModal').modal('show');
        });

        // Set slot in modal
        $('.btn-modal-set-slot').click(function() {
            let slot = $(this).data('slot');
            if (!currentSlotUrl) return;

            $.ajax({
                url: currentSlotUrl,
                type: "POST",
                data: { slot: slot },
                success: function(res) {
                    $('#setSlotModal').modal('hide');
                    reloadDataTable();

                    Swal.fire({
                        icon: 'success',
                        title: 'Slot Berhasil Diubah',
                        text: res.message,
                        timer: 1500,
                        showConfirmButton: false
                    });
                }
            });
        });

        // Handle Delete with SweetAlert2
        $(document).on('click', '.btn-delete', function() {
            let name = $(this).data('name');
            let deleteUrl = $(this).data('url');

            Swal.fire({
                title: 'Hapus Data Sekolah?',
                html: `Apakah Anda yakin ingin menghapus data sekolah <strong>${name}</strong>?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, Hapus Data!',
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
                            reloadDataTable();
                            Swal.fire({
                                icon: 'success',
                                title: 'Terhapus!',
                                text: res.message || 'Data sekolah telah berhasil dihapus.',
                                timer: 1500,
                                showConfirmButton: false
                            });
                        },
                        error: function() {
                            Swal.fire('Error', 'Terjadi kesalahan saat menghapus data.', 'error');
                        }
                    });
                }
            });
        });
    });
    </script>
@endpush
