<?php

namespace App\Traits;

use Illuminate\Support\Facades\Cache;

trait CacheInvalidator
{
    public static function bootCacheInvalidator()
    {
        static::saved(function ($model) {
            $model->clearRelatedCache();
        });

        static::deleted(function ($model) {
            $model->clearRelatedCache();
        });
    }

    public function clearRelatedCache()
    {
        // For 'file' driver which doesn't support tags, we clear specific prefixes or all
        // Given the scale, flushing might be safer to ensure everything is fresh
        // but we can try to be specific if we want.
        
        // Simple approach: clear all cache to ensure consistency across all related features
        Cache::flush();
        
        // If we want to be more specific later, we can check the model type:
        // if ($this instanceof \App\Models\Post) { ... }
    }
}
