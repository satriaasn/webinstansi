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
        if (!Schema::hasTable('statistik_makro')) {
            Schema::create('statistik_makro', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('api_id')->unique();
                $table->string('judul');
                $table->text('deskripsi')->nullable();
                $table->string('sektor_nama')->nullable();
                $table->string('kategori_nama')->nullable();
                $table->string('jenis_grafik', 50)->nullable();
                $table->string('jenis_indikator', 30)->nullable();
                $table->boolean('is_indikator_utama')->default(false);
                $table->string('satuan', 100)->nullable();
                $table->string('periode', 50)->nullable();
                $table->string('sumber_data')->nullable();
                $table->string('nilai_terbaru', 100)->nullable();
                $table->string('nilai_formatted', 100)->nullable();
                $table->string('delta_formatted', 100)->nullable();
                $table->string('arah_perubahan', 20)->nullable();
                $table->string('periode_terbaru', 100)->nullable();
                $table->string('periode_pembanding', 100)->nullable();
                $table->longText('data_series')->nullable();
                $table->boolean('show_on_home')->default(false);
                $table->integer('urutan')->default(0);
                $table->timestamp('synced_at')->nullable();
                $table->timestamps();

                $table->index('show_on_home');
                $table->index('urutan');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('statistik_makro');
    }
};
