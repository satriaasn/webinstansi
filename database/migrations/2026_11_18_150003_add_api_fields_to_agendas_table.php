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
        Schema::table('agendas', function (Blueprint $table) {
            $table->string('api_id', 100)->nullable()->unique()->after('id');
            $table->string('location', 500)->nullable()->after('content');
            $table->string('pakaian', 255)->nullable()->after('location');
            $table->string('penyelenggara', 255)->nullable()->after('pakaian');
            $table->string('sumber_agenda', 100)->nullable()->after('penyelenggara');
            $table->string('status_waktu', 50)->nullable()->after('sumber_agenda');
            $table->json('metadata')->nullable()->after('status_waktu');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('agendas', function (Blueprint $table) {
            $table->dropColumn([
                'api_id',
                'location',
                'pakaian',
                'penyelenggara',
                'sumber_agenda',
                'status_waktu',
                'metadata'
            ]);
        });
    }
};
