<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $users = collect();
        for ($i = 1; $i <= 3; $i++) {
            $users->push([
                'id' => $i,
                'email' => "user$i@mail.com",
                'name' => 'user' . $i,
                'password' => password_hash('123', PASSWORD_DEFAULT),
            ]);
        }
        DB::table('users')->insert($users->all());
        $posts = collect();
        for ($i = 1; $i <= 100; $i++) {
            $posts->push([
                'id' => $i,
                'name' => 'post-' . $i,
                'abstract' => "post-$i-abstract",
                'user_id' => $users->random()['id'],
                'created_at' => mDate(time() - mt_rand(1, 999) * 60),
            ]);
        }
        DB::table('posts')->insert($posts->all());
    }

}
