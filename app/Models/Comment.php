<?php

namespace App\Models;

use App\Models\Traits\TimeReadable;

class Comment extends Model
{
    use TimeReadable;

    public static $searchRule = [
        'id' => '=',
        'content' => 'like',
        'userId/d' => '=',
        'fromUserId/d' => '=',
        'subjectId/d' => '=',
        'commentId/d' => '=',
    ];

    public static $sortRule = ['id', 'content', 'userId', 'fromUserId', 'subjectId', 'commentId', 'createdAt', 'updatedAt'];

    protected $appends = ['createdAtReadable', 'updatedAtReadable', 'contentShort'];
    protected $with = ['user', 'from'];
    protected $casts = [
        'images' => 'json',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function from()
    {
        return $this->belongsTo(User::class, 'from_user_id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function comment()
    {
        return $this->belongsTo(Comment::class);
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function getContentShortAttribute()
    {
        $return = $content = \Parsedown::instance()->parse($this->attributes['content']);
        mb_strlen($content) > 200 && $return = mb_substr($content, 0, 200) . '...';
        $return = str_replace("\n", ' ', strip_tags($return));
        return $return;
    }

}
