<?php

namespace App\Models;

class Post extends Model
{
    public static $searchRule = [
        'id' => '=',
        'name' => 'like',
        'userId' => '=',
    ];

    public static $sortRule = ['id', 'userId', 'name', 'createdAt'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
