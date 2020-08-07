<?php

use App\Models\Comment;
use App\Models\Subject;
use App\Models\Subject\Category;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->user();
        $this->subjectCategory();
        $this->subject();
        $this->comment();
    }

    private function user()
    {
        for ($i = 1; $i <= 3; $i++) {
            User::query()->create([
                'email' => "user$i@mail.com",
                'name' => "user$i",
                'password' => password_hash('123', PASSWORD_DEFAULT),
            ]);
        }
    }

    private function subjectCategory()
    {
        for ($i = 1; $i <= 3; $i++) {
            Category::query()->create([
                'name' => "category-$i",
            ]);
        }
    }

    private function subject()
    {
        for ($i = 1; $i <= 3; $i++) {
            Subject::query()->create([
                'title' => "subject-$i",
                'userId' => $i,
                'categoryId' => $i,
                'content' => "### Title \n\n Subject $i",
                'images' => array_fill(0, 3, 'https://s1.moodrain.cn/test/img/img.jpg'),
            ]);
        }
    }

    private function comment()
    {
        Comment::query()->create([
            'fromUserId' => 2,
            'subjectId' => 1,
            'commentId' => null,
            'userId' => 1,
            'content' => "#### Title \n\n Comment",
            'images' => array_fill(0, 3, 'https://s1.moodrain.cn/test/img/img.jpg'),
        ]);
        Comment::query()->create([
            'fromUserId' => 3,
            'subjectId' => 1,
            'commentId' => 1,
            'userId' => 2,
            'content' => "#### Title \n\n SubComment",
            'images' => array_fill(0, 3, 'https://s1.moodrain.cn/test/img/img.jpg'),
        ]);
        Comment::query()->create([
            'fromUserId' => 1,
            'subjectId' => 1,
            'commentId' => 2,
            'userId' => 3,
            'content' => "#### Title \n\n SubComment",
            'images' => array_fill(0, 3, 'https://s1.moodrain.cn/test/img/img.jpg'),
        ]);
    }

}
