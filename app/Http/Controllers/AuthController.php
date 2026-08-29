<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class AuthController extends Controller
{
    public function login()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }

        return view('layouts.auth.login');
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'login' => 'required|string',
            'password' => 'required|string',
        ], [
            'login.required' => 'Email atau Username wajib diisi.',
            'password.required' => 'Password wajib diisi.',
        ]);

        $loginType = filter_var($request->login, FILTER_VALIDATE_EMAIL) ? 'email' : 'name';

        $attemptData = [
            $loginType => $request->login,
            'password' => $request->password,
        ];

        $remember = $request->has('remember');

        if (Auth::attempt($attemptData, $remember)) {
            $request->session()->regenerate();
            Alert::success('Berhasil Masuk', 'Selamat datang kembali, ' . Auth::user()->name . '!');
            return redirect()->intended(route('dashboard'));
        }

        Alert::error('Gagal Masuk', 'Email/Username atau password yang Anda masukkan salah.');
        return back()->withInput($request->only('login', 'remember'));
    }

    public function changePassword(Request $request)
    {
        $validated = $request->validate([
            'current_password' => 'required|string',
            'password' => 'required|string|min:6|confirmed',
        ], [
            'current_password.required' => 'Password saat ini wajib diisi.',
            'password.required' => 'Password baru wajib diisi.',
            'password.min' => 'Password baru minimal 6 karakter.',
            'password.confirmed' => 'Konfirmasi password baru tidak cocok.',
        ]);

        /** @var \App\Models\User $user */
        $user = \App\Models\User::find(Auth::id());

        if (!\Illuminate\Support\Facades\Hash::check($validated['current_password'], $user->password)) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Password saat ini yang Anda masukkan salah.',
                ], 422);
            }
            Alert::error('Gagal', 'Password saat ini yang Anda masukkan salah.');
            return back();
        }

        $user->password = \Illuminate\Support\Facades\Hash::make($validated['password']);
        $user->save();

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Password Anda berhasil diperbarui!',
            ]);
        }

        Alert::success('Berhasil', 'Password Anda berhasil diperbarui!');
        return back();
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        Alert::success('Logout Berhasil', 'Anda telah berhasil keluar dari sistem.');
        return redirect()->route('login');
    }
}
