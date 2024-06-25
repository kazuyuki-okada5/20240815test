<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            // 管理者ユーザー
            [
                'name' => '管理者太郎',
                'email' => 'aa@ne.jp',
                'password' => bcrypt('12345678'),
                'role' => 0,
            ],

            [
                'name' => '管理者次郎',
                'email' => 'bb@ne.jp',
                'password' => bcrypt('23456789'),
                'role' => 0,
            ],
            
            // 一般ユーザー
            [
                'name' => '一郎',
                'email' => 'a@ne.jp',
                'password' => bcrypt('11111111'),
                'role' => 1,
            ],

            [
                'name' => '二郎',
                'email' => 'b@ne.jp',
                'password' => bcrypt('22222222'),
                'role' => 1,
            ],
            [
                'name' => '三郎',
                'email' => 'c@ne.jp',
                'password' => bcrypt('33333333'),
                'role' => 1,
            ],

            [
                'name' => '四郎',
                'email' => 'd@ne.jp',
                'password' => bcrypt('44444444'),
                'role' => 1,
            ],

            [
                'name' => '五郎',
                'email' => 'e@ne.jp',
                'password' => bcrypt('55555555'),
                'role' => 1,
            ],
        ];

        foreach ($users as $user) {
            $user['created_at'] = Carbon::now();
            $user['updated_at'] = Carbon::now();
            DB::table('users')->insert($user);
        }
    }
}
