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
        if (!Schema::hasTable('permohonan_informasi')) {
            Schema::create('permohonan_informasi', function (Blueprint $table) {
                $table->id();
                $table->string('nomor_tiket', 50)->unique();
                $table->string('kategori_pemohon', 50)->default('Perorangan');
                $table->string('nama_pemohon', 255);
                $table->string('nik', 30);
                $table->string('file_ktp', 255)->nullable();
                $table->string('email', 255);
                $table->string('no_telepon', 30);
                $table->string('pekerjaan', 150)->nullable();
                $table->string('instansi', 200)->nullable();
                $table->text('alamat');
                $table->text('rincian_informasi');
                $table->text('tujuan_penggunaan');
                $table->string('cara_memperoleh', 150)->default('Mendapatkan Salinan Dokumen (Softcopy)');
                $table->string('cara_penyerahan', 150)->default('Email');
                $table->string('file_pendukung', 255)->nullable();
                $table->enum('status', ['pending', 'diproses', 'selesai', 'ditolak'])->default('pending');
                $table->text('tanggapan')->nullable();
                $table->string('file_lampiran_jawaban', 255)->nullable();
                $table->timestamp('tanggal_respon')->nullable();
                $table->unsignedBigInteger('respon_oleh')->nullable();
                $table->boolean('email_notifikasi_terkirim')->default(false);
                $table->timestamp('tanggal_email_terakhir')->nullable();
                $table->timestamps();

                $table->index('nomor_tiket');
                $table->index('status');
                $table->index('email');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('permohonan_informasi');
    }
};

