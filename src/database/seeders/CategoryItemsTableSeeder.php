<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoryItemsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categoryItems = [
            [
                'category_id' => 1,
                'item_id' => 1,
            ],
            [
                'category_id' => 2,
                'item_id' => 2,
            ],
            [
                'category_id' => 3,
                'item_id' => 3,
            ],
            [
                'category_id' => 4,
                'item_id' => 4,
            ],
            [
                'category_id' => 5,
                'item_id' => 5,
            ],
            [
                'category_id' => 1,
                'item_id' => 6,
            ],
            [
                'category_id' => 2,
                'item_id' => 7,
            ],
            [
                'category_id' => 3,
                'item_id' => 8,
            ],
            [
                'category_id' => 3,
                'item_id' => 9,
            ],
            [
                'category_id' => 4,
                'item_id' => 10,
            ],
            [
                'category_id' => 4,
                'item_id' => 11,
            ],
            [
                'category_id' => 4,
                'item_id' => 12,
            ],
            [
                'category_id' => 4,
                'item_id' => 13,
            ],
            [
                'category_id' => 1,
                'item_id' => 14,
            ],
            [
                'category_id' => 1,
                'item_id' => 15,
            ],
            [
                'category_id' => 1,
                'item_id' => 16,
            ],
            [
                'category_id' => 2,
                'item_id' => 17,
            ],
            [
                'category_id' => 1,
                'item_id' => 18,
            ],
            [
                'category_id' => 1,
                'item_id' => 19,
            ],
            [
                'category_id' => 2,
                'item_id' => 20,
            ],
            [
                'category_id' => 4,
                'item_id' => 21,
            ],
            [
                'category_id' => 1,
                'item_id' => 22,
            ],
            [
                'category_id' => 3,
                'item_id' => 23,
            ],
            [
                'category_id' => 4,
                'item_id' => 24,
            ],
            [
                'category_id' => 4,
                'item_id' => 25,
            ],
            [
                'category_id' => 1,
                'item_id' => 26,
            ],
            [
                'category_id' => 1,
                'item_id' => 27,
            ],
            [
                'category_id' => 3,
                'item_id' => 28,
            ],
            [
                'category_id' => 3,
                'item_id' => 29,
            ],
            [
                'category_id' => 3,
                'item_id' => 30,
            ],
        ];

        foreach ($categoryItems as $categoryItem) {
            DB::table('category_items')->insert($categoryItem);
        }
    }
}
