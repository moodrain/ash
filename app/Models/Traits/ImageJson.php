<?php

namespace App\Models\Traits;

trait ImageJson
{
    public function getImageJsonAttribute()
    {
        return $this->attributes['images'];
    }

}