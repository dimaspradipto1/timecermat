<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>PENGUMUMAN JUARA 1, 2 & 3 - UIS Grand Academic Challenge {{ date('Y') }}</title>

    <!-- Favicons -->
    <link href="{{ asset('assets/img/logouis.png') }}" rel="icon">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Anton&family=Bebas+Neue&family=Montserrat:wght@700;800;900&family=Poppins:wght@400;600;700;800&family=Oswald:wght@600;700&display=swap" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- Canvas Confetti -->
    <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.browser.min.js"></script>

    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            user-select: none;
        }

        html, body {
            width: 100vw;
            height: 100vh;
            overflow: hidden;
            background-color: #022016;
            font-family: 'Poppins', sans-serif;
            color: #ffffff;
        }

        .stage-bg {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            background-image: radial-gradient(circle at center, #065f46 0%, #064e3b 40%, #022016 100%);
            background-size: cover;
            background-position: center;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 2.5vh 3vw 3vh;
        }

        /* Top Action Bar (Auto-fade on idle) */
        .stage-controls {
            position: absolute;
            top: 15px;
            right: 20px;
            z-index: 100;
            display: flex;
            gap: 10px;
            opacity: 0.4;
            transition: opacity 0.3s ease;
        }

        .stage-controls:hover {
            opacity: 1;
        }

        .btn-ctrl {
            background: rgba(0, 0, 0, 0.7);
            border: 1px solid rgba(255, 255, 255, 0.3);
            color: #fff;
            padding: 8px 14px;
            border-radius: 8px;
            cursor: pointer;
            font-family: 'Poppins', sans-serif;
            font-size: 13px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 6px;
            text-decoration: none;
            backdrop-filter: blur(5px);
            transition: all 0.2s ease;
        }

        .btn-ctrl:hover {
            background: #059669;
            border-color: #10b981;
            color: #fff;
            transform: scale(1.05);
        }

        /* HEADER AREA */
        .stage-header {
            text-align: center;
            position: relative;
            z-index: 10;
        }

        .event-badge {
            display: inline-block;
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
            color: #fff;
            padding: 4px 18px;
            border-radius: 30px;
            font-weight: 700;
            font-size: clamp(12px, 1.2vw, 16px);
            letter-spacing: 2px;
            text-transform: uppercase;
            box-shadow: 0 4px 15px rgba(245, 158, 11, 0.4);
            margin-bottom: 8px;
        }

        .stage-title {
            font-family: 'Montserrat', sans-serif;
            font-size: clamp(24px, 3.2vw, 48px);
            font-weight: 900;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: #fff;
            text-shadow: 0 4px 20px rgba(0, 0, 0, 0.8), 0 0 30px rgba(16, 185, 129, 0.5);
            line-height: 1.1;
        }

        /* PODIUM STAGE AREA */
        .podium-stage-wrapper {
            flex: 1;
            display: flex;
            align-items: flex-end;
            justify-content: center;
            gap: clamp(15px, 2.5vw, 40px);
            padding-bottom: 2vh;
            position: relative;
            z-index: 10;
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
        }

        .podium-column {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            position: relative;
            animation: slide-up 1s cubic-bezier(0.175, 0.885, 0.32, 1.275) forwards;
        }

        .podium-avatar {
            width: clamp(70px, 8vw, 110px);
            height: clamp(70px, 8vw, 110px);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: clamp(34px, 4vw, 55px);
            margin-bottom: 12px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.5);
        }

        .podium-card-body {
            width: 100%;
            background: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(12px);
            border: 2px solid rgba(255, 255, 255, 0.2);
            border-radius: 20px 20px 0 0;
            padding: clamp(15px, 2vh, 25px) 15px;
            text-align: center;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .school-title {
            font-family: 'Montserrat', sans-serif;
            font-weight: 800;
            font-size: clamp(16px, 1.8vw, 26px);
            line-height: 1.2;
            text-transform: uppercase;
            color: #ffffff;
            margin: 6px 0 4px;
            min-height: clamp(38px, 4.5vh, 65px);
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
        }

        .regu-pill {
            font-size: clamp(11px, 1vw, 14px);
            font-weight: 700;
            padding: 3px 12px;
            border-radius: 20px;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 8px;
        }

        .score-box {
            font-family: 'Bebas Neue', 'Montserrat', sans-serif;
            font-size: clamp(42px, 5.5vw, 75px);
            line-height: 0.9;
            font-weight: 900;
            letter-spacing: 2px;
            text-shadow: 0 4px 15px rgba(0,0,0,0.7);
        }

        .score-lbl {
            font-size: clamp(10px, 0.9vw, 13px);
            color: rgba(255, 255, 255, 0.7);
            letter-spacing: 2px;
            font-weight: 600;
        }

        /* 1st Place Champion (Center) */
        .podium-pos-1 {
            order: 2;
            z-index: 5;
        }
        .podium-pos-1 .podium-pillar {
            height: clamp(120px, 20vh, 200px);
            background: linear-gradient(180deg, #f59e0b 0%, #b45309 100%);
            box-shadow: 0 0 35px rgba(245, 158, 11, 0.6);
        }
        .podium-pos-1 .podium-avatar {
            background: linear-gradient(135deg, #fef08a 0%, #eab308 50%, #ca8a04 100%);
            color: #78350f;
            border: 4px solid #fef08a;
            box-shadow: 0 0 35px rgba(234, 179, 8, 0.8);
            animation: float-trophy 2.5s ease-in-out infinite;
        }
        .podium-pos-1 .podium-card-body {
            background: rgba(234, 179, 8, 0.25);
            border-color: rgba(253, 224, 71, 0.6);
            box-shadow: 0 -10px 30px rgba(234, 179, 8, 0.3);
        }
        .podium-pos-1 .score-box {
            color: #fef08a;
            text-shadow: 0 0 25px rgba(254, 240, 138, 0.8);
        }

        /* 2nd Place (Left) */
        .podium-pos-2 {
            order: 1;
            z-index: 3;
        }
        .podium-pos-2 .podium-pillar {
            height: clamp(80px, 14vh, 140px);
            background: linear-gradient(180deg, #94a3b8 0%, #475569 100%);
            box-shadow: 0 0 20px rgba(148, 163, 184, 0.4);
        }
        .podium-pos-2 .podium-avatar {
            background: linear-gradient(135deg, #f8fafc 0%, #cbd5e1 50%, #94a3b8 100%);
            color: #1e293b;
            border: 3px solid #f8fafc;
            box-shadow: 0 0 20px rgba(203, 213, 225, 0.6);
        }
        .podium-pos-2 .podium-card-body {
            background: rgba(148, 163, 184, 0.2);
            border-color: rgba(203, 213, 225, 0.4);
        }
        .podium-pos-2 .score-box {
            color: #f1f5f9;
        }

        /* 3rd Place (Right) */
        .podium-pos-3 {
            order: 3;
            z-index: 2;
        }
        .podium-pos-3 .podium-pillar {
            height: clamp(55px, 10vh, 100px);
            background: linear-gradient(180deg, #d97706 0%, #78350f 100%);
            box-shadow: 0 0 20px rgba(217, 119, 6, 0.3);
        }
        .podium-pos-3 .podium-avatar {
            background: linear-gradient(135deg, #fed7aa 0%, #f97316 50%, #c2410c 100%);
            color: #451a03;
            border: 3px solid #ffedd5;
            box-shadow: 0 0 20px rgba(249, 115, 22, 0.5);
        }
        .podium-pos-3 .podium-card-body {
            background: rgba(217, 119, 6, 0.2);
            border-color: rgba(254, 215, 170, 0.4);
        }
        .podium-pos-3 .score-box {
            color: #fed7aa;
        }

        .podium-pillar {
            width: 100%;
            border-radius: 0 0 16px 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Montserrat', sans-serif;
            font-size: clamp(28px, 3.5vw, 48px);
            font-weight: 900;
            color: #fff;
            text-shadow: 0 3px 8px rgba(0,0,0,0.5);
        }

        @keyframes float-trophy {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }

        @keyframes slide-up {
            from { opacity: 0; transform: translateY(40px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>

<body>

    <div class="stage-bg">

        <!-- Top Right Control Bar -->
        <div class="stage-controls">
            <button type="button" class="btn-ctrl" id="btnConfetti" title="Ledakkan Confetti">
                <i class="bi bi-stars text-warning"></i> Confetti
            </button>
            <button type="button" class="btn-ctrl" id="btnFullscreen" title="Layar Penuh">
                <i class="bi bi-fullscreen"></i> Fullscreen
            </button>
            <a href="{{ route('dashboard.rekapitulasi.index') }}" class="btn-ctrl" title="Kembali ke Dashboard">
                <i class="bi bi-speedometer2"></i> Dashboard
            </a>
            <a href="{{ route('beranda') }}" class="btn-ctrl" title="Layar Panggung Utama">
                <i class="bi bi-display"></i> Layar Utama
            </a>
        </div>

        <!-- Stage Header -->
        <div class="stage-header">
            <div class="event-badge">
                <i class="bi bi-trophy-fill me-1"></i> PENGUMUMAN HASIL AKHIR JUARA 1, 2 & 3
            </div>
            <h1 class="stage-title">UIS GRAND ACADEMIC CHALLENGE {{ date('Y') }}</h1>
        </div>

        <!-- Podium Stage -->
        <div class="podium-stage-wrapper">
            
            <!-- Juara 2 (Perak) -->
            <div class="podium-column podium-pos-2">
                <div class="podium-avatar">
                    <i class="bi bi-award-fill"></i>
                </div>
                <div class="podium-card-body">
                    <span class="regu-pill bg-secondary text-white">JUARA II (PERAK)</span>
                    <div class="school-title">{{ $juara2->name ?? 'Belum Ada' }}</div>
                    <span class="badge bg-light text-dark mb-2">{{ $juara2->regu ?? 'Regu' }}</span>
                    <div class="score-box">{{ $juara2 ? number_format($juara2->score, 0, ',', '.') : 0 }}</div>
                    <div class="score-lbl">TOTAL POIN</div>
                </div>
                <div class="podium-pillar">2</div>
            </div>

            <!-- Juara 1 (Emas / Champion) -->
            <div class="podium-column podium-pos-1">
                <div class="podium-avatar">
                    <i class="bi bi-trophy-fill"></i>
                </div>
                <div class="podium-card-body">
                    <span class="regu-pill bg-warning text-dark font-weight-bold">
                        <i class="bi bi-crown-fill me-1"></i> JUARA I (CHAMPION)
                    </span>
                    <div class="school-title">{{ $juara1->name ?? 'Belum Ada' }}</div>
                    <span class="badge bg-warning text-dark mb-2 fw-bold">{{ $juara1->regu ?? 'Regu' }}</span>
                    <div class="score-box">{{ $juara1 ? number_format($juara1->score, 0, ',', '.') : 0 }}</div>
                    <div class="score-lbl text-warning">TOTAL POIN</div>
                </div>
                <div class="podium-pillar">
                    <i class="bi bi-crown-fill text-warning fs-3 me-2"></i> 1
                </div>
            </div>

            <!-- Juara 3 (Perunggu) -->
            <div class="podium-column podium-pos-3">
                <div class="podium-avatar">
                    <i class="bi bi-award"></i>
                </div>
                <div class="podium-card-body">
                    <span class="regu-pill bg-danger text-white">JUARA III (PERUNGGU)</span>
                    <div class="school-title">{{ $juara3->name ?? 'Belum Ada' }}</div>
                    <span class="badge bg-light text-dark mb-2">{{ $juara3->regu ?? 'Regu' }}</span>
                    <div class="score-box">{{ $juara3 ? number_format($juara3->score, 0, ',', '.') : 0 }}</div>
                    <div class="score-lbl">TOTAL POIN</div>
                </div>
                <div class="podium-pillar">3</div>
            </div>

        </div>

    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script>
        function launchCelebrationConfetti() {
            var duration = 4 * 1000;
            var animationEnd = Date.now() + duration;
            var defaults = { startVelocity: 30, spread: 360, ticks: 60, zIndex: 1000 };

            function randomInRange(min, max) {
                return Math.random() * (max - min) + min;
            }

            var interval = setInterval(function() {
                var timeLeft = animationEnd - Date.now();

                if (timeLeft <= 0) {
                    return clearInterval(interval);
                }

                var particleCount = 50 * (timeLeft / duration);
                confetti(Object.assign({}, defaults, { particleCount, origin: { x: randomInRange(0.1, 0.3), y: Math.random() - 0.2 } }));
                confetti(Object.assign({}, defaults, { particleCount, origin: { x: randomInRange(0.7, 0.9), y: Math.random() - 0.2 } }));
            }, 250);
        }

        $(document).ready(function() {
            // Auto fire confetti on page open
            setTimeout(function() {
                launchCelebrationConfetti();
            }, 800);

            $('#btnConfetti').click(function() {
                launchCelebrationConfetti();
            });

            // Fullscreen Toggle
            $('#btnFullscreen').click(function() {
                if (!document.fullscreenElement) {
                    document.documentElement.requestFullscreen().catch(err => {
                        console.log('Error entering fullscreen:', err);
                    });
                } else {
                    document.exitFullscreen();
                }
            });
        });
    </script>
</body>
</html>
