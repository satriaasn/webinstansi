<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('visitors', function (Blueprint $table) {
            $table->index(['session_id', 'date_time'], 'idx_visitors_session_date');
        });

        Schema::table('agendas', function (Blueprint $table) {
            $table->index(['active', 'start'], 'idx_agendas_active_start');
        });
    }

    public function down(): void
    {
        Schema::table('visitors', function (Blueprint $table) {
            $table->dropIndex('idx_visitors_session_date');
        });

        Schema::table('agendas', function (Blueprint $table) {
            $table->dropIndex('idx_agendas_active_start');
        });
    }
};
