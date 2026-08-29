<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport">

    <title>UIS Grand Academic Challenge 2026 - Layar Panggung</title>
    <meta content="Layar Panggung Cerdas Cermat UIS Grand Academic Challenge SLTA Se-Kota Batam 2026" name="description">

    <!-- Favicons -->
    <link href="{{ asset('assets/img/logouis.png') }}" rel="icon">
    <link href="{{ asset('assets/img/logouis.png') }}" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Anton&family=Bebas+Neue&family=Montserrat:wght@700;800;900&family=Poppins:wght@600;700;800&family=Oswald:wght@600;700&display=swap" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">

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
            font-family: 'Bebas Neue', 'Oswald', sans-serif;
        }

        /* FULLWIDTH & FULLHEIGHT STAGE CONTAINER */
        .stage-container {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            background-image: url("{{ asset('assets/img/background.jpeg') }}");
            background-size: 100% 100%;
            background-position: center center;
            background-repeat: no-repeat;
            overflow: hidden;
        }

        /* Top Action Bar (Auto-fade on idle) */
        .stage-controls {
            position: absolute;
            top: 15px;
            right: 20px;
            z-index: 100;
            display: flex;
            gap: 10px;
            opacity: 0.35;
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

        /* TIMER AREA - POSITIONED PRECISELY UNDER "TIME STOP" IN BACKGROUND */
        .timer-container {
            position: absolute;
            top: 48.2%;
            left: 49.8%;
            transform: translateX(-50%);
            text-align: center;
            width: 32%;
            z-index: 20;
            pointer-events: none;
        }

        .timer-digits {
            font-family: 'Bebas Neue', sans-serif;
            font-size: clamp(44px, 6.2vw, 100px);
            color: #ffffff;
            letter-spacing: 4px;
            line-height: 0.92;
            text-shadow: 0 4px 18px rgba(0, 0, 0, 0.95), 0 0 25px rgba(255, 255, 255, 0.6);
            transition: color 0.3s ease, text-shadow 0.3s ease;
        }

        .timer-digits.danger-time {
            color: #ff3b3b;
            text-shadow: 0 0 35px rgba(255, 59, 59, 0.95);
            animation: blink-timer 0.6s infinite alternate;
        }

        /* 3 DYNAMIC SCHOOL SCORE CARDS POSITIONED OVER THE 3 BACKGROUND BOXES */
        .school-slot {
            position: absolute;
            bottom: 4.6%;
            height: 31.8%;
            width: 19.4%;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            align-items: center;
            z-index: 25;
            pointer-events: none;
        }

        /* Exact horizontal alignment for 3 boxes */
        .school-slot-1 {
            left: 17.7%;
        }

        .school-slot-2 {
            left: 40.4%;
        }

        .school-slot-3 {
            left: 63.1%;
        }

        .score-container {
            flex: 1;
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
        }

        .score-number {
            font-family: 'Bebas Neue', 'Anton', sans-serif;
            font-size: clamp(52px, 8.5vw, 135px);
            color: #ffffff;
            line-height: 0.9;
            text-align: center;
            text-shadow: 0 4px 18px rgba(0,0,0,0.95);
            transition: transform 0.2s ease, color 0.2s ease;
            display: inline-block;
        }

        .score-number.score-pop {
            transform: scale(1.2);
            color: #fde047;
            text-shadow: 0 0 30px rgba(253, 224, 71, 0.95);
        }

        .school-name-box {
            width: 100%;
            height: 22.5%;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0 8px;
            text-align: center;
        }

        .school-name-text {
            font-family: 'Bebas Neue', 'Oswald', sans-serif;
            font-size: clamp(14px, 1.95vw, 32px);
            color: #000000;
            text-transform: uppercase;
            letter-spacing: 1px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            line-height: 1;
            text-align: center;
            width: 100%;
        }

        /* ANIMATIONS */
        @keyframes blink-timer {
            0% { opacity: 1; }
            100% { opacity: 0.4; }
        }

        /* Sound Enable Banner */
        #audioEnableBanner {
            position: absolute;
            bottom: 15px;
            left: 50%;
            transform: translateX(-50%);
            background: rgba(0, 0, 0, 0.85);
            border: 1px solid #10b981;
            color: #fff;
            padding: 8px 18px;
            border-radius: 30px;
            font-family: 'Poppins', sans-serif;
            font-size: 13px;
            cursor: pointer;
            z-index: 200;
            display: none;
            backdrop-filter: blur(8px);
        }
    </style>
</head>

