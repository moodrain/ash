<?php

namespace App\Models\Subject;

use App\Models\Model;

class Category extends Model
{
    public static $searchRule = [
        'id' => '=',
        'name' => 'like',
    ];
    public static $sortRule = ['id', 'name', 'createdAt'];

    protected $table = 'subject_categories';
}
