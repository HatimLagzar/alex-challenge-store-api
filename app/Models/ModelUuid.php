<?php

namespace App\Models;

use App\Observers\ModelUuidObserver;
use Illuminate\Database\Eloquent\Model;

class ModelUuid extends Model
{
    public $incrementing = false;

    protected $keyType = 'string';

    protected static function boot()
    {
        parent::boot();

        static::observe(ModelUuidObserver::class);
    }
}
