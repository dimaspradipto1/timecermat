<?php

namespace App\Http\Controllers;

use App\DataTables\SchoolsDataTable;
use App\Models\Schools;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class SchoolsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(SchoolsDataTable $dataTable)
    {
        return $dataTable->render('pages.schools.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.schools.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'regu' => 'nullable|string|max:50',
            'score' => 'nullable|numeric',
            'slot' => 'nullable|integer|in:1,2,3',
            'is_active' => 'nullable|boolean',
        ], [
            'name.required' => 'Nama Sekolah wajib diisi.',
            'slot.in' => 'Pilihan slot panggung harus 1, 2, atau 3.',
        ]);

        $score = $request->filled('score') ? (int) $request->score : 0;
        $slot = $request->filled('slot') ? (int) $request->slot : null;

        // If a slot is chosen, clear it from any existing school
        if ($slot) {
            Schools::where('slot', $slot)->update(['slot' => null]);
        }

        $newSchool = Schools::create([
            'name' => $validated['name'],
            'regu' => $validated['regu'] ?? null,
            'score' => $score,
            'slot' => $slot,
            'is_active' => $request->has('is_active') ? true : true,
        ]);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Data sekolah baru berhasil ditambahkan!',
                'school' => $newSchool,
            ]);
        }

        Alert::success('Berhasil', 'Data sekolah baru berhasil disimpan!');
        return redirect()->route('dashboard.schools.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Schools $school)
    {
        return response()->json($school);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Schools $school)
    {
        return response()->json($school);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Schools $school)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'regu' => 'nullable|string|max:50',
            'score' => 'required|numeric',
            'slot' => 'nullable|integer|in:1,2,3',
        ], [
            'name.required' => 'Nama Sekolah wajib diisi.',
            'score.required' => 'Skor wajib diisi.',
            'slot.in' => 'Pilihan slot panggung harus 1, 2, atau 3.',
        ]);

        $slot = $request->filled('slot') && $request->slot !== '' ? (int) $request->slot : null;

        // If slot is being assigned, unset from other school
        if ($slot) {
            Schools::where('slot', $slot)->where('id', '!=', $school->id)->update(['slot' => null]);
        }

        $school->update([
            'name' => $validated['name'],
            'regu' => $validated['regu'] ?? null,
            'score' => (int) $validated['score'],
            'slot' => $slot,
        ]);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Data sekolah berhasil diperbarui.',
                'school' => $school,
            ]);
        }

        Alert::success('Berhasil', 'Data sekolah berhasil diperbarui!');
        return redirect()->route('dashboard.schools.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, $school)
    {
        $schoolModel = $school instanceof Schools ? $school : Schools::findOrFail($school);
        $schoolName = $schoolModel->name;
        $schoolModel->delete();

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => "Sekolah '{$schoolName}' berhasil dihapus.",
            ]);
        }

        Alert::success('Berhasil', "Data sekolah '{$schoolName}' berhasil dihapus!");
        return redirect()->route('dashboard.schools.index');
    }

    /**
     * Quick adjust score (+10, -5, +100, reset, or custom)
     */
    public function adjustScore(Request $request, $school)
    {
        $schoolModel = $school instanceof Schools ? $school : Schools::findOrFail($school);

        $request->validate([
            'action' => 'required|string|in:add,subtract,set,reset',
            'amount' => 'nullable|numeric',
        ]);

        $action = $request->action;
        $amount = (int) ($request->amount ?? 0);

        if ($action === 'add') {
            $schoolModel->score += $amount;
        } elseif ($action === 'subtract') {
            $schoolModel->score = max(0, $schoolModel->score - $amount);
        } elseif ($action === 'set') {
            $schoolModel->score = $amount;
        } elseif ($action === 'reset') {
            $schoolModel->score = 0;
        }

        $schoolModel->save();

        return response()->json([
            'success' => true,
            'message' => "Skor {$schoolModel->name} kini {$schoolModel->score}.",
            'score' => $schoolModel->score,
            'school' => $schoolModel,
        ]);
    }

    /**
     * Set stage slot (1, 2, 3 or null)
     */
    public function setSlot(Request $request, $school)
    {
        $schoolModel = $school instanceof Schools ? $school : Schools::findOrFail($school);
        $slot = $request->slot ? (int) $request->slot : null;

        if ($slot && in_array($slot, [1, 2, 3])) {
            Schools::where('slot', $slot)->where('id', '!=', $schoolModel->id)->update(['slot' => null]);
            $schoolModel->slot = $slot;
        } else {
            $schoolModel->slot = null;
        }

        $schoolModel->save();

        return response()->json([
            'success' => true,
            'message' => $slot ? "Sekolah {$schoolModel->name} diset ke Slot {$slot} panggung." : "Sekolah {$schoolModel->name} dilepas dari slot panggung.",
            'slot' => $schoolModel->slot,
            'school' => $schoolModel,
        ]);
    }
}
