@extends('layouts.dashboard.template')

@section('title', 'Backup Database & Storage')

@section('content')
<style>
    .backup-circle-db {
        width: 52px;
        height: 52px;
        border-radius: 50%;
        background-color: #276738;
        color: #ffffff;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }
    .backup-circle-storage {
        width: 52px;
        height: 52px;
        border-radius: 50%;
        background-color: #e8f5e9;
        color: #2e7d32;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }
    .btn-backup-green {
        background-color: #236c3b;
        color: #ffffff;
        border: 1px solid #236c3b;
        font-weight: 500;
        transition: all 0.2s ease-in-out;
    }
    .btn-backup-green:hover {
        background-color: #1b532d;
        color: #ffffff;
        border-color: #1b532d;
    }
    .alert-backup-info {
        background-color: #e1f5fe;
        border: 1px solid #b3e5fc;
        color: #0277bd;
    }
    .alert-backup-warning {
        background-color: #fff9c4;
        border: 1px solid #fff59d;
        color: #795548;
    }
    .code-db-name {
        color: #d63384;
        font-weight: 600;
        background-color: #f8f9fa;
        padding: 2px 6px;
        border-radius: 4px;
    }
</style>

<div class="pagetitle">
    <h1 class="fw-bold text-dark mb-1">Backup Database &amp; Storage</h1>
    <nav>
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Home</a></li>
            <li class="breadcrumb-item">Pengaturan Sistem</li>
            <li class="breadcrumb-item active">Backup Database &amp; Storage</li>
        </ol>
    </nav>
</div><!-- End Page Title -->

<section class="section mt-3">
    <div class="row g-4">
        <!-- Card 1: Ekspor & Impor Database -->
        <div class="col-12 col-lg-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body p-4 d-flex flex-column">
                    <div class="d-flex align-items-start gap-3 mb-4">
                        <div class="backup-circle-db flex-shrink-0">
                            <i class="bi bi-server fs-4" aria-hidden="true"></i>
                        </div>
                        <div>
                            <h5 class="fw-bold mb-1 text-dark">Ekspor &amp; Impor Database</h5>
                            <p class="text-muted small mb-0">Unduh atau pulihkan struktur tabel dan data database aplikasi sebagai berkas SQL.</p>
                        </div>
                    </div>

                    <dl class="row mb-4 small">
                        <dt class="col-sm-4 text-muted fw-semibold">Koneksi</dt>
                        <dd class="col-sm-8"><span class="badge bg-light text-dark border px-2 py-1">{{ strtoupper($databaseDriver) }}</span></dd>
                        
                        <dt class="col-sm-4 text-muted fw-semibold">Database</dt>
                        <dd class="col-sm-8"><code class="code-db-name">{{ $databaseName ?: '-' }}</code></dd>
                        
                        <dt class="col-sm-4 text-muted fw-semibold">Isi backup</dt>
                        <dd class="col-sm-8 text-secondary">Struktur dan data semua tabel MySQL</dd>
                    </dl>

                    @if($databaseDriver === 'mysql')
                        <div class="alert alert-backup-info small mt-auto mb-3 rounded-2" role="alert">
                            <i class="bi bi-shield-lock-fill me-1" aria-hidden="true"></i>
                            Hanya administrator yang dapat mengunduh dan memulihkan database. Simpan berkas SQL di lokasi aman karena berisi seluruh data aplikasi.
                        </div>
                        <div class="d-flex flex-wrap align-items-center gap-2 pt-2">
                            <a href="{{ route('dashboard.backup.export') }}" class="btn btn-backup-green d-inline-flex align-items-center gap-2 shadow-sm">
                                <i class="bi bi-download"></i>
                                Unduh Backup SQL
                            </a>
                            <button type="button" class="btn btn-outline-primary d-inline-flex align-items-center gap-2" data-bs-toggle="modal" data-bs-target="#modalImportDatabase">
                                <i class="bi bi-upload"></i>
                                Import / Pulihkan Database
                            </button>
                        </div>
                    @else
                        <div class="alert alert-warning mt-auto mb-0 small" role="alert">
                            <i class="bi bi-exclamation-triangle-fill me-1"></i>
                            Ekspor &amp; Impor SQL membutuhkan koneksi database MySQL. Koneksi aktif saat ini adalah
                            <strong>{{ strtoupper($databaseDriver) }}</strong>.
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Card 2: Backup & Impor Storage Public -->
        <div class="col-12 col-lg-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body p-4 d-flex flex-column">
                    <div class="d-flex align-items-start gap-3 mb-4">
                        <div class="backup-circle-storage flex-shrink-0">
                            <i class="bi bi-folder-symlink fs-4" aria-hidden="true"></i>
                        </div>
                        <div>
                            <h5 class="fw-bold mb-1 text-dark">Backup &amp; Impor Storage Public</h5>
                            <p class="text-muted small mb-0">Arsipkan atau pulihkan semua file pada folder <code class="text-danger">storage/app/public</code> ke dalam berkas ZIP.</p>
                        </div>
                    </div>

                    <div class="alert alert-backup-warning small mt-auto mb-3 rounded-2" role="alert">
                        <i class="bi bi-exclamation-triangle-fill me-1 text-warning"></i>
                        Backup storage memuat seluruh berkas lampiran, SK, dan dokumen publik aplikasi.
                    </div>

                    <div class="d-flex flex-wrap align-items-center gap-2 pt-2">
                        <a href="{{ route('dashboard.backup.storage-public') }}" class="btn btn-backup-green d-inline-flex align-items-center gap-2 shadow-sm">
                            <i class="bi bi-download"></i>
                            Unduh Backup Storage ZIP
                        </a>
                        <button type="button" class="btn btn-outline-success d-inline-flex align-items-center gap-2" data-bs-toggle="modal" data-bs-target="#modalImportStorage">
                            <i class="bi bi-upload"></i>
                            Import / Pulihkan Storage
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Modal Import Database -->
<div class="modal fade" id="modalImportDatabase" tabindex="-1" aria-labelledby="modalImportDatabaseLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title fw-bold" id="modalImportDatabaseLabel">
                    <i class="bi bi-database-up me-2"></i> Import / Pulihkan Database
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('dashboard.backup.import') }}" method="POST" enctype="multipart/form-data" id="formImportDatabase">
                @csrf
                <div class="modal-body p-4">
                    <div class="alert alert-warning d-flex align-items-start gap-2 mb-3" role="alert">
                        <i class="bi bi-exclamation-triangle-fill fs-5 text-warning flex-shrink-0 mt-1"></i>
                        <div class="small">
                            <strong>Perhatian:</strong> Mengimpor database akan memulihkan data sistem sesuai dengan berkas SQL yang diunggah. Pastikan Anda telah mengunduh cadangan (backup) database saat ini terlebih dahulu!
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold text-dark mb-1">Pilih Berkas Backup SQL (.sql)</label>
                        <input type="file" name="file_sql" class="form-control" accept=".sql" required>
                        <div class="form-text small">Unggah berkas backup SQL resmi aplikasi atau MySQL dump.</div>
                    </div>

                    <div class="p-3 bg-light rounded border mb-3">
                        <div class="form-check form-switch mb-0">
                            <input class="form-check-input" type="checkbox" role="switch" name="wipe_before_import" value="1" id="wipeBeforeImport" checked>
                            <label class="form-check-label fw-semibold text-dark" for="wipeBeforeImport">
                                Sinkronkan Total (Bersihkan tabel lama sebelum impor)
                            </label>
                        </div>
                        <div class="text-muted small mt-1 ms-4">
                            Data lama akan dibersihkan terlebih dahulu sehingga seluruh sistem 100% sinkron dan identik dengan data pada berkas backup yang baru.
                        </div>
                    </div>

                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="confirmDbRestore" required>
                        <label class="form-check-label small text-secondary" for="confirmDbRestore">
                            Saya yakin dan menyetujui pemulihan database dengan data baru dari berkas ini.
                        </label>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary px-3" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary px-4 fw-bold" id="btnSubmitDbImport">
                        <i class="bi bi-upload me-1"></i> Mulai Impor Database
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Import Storage -->
<div class="modal fade" id="modalImportStorage" tabindex="-1" aria-labelledby="modalImportStorageLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title fw-bold" id="modalImportStorageLabel">
                    <i class="bi bi-folder-symlink me-2"></i> Import / Pulihkan Storage Public
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('dashboard.backup.storage-public.import') }}" method="POST" enctype="multipart/form-data" id="formImportStorage">
                @csrf
                <div class="modal-body p-4">
                    <div class="alert alert-info d-flex align-items-start gap-2 mb-3" role="alert">
                        <i class="bi bi-info-circle-fill fs-5 text-primary flex-shrink-0 mt-1"></i>
                        <div class="small">
                            Berkas ZIP akan diekstrak langsung ke folder <code>storage/app/public</code>. Berkas dokumen/lampiran yang ada akan disesuaikan dan ditimpa dengan berkas terbaru dari arsip ZIP.
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold text-dark mb-1">Pilih Berkas Backup Storage (.zip)</label>
                        <input type="file" name="file_zip" class="form-control" accept=".zip" required>
                        <div class="form-text small">Unggah berkas ZIP cadangan storage public.</div>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary px-3" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success px-4 fw-bold text-white" id="btnSubmitStorageImport">
                        <i class="bi bi-upload me-1"></i> Ekstrak &amp; Pulihkan Storage
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const formDb = document.getElementById('formImportDatabase');
    if (formDb) {
        formDb.addEventListener('submit', function (e) {
            const btn = document.getElementById('btnSubmitDbImport');
            if (btn) {
                btn.disabled = true;
                btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Memproses Pemulihan...';
            }
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    title: 'Memulihkan Database...',
                    text: 'Mohon tunggu, proses sedang menyinkronkan data database baru.',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    showConfirmButton: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
            }
        });
    }

    const formStorage = document.getElementById('formImportStorage');
    if (formStorage) {
        formStorage.addEventListener('submit', function (e) {
            const btn = document.getElementById('btnSubmitStorageImport');
            if (btn) {
                btn.disabled = true;
                btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Mengekstrak Berkas...';
            }
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    title: 'Mengekstrak Storage...',
                    text: 'Mohon tunggu, berkas arsip sedang diekstrak dan disinkronkan.',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    showConfirmButton: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
            }
        });
    }
});
</script>
@endpush
