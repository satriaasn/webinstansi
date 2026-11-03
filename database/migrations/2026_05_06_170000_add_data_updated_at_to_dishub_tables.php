<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $tables = [
            'dishub_flight_schedules',
            'dishub_terminals',
            'dishub_akdp_routes',
            'dishub_toll_rates',
            'dishub_section_notes',
        ];

        foreach ($tables as $table) {
            Schema::table($table, function (Blueprint $blueprint) {
                $blueprint->date('data_updated_at')->nullable();
            });
        }

        $today = Carbon::today()->toDateString();

        foreach ($tables as $table) {
            DB::table($table)->whereNull('data_updated_at')->update(['data_updated_at' => $today]);
        }
    }

    public function down(): void
    {
        $tables = [
            'dishub_flight_schedules',
            'dishub_terminals',
            'dishub_akdp_routes',
            'dishub_toll_rates',
            'dishub_section_notes',
        ];

        foreach ($tables as $table) {
            Schema::table($table, function (Blueprint $blueprint) {
                $blueprint->dropColumn('data_updated_at');
            });
        }
    }
};
