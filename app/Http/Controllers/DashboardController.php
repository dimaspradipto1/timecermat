<?php

namespace App\Http\Controllers;

use App\Models\GameSetting;
use App\Models\Schools;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalSchools = Schools::count();
        $slot1 = Schools::where('slot', 1)->first();
        $slot2 = Schools::where('slot', 2)->first();
        $slot3 = Schools::where('slot', 3)->first();

        $allSchools = Schools::orderBy('name', 'asc')->get();

        $timerDuration = (int) GameSetting::get('timer_duration', 15);
        $timerRemaining = (int) GameSetting::get('timer_remaining', 15);
        $timerStatus = GameSetting::get('timer_status', 'stopped');

        return view('pages.dashboard.index', compact(
            'totalSchools',
            'slot1',
            'slot2',
            'slot3',
            'allSchools',
            'timerDuration',
            'timerRemaining',
            'timerStatus'
        ));
    }
}
