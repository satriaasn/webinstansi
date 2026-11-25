<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable('keberatan_informasi')) {
            Schema::create('keberatan_informasi', function (Blueprint $table) {
                $table->id();
                $table->string('nomor_registrasi_keberatan', 50)->unique();
                $table->string('informasi_pengaju_keberatan', 255)->nullable();
                $table->string('nomor_permohonan_informasi', 100)->nullable();
                $table->text('tujuan_penggunaan_informasi');
                $table->string('nama', 255);
                $table->text('alamat_lengkap');
                $table->string('pekerjaan', 150)->nullable();
                $table->string('nomor_telepon', 30);
                $table->text('alasan_keberatan');
                $table->text('kasus_posisi');
                $table->enum('status', ['pending', 'diproses', 'selesai', 'ditolak'])->default('pending');
                $table->text('tanggapan')->nullable();
                $table->timestamp('tanggal_respon')->nullable();
                $table->unsignedBigInteger('respon_oleh')->nullable();
                $table->timestamps();

                $table->index('nomor_registrasi_keberatan');
                $table->index('nomor_permohonan_informasi');
                $table->index('status');
            });
        }

        // Update menu PPID "FORM KEBERATAN ATAS PERMOHONAN" agar mengarah ke halaman internal
        DB::table('menus')
            ->where('url', 'like', '%1_F7BiwIteg1ozdBy1XMWFjkP4D67TvmqVifX0j2onc0%')
            ->update(['url' => 'keberatan-informasi', 'target' => 'none']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('keberatan_informasi');
    }
};
