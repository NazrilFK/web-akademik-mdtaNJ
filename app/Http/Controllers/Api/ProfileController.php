<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    /**
     * ==========================================
     * GET PROFILE
     * ==========================================
     */
    public function index(Request $request)
    {
        $user = $request->user();

        return response()->json([
            'success' => true,
            'message' => 'Data profil berhasil diambil.',
            'data' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->role,
                'nama_kelas' => $user->nama_kelas,
                'no_hp' => $user->no_hp,
                'status' => $user->status,
                'last_login' => optional($user->last_login)?->format('d-m-Y H:i'),
            ]
        ]);
    }

    /**
     * ==========================================
     * UPDATE PROFILE
     * ==========================================
     */
    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'no_hp' => 'nullable|string|max:20',
        ]);

        $user = $request->user();

        $user->update([
            'name' => $request->name,
            'no_hp' => $request->no_hp,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Profil berhasil diperbarui.',
            'data' => $user,
        ]);
    }

    /**
     * ==========================================
     * CHANGE PASSWORD
     * ==========================================
     */
    public function changePassword(Request $request)
    {
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|min:6|confirmed',
        ]);

        $user = $request->user();

        if (! Hash::check($request->old_password, $user->password)) {

            return response()->json([
                'success' => false,
                'message' => 'Password lama tidak sesuai.',
            ], 422);

        }

        $user->update([
            'password' => Hash::make($request->new_password),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Password berhasil diubah.',
        ]);
    }
}