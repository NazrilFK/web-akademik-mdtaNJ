<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Kelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class RegisterController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],

            'email' => [
                'required',
                'email',
                'unique:users,email'
            ],

            'password' => [
                'required',
                'confirmed',
                Rules\Password::defaults(),
            ],

            'nama_kelas' => [
                'required',
                'exists:kelas,nama_kelas'
            ],

            'no_hp' => [
                'required',
                'string',
                'max:20'
            ],
        ]);

        $user = User::create([
            'name' => $request->name,

            'email' => $request->email,

            'password' => Hash::make($request->password),

            'nama_kelas' => $request->nama_kelas,

            'no_hp' => $request->no_hp,

            'role' => 'siswa',

            'status' => true,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Pendaftaran berhasil.',
            'data' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'kelas' => $user->nama_kelas,
            ]
        ], 201);
    }
}