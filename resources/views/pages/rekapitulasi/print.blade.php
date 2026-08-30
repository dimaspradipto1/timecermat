<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }} - UIS Grand Academic Challenge 2026</title>
    
    <!-- Favicon -->
    <link href="{{ asset('assets/img/logouis.png') }}" rel="icon">

    <!-- Bootstrap 5 CSS -->
    <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #1e293b;
            background: #fff;
            padding: 30px;
        }

        .header-print {
            border-bottom: 3px double #064e3b;
            padding-bottom: 15px;
            margin-bottom: 25px;
        }

        .podium-box {
            border: 2px solid #064e3b;
            border-radius: 10px;
            padding: 15px;
            text-align: center;
        }

        .podium-gold {
            background-color: #fef9c3;
            border-color: #f59e0b;
        }

        .podium-silver {
            background-color: #f1f5f9;
            border-color: #94a3b8;
        }

        .podium-bronze {
            background-color: #ffedd5;
            border-color: #ea580c;
        }

        @media print {
            .no-print {
                display: none !important;
            }
            body {
                padding: 0;
            }
            @page {
                size: A4 portrait;
                margin: 1.5cm;
            }
        }
    </style>
</head>
<body>

    <!-- Action Bar (Hidden when printing) -->
    <div class="no-print d-flex justify-content-between align-items-center mb-4 p-3 bg-light rounded border">
        <div>
            <a href="{{ route('dashboard.rekapitulasi.index') }}" class="btn btn-outline-secondary btn-sm">
                <i class="bi bi-arrow-left me-1"></i> Kembali ke Dashboard
            </a>
            <span class="ms-3 fw-semibold text-muted">Preview Lembar Rekapitulasi Resmi</span>
        </div>
        <div class="d-flex gap-2">
            <button onclick="window.print()" class="btn btn-success fw-bold">
                <i class="bi bi-printer-fill me-1"></i> Cetak / Simpan PDF
            </button>
        </div>
    </div>

    <!-- Official Header -->
    <div class="header-print">
        <div class="d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center gap-3">
                <img src="{{ asset('assets/img/logouis.png') }}" alt="Logo UIS" style="height: 75px;">
                <div>
                    <h5 class="fw-bold text-success mb-0 text-uppercase">UNIVERSITAS IBNU SINA (UIS) BATAM</h5>
                    <h4 class="fw-bold mb-0">UIS GRAND ACADEMIC CHALLENGE {{ date('Y') }}</h4>
                    <p class="text-muted small mb-0">Kompetisi Cerdas Cermat Tingkat SLTA / SMA / SMK / MA Se-Kota Batam</p>
                </div>
            </div>
            <div class="text-end">
                <span class="badge bg-success fs-6 px-3 py-2">HASIL AKHIR RESMI</span>
                <div class="small text-muted mt-1">Tanggal: {{ date('d F Y') }}</div>
            </div>
        </div>
    </div>

    <!-- Title -->
    <div class="text-center my-4">
        <h4 class="fw-bold text-uppercase text-decoration-underline">{{ $title }}</h4>
        <p class="text-muted small">Berdasarkan hasil akumulasi perolehan poin dari seluruh babak kompetisi.</p>
    </div>

    <!-- Top 3 Winners Summary Boxes -->
    <div class="row g-3 mb-4">
        <!-- Juara 1 -->
        <div class="col-4">
            <div class="podium-box podium-gold">
                <div class="fw-bold text-warning-emphasis fs-6">🥇 JUARA I (EMAS)</div>
                <h5 class="fw-bold text-dark my-2">{{ $juara1->name ?? '-' }}</h5>
                <div class="badge bg-warning text-dark mb-2">{{ $juara1->regu ?? 'Regu A' }}</div>
                <div class="fs-4 fw-bold text-success">{{ $juara1 ? number_format($juara1->score, 0, ',', '.') : 0 }} Poin</div>
            </div>
        </div>

        <!-- Juara 2 -->
        <div class="col-4">
            <div class="podium-box podium-silver">
                <div class="fw-bold text-secondary fs-6">🥈 JUARA II (PERAK)</div>
                <h5 class="fw-bold text-dark my-2">{{ $juara2->name ?? '-' }}</h5>
                <div class="badge bg-secondary mb-2">{{ $juara2->regu ?? 'Regu B' }}</div>
                <div class="fs-4 fw-bold text-dark">{{ $juara2 ? number_format($juara2->score, 0, ',', '.') : 0 }} Poin</div>
            </div>
        </div>

        <!-- Juara 3 -->
        <div class="col-4">
            <div class="podium-box podium-bronze">
                <div class="fw-bold text-danger fs-6">🥉 JUARA III (PERUNGGU)</div>
                <h5 class="fw-bold text-dark my-2">{{ $juara3->name ?? '-' }}</h5>
                <div class="badge bg-danger mb-2">{{ $juara3->regu ?? 'Regu C' }}</div>
                <div class="fs-4 fw-bold text-dark">{{ $juara3 ? number_format($juara3->score, 0, ',', '.') : 0 }} Poin</div>
            </div>
        </div>
    </div>

    <!-- Complete Table -->
    <table class="table table-bordered align-middle my-4">
        <thead class="table-dark text-center">
            <tr>
                <th style="width: 8%;">Peringkat</th>
                <th style="width: 45%;">Nama Sekolah Peserta</th>
                <th style="width: 15%;">Regu / Tim</th>
                <th style="width: 15%;">Total Skor</th>
                <th style="width: 17%;">Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($rankedSchools as $idx => $s)
                @php $r = $idx + 1; @endphp
                <tr class="{{ $r <= 3 ? 'fw-bold' : '' }}">
                    <td class="text-center">{{ $r }}</td>
                    <td>{{ $s->name }}</td>
                    <td class="text-center">{{ $s->regu ?? '-' }}</td>
                    <td class="text-center fs-5 text-success">{{ number_format($s->score, 0, ',', '.') }}</td>
                    <td class="text-center">
                        @if($r === 1)
                            <span class="text-warning fw-bold">JUARA I</span>
                        @elseif($r === 2)
                            <span class="text-secondary fw-bold">JUARA II</span>
                        @elseif($r === 3)
                            <span class="text-danger fw-bold">JUARA III</span>
                        @else
                            <span class="text-muted">Finalis</span>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Signatures -->
    <div class="row mt-5 pt-4">
        <div class="col-6 text-center">
            <p class="mb-1">Mengetahui,</p>
            <p class="fw-bold">Ketua Panitia UIS Challenge {{ date('Y') }}</p>
            <div style="height: 70px;"></div>
            <p class="fw-bold text-decoration-underline mb-0">( .................................................... )</p>
        </div>
        <div class="col-6 text-center">
            <p class="mb-1">Batam, {{ date('d F Y') }}</p>
            <p class="fw-bold">Koordinator Dewan Juri</p>
            <div style="height: 70px;"></div>
            <p class="fw-bold text-decoration-underline mb-0">( .................................................... )</p>
        </div>
    </div>

</body>
</html>
