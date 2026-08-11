<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('kalender_akademiks', function (Blueprint $table) {
            $table->id();

            $table->string('judul');

            $table->enum('jenis_kegiatan', [
                'Libur Sekolah',
                'Ujian',
                'Kegiatan Madrasah',
                'Rapat Guru',
                'Pembagian Rapor',
                'Lainnya',
            ]);

            $table->date('tanggal_mulai');

            $table->date('tanggal_selesai')->nullable();

            $table->string('tahun_akademik');

            $table->enum('semester', [
                'Ganjil',
                'Genap',
            ]);

            $table->text('deskripsi')->nullable();

            $table->string('warna')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kalender_akademiks');
    }
};
