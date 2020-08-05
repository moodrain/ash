<?php

namespace App\Models\Subject;

class Category extends Model
{
    public static $searchRule = [
        'id' => '=',
        'name' => 'like',
    ];
    public static $sortRule = ['id', 'name', 'createdAt'];
}
