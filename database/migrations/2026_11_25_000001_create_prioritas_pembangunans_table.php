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
        Schema::create('prioritas_pembangunans', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('icon', 100)->default('fas fa-bullseye');
            $table->integer('urutan')->default(0);
            $table->enum('active', ['Y', 'N'])->default('Y');
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->timestamps();
        });

        // Seed initial default priority items so the homepage displays cleanly right away
        DB::table('prioritas_pembangunans')->insert([
            [
                'title' => 'Pembangunan Jalan & Infrastruktur Konektivitas',
                'description' => 'Peningkatan kemantapan jalan provinsi, jembatan, serta infrastruktur penunjang konektivitas antarwilayah.',
                'icon' => 'fas fa-road',
                'urutan' => 1,
                'active' => 'Y',
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Pembangunan Sumber Daya Manusia',
                'description' => 'Peningkatan kualitas kesehatan, penurunan angka stunting, dan penguatan daya saing tenaga kerja Lampung.',
                'icon' => 'fas fa-users',
                'urutan' => 2,
                'active' => 'Y',
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Pembangunan Sekolah & Akses Pendidikan',
                'description' => 'Pemerataan fasilitas pendidikan, rehabilitasi ruang kelas, dan peningkatan mutu pembelajaran.',
                'icon' => 'fas fa-school',
                'urutan' => 3,
                'active' => 'Y',
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Penguatan Ekonomi & Ketahanan Pangan',
                'description' => 'Hilirisasi komoditas unggulan pertanian, dukungan UMKM, dan pengendalian inflasi daerah.',
                'icon' => 'fas fa-seedling',
                'urutan' => 4,
                'active' => 'Y',
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prioritas_pembangunans');
    }
};
