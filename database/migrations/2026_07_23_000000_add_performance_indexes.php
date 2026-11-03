<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    private function hasIndex(string $table, string $index): bool
    {
        return DB::table('information_schema.statistics')
            ->where('table_schema', DB::getDatabaseName())
            ->where('table_name', $table)
            ->where('index_name', $index)
            ->exists();
    }

    public function up(): void
    {
        /*
        |--------------------------------------------------------------------------
        | POSTS
        |--------------------------------------------------------------------------
        */

        if (Schema::hasTable('posts')) {

            if (!$this->hasIndex('posts', 'idx_posts_active_cat_id')) {
                Schema::table('posts', function (Blueprint $table) {
                    $table->index(
                        ['active', 'post_category_id', 'id'],
                        'idx_posts_active_cat_id'
                    );
                });
            }

            if (!$this->hasIndex('posts', 'idx_posts_active_seo')) {
                DB::statement("
                    ALTER TABLE posts
                    ADD INDEX idx_posts_active_seo (active, seotitle(180))
                ");
            }

            if (!$this->hasIndex('posts', 'idx_posts_headline')) {
                DB::statement("
                    ALTER TABLE posts
                    ADD INDEX idx_posts_headline (active, headline, id)
                ");
            }
        }

        /*
        |--------------------------------------------------------------------------
        | POST CATEGORYS
        |--------------------------------------------------------------------------
        */

        if (Schema::hasTable('post_categorys')) {

            if (!$this->hasIndex('post_categorys', 'idx_post_cat_active_seo')) {
                DB::statement("
                    ALTER TABLE post_categorys
                    ADD INDEX idx_post_cat_active_seo (active, seotitle(180))
                ");
            }
        }

        /*
        |--------------------------------------------------------------------------
        | POST REVIEWS
        |--------------------------------------------------------------------------
        */

        if (Schema::hasTable('post_reviews')) {

            if (!$this->hasIndex('post_reviews', 'idx_reviews_post_status')) {
                Schema::table('post_reviews', function (Blueprint $table) {
                    $table->index(
                        ['post_id', 'status'],
                        'idx_reviews_post_status'
                    );
                });
            }
        }

        /*
        |--------------------------------------------------------------------------
        | SETTINGS
        |--------------------------------------------------------------------------
        */

        if (Schema::hasTable('settings')) {

            if (!$this->hasIndex('settings', 'idx_settings_key')) {
                Schema::table('settings', function (Blueprint $table) {
                    $table->index('key', 'idx_settings_key');
                });
            }
        }
    }

    public function down(): void
    {
        $indexes = [
            'posts' => [
                'idx_posts_active_cat_id',
                'idx_posts_active_seo',
                'idx_posts_headline',
            ],

            'post_categorys' => [
                'idx_post_cat_active_seo',
            ],

            'post_reviews' => [
                'idx_reviews_post_status',
            ],

            'settings' => [
                'idx_settings_key',
            ],
        ];

        foreach ($indexes as $table => $list) {

            if (!Schema::hasTable($table)) {
                continue;
            }

            foreach ($list as $index) {

                if ($this->hasIndex($table, $index)) {
                    DB::statement("
                        ALTER TABLE `$table`
                        DROP INDEX `$index`
                    ");
                }
            }
        }
    }
};