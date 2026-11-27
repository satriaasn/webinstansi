<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('struktur_organisasis', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('parent_id')->nullable()->index();
            $table->string('jabatan', 255);
            $table->string('nama', 255)->nullable();
            $table->string('nip', 100)->nullable();
            $table->string('pangkat', 150)->nullable();
            $table->string('tmt_pangkat', 50)->nullable();
            $table->string('tmt_jabatan', 50)->nullable();
            $table->string('foto', 255)->nullable();
            $table->string('tipe_node', 50)->default('jabatan'); // pimpinan, sekretaris, kasubbag, kabid, uptd, kasi, fungsional
            $table->integer('urutan')->default(0);
            $table->text('deskripsi')->nullable();
            $table->enum('active', ['Y', 'N'])->default('Y');
            $table->integer('created_by')->default(1);
            $table->integer('updated_by')->default(1);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('struktur_organisasis');
    }
};
