<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Note;
use Illuminate\Http\Request;

class NoteController extends Controller
{
    // 1. Ambil semua catatan milik siswa yang sedang login
    public function index(Request $request)
    {
        $notes = Note::where('user_id', $request->user()->id)->latest()->get();

        return response()->json([
            'success' => true,
            'data' => $notes
        ], 200);
    }

    // 2. Simpan catatan baru dari aplikasi mobile
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'isi' => 'required|string',
        ]);

        $note = Note::create([
            'user_id' => $request->user()->id, // Otomatis mengambil ID dari token login siswa
            'judul' => $request->judul,
            'isi' => $request->isi,
            'warna' => $request->warna ?? '#202023',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Catatan berhasil disimpan!',
            'data' => $note
        ], 201);
    }

    // 3. Ubah/Update isi catatan
    public function update(Request $request, $id)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'isi' => 'required|string',
        ]);

        $note = Note::where(
            'user_id',
            $request->user()->id
        )->find($id);

        if (!$note) {

            return response()->json([
                'success' => false,
                'message' => 'Catatan tidak ditemukan.'
            ],404);

        }

        $note->update([

            'judul' => $request->judul,

            'isi' => $request->isi,

            'warna' => $request->warna ?? $note->warna,

        ]);

        return response()->json([

            'success' => true,

            'message' => 'Catatan berhasil diperbarui!',

            'data' => $note,

        ]);

    }

    // 4. Hapus catatan
    public function destroy(Request $request, $id)
    {
        $note = Note::where('user_id', $request->user()->id)->find($id);

        if (!$note) {
            return response()->json(['success' => false, 'message' => 'Catatan tidak ditemukan.'], 404);
        }

        $note->delete();

        return response()->json([
            'success' => true,
            'message' => 'Catatan berhasil dihapus.'
        ], 200);
    }
}