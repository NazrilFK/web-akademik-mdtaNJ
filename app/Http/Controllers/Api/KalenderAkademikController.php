<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\KalenderAkademikResource;
use App\Models\KalenderAkademik;

class KalenderAkademikController extends Controller
{
    public function index()
    {
        $kalender = KalenderAkademik::orderBy('tanggal_mulai', 'asc')->get();

        if ($kalender->isEmpty()) {

            return response()->json([
                'success' => true,
                'message' => 'Belum ada data kalender akademik.',
                'data' => []
            ]);

        }

        return response()->json([

            'success' => true,

            'total' => $kalender->count(),

            'data' => KalenderAkademikResource::collection($kalender)

        ]);
    }
}