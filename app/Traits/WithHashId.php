<?php

namespace App\Traits;

use Hashids\Hashids;
use Illuminate\Database\Eloquent\Builder;

trait WithHashId
{
    protected static function bootWithHashId()
    {
        static::creating(function ($model) {
            // temporary empty
        });

        static::created(function ($model) {
            if ($model->hashid) {
                return;
            }

            $hashids = new Hashids(config('app.key'), 10);
            $model->hashid = $hashids->encode($model->id);
            $model->saveQuietly();
        });
    }
    /**
     * Scope to query by hashid User::hashid('m5XoR0PB12')
     */
    public function scopeHashId(Builder $builder, string $hashid)
    {
        return $builder->where('hashid', $hashid);
    }

    /**
     * Helper to get the original ID from hashid
     */
    public static function getId(?string $hashid): ?int
    {
        if (! $hashid) {
            return null;
        }

        return static::hashId($hashid)->first()?->id;
    }

    /**
     * Route model binding by hashid
     */
    public function getRouteKeyName(): string
    {
        return 'hashid';
    }
}
