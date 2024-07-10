<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            ['category' => 'メンズ'],
            ['category' => 'レディース'],
            ['category' => 'キッズ'],
            ['category' => '食品'],
            ['category' => 'ペット用品'],
            ['category' => '日用雑貨'],
            ['category' => '植物'],
        ];
        DB::table('categories')->insert($categories);
    }
}
