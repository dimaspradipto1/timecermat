<?php

namespace App\Http\Controllers;

use App\Models\Schools;
use Illuminate\Http\Request;

class RekapitulasiController extends Controller
{
    /**
     * Display the winners recapitulation dashboard
     */
    public function index()
    {
        // All schools ranked by score descending
        $allRankedSchools = Schools::orderBy('score', 'desc')->orderBy('name', 'asc')->get();

        // Top 3 Overall
        $juara1 = $allRankedSchools->get(0);
        $juara2 = $allRankedSchools->get(1);
        $juara3 = $allRankedSchools->get(2);

        // Stage Slot Schools (Slot 1, 2, 3) ranked by score
        $stageSchools = Schools::whereNotNull('slot')
            ->whereIn('slot', [1, 2, 3])
            ->orderBy('score', 'desc')
            ->get();

        $stageJuara1 = $stageSchools->get(0);
        $stageJuara2 = $stageSchools->get(1);
        $stageJuara3 = $stageSchools->get(2);

        // Summary Stats
        $totalSchools = $allRankedSchools->count();
        $highestScore = $allRankedSchools->max('score') ?? 0;
        $averageScore = $totalSchools > 0 ? round($allRankedSchools->avg('score'), 1) : 0;
        $totalScoresAll = $allRankedSchools->sum('score');

        return view('pages.rekapitulasi.index', compact(
            'allRankedSchools',
            'juara1',
            'juara2',
            'juara3',
            'stageSchools',
            'stageJuara1',
            'stageJuara2',
            'stageJuara3',
            'totalSchools',
            'highestScore',
            'averageScore',
            'totalScoresAll'
        ));
    }

    /**
     * Printable recap sheet for official reporting
     */
    public function print(Request $request)
    {
        $mode = $request->query('mode', 'all'); // 'all' or 'stage'

        if ($mode === 'stage') {
            $rankedSchools = Schools::whereNotNull('slot')
                ->whereIn('slot', [1, 2, 3])
                ->orderBy('score', 'desc')
                ->get();
            $title = 'Rekapitulasi Juara Tim Panggung (Slot 1 - 3)';
        } else {
            $rankedSchools = Schools::orderBy('score', 'desc')->orderBy('name', 'asc')->get();
            $title = 'Rekapitulasi Peringkat & Juara Umum';
        }

        $juara1 = $rankedSchools->get(0);
        $juara2 = $rankedSchools->get(1);
        $juara3 = $rankedSchools->get(2);

        return view('pages.rekapitulasi.print', compact(
            'rankedSchools',
            'juara1',
            'juara2',
            'juara3',
            'title',
            'mode'
        ));
    }

    /**
     * Fullscreen celebration stage display for announcing winners
     */
    public function stageView(Request $request)
    {
        $mode = $request->query('mode', 'stage'); // 'stage' or 'all'

        if ($mode === 'all') {
            $rankedSchools = Schools::orderBy('score', 'desc')->orderBy('name', 'asc')->get();
        } else {
            $rankedSchools = Schools::whereNotNull('slot')
                ->whereIn('slot', [1, 2, 3])
                ->orderBy('score', 'desc')
                ->get();
        }

        $juara1 = $rankedSchools->get(0);
        $juara2 = $rankedSchools->get(1);
        $juara3 = $rankedSchools->get(2);

        return view('pages.rekapitulasi.stage', compact(
            'rankedSchools',
            'juara1',
            'juara2',
            'juara3',
            'mode'
        ));
    }

    /**
     * API for real-time recapitulation data polling
     */
    public function getDataApi()
    {
        $allRankedSchools = Schools::orderBy('score', 'desc')->orderBy('name', 'asc')->get();
        $stageSchools = Schools::whereNotNull('slot')
            ->whereIn('slot', [1, 2, 3])
            ->orderBy('score', 'desc')
            ->get();

        return response()->json([
            'all' => $allRankedSchools,
            'stage' => $stageSchools,
            'juara1' => $allRankedSchools->get(0),
            'juara2' => $allRankedSchools->get(1),
            'juara3' => $allRankedSchools->get(2),
            'stageJuara1' => $stageSchools->get(0),
            'stageJuara2' => $stageSchools->get(1),
            'stageJuara3' => $stageSchools->get(2),
        ]);
    }
}
