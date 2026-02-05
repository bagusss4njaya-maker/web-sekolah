<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'tahun_masuk')) {
                $table->unsignedSmallInteger('tahun_masuk')->nullable();
            }
            if (!Schema::hasColumn('users', 'status_awal')) {
                $table->enum('status_awal', ['aktif', 'pindah', 'keluar'])->default('aktif');
            }
            if (!Schema::hasColumn('users', 'status_siswa')) {
                $table->enum('status_siswa', ['aktif', 'lulus', 'pindah', 'keluar'])->default('aktif');
            }
            if (!Schema::hasColumn('users', 'tahun_lulus')) {
                $table->unsignedSmallInteger('tahun_lulus')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'tahun_masuk')) {
                $table->dropColumn('tahun_masuk');
            }
            if (Schema::hasColumn('users', 'status_awal')) {
                $table->dropColumn('status_awal');
            }
            if (Schema::hasColumn('users', 'status_siswa')) {
                $table->dropColumn('status_siswa');
            }
            if (Schema::hasColumn('users', 'tahun_lulus')) {
                $table->dropColumn('tahun_lulus');
            }
        });
    }
};
