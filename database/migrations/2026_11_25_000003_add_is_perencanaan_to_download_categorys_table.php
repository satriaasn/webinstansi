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
        Schema::table('download_categorys', function (Blueprint $table) {
            $table->boolean('is_perencanaan')->default(false)->after('active');
        });

        // Tandai kategori perencanaan pembangunan yang sudah ada
        DB::table('download_categorys')
            ->whereIn('id', [9, 23, 24, 26, 27, 42, 45, 46, 47, 48, 54, 83, 84])
            ->update(['is_perencanaan' => 1]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('download_categorys', function (Blueprint $table) {
            $table->dropColumn('is_perencanaan');
        });
    }
};
