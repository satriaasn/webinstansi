<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dishub_flight_schedules', function (Blueprint $table) {
            $table->id();
            $table->enum('category', ['arrival', 'departure']);
            $table->string('airline');
            $table->string('route');
            $table->string('estimated_time');
            $table->string('operational_days');
            $table->text('notes')->nullable();
            $table->string('source')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('dishub_terminals', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('group_no')->nullable();
            $table->string('kabupaten_kota');
            $table->string('nama_terminal');
            $table->string('tipe', 20)->nullable();
            $table->text('status_operasional');
            $table->string('koordinat_label')->nullable();
            $table->string('koordinat_url')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('dishub_akdp_routes', function (Blueprint $table) {
            $table->id();
            $table->string('wilayah_tujuan');
            $table->text('detail_trayek');
            $table->string('keterangan', 100)->nullable();
            $table->string('kategori', 100)->nullable();
            $table->string('label_aplikasi', 100)->nullable();
            $table->string('source')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('dishub_toll_rates', function (Blueprint $table) {
            $table->id();
            $table->string('asal_tujuan');
            $table->string('golongan_i', 100);
            $table->string('golongan_ii_iii', 100);
            $table->string('golongan_iv_v', 100);
            $table->string('source')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::create('dishub_section_notes', function (Blueprint $table) {
            $table->id();
            $table->enum('section', ['flight_schedule', 'terminal', 'akdp_route', 'toll_rate']);
            $table->text('note');
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dishub_section_notes');
        Schema::dropIfExists('dishub_toll_rates');
        Schema::dropIfExists('dishub_akdp_routes');
        Schema::dropIfExists('dishub_terminals');
        Schema::dropIfExists('dishub_flight_schedules');
    }
};
