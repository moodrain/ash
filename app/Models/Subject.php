<?php

namespace App\Models;

use App\Models\Subject\Category;
use App\Models\Traits\Content;
use App\Models\Traits\TimeReadable;

class Subject extends Model
{
    use TimeReadable, Content;

    public static $searchRule = [
        'id' => '=',
        'title' => 'like',
        'userId/d' => '=',
        'categoryId/d' => '=',
    ];

    public static $sortRule = ['id', 'title', 'userId', 'categoryId', 'createdAt', 'updatedAt'];

    protected $appends = ['createdAtReadable', 'updatedAtReadable', 'contentShort', 'contentBase64'];
    protected $with = ['user', 'category'];
    protected $casts = [
        'images' => 'json',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

}
