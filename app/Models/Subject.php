<?php

namespace App\Models;

use App\Models\Subject\Category;
use App\Models\Traits\TimeReadable;

class Subject extends Model
{
    use TimeReadable;

    public static $searchRule = [
        'id' => '=',
        'title' => 'like',
        'userId/d' => '=',
        'categoryId/d' => '=',
    ];

    public static $sortRule = ['id', 'title', 'userId', 'categoryId', 'createdAt', 'updatedAt'];

    protected $appends = ['createdAtReadable', 'updatedAtReadable', 'contentShort'];
    protected $with = ['user', 'category'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function getContentShortAttribute()
    {
        $return = $content = \Parsedown::instance()->parse($this->attributes['content']);
        mb_strlen($content) > 200 && $return = mb_substr($content, 0, 200) . '...';
        $return = str_replace("\n", ' ', strip_tags($return));
        return $return;
    }

}
