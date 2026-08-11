<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\JadwalResource;
use App\Models\JadwalPelajaran;
use App\Models\Kelas;
use Illuminate\Http\Request;

class JadwalController extends Controller
{
    public function hariIni(Request $request)
    {
        // Gunakan waktu Indonesia
        date_default_timezone_set('Asia/Jakarta');

        $user = $request->user();

        // Pastikan user memiliki kelas
        if (empty($user->nama_kelas)) {

            return response()->json([
                'success' => false,
                'message' => 'Akun belum memiliki kelas.',
            ], 400);

        }

        // Cari kelas berdasarkan nama kelas user
        $kelas = Kelas::whereRaw(
            'LOWER(nama_kelas) = ?',
            [strtolower(trim($user->nama_kelas))]
        )->first();

        if (!$kelas) {

            return response()->json([
                'success' => false,
                'message' => 'Data kelas tidak ditemukan.',
            ], 404);

        }

        // Mapping nama hari Inggris -> Indonesia
        $hariMapping = [
            'Sunday'    => 'Minggu',
            'Monday'    => 'Senin',
            'Tuesday'   => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday'  => 'Kamis',
            'Friday'    => 'Jumat',
            'Saturday'  => 'Sabtu',
        ];

        $hariInggris = now()->format('l');
        $hariIni = $hariMapping[$hariInggris];

        // Ambil jadwal
        $jadwal = JadwalPelajaran::with([
                'guru',
                'kelas',
                'mataPelajaran',
            ])
            ->where('kelas_id', $kelas->id)
            ->whereRaw('LOWER(hari) = ?', [strtolower($hariIni)])
            ->orderBy('jam_mulai', 'asc')
            ->get();

        if ($jadwal->isEmpty()) {

            return response()->json([
                'success' => true,
                'message' => 'Tidak ada jadwal pada hari ini.',
                'hari'    => $hariIni,
                'kelas'   => $kelas->nama_kelas,
                'total'   => 0,
                'data'    => [],
            ]);

        }

        return response()->json([
            'success' => true,
            'message' => 'Berhasil mengambil jadwal.',
            'hari'    => $hariIni,
            'kelas'   => $kelas->nama_kelas,
            'total'   => $jadwal->count(),
            'data'    => JadwalResource::collection($jadwal),
        ]);
    }
}