<body>

    <div class="stage-container" id="stageScreen">

        <!-- Top Right Control Bar -->
        <div class="stage-controls">
            <button type="button" class="btn-ctrl" id="btnToggleSound" title="Buzzer Suara">
                <i class="bi bi-volume-up-fill" id="soundIcon"></i> <span id="soundText">Suara ON</span>
            </button>
            <button type="button" class="btn-ctrl" id="btnFullscreen" title="Layar Penuh">
                <i class="bi bi-fullscreen" id="fsIcon"></i> Fullscreen
            </button>
            @auth
                <a href="{{ route('dashboard.index') }}" target="_blank" class="btn-ctrl" title="Ke Dashboard Admin (Tab Baru)">
                    <i class="bi bi-speedometer2"></i> Dashboard
                </a>
            @else
                <a href="{{ route('login') }}" target="_blank" class="btn-ctrl" title="Login Admin (Tab Baru)">
                    <i class="bi bi-lock-fill"></i> Admin
                </a>
            @endauth
        </div>

        <!-- CENTER TIMER (POSITIONED DIRECTLY UNDER BACKGROUND'S "TIME STOP") -->
        <div class="timer-container">
            <div class="timer-digits {{ $timerStatus === 'running' && $timerRemaining <= 5 && $timerRemaining > 0 ? 'danger-time' : '' }}" id="timerDigits">
                {{ sprintf('%02d : %02d', floor($timerRemaining / 60), $timerRemaining % 60) }}
            </div>
        </div>

        <!-- SLOT 1 (KIRI) -->
        <div class="school-slot school-slot-1" id="stageSlot1">
            <div class="score-container">
                <div class="score-number" id="slot1Score">{{ $slot1->score ?? 0 }}</div>
            </div>
            <div class="school-name-box">
                <div class="school-name-text" id="slot1Name">{{ $slot1->name ?? 'SEKOLAH' }}</div>
            </div>
        </div>

        <!-- SLOT 2 (TENGAH) -->
        <div class="school-slot school-slot-2" id="stageSlot2">
            <div class="score-container">
                <div class="score-number" id="slot2Score">{{ $slot2->score ?? 0 }}</div>
            </div>
            <div class="school-name-box">
                <div class="school-name-text" id="slot2Name">{{ $slot2->name ?? 'SEKOLAH' }}</div>
            </div>
        </div>

        <!-- SLOT 3 (KANAN) -->
        <div class="school-slot school-slot-3" id="stageSlot3">
            <div class="score-container">
                <div class="score-number" id="slot3Score">{{ $slot3->score ?? 0 }}</div>
            </div>
            <div class="school-name-box">
                <div class="school-name-text" id="slot3Name">{{ $slot3->name ?? 'SEKOLAH' }}</div>
            </div>
        </div>

        <!-- Audio Enable helper -->
        <div id="audioEnableBanner" onclick="enableAudioContext()">
            <i class="bi bi-volume-up-fill text-warning me-1"></i> Klik di sini untuk mengaktifkan Suara Buzzer
        </div>

    </div>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <script>
        // State variables
        let soundEnabled = true;
        let audioCtx = null;
        let lastTimerStatus = "{{ $timerStatus }}";
        let lastRemaining = {{ $timerRemaining }};
        let lastScores = {
            1: {{ $slot1->score ?? 0 }},
            2: {{ $slot2->score ?? 0 }},
            3: {{ $slot3->score ?? 0 }}
        };

        // Web Audio API Synthesizer for Game Show Buzzer
        function initAudio() {
            if (!audioCtx) {
                audioCtx = new (window.AudioContext || window.webkitAudioContext)();
            }
            if (audioCtx.state === 'suspended') {
                audioCtx.resume();
            }
        }

        function playBuzzer() {
            if (!soundEnabled) return;
            try {
                initAudio();
                const now = audioCtx.currentTime;

                const osc1 = audioCtx.createOscillator();
                const osc2 = audioCtx.createOscillator();
                const gain = audioCtx.createGain();

                osc1.type = 'sawtooth';
                osc2.type = 'square';

                osc1.frequency.setValueAtTime(150, now);
                osc1.frequency.exponentialRampToValueAtTime(115, now + 1.2);

                osc2.frequency.setValueAtTime(155, now);
                osc2.frequency.exponentialRampToValueAtTime(120, now + 1.2);

                gain.gain.setValueAtTime(0.4, now);
                gain.gain.exponentialRampToValueAtTime(0.01, now + 1.2);

                osc1.connect(gain);
                osc2.connect(gain);
                gain.connect(audioCtx.destination);

                osc1.start(now);
                osc2.start(now);
                osc1.stop(now + 1.2);
                osc2.stop(now + 1.2);
            } catch (e) {
                console.log('Audio buzzer error:', e);
            }
        }

        function playBeep(freq = 440, duration = 0.15) {
            if (!soundEnabled) return;
            try {
                initAudio();
                const now = audioCtx.currentTime;
                const osc = audioCtx.createOscillator();
                const gain = audioCtx.createGain();

                osc.type = 'sine';
                osc.frequency.setValueAtTime(freq, now);

                gain.gain.setValueAtTime(0.2, now);
                gain.gain.exponentialRampToValueAtTime(0.01, now + duration);

                osc.connect(gain);
                gain.connect(audioCtx.destination);

                osc.start(now);
                osc.stop(now + duration);
            } catch (e) {}
        }

        function formatTime(seconds) {
            let m = Math.floor(seconds / 60);
            let s = Math.max(0, seconds % 60);
            return (m < 10 ? '0' + m : m) + ' : ' + (s < 10 ? '0' + s : s);
        }

        function updateStageUI(data) {
            let timer = data.timer;
            let currentSec = timer.remaining;
            let status = timer.status;

            // Timer display
            let digitsElem = $('#timerDigits');
            digitsElem.text(formatTime(currentSec));

            if (status === 'running') {
                if (currentSec <= 5 && currentSec > 0) {
                    digitsElem.addClass('danger-time');
                } else {
                    digitsElem.removeClass('danger-time');
                }

                if (lastTimerStatus !== 'running') {
                    playBeep(600, 0.2);
                }
            } else {
                digitsElem.removeClass('danger-time');
                if (currentSec <= 0 && lastRemaining > 0 && lastTimerStatus === 'running') {
                    playBuzzer();
                }
            }

            lastTimerStatus = status;
            lastRemaining = currentSec;

            // Dynamic Update School Slots (Scores & Names)
            if (data.slots) {
                for (let i = 1; i <= 3; i++) {
                    let slotData = data.slots[i];
                    let scoreElem = $('#slot' + i + 'Score');
                    let nameElem = $('#slot' + i + 'Name');

                    nameElem.text(slotData.name || 'SEKOLAH');

                    // Animate if score changed
                    if (lastScores[i] !== slotData.score) {
                        scoreElem.text(slotData.score);
                        scoreElem.addClass('score-pop');
                        playBeep(520, 0.1);
                        setTimeout(function() {
                            scoreElem.removeClass('score-pop');
                        }, 400);
                        lastScores[i] = slotData.score;
                    } else {
                        scoreElem.text(slotData.score);
                    }
                }
            }
        }

        // Realtime Polling Loop
        function pollStageData() {
            $.ajax({
                url: "{{ route('stage.data') }}",
                type: "GET",
                dataType: "json",
                success: function(data) {
                    updateStageUI(data);
                },
                error: function(err) {
                    console.log('Stage sync polling err:', err);
                }
            });
        }

        $(document).ready(function() {
            // High frequency polling (400ms) for instant real-time synchronization
            setInterval(pollStageData, 400);

            // Fullscreen toggle
            $('#btnFullscreen').click(function() {
                if (!document.fullscreenElement) {
                    document.documentElement.requestFullscreen().catch(err => {
                        console.log(`Error attempting fullscreen: ${err.message}`);
                    });
                    $('#fsIcon').removeClass('bi-fullscreen').addClass('bi-fullscreen-exit');
                } else {
                    document.exitFullscreen();
                    $('#fsIcon').removeClass('bi-fullscreen-exit').addClass('bi-fullscreen');
                }
            });

            // Toggle sound button
            $('#btnToggleSound').click(function() {
                soundEnabled = !soundEnabled;
                if (soundEnabled) {
                    initAudio();
                    $('#soundIcon').removeClass('bi-volume-mute-fill text-danger').addClass('bi-volume-up-fill');
                    $('#soundText').text('Suara ON');
                    playBeep(500, 0.1);
                } else {
                    $('#soundIcon').removeClass('bi-volume-up-fill').addClass('bi-volume-mute-fill text-danger');
                    $('#soundText').text('Suara OFF');
                }
            });

            // Enable audio context on any user click
            $(document).one('click', function() {
                initAudio();
            });
        });

        function enableAudioContext() {
            initAudio();
            $('#audioEnableBanner').fadeOut();
            playBeep(440, 0.1);
        }
    </script>
</body>

</html>
