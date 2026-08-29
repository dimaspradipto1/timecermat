<?php

namespace App\Http\Controllers;

use App\Models\GameSetting;
use App\Models\Schools;
use Illuminate\Http\Request;

class FrontController extends Controller
{
    /**
     * Display the stage / beranda screen
     */
    public function beranda()
    {
        $slot1 = Schools::where('slot', 1)->first();
        $slot2 = Schools::where('slot', 2)->first();
        $slot3 = Schools::where('slot', 3)->first();

        $timerDuration = (int) GameSetting::get('timer_duration', 15);
        $timerRemaining = (int) GameSetting::get('timer_remaining', 0);
        $timerStatus = GameSetting::get('timer_status', 'stopped');
        $timerEndTimestamp = (float) GameSetting::get('timer_end_timestamp', 0);

        return view('beranda', compact(
            'slot1',
            'slot2',
            'slot3',
            'timerDuration',
            'timerRemaining',
            'timerStatus',
            'timerEndTimestamp'
        ));
    }

    /**
     * Get real-time stage data for AJAX polling
     */
    public function getStageData()
    {
        $slot1 = Schools::where('slot', 1)->first();
        $slot2 = Schools::where('slot', 2)->first();
        $slot3 = Schools::where('slot', 3)->first();

        $timerDuration = (int) GameSetting::get('timer_duration', 15);
        $timerRemaining = (int) GameSetting::get('timer_remaining', 0);
        $timerStatus = GameSetting::get('timer_status', 'stopped');
        $timerEndTimestamp = (float) GameSetting::get('timer_end_timestamp', 0);

        // If running, calculate accurate remaining time from microtime/timestamp
        if ($timerStatus === 'running') {
            $now = microtime(true);
            if ($timerEndTimestamp > $now) {
                $timerRemaining = (int) ceil($timerEndTimestamp - $now);
            } else {
                $timerRemaining = 0;
                $timerStatus = 'stopped';
                GameSetting::set('timer_status', 'stopped');
                GameSetting::set('timer_remaining', '0');
                GameSetting::set('timer_end_timestamp', '0');
            }
        }

        return response()->json([
            'timer' => [
                'duration' => $timerDuration,
                'remaining' => $timerRemaining,
                'status' => $timerStatus,
                'end_timestamp' => $timerEndTimestamp,
            ],
            'slots' => [
                1 => [
                    'id' => $slot1?->id,
                    'name' => $slot1?->name ?? 'SEKOLAH',
                    'regu' => $slot1?->regu ?? 'Regu A',
                    'score' => $slot1?->score ?? 0,
                ],
                2 => [
                    'id' => $slot2?->id,
                    'name' => $slot2?->name ?? 'SEKOLAH',
                    'regu' => $slot2?->regu ?? 'Regu B',
                    'score' => $slot2?->score ?? 0,
                ],
                3 => [
                    'id' => $slot3?->id,
                    'name' => $slot3?->name ?? 'SEKOLAH',
                    'regu' => $slot3?->regu ?? 'Regu C',
                    'score' => $slot3?->score ?? 0,
                ],
            ],
        ]);
    }

    /**
     * Timer control endpoint
     */
    public function updateTimer(Request $request)
    {
        $action = $request->action; // start, pause, reset, set_duration
        $duration = (int) ($request->duration ?? GameSetting::get('timer_duration', 15));

        if ($action === 'start') {
            $duration = (int) GameSetting::get('timer_duration', 15);
            $remaining = (int) GameSetting::get('timer_remaining', 0);

            // If timer was reset (0) or expired, start fresh from the set duration (e.g. 15s)
            if ($remaining <= 0) {
                $remaining = $duration > 0 ? $duration : 15;
            }

            $now = microtime(true);
            $endTimestamp = $now + $remaining;

            GameSetting::set('timer_status', 'running');
            GameSetting::set('timer_remaining', (string) $remaining);
            GameSetting::set('timer_end_timestamp', (string) $endTimestamp);
        } elseif ($action === 'pause') {
            $now = microtime(true);
            $endTimestamp = (float) GameSetting::get('timer_end_timestamp', 0);
            $remaining = max(0, (int) ceil($endTimestamp - $now));

            GameSetting::set('timer_status', 'paused');
            GameSetting::set('timer_remaining', (string) $remaining);
            GameSetting::set('timer_end_timestamp', '0');
        } elseif ($action === 'reset') {
            GameSetting::set('timer_status', 'stopped');
            GameSetting::set('timer_remaining', '0');
            GameSetting::set('timer_end_timestamp', '0');
        } elseif ($action === 'set_duration') {
            GameSetting::set('timer_duration', (string) $duration);
            GameSetting::set('timer_remaining', '0');
            GameSetting::set('timer_status', 'stopped');
            GameSetting::set('timer_end_timestamp', '0');
        }

        return $this->getStageData();
    }
}
