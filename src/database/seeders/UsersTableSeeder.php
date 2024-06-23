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
            [
                'name' => '一郎',
                'email' => 'a@ne.jp',
                'password' => bcrypt('11111111'),
            ],
            [
                'name' => '二郎',
                'email' => 'b@ne.jp',
                'password' => bcrypt('22222222'),
            ],
            [
                'name' => '三郎',
                'email' => 'c@ne.jp',
                'password' => bcrypt('33333333'),
            ],
            [
                'name' => '四郎',
                'email' => 'd@ne.jp',
                'password' => bcrypt('44444444'),
            ],
            [
                'name' => '五郎',
                'email' => 'e@ne.jp',
                'password' => bcrypt('44444444'),
            ],
        ];

        foreach ($users as $user) {
            $user['created_at'] = Carbon::now();
            $user['updated_at'] = Carbon::now();
            DB::table('users')->insert($user);
        }
    }
}
