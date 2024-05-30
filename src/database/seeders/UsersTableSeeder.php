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
                'name' => 'a',
                'email' => 'a@ne.jp',
                'password' => bcrypt('aaaaaaaa'),
            ],
            [
                'name' => 'b',
                'email' => 'b@ne.jp',
                'password' => bcrypt('bbbbbbbb'),
            ],
            [
                'name' => 'c',
                'email' => 'c@ne.jp',
                'password' => bcrypt('cccccccc'),
            ],
            [
                'name' => 'd',
                'email' => 'd@ne.jp',
                'password' => bcrypt('dddddddd'),
            ],
            [
                'name' => 'e',
                'email' => 'e@ne.jp',
                'password' => bcrypt('eeeeeeee'),
            ],
        ];

        foreach ($users as $user) {
            $user['created_at'] = Carbon::now();
            $user['updated_at'] = Carbon::now();
            DB::table('users')->insert($user);
        }
    }
}
