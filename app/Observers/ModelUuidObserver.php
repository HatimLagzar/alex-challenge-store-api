<?php

namespace App\Observers;

use App\Models\ModelUuid;
use Illuminate\Support\Str;

class ModelUuidObserver
{
    public function creating(ModelUuid $modelUuid)
    {
        $modelUuid->{$modelUuid->getKeyName()} = Str::uuid()->toString();
    }
}
