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
        Schema::table('users', function (Blueprint $table) {

            $table->string('no_hp')->nullable();

            $table->enum('role', [
                'admin',
                'guru',
                'kepala_madrasah',
                'siswa'
            ])->default('siswa');

            $table->boolean('status')
                ->default(true);

            $table->timestamp('last_login')
                ->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};
