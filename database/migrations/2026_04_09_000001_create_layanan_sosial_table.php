<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Tabel Kategori Layanan
        Schema::create('layanan_sosial', function (Blueprint $table) {
            $table->id();
            $table->string('kode', 20)->unique(); // e.g. FM, PBS, PJS, RS, PRSPD, PSAA_BA, PSAA_HB, PSBR, PSLU
            $table->string('nama');
            $table->string('singkatan')->nullable();
            $table->enum('jenis', ['bidang', 'uptd'])->default('bidang');
            $table->text('deskripsi')->nullable();
            $table->text('persyaratan')->nullable();
            $table->string('icon')->nullable();
            $table->string('warna', 20)->nullable(); // hex color
            $table->string('file_brosur')->nullable(); // path ke PDF brosur
            $table->boolean('aktif')->default(true);
            $table->integer('urutan')->default(0);
            $table->timestamps();
        });

        // Tabel Pendaftaran Layanan
        Schema::create('pendaftaran_layanan', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_registrasi', 30)->unique();
            $table->foreignId('layanan_sosial_id')->constrained('layanan_sosial');

            // --- Data Pemohon (Universal) ---
            $table->string('nama_lengkap');
            $table->string('nik', 16)->nullable();
            $table->enum('jenis_kelamin', ['laki-laki', 'perempuan'])->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->string('tempat_lahir')->nullable();
            $table->string('agama', 30)->nullable();
            $table->string('status_perkawinan', 30)->nullable();
            $table->string('pendidikan_terakhir', 50)->nullable();
            $table->text('alamat_lengkap')->nullable();
            $table->string('kelurahan_desa')->nullable();
            $table->string('kecamatan')->nullable();
            $table->string('kabupaten_kota')->nullable();
            $table->string('no_telepon', 20)->nullable();
            $table->string('email')->nullable();

            // --- Data Penanggung Jawab / Wali (untuk anak, lansia, disabilitas) ---
            $table->string('nama_wali')->nullable();
            $table->string('hubungan_wali', 50)->nullable();
            $table->string('no_telepon_wali', 20)->nullable();
            $table->text('alamat_wali')->nullable();

            // --- Data Spesifik per Layanan (JSON) ---
            $table->json('data_tambahan')->nullable();

            // --- Dokumen Upload ---
            $table->string('file_ktp')->nullable();
            $table->string('file_kk')->nullable();
            $table->string('file_surat_keterangan')->nullable(); // surat miskin / tdk mampu / rujukan
            $table->string('file_dokumen_pendukung')->nullable(); // dokumen tambahan (sertifikat, dll)
            $table->string('file_foto')->nullable(); // pas foto / foto kondisi

            // --- Status ---
            $table->enum('status', ['menunggu', 'diproses', 'diterima', 'ditolak', 'selesai'])->default('menunggu');
            $table->text('catatan_petugas')->nullable();
            $table->timestamp('tanggal_daftar')->useCurrent();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pendaftaran_layanan');
        Schema::dropIfExists('layanan_sosial');
    }
};
