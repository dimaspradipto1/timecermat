@extends('layouts.dashboard.template')

@section('title', 'Rekapitulasi Juara 1, 2, dan 3')

@push('styles')
<style>
    /* PODIUM STYLING */
    .podium-section {
        background: linear-gradient(135deg, #022016 0%, #064e3b 60%, #047857 100%);
        border-radius: 18px;
        padding: 35px 25px 20px;
        color: #fff;
        position: relative;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(4, 120, 87, 0.25);
    }

    .podium-section::before {
        content: '';
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(255,255,255,0.06) 0%, transparent 60%);
        pointer-events: none;
    }

    .podium-container {
        display: flex;
        align-items: flex-end;
        justify-content: center;
        gap: 15px;
        margin-top: 20px;
        min-height: 380px;
    }

    .podium-card {
        flex: 1;
        max-width: 310px;
        border-radius: 16px 16px 12px 12px;
        text-align: center;
        position: relative;
        transition: transform 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        display: flex;
        flex-direction: column;
        justify-content: flex-end;
    }

    .podium-card:hover {
        transform: translateY(-8px);
    }

    .podium-card-content {
        padding: 20px 15px;
        border-radius: 16px 16px 0 0;
        background: rgba(255, 255, 255, 0.08);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.15);
        border-bottom: none;
        position: relative;
        z-index: 2;
    }

    .podium-avatar-wrapper {
        position: relative;
        width: 80px;
        height: 80px;
        margin: 0 auto 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        font-size: 38px;
    }

    /* Rank 1 (Gold) */
    .podium-rank-1 {
        order: 2;
        z-index: 3;
    }
    .podium-rank-1 .podium-step {
        height: 140px;
        background: linear-gradient(180deg, #f59e0b 0%, #b45309 100%);
        box-shadow: 0 0 25px rgba(245, 158, 11, 0.4);
    }
    .podium-rank-1 .podium-avatar-wrapper {
        background: linear-gradient(135deg, #fef08a 0%, #eab308 50%, #ca8a04 100%);
        color: #78350f;
        box-shadow: 0 0 25px rgba(234, 179, 8, 0.6);
        border: 3px solid #fef9c3;
        animation: pulse-gold 2s infinite;
    }
    .podium-rank-1 .podium-card-content {
        background: rgba(234, 179, 8, 0.15);
        border-color: rgba(253, 224, 71, 0.4);
    }

    /* Rank 2 (Silver) */
    .podium-rank-2 {
        order: 1;
        z-index: 2;
    }
    .podium-rank-2 .podium-step {
        height: 100px;
        background: linear-gradient(180deg, #94a3b8 0%, #475569 100%);
    }
    .podium-rank-2 .podium-avatar-wrapper {
        background: linear-gradient(135deg, #f8fafc 0%, #cbd5e1 50%, #94a3b8 100%);
        color: #334155;
        box-shadow: 0 0 20px rgba(148, 163, 184, 0.5);
        border: 3px solid #ffffff;
    }

    /* Rank 3 (Bronze) */
    .podium-rank-3 {
        order: 3;
        z-index: 1;
    }
    .podium-rank-3 .podium-step {
        height: 75px;
        background: linear-gradient(180deg, #d97706 0%, #78350f 100%);
    }
    .podium-rank-3 .podium-avatar-wrapper {
        background: linear-gradient(135deg, #fed7aa 0%, #f97316 50%, #c2410c 100%);
        color: #451a03;
        box-shadow: 0 0 20px rgba(249, 115, 22, 0.4);
        border: 3px solid #ffedd5;
    }

    .podium-step {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        font-family: 'Montserrat', sans-serif;
        font-weight: 800;
        font-size: 32px;
        color: #fff;
        border-radius: 0 0 12px 12px;
        text-shadow: 0 2px 5px rgba(0,0,0,0.4);
    }

    .podium-school-name {
        font-family: 'Montserrat', sans-serif;
        font-weight: 700;
        font-size: 15px;
        line-height: 1.3;
        margin-bottom: 4px;
        min-height: 38px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .podium-score {
        font-family: 'Montserrat', sans-serif;
        font-size: 32px;
        font-weight: 800;
        line-height: 1;
        margin: 6px 0;
        text-shadow: 0 2px 10px rgba(0,0,0,0.3);
    }

    @keyframes pulse-gold {
        0%, 100% {
            box-shadow: 0 0 20px rgba(234, 179, 8, 0.5);
            transform: scale(1);
        }
        50% {
            box-shadow: 0 0 35px rgba(250, 204, 21, 0.9);
            transform: scale(1.05);
        }
    }

    /* STAT CARD BADGES */
    .winner-badge-gold {
        background: linear-gradient(135deg, #fbbf24 0%, #d97706 100%);
        color: #fff;
        font-weight: 700;
    }
    .winner-badge-silver {
        background: linear-gradient(135deg, #cbd5e1 0%, #64748b 100%);
        color: #fff;
        font-weight: 700;
    }
    .winner-badge-bronze {
        background: linear-gradient(135deg, #fdba74 0%, #c2410c 100%);
        color: #fff;
        font-weight: 700;
    }

    .rank-circle {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 15px;
    }

    /* RESPONSIVE */
    @media (max-width: 768px) {
        .podium-container {
            flex-direction: column;
            align-items: stretch;
            min-height: auto;
        }
        .podium-card {
            max-width: 100%;
            margin-bottom: 12px;
        }
        .podium-rank-1 { order: 1; }
        .podium-rank-2 { order: 2; }
        .podium-rank-3 { order: 3; }
        .podium-step {
            height: 45px !important;
            border-radius: 0 0 8px 8px;
            font-size: 20px;
        }
    }
</style>
@endpush

@section('content')
<div class="pagetitle d-flex justify-content-between align-items-center flex-wrap gap-2">
    <div>
        <h1><i class="bi bi-trophy-fill text-warning me-2"></i> Rekapitulasi Juara 1, 2, & 3</h1>
        <nav>
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Home</a></li>
                <li class="breadcrumb-item active">Rekapitulasi Juara</li>
            </ol>
        </nav>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('stage.juara') }}" target="_blank" class="btn btn-warning text-dark fw-bold shadow-sm">
            <i class="bi bi-display me-1"></i> Layar Panggung Juara <i class="bi bi-box-arrow-up-right ms-1"></i>
        </a>
        <a href="{{ route('dashboard.rekapitulasi.print') }}" target="_blank" class="btn btn-outline-secondary shadow-sm bg-white">
            <i class="bi bi-printer-fill me-1"></i> Cetak Rekap (PDF)
        </a>
        <button type="button" class="btn btn-uis-primary shadow-sm" onclick="window.location.reload();">
            <i class="bi bi-arrow-clockwise me-1"></i> Refresh
        </button>
    </div>
</div><!-- End Page Title -->

<section class="section mt-3">

    <!-- Top Highlight Cards (Juara 1, 2, 3 Cards) -->
    <div class="row g-3 mb-4">
        <!-- Juara 1 -->
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100 position-relative overflow-hidden" style="border-left: 5px solid #f59e0b !important;">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <span class="badge winner-badge-gold px-3 py-2 rounded-pill fs-6">
                            <i class="bi bi-trophy-fill me-1"></i> JUARA 1 (EMAS)
                        </span>
                        <div class="rank-circle winner-badge-gold shadow-sm">1</div>
                    </div>
                    @if($juara1)
                        <h4 class="fw-bold text-dark mt-3 mb-1">{{ $juara1->name }}</h4>
                        <div class="text-muted small mb-3">
                            <span class="badge bg-light text-dark border me-1">{{ $juara1->regu ?? 'Regu Utama' }}</span>
                            @if($juara1->slot)
                                <span class="badge bg-primary-subtle text-primary">Slot {{ $juara1->slot }} Panggung</span>
                            @endif
                        </div>
                        <div class="d-flex justify-content-between align-items-baseline pt-2 border-top">
                            <span class="text-muted small fw-semibold">TOTAL SKOR:</span>
                            <span class="fs-2 fw-bold text-warning">{{ number_format($juara1->score, 0, ',', '.') }} <span class="fs-6 text-muted">Poin</span></span>
                        </div>
                    @else
                        <div class="text-center py-4 text-muted">
                            <i class="bi bi-inbox fs-2 d-block mb-1"></i>
                            Belum ada data sekolah
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Juara 2 -->
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100 position-relative overflow-hidden" style="border-left: 5px solid #94a3b8 !important;">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <span class="badge winner-badge-silver px-3 py-2 rounded-pill fs-6">
                            <i class="bi bi-award-fill me-1"></i> JUARA 2 (PERAK)
                        </span>
                        <div class="rank-circle winner-badge-silver shadow-sm">2</div>
                    </div>
                    @if($juara2)
                        <h4 class="fw-bold text-dark mt-3 mb-1">{{ $juara2->name }}</h4>
                        <div class="text-muted small mb-3">
                            <span class="badge bg-light text-dark border me-1">{{ $juara2->regu ?? 'Regu Utama' }}</span>
                            @if($juara2->slot)
                                <span class="badge bg-primary-subtle text-primary">Slot {{ $juara2->slot }} Panggung</span>
                            @endif
                        </div>
                        <div class="d-flex justify-content-between align-items-baseline pt-2 border-top">
                            <span class="text-muted small fw-semibold">TOTAL SKOR:</span>
                            <span class="fs-2 fw-bold text-secondary">{{ number_format($juara2->score, 0, ',', '.') }} <span class="fs-6 text-muted">Poin</span></span>
                        </div>
                    @else
                        <div class="text-center py-4 text-muted">
                            <i class="bi bi-inbox fs-2 d-block mb-1"></i>
                            Belum ada data sekolah ke-2
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Juara 3 -->
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100 position-relative overflow-hidden" style="border-left: 5px solid #d97706 !important;">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <span class="badge winner-badge-bronze px-3 py-2 rounded-pill fs-6">
                            <i class="bi bi-award me-1"></i> JUARA 3 (PERUNGGU)
                        </span>
                        <div class="rank-circle winner-badge-bronze shadow-sm">3</div>
                    </div>
                    @if($juara3)
                        <h4 class="fw-bold text-dark mt-3 mb-1">{{ $juara3->name }}</h4>
                        <div class="text-muted small mb-3">
                            <span class="badge bg-light text-dark border me-1">{{ $juara3->regu ?? 'Regu Utama' }}</span>
                            @if($juara3->slot)
                                <span class="badge bg-primary-subtle text-primary">Slot {{ $juara3->slot }} Panggung</span>
                            @endif
                        </div>
                        <div class="d-flex justify-content-between align-items-baseline pt-2 border-top">
                            <span class="text-muted small fw-semibold">TOTAL SKOR:</span>
                            <span class="fs-2 fw-bold" style="color: #c2410c;">{{ number_format($juara3->score, 0, ',', '.') }} <span class="fs-6 text-muted">Poin</span></span>
                        </div>
                    @else
                        <div class="text-center py-4 text-muted">
                            <i class="bi bi-inbox fs-2 d-block mb-1"></i>
                            Belum ada data sekolah ke-3
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Visual Podium Section -->
    <div class="podium-section mb-4">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 pb-3 border-bottom border-white border-opacity-10">
            <div>
                <h4 class="fw-bold text-white mb-0">
                    <i class="bi bi-award-fill text-warning me-2"></i> Panggung Podium Juara 1, 2, dan 3
                </h4>
                <p class="text-white-50 small mb-0">Visualisasi podium kehormatan pemenang UIS Grand Academic Challenge {{ date('Y') }}</p>
            </div>
            
            <!-- Podium Mode Toggle Pills -->
            <ul class="nav nav-pills bg-black bg-opacity-25 p-1 rounded-pill" id="podiumTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active rounded-pill text-white btn-sm px-3 fw-semibold" id="tab-all-btn" data-bs-toggle="pill" data-bs-target="#tab-all" type="button" role="tab">
                        <i class="bi bi-globe2 me-1"></i> Semua Sekolah ({{ $totalSchools }})
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link rounded-pill text-white btn-sm px-3 fw-semibold" id="tab-stage-btn" data-bs-toggle="pill" data-bs-target="#tab-stage" type="button" role="tab">
                        <i class="bi bi-display me-1"></i> 3 Tim di Panggung ({{ $stageSchools->count() }})
                    </button>
                </li>
            </ul>
        </div>

        <div class="tab-content" id="podiumTabContent">
            
            <!-- Tab 1: Peringkat Semua Sekolah -->
            <div class="tab-pane fade show active" id="tab-all" role="tabpanel">
                <div class="podium-container">
                    
                    <!-- 2nd Place (Silver) -->
                    <div class="podium-card podium-rank-2">
                        <div class="podium-card-content">
                            <div class="podium-avatar-wrapper">
                                <i class="bi bi-award-fill"></i>
                            </div>
                            <span class="badge winner-badge-silver rounded-pill px-3 py-1 mb-2">JUARA 2</span>
                            <div class="podium-school-name">{{ $juara2->name ?? 'Belum Ada' }}</div>
                            <div class="small text-white-50">{{ $juara2->regu ?? '-' }}</div>
                            <div class="podium-score">{{ $juara2->score ?? 0 }}</div>
                            <div class="small text-white-50">POIN</div>
                        </div>
                        <div class="podium-step">2</div>
                    </div>

                    <!-- 1st Place (Gold) -->
                    <div class="podium-card podium-rank-1">
                        <div class="podium-card-content">
                            <div class="podium-avatar-wrapper">
                                <i class="bi bi-trophy-fill"></i>
                            </div>
                            <span class="badge winner-badge-gold rounded-pill px-3 py-1 mb-2">
                                <i class="bi bi-stars"></i> JUARA 1 (CHAMPION)
                            </span>
                            <div class="podium-school-name fw-bold">{{ $juara1->name ?? 'Belum Ada' }}</div>
                            <div class="small text-warning fw-semibold">{{ $juara1->regu ?? '-' }}</div>
                            <div class="podium-score text-warning">{{ $juara1->score ?? 0 }}</div>
                            <div class="small text-warning">POIN</div>
                        </div>
                        <div class="podium-step">
                            <i class="bi bi-crown-fill text-warning fs-3 mb-1"></i>
                            1
                        </div>
                    </div>

                    <!-- 3rd Place (Bronze) -->
                    <div class="podium-card podium-rank-3">
                        <div class="podium-card-content">
                            <div class="podium-avatar-wrapper">
                                <i class="bi bi-award"></i>
                            </div>
                            <span class="badge winner-badge-bronze rounded-pill px-3 py-1 mb-2">JUARA 3</span>
                            <div class="podium-school-name">{{ $juara3->name ?? 'Belum Ada' }}</div>
                            <div class="small text-white-50">{{ $juara3->regu ?? '-' }}</div>
                            <div class="podium-score">{{ $juara3->score ?? 0 }}</div>
                            <div class="small text-white-50">POIN</div>
                        </div>
                        <div class="podium-step">3</div>
                    </div>

                </div>
            </div>

            <!-- Tab 2: Peringkat 3 Tim di Panggung -->
            <div class="tab-pane fade" id="tab-stage" role="tabpanel">
                <div class="podium-container">
                    
                    <!-- Stage 2nd Place -->
                    <div class="podium-card podium-rank-2">
                        <div class="podium-card-content">
                            <div class="podium-avatar-wrapper">
                                <i class="bi bi-award-fill"></i>
                            </div>
                            <span class="badge winner-badge-silver rounded-pill px-3 py-1 mb-2">JUARA 2 PANGGUNG</span>
                            <div class="podium-school-name">{{ $stageJuara2->name ?? 'Belum Ada' }}</div>
                            <div class="small text-white-50">{{ $stageJuara2 ? ($stageJuara2->regu . ' - Slot ' . $stageJuara2->slot) : '-' }}</div>
                            <div class="podium-score">{{ $stageJuara2->score ?? 0 }}</div>
                            <div class="small text-white-50">POIN</div>
                        </div>
                        <div class="podium-step">2</div>
                    </div>

                    <!-- Stage 1st Place -->
                    <div class="podium-card podium-rank-1">
                        <div class="podium-card-content">
                            <div class="podium-avatar-wrapper">
                                <i class="bi bi-trophy-fill"></i>
                            </div>
                            <span class="badge winner-badge-gold rounded-pill px-3 py-1 mb-2">
                                <i class="bi bi-stars"></i> JUARA 1 PANGGUNG
                            </span>
                            <div class="podium-school-name fw-bold">{{ $stageJuara1->name ?? 'Belum Ada' }}</div>
                            <div class="small text-warning fw-semibold">{{ $stageJuara1 ? ($stageJuara1->regu . ' - Slot ' . $stageJuara1->slot) : '-' }}</div>
                            <div class="podium-score text-warning">{{ $stageJuara1->score ?? 0 }}</div>
                            <div class="small text-warning">POIN</div>
                        </div>
                        <div class="podium-step">
                            <i class="bi bi-crown-fill text-warning fs-3 mb-1"></i>
                            1
                        </div>
                    </div>

                    <!-- Stage 3rd Place -->
                    <div class="podium-card podium-rank-3">
                        <div class="podium-card-content">
                            <div class="podium-avatar-wrapper">
                                <i class="bi bi-award"></i>
                            </div>
                            <span class="badge winner-badge-bronze rounded-pill px-3 py-1 mb-2">JUARA 3 PANGGUNG</span>
                            <div class="podium-school-name">{{ $stageJuara3->name ?? 'Belum Ada' }}</div>
                            <div class="small text-white-50">{{ $stageJuara3 ? ($stageJuara3->regu . ' - Slot ' . $stageJuara3->slot) : '-' }}</div>
                            <div class="podium-score">{{ $stageJuara3->score ?? 0 }}</div>
                            <div class="small text-white-50">POIN</div>
                        </div>
                        <div class="podium-step">3</div>
                    </div>

                </div>
            </div>

        </div>
    </div>

    <!-- Complete Ranked Table -->
    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">
            <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
                <div>
                    <h5 class="card-title p-0 m-0 fw-bold text-dark">
                        <i class="bi bi-list-ol text-success me-2"></i> Tabel Rekapitulasi & Peringkat Lengkap
                    </h5>
                    <p class="text-muted small mb-0">Urutan peringkat sekolah berdasarkan akumulasi perolehan skor tertinggi.</p>
                </div>
                <div class="d-flex gap-2">
                    <span class="badge bg-light text-dark border align-self-center px-3 py-2">
                        Total Skor Seluruhnya: <strong>{{ number_format($totalScoresAll, 0, ',', '.') }}</strong>
                    </span>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-hover align-middle" id="rekapTable">
                    <thead class="table-light">
                        <tr>
                            <th class="text-center" style="width: 80px;">Peringkat</th>
                            <th>Nama Sekolah Peserta</th>
                            <th>Regu / Tim</th>
                            <th>Status Slot Panggung</th>
                            <th class="text-center" style="width: 150px;">Perolehan Skor</th>
                            <th class="text-center" style="width: 180px;">Status Juara</th>
                            <th class="text-center" style="width: 120px;">Selisih Juara 1</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($allRankedSchools as $index => $school)
                            @php
                                $rank = $index + 1;
                                $scoreDiff = ($juara1 ? $juara1->score : 0) - $school->score;
                                $percentage = ($highestScore > 0) ? round(($school->score / $highestScore) * 100) : 0;
                            @endphp
                            <tr class="{{ $rank === 1 ? 'table-warning bg-opacity-25' : ($rank === 2 ? 'table-secondary bg-opacity-10' : ($rank === 3 ? 'table-light' : '')) }}">
                                <td class="text-center">
                                    @if($rank === 1)
                                        <span class="rank-circle winner-badge-gold shadow-sm">1</span>
                                    @elseif($rank === 2)
                                        <span class="rank-circle winner-badge-silver shadow-sm">2</span>
                                    @elseif($rank === 3)
                                        <span class="rank-circle winner-badge-bronze shadow-sm">3</span>
                                    @else
                                        <span class="rank-circle bg-light text-muted border">{{ $rank }}</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="fw-bold text-dark fs-6">{{ $school->name }}</div>
                                    <div class="progress mt-1" style="height: 5px; width: 140px;">
                                        <div class="progress-bar {{ $rank === 1 ? 'bg-warning' : ($rank === 2 ? 'bg-secondary' : ($rank === 3 ? 'bg-danger' : 'bg-success')) }}" 
                                             role="progressbar" 
                                             style="width: {{ $percentage }}%"></div>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-light text-dark border px-2 py-1">{{ $school->regu ?? 'Regu -' }}</span>
                                </td>
                                <td>
                                    @if($school->slot == 1)
                                        <span class="badge bg-primary text-white"><i class="bi bi-display me-1"></i> Slot 1 (Kiri)</span>
                                    @elseif($school->slot == 2)
                                        <span class="badge bg-success text-white"><i class="bi bi-display me-1"></i> Slot 2 (Tengah)</span>
                                    @elseif($school->slot == 3)
                                        <span class="badge bg-warning text-white"><i class="bi bi-display me-1"></i> Slot 3 (Kanan)</span>
                                    @else
                                        <span class="badge bg-secondary text-white-50">Standby</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <span class="fs-4 fw-bold {{ $rank === 1 ? 'text-warning' : ($rank === 2 ? 'text-secondary' : ($rank === 3 ? 'text-dark' : 'text-success')) }}">
                                        {{ number_format($school->score, 0, ',', '.') }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    @if($rank === 1)
                                        <span class="badge winner-badge-gold px-3 py-2 shadow-sm rounded-pill fs-7">
                                            <i class="bi bi-trophy-fill me-1"></i> JUARA 1 (EMAS)
                                        </span>
                                    @elseif($rank === 2)
                                        <span class="badge winner-badge-silver px-3 py-2 shadow-sm rounded-pill fs-7">
                                            <i class="bi bi-award-fill me-1"></i> JUARA 2 (PERAK)
                                        </span>
                                    @elseif($rank === 3)
                                        <span class="badge winner-badge-bronze px-3 py-2 shadow-sm rounded-pill fs-7">
                                            <i class="bi bi-award me-1"></i> JUARA 3 (PERUNGGU)
                                        </span>
                                    @else
                                        <span class="badge bg-light text-muted border px-3 py-2 rounded-pill">
                                            Peserta / Finalis
                                        </span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if($rank === 1)
                                        <span class="badge bg-success-subtle text-success fw-bold px-2 py-1">Pimpinan</span>
                                    @else
                                        <span class="text-danger small fw-semibold">-{{ number_format($scoreDiff, 0, ',', '.') }} Poin</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-4 text-muted">
                                    <i class="bi bi-info-circle fs-3 d-block mb-2"></i>
                                    Belum ada data sekolah yang terdaftar.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</section>
@endsection
