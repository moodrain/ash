<?php

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
                'user_id' => $i,
                'category_id' => $i,
                'content' => "### Title \n\n Content $i",
                'images' => json_encode(array_fill(0, 3, 'https://s1.moodrain.cn/test/img/img.jpg')),
            ]);
        }
    }

    private function comment()
    {

    }

}
