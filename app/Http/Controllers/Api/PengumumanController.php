<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PengumumanResource;
use App\Models\Pengumuman;
use App\Models\Kelas;
use Illuminate\Http\Request;

class PengumumanController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        $kelas = Kelas::where(
            'nama_kelas',
            $user->nama_kelas
        )->first();

        $pengumuman = Pengumuman::query()

            ->where('status', 'Published')

            ->where(function ($query) use ($kelas) {

                $query->where('target', 'Semua');

                if ($kelas) {

                    $query->orWhere(function ($q) use ($kelas) {

                        $q->where('target', 'Kelas')
                          ->where('kelas_id', $kelas->id);

                    });

                }

            })

            ->orderByDesc('tanggal_publish')

            ->get();

        if ($pengumuman->isEmpty()) {

            return response()->json([

                'success' => true,

                'message' => 'Belum ada pengumuman.',

                'data' => []

            ]);

        }

        return response()->json([

            'success' => true,

            'total' => $pengumuman->count(),

            'data' => PengumumanResource::collection($pengumuman)

        ]);

    }
}