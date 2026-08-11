<?php

namespace App\Http\Controllers\Api; 

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // 1. FUNGSI LOGIN API
    public function login(Request $request)
    {
        // Validasi input data dari aplikasi mobile
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Cari user berdasarkan email
        $user = User::where('email', $request->email)->first();

        // Periksa apakah user ditemukan dan password-nya cocok
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Email atau password salah.'
            ], 401); // BERHASIL DIPERBAIKI: Menggunakan 401 dan ditutup kurung biasa )
        }

        $user->update([
            'last_login' => now(),
        ]);

        // BUAT TOKEN AKSES SANCTUM
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'Login berhasil!',
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->role,          // Terkirim ke mobile
                'nama_kelas' => $user->nama_kelas,  // Kunci utama filter jadwal otomatis di HP siswa!
            ]
        ], 200);
    }

    // 2. FUNGSI LOGOUT API
    public function logout(Request $request)
    {
        // Hapus token yang sedang digunakan saat ini dari database
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'success' => true,
            'message' => 'Logout berhasil, token telah dihapus.'
        ], 200);
    }
}