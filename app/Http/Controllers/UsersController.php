<?php

namespace App\Http\Controllers;

use App\DataTables\UsersDataTable;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(UsersDataTable $dataTable)
    {
        return $dataTable->render('pages.users.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|max:255|unique:users,email',
            'password' => 'required|string|min:6',
            'role' => 'required|string|in:admin,operator,juri',
        ], [
            'name.required' => 'Nama lengkap wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.unique' => 'Email ini sudah digunakan oleh akun lain.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 6 karakter.',
            'role.required' => 'Role wajib dipilih.',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
        ]);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => "Pengguna '{$user->name}' berhasil ditambahkan!",
                'user' => $user,
            ]);
        }

        Alert::success('Berhasil', "Pengguna '{$user->name}' berhasil ditambahkan!");
        return redirect()->route('dashboard.users.index');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $user)
    {
        $userModel = $user instanceof User ? $user : User::findOrFail($user);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|max:255|unique:users,email,' . $userModel->id,
            'password' => 'nullable|string|min:6',
            'role' => 'required|string|in:admin,operator,juri',
        ], [
            'name.required' => 'Nama lengkap wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.unique' => 'Email ini sudah digunakan oleh akun lain.',
            'password.min' => 'Password baru minimal 6 karakter.',
            'role.required' => 'Role wajib dipilih.',
        ]);

        $updateData = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'role' => $validated['role'],
        ];

        if ($request->filled('password')) {
            $updateData['password'] = Hash::make($request->password);
        }

        $userModel->update($updateData);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => "Data pengguna '{$userModel->name}' berhasil diperbarui.",
                'user' => $userModel,
            ]);
        }

        Alert::success('Berhasil', "Data pengguna '{$userModel->name}' berhasil diperbarui!");
        return redirect()->route('dashboard.users.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, $user)
    {
        $userModel = $user instanceof User ? $user : User::findOrFail($user);

        if ($userModel->id === auth()->id()) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Anda tidak dapat menghapus akun Anda sendiri.',
                ], 422);
            }
            Alert::error('Gagal', 'Anda tidak dapat menghapus akun Anda sendiri.');
            return back();
        }

        $userName = $userModel->name;
        $userModel->delete();

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => "Pengguna '{$userName}' berhasil dihapus.",
            ]);
        }

        Alert::success('Berhasil', "Pengguna '{$userName}' berhasil dihapus!");
        return redirect()->route('dashboard.users.index');
    }
}
