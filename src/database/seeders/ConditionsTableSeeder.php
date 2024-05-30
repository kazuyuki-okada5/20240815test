<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ConditionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $conditions = [
            ['condition' => '非常に良い'],
            ['condition' => '良い'],
            ['condition' => '普通'],
            ['condition' => '悪い'],
            ['condition' => '非常に悪い'],
        ];
        DB::table('conditions')->insert($conditions);
    }
}

