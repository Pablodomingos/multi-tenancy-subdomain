<?php

namespace App\Traits;

use App\Models\Scopes\ModelScope;
use App\Observers\ModelObserver;

trait ModelBooted
{
    public static function booted(): void
    {
        static::addGlobalScope(new ModelScope());
        static::observe(ModelObserver::class);
    }
}
