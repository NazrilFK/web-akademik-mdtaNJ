<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Kelas;

class KelasController extends Controller
{
    public function index()
    {
        return response()->json([
            'success' => true,
            'data' => Kelas::select(
                    'id',
                    'nama_kelas'
                )
                ->orderBy('tingkat')
                ->get(),
        ]);
    }
}