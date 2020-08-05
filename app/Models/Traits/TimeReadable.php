<?php

namespace App\Models\Traits;

use Illuminate\Support\Carbon;

trait TimeReadable
{
    public function getCreatedAtReadableAttribute()
    {
        return Carbon::create($this->attributes['created_at'])->diffForHumans();
    }

    public function getUpdatedAtReadableAttribute()
    {
        return Carbon::create($this->attributes['updated_at'])->diffForHumans();
    }
}