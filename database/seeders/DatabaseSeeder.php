<?php

use App\Models\Comment;
use App\Models\Subject;
use App\Models\Subject\Category;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        for ($i = 1; $i <= 3; $i++) {
            User::query()->create([
                'email' => "user$i@mail.com",
                'name' => "user$i",
                'password' => password_hash('123', PASSWORD_DEFAULT),
            ]);
        }
        for ($i = 1; $i <= 3; $i++) {
            Category::query()->create([
                'name' => "category-$i",
            ]);
        }
        for ($i = 1; $i <= 3; $i++) {
            Subject::query()->create([
                'title' => "subject-$i",
                'userId' => $i,
                'categoryId' => $i,
                'content' => "### Title \n\n Subject $i",
                'images' => array_fill(0, 3, 'https://s1.moodrain.cn/test/img/img.jpg'),
            ]);
        }
        Comment::query()->create([
            'fromUserId' => 2,
            'subjectId' => 1,
            'userId' => 1,
            'content' => "Comment-1",
            'images' => array_fill(0, 3, 'https://s1.moodrain.cn/test/img/img.jpg'),
            'orderId' => 1,
        ]);
        Comment::query()->create([
            'fromUserId' => 3,
            'subjectId' => 1,
            'commentId' => 1,
            'userId' => 2,
            'content' => "SubComment-1-1",
            'images' => array_fill(0, 3, 'https://s1.moodrain.cn/test/img/img.jpg'),
            'orderId' => 1,
        ]);
        Comment::query()->create([
            'fromUserId' => 1,
            'subjectId' => 1,
            'commentId' => 2,
            'userId' => 3,
            'content' => "SubSubComment-1-1-1",
            'images' => array_fill(0, 3, 'https://s1.moodrain.cn/test/img/img.jpg'),
            'orderId' => 1,
        ]);
        Comment::query()->create([
            'fromUserId' => 1,
            'subjectId' => 1,
            'userId' => 1,
            'content' => "Comment-2",
            'images' => array_fill(0, 3, 'https://s1.moodrain.cn/test/img/img.jpg'),
            'orderId' => 4,
        ]);
    }

}
