@extends('layouts.dashboard.template')

@section('title', 'Dashboard & Kontrol Panggung')

@section('content')
<div class="pagetitle d-flex justify-content-between align-items-center">
    <div>
        <h1>Dashboard & Kontrol Panggung</h1>
        <nav>
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Home</a></li>
                <li class="breadcrumb-item active">Kontrol Cerdas Cermat</li>
            </ol>
        </nav>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('dashboard.rekapitulasi.index') }}" class="btn btn-warning text-dark fw-bold shadow-sm">
            <i class="bi bi-trophy-fill me-1"></i> Rekapitulasi Juara
        </a>
        <a href="{{ route('beranda') }}" target="_blank" class="btn btn-uis-primary shadow-sm">
            <i class="bi bi-display me-1"></i> Layar Panggung <i class="bi bi-box-arrow-up-right ms-1"></i>
        </a>
    </div>
</div><!-- End Page Title -->

<section class="section dashboard mt-3">

    <!-- Row 1: Quick Stats & Timer Controller -->
    <div class="row">

        <!-- Timer Stage Controller -->
        <div class="col-lg-7">
            <div class="card shadow-sm border-0 mb-4" style="background: linear-gradient(135deg, #064e3b 0%, #047857 100%); color: #fff; border-radius: 14px;">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="card-title text-white m-0 p-0 fw-bold">
                            <i class="bi bi-stopwatch-fill text-warning me-2"></i> PENGATUR TIMER PANGGUNG
                        </h5>
                        <span id="timerBadgeStatus" class="badge bg-secondary text-white fs-6 px-3 py-1 text-uppercase fw-bold">
                            {{ $timerStatus === 'running' ? 'BERJALAN' : ($timerStatus === 'paused' ? 'DIJEDA' : 'BERHENTI') }}
                        </span>
                    </div>

                    <div class="row align-items-center py-2 g-3">
                        <div class="col-md-5 text-center text-md-start">
                            <div class="fw-bold text-white font-monospace" id="dashTimerDisplay" style="font-size: 2.8rem; line-height: 1.1; white-space: nowrap; text-shadow: 0 4px 10px rgba(0,0,0,0.5);">
                                {{ sprintf('%02d : %02d', floor($timerRemaining / 60), $timerRemaining % 60) }}
                            </div>
                            <div class="text-white-50 small mt-1">Durasi Aktif: <span id="currentDurationText" class="text-warning fw-bold">{{ $timerDuration }}</span> detik</div>
                        </div>

                        <div class="col-md-7 text-center text-md-end">
                            <div class="d-flex flex-wrap gap-2 justify-content-center justify-content-md-end">
                                <button type="button" id="btnTimerStart" class="btn btn-success px-3 shadow fw-bold">
                                    <i class="bi bi-play-fill fs-5 align-middle"></i> START
                                </button>
                                <button type="button" id="btnTimerPause" class="btn btn-warning px-3 shadow fw-bold">
                                    <i class="bi bi-pause-fill fs-5 align-middle"></i> PAUSE
                                </button>
                                <button type="button" id="btnTimerReset" class="btn btn-danger px-3 shadow fw-bold">
                                    <i class="bi bi-arrow-counterclockwise fs-5 align-middle"></i> RESET
                                </button>
                            </div>

                            <div class="mt-3 d-flex gap-1 justify-content-center justify-content-md-end align-items-center flex-wrap">
                                <span class="text-white-50 small me-2">Pilih Durasi:</span>
                                <button type="button" class="btn btn-sm btn-outline-light btn-set-dur {{ $timerDuration == 10 ? 'active fw-bold' : '' }}" data-sec="10">10s</button>
                                <button type="button" class="btn btn-sm btn-outline-light btn-set-dur {{ $timerDuration == 15 ? 'active fw-bold' : '' }}" data-sec="15">15s</button>
                                <button type="button" class="btn btn-sm btn-outline-light btn-set-dur {{ $timerDuration == 30 ? 'active fw-bold' : '' }}" data-sec="30">30s</button>
                                <button type="button" class="btn btn-sm btn-outline-light btn-set-dur {{ $timerDuration == 60 ? 'active fw-bold' : '' }}" data-sec="60">60s</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Summary Cards -->
        <div class="col-lg-5">
            <div class="row">
                <div class="col-sm-6">
                    <div class="card info-card sales-card border-0 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title text-muted">Total Sekolah</h5>
                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center bg-success-subtle text-success" style="width: 54px; height: 54px; font-size: 26px; flex-shrink: 0;">
                                    <i class="bi bi-mortarboard-fill"></i>
                                </div>
                                <div class="ps-3">
                                    <h4 class="fw-bold mb-0 text-dark">{{ $totalSchools }}</h4>
                                    <span class="text-muted small">Terdaftar</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="card info-card revenue-card border-0 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title text-muted">Slot Panggung</h5>
                            <div class="d-flex align-items-center">
                                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center bg-primary-subtle text-primary" style="width: 54px; height: 54px; font-size: 26px; flex-shrink: 0;">
                                    <i class="bi bi-display"></i>
                                </div>
                                <div class="ps-3">
                                    <h4 class="fw-bold mb-0 text-dark">3 Slot</h4>
                                    <span class="text-success small fw-bold">Aktif Tampil</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12">
                    <div class="card border-0 shadow-sm bg-light">
                        <div class="card-body p-3 d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="fw-bold mb-1 text-dark"><i class="bi bi-info-circle text-primary me-1"></i> Mode Sinkronisasi</h6>
                                <p class="text-muted small mb-0">Reset mengubah waktu jadi 00:00, Start langsung memulai hitung mundur.</p>
                            </div>
                            <a href="{{ route('dashboard.schools.index') }}" class="btn btn-outline-dark btn-sm rounded-pill">
                                Kelola Sekolah <i class="bi bi-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Row 2: 3 Active Slots Score Controller -->
    <h5 class="fw-bold text-dark mt-2 mb-3"><i class="bi bi-sliders me-2 text-success"></i> Kontrol Skor 3 Tim di Panggung</h5>
    <div class="row">

        <!-- Slot 1 (Kiri) -->
        <div class="col-lg-4 mb-4">
            <div class="card border-0 shadow-sm h-100" style="border-top: 5px solid #2563eb !important; border-radius: 12px;">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <span class="badge bg-primary px-3 py-2 fs-6"><i class="bi bi-display me-1"></i> SLOT 1 (KIRI)</span>
                    <span class="badge bg-primary text-white fs-6 px-3 py-1 fw-bold shadow-sm" id="slot1ReguBadge">{{ $slot1->regu ?? 'Regu A' }}</span>
                </div>
                <div class="card-body p-4 text-center">
                    <div class="mb-3">
                        <label class="form-label small text-muted fw-semibold">Pilih Sekolah untuk Slot 1:</label>
                        <select class="form-select form-select-sm select-slot-school" data-slot="1">
                            <option value="">-- Kosongkan Slot 1 --</option>
                            @foreach($allSchools as $school)
                                <option value="{{ $school->id }}" {{ ($slot1 && $slot1->id == $school->id) ? 'selected' : '' }}>
                                    {{ $school->name }} ({{ $school->regu ?? 'No Regu' }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="p-3 bg-light rounded-3 my-3">
                        <div class="text-muted small">NAMA SEKOLAH DI PANGGUNG:</div>
                        <h5 class="fw-bold text-dark mb-0 mt-1" id="slot1NameText">{{ $slot1->name ?? 'Belum Dipilih' }}</h5>
                    </div>

                    <div class="my-3">
                        <div class="text-muted small fw-bold">SKOR SAAT INI</div>
                        <div class="display-3 fw-bold text-primary" id="slot1ScoreDisplay">{{ $slot1->score ?? 0 }}</div>
                    </div>

                    <!-- Quick Score Buttons -->
                    <div class="d-flex flex-wrap gap-2 justify-content-center mt-3">
                        <button type="button" class="btn btn-outline-success btn-sm btn-adj-score" data-slot="1" data-id="{{ $slot1->id ?? '' }}" data-act="add" data-val="5">+5</button>
                        <button type="button" class="btn btn-outline-success btn-sm btn-adj-score" data-slot="1" data-id="{{ $slot1->id ?? '' }}" data-act="add" data-val="10">+10</button>
                        <button type="button" class="btn btn-outline-success btn-sm btn-adj-score" data-slot="1" data-id="{{ $slot1->id ?? '' }}" data-act="add" data-val="50">+50</button>
                        <button type="button" class="btn btn-outline-success btn-sm btn-adj-score" data-slot="1" data-id="{{ $slot1->id ?? '' }}" data-act="add" data-val="100">+100</button>
                        <button type="button" class="btn btn-outline-danger btn-sm btn-adj-score" data-slot="1" data-id="{{ $slot1->id ?? '' }}" data-act="subtract" data-val="5">-5</button>
                        <button type="button" class="btn btn-outline-danger btn-sm btn-adj-score" data-slot="1" data-id="{{ $slot1->id ?? '' }}" data-act="subtract" data-val="10">-10</button>
                        <button type="button" class="btn btn-outline-secondary btn-sm btn-adj-score" data-slot="1" data-id="{{ $slot1->id ?? '' }}" data-act="reset" data-val="0">Reset 0</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Slot 2 (Tengah) -->
        <div class="col-lg-4 mb-4">
            <div class="card border-0 shadow-sm h-100" style="border-top: 5px solid #16a34a !important; border-radius: 12px;">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <span class="badge bg-success px-3 py-2 fs-6"><i class="bi bi-display me-1"></i> SLOT 2 (TENGAH)</span>
                    <span class="badge bg-success text-white fs-6 px-3 py-1 fw-bold shadow-sm" id="slot2ReguBadge">{{ $slot2->regu ?? 'Regu B' }}</span>
                </div>
                <div class="card-body p-4 text-center">
                    <div class="mb-3">
                        <label class="form-label small text-muted fw-semibold">Pilih Sekolah untuk Slot 2:</label>
                        <select class="form-select form-select-sm select-slot-school" data-slot="2">
                            <option value="">-- Kosongkan Slot 2 --</option>
                            @foreach($allSchools as $school)
                                <option value="{{ $school->id }}" {{ ($slot2 && $slot2->id == $school->id) ? 'selected' : '' }}>
                                    {{ $school->name }} ({{ $school->regu ?? 'No Regu' }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="p-3 bg-light rounded-3 my-3">
                        <div class="text-muted small">NAMA SEKOLAH DI PANGGUNG:</div>
                        <h5 class="fw-bold text-dark mb-0 mt-1" id="slot2NameText">{{ $slot2->name ?? 'Belum Dipilih' }}</h5>
                    </div>

                    <div class="my-3">
                        <div class="text-muted small fw-bold">SKOR SAAT INI</div>
                        <div class="display-3 fw-bold text-success" id="slot2ScoreDisplay">{{ $slot2->score ?? 0 }}</div>
                    </div>

                    <!-- Quick Score Buttons -->
                    <div class="d-flex flex-wrap gap-2 justify-content-center mt-3">
                        <button type="button" class="btn btn-outline-success btn-sm btn-adj-score" data-slot="2" data-id="{{ $slot2->id ?? '' }}" data-act="add" data-val="5">+5</button>
                        <button type="button" class="btn btn-outline-success btn-sm btn-adj-score" data-slot="2" data-id="{{ $slot2->id ?? '' }}" data-act="add" data-val="10">+10</button>
                        <button type="button" class="btn btn-outline-success btn-sm btn-adj-score" data-slot="2" data-id="{{ $slot2->id ?? '' }}" data-act="add" data-val="50">+50</button>
                        <button type="button" class="btn btn-outline-success btn-sm btn-adj-score" data-slot="2" data-id="{{ $slot2->id ?? '' }}" data-act="add" data-val="100">+100</button>
                        <button type="button" class="btn btn-outline-danger btn-sm btn-adj-score" data-slot="2" data-id="{{ $slot2->id ?? '' }}" data-act="subtract" data-val="5">-5</button>
                        <button type="button" class="btn btn-outline-danger btn-sm btn-adj-score" data-slot="2" data-id="{{ $slot2->id ?? '' }}" data-act="subtract" data-val="10">-10</button>
                        <button type="button" class="btn btn-outline-secondary btn-sm btn-adj-score" data-slot="2" data-id="{{ $slot2->id ?? '' }}" data-act="reset" data-val="0">Reset 0</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Slot 3 (Kanan) -->
        <div class="col-lg-4 mb-4">
            <div class="card border-0 shadow-sm h-100" style="border-top: 5px solid #ffc107 !important; border-radius: 12px;">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <span class="badge bg-warning text-white px-3 py-2 fs-6 fw-bold shadow-sm"><i class="bi bi-display me-1"></i> SLOT 3 (KANAN)</span>
                    <span class="badge bg-warning text-white fs-6 px-3 py-1 fw-bold shadow-sm" id="slot3ReguBadge">{{ $slot3->regu ?? 'Regu C' }}</span>
                </div>
                <div class="card-body p-4 text-center">
                    <div class="mb-3">
                        <label class="form-label small text-muted fw-semibold">Pilih Sekolah untuk Slot 3:</label>
                        <select class="form-select form-select-sm select-slot-school" data-slot="3">
                            <option value="">-- Kosongkan Slot 3 --</option>
                            @foreach($allSchools as $school)
                                <option value="{{ $school->id }}" {{ ($slot3 && $slot3->id == $school->id) ? 'selected' : '' }}>
                                    {{ $school->name }} ({{ $school->regu ?? 'No Regu' }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="p-3 bg-light rounded-3 my-3">
                        <div class="text-muted small">NAMA SEKOLAH DI PANGGUNG:</div>
                        <h5 class="fw-bold text-dark mb-0 mt-1" id="slot3NameText">{{ $slot3->name ?? 'Belum Dipilih' }}</h5>
                    </div>

                    <div class="my-3">
                        <div class="text-muted small fw-bold">SKOR SAAT INI</div>
                        <div class="display-3 fw-bold text-warning" id="slot3ScoreDisplay">{{ $slot3->score ?? 0 }}</div>
                    </div>

                    <!-- Quick Score Buttons -->
                    <div class="d-flex flex-wrap gap-2 justify-content-center mt-3">
                        <button type="button" class="btn btn-outline-success btn-sm btn-adj-score" data-slot="3" data-id="{{ $slot3->id ?? '' }}" data-act="add" data-val="5">+5</button>
                        <button type="button" class="btn btn-outline-success btn-sm btn-adj-score" data-slot="3" data-id="{{ $slot3->id ?? '' }}" data-act="add" data-val="10">+10</button>
                        <button type="button" class="btn btn-outline-success btn-sm btn-adj-score" data-slot="3" data-id="{{ $slot3->id ?? '' }}" data-act="add" data-val="50">+50</button>
                        <button type="button" class="btn btn-outline-success btn-sm btn-adj-score" data-slot="3" data-id="{{ $slot3->id ?? '' }}" data-act="add" data-val="100">+100</button>
                        <button type="button" class="btn btn-outline-danger btn-sm btn-adj-score" data-slot="3" data-id="{{ $slot3->id ?? '' }}" data-act="subtract" data-val="5">-5</button>
                        <button type="button" class="btn btn-outline-danger btn-sm btn-adj-score" data-slot="3" data-id="{{ $slot3->id ?? '' }}" data-act="subtract" data-val="10">-10</button>
                        <button type="button" class="btn btn-outline-secondary btn-sm btn-adj-score" data-slot="3" data-id="{{ $slot3->id ?? '' }}" data-act="reset" data-val="0">Reset 0</button>
                    </div>
                </div>
            </div>
        </div>

    </div>

</section>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    let timerState = {
        duration: {{ $timerDuration }},
        remaining: {{ $timerRemaining }},
        status: '{{ $timerStatus }}',
        endTimestamp: 0
    };

    function formatTime(seconds) {
        let m = Math.floor(seconds / 60);
        let s = Math.max(0, seconds % 60);
        return (m < 10 ? '0' + m : m) + ' : ' + (s < 10 ? '0' + s : s);
    }

    function updateTimerUI(data) {
        timerState = data.timer;
        $('#dashTimerDisplay').text(formatTime(timerState.remaining));
        $('#currentDurationText').text(timerState.duration);

        let badge = $('#timerBadgeStatus');
        if (timerState.status === 'running') {
            badge.removeClass('bg-warning bg-secondary').addClass('bg-success').text('BERJALAN');
        } else if (timerState.status === 'paused') {
            badge.removeClass('bg-success bg-secondary').addClass('bg-warning text-dark').text('DIJEDA');
        } else {
            badge.removeClass('bg-success bg-warning').addClass('bg-secondary text-white').text('BERHENTI');
        }

        // Update Slots dynamically
        if (data.slots) {
            for (let i = 1; i <= 3; i++) {
                let slotData = data.slots[i];
                $('#slot' + i + 'ScoreDisplay').text(slotData.score);
                $('#slot' + i + 'NameText').text(slotData.name || 'Belum Dipilih');
                $('#slot' + i + 'ReguBadge').text(slotData.regu || 'Slot ' + i);

                // Update data-id on buttons
                $('.btn-adj-score[data-slot="' + i + '"]').attr('data-id', slotData.id || '');
            }
        }
    }

    // Timer action API call
    function sendTimerAction(action, extraData = {}) {
        $.ajax({
            url: "{{ route('stage.timer') }}",
            type: "POST",
            data: {
                action: action,
                ...extraData
            },
            success: function(response) {
                updateTimerUI(response);
            }
        });
    }

    $('#btnTimerStart').click(function() {
        sendTimerAction('start');
    });

    $('#btnTimerPause').click(function() {
        sendTimerAction('pause');
    });

    $('#btnTimerReset').click(function() {
        sendTimerAction('reset');
    });

    $('.btn-set-dur').click(function() {
        let sec = $(this).data('sec');
        $('.btn-set-dur').removeClass('active fw-bold');
        $(this).addClass('active fw-bold');
        sendTimerAction('set_duration', { duration: sec });
    });

    // Score adjust button
    $(document).on('click', '.btn-adj-score', function() {
        let schoolId = $(this).attr('data-id');
        let action = $(this).data('act');
        let amount = $(this).data('val');
        let slot = $(this).data('slot');

        if (!schoolId) {
            Swal.fire({
                icon: 'warning',
                title: 'Slot Kosong',
                text: 'Silakan pilih sekolah terlebih dahulu untuk Slot ' + slot + '.'
            });
            return;
        }

        $.ajax({
            url: "/dashboard/schools/" + schoolId + "/adjust-score",
            type: "POST",
            data: {
                action: action,
                amount: amount
            },
            success: function(res) {
                if (res.success) {
                    $('#slot' + slot + 'ScoreDisplay').text(res.score);
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

    // Slot school assignment dropdown change
    $('.select-slot-school').change(function() {
        let slot = $(this).data('slot');
        let schoolId = $(this).val();

        if (schoolId) {
            $.ajax({
                url: "/dashboard/schools/" + schoolId + "/set-slot",
                type: "POST",
                data: { slot: slot },
                success: function(res) {
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

                    // Immediate sync poll
                    $.get("{{ route('stage.data') }}", function(data) {
                        updateTimerUI(data);
                    });
                }
            });
        }
    });

    // Background polling every 500ms for instantaneous sync
    setInterval(function() {
        $.get("{{ route('stage.data') }}", function(data) {
            updateTimerUI(data);
        });
    }, 500);
});
</script>
@endpush
