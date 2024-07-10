<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ItemsTableSeeder extends Seeder
// ビュー表示出来なかったら　php artisan storage:link　でディレクトリ公開する
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $items = [
            [
                'user_id' => 3,
                'condition_id' => 1,
                'name' => '青シャツ',
                'price' => 1000,
                'comment' => '汚れ・ほつれ無し',
                'image_url' => '/images/スクリーンショット 2024-05-24 16.25.05.png',
                'brand' => 'ノーブランド',
            ],
            [
                'user_id' => 3,
                'condition_id' => 2,
                'name' => '黒パンツ',
                'price' => 1000,
                'comment' => '汚れ・ほつれ無し',
                'image_url' => '/images/スクリーンショット 2024-05-24 16.27.11.png',
                'brand' => 'ノーブランド',
            ],
            [
                'user_id' => 3,
                'condition_id' => 3,
                'name' => '柄シャツ',
                'price' => 800,
                'comment' => '一部ほつれあり',
                'image_url' => '/images/スクリーンショット 2024-05-24 16.28.10.png',
                'brand' => 'ノーブランド',
            ],
            [
                'user_id' => 3,
                'condition_id' => 4,
                'name' => 'メガネ',
                'price' => 200,
                'comment' => '一部汚れあり',
                'image_url' => '/images/スクリーンショット 2024-05-24 16.29.10.png',
                'brand' => 'ノーブランド',
            ],
            [
                'user_id' => 3,
                'condition_id' => 5,
                'name' => 'ネックレス',
                'price' => 20,
                'comment' => 'ボロボロ',
                'image_url' => '/images/スクリーンショット 2024-05-24 16.32.05.png',
                'brand' => 'ノーブランド',
            ],
            [
                'user_id' => 3,
                'condition_id' => 1,
                'name' => '紺ワンピース',
                'price' => 2000,
                'comment' => '新品同様',
                'image_url' => '/images/スクリーンショット 2024-05-24 16.32.24.png',
                'brand' => 'ノーブランド',
            ],
            [
                'user_id' => 3,
                'condition_id' => 2,
                'name' => '柄スカート',
                'price' => 1500,
                'comment' => 'ほつれ、汚れなし',
                'image_url' => '/images/スクリーンショット 2024-05-24 16.33.50.png',
                'brand' => 'ノーブランド',
            ],
            [
                'user_id' => 4,
                'condition_id' => 3,
                'name' => '白ワンピース',
                'price' => 400,
                'comment' => '普通',
                'image_url' => '/images/スクリーンショット 2024-05-24 16.34.59.png',
                'brand' => 'ノーブランド',
            ],
            [
                'user_id' => 4,
                'condition_id' => 3,
                'name' => 'バースデープレート',
                'price' => 400,
                'comment' => '普通',
                'image_url' => '/images/スクリーンショット 2024-05-24 16.36.15.png',
                'brand' => 'ノーブランド',
            ],
            [
                'user_id' => 4,
                'condition_id' => 4,
                'name' => '帽子',
                'price' => 400,
                'comment' => '一部汚れあり',
                'image_url' => '/images/スクリーンショット 2024-05-24 16.36.50.png',
                'brand' => 'ノーブランド',
            ],
            [
                'user_id' => 4,
                'condition_id' => 4,
                'name' => '靴',
                'price' => 400,
                'comment' => '一部汚れあり',
                'image_url' => '/images/スクリーンショット 2024-05-24 16.37.18.png',
                'brand' => 'ノーブランド',
            ],
            [
                'user_id' => 4,
                'condition_id' => 4,
                'name' => 'おもちゃ',
                'price' => 400,
                'comment' => 'キズ、凹みあり',
                'image_url' => '/images/スクリーンショット 2024-05-24 16.38.53.png',
                'brand' => 'ノーブランド',
            ],
            [
                'user_id' => 4,
                'condition_id' => 1,
                'name' => '飲料水',
                'price' => 300,
                'comment' => '新品',
                'image_url' => '/images/スクリーンショット 2024-05-24 16.40.10.png',
                'brand' => 'ノーブランド',
            ],
            [
                'user_id' => 5,
                'condition_id' => 1,
                'name' => '洋菓子',
                'price' => 700,
                'comment' => '新品',
                'image_url' => '/images/スクリーンショット 2024-05-24 16.40.32.png',
                'brand' => 'ノーブランド',
            ],
            [
                'user_id' => 5,
                'condition_id' => 1,
                'name' => 'コーヒー',
                'price' => 1200,
                'comment' => '新品',
                'image_url' => '/images/スクリーンショット 2024-05-24 16.41.15.png',
                'brand' => 'ノーブランド',
            ],
            [
                'user_id' => 5,
                'condition_id' => 2,
                'name' => '不揃いトマト',
                'price' => 1000,
                'comment' => 'サイズ不均一',
                'image_url' => '/images/スクリーンショット 2024-05-24 16.41.31.png',
                'brand' => 'ノーブランド',
            ],
            [
                'user_id' => 5,
                'condition_id' => 1,
                'name' => '洋菓子',
                'price' => 1600,
                'comment' => '新品',
                'image_url' => '/images/スクリーンショット 2024-05-24 16.43.08.png',
                'brand' => 'ノーブランド',
            ],
            [
                'user_id' => 5,
                'condition_id' => 1,
                'name' => '洋菓子',
                'price' => 1600,
                'comment' => '新品',
                'image_url' => '/images/スクリーンショット 2024-05-24 16.43.08.png',
                'brand' => 'ノーブランド',
            ],
            [
                'user_id' => 5,
                'condition_id' => 2,
                'name' => '訳ありスイカ',
                'price' => 1100,
                'comment' => 'サイズ不揃い',
                'image_url' => '/images/スクリーンショット 2024-05-24 16.43.30.png',
                'brand' => 'ノーブランド',
            ],
            [
                'user_id' => 6,
                'condition_id' => 4,
                'name' => '小型犬服',
                'price' => 1100,
                'comment' => '汚れあり',
                'image_url' => '/images/スクリーンショット 2024-05-24 16.47.30.png',
                'brand' => 'ノーブランド',
            ],
            [
                'user_id' => 6,
                'condition_id' => 1,
                'name' => '小型犬服',
                'price' => 2100,
                'comment' => '新品同様',
                'image_url' => '/images/スクリーンショット 2024-05-24 16.48.34.png',
                'brand' => 'ノーブランド',
            ],
            [
                'user_id' => 6,
                'condition_id' => 3,
                'name' => 'ケージ小',
                'price' => 1000,
                'comment' => '普通',
                'image_url' => '/images/スクリーンショット 2024-05-24 16.48.57.png',
                'brand' => 'ノーブランド',
            ],
            [
                'user_id' => 6,
                'condition_id' => 4,
                'name' => '鍋',
                'price' => 2100,
                'comment' => '使用感あり',
                'image_url' => '/images/スクリーンショット 2024-05-24 16.49.49.png',
                'brand' => 'ノーブランド',
            ],
            [
                'user_id' => 6,
                'condition_id' => 4,
                'name' => '包丁',
                'price' => 2600,
                'comment' => '使用感あり',
                'image_url' => '/images/スクリーンショット 2024-05-24 16.50.06.png',
                'brand' => 'ノーブランド',
            ],
            [
                'user_id' => 6,
                'condition_id' => 1,
                'name' => 'シャンプー',
                'price' => 2500,
                'comment' => '新品',
                'image_url' => '/images/スクリーンショット 2024-05-24 16.50.33.png',
                'brand' => 'ノーブランド',
            ],
            [
                'user_id' => 7,
                'condition_id' => 1,
                'name' => '急須',
                'price' => 500,
                'comment' => '新品',
                'image_url' => '/images/スクリーンショット 2024-05-24 16.51.01.png',
                'brand' => 'ノーブランド',
            ],
            [
                'user_id' => 7,
                'condition_id' => 3,
                'name' => '植物',
                'price' => 2500,
                'comment' => '痛みあり',
                'image_url' => '/images/スクリーンショット 2024-05-24 16.54.01.png',
                'brand' => 'ノーブランド',
            ],
            [
                'user_id' => 7,
                'condition_id' => 3,
                'name' => '植物',
                'price' => 2900,
                'comment' => '痛みあり',
                'image_url' => '/images/スクリーンショット 2024-05-24 16.54.22.png',
                'brand' => 'ノーブランド',
            ],
            [
                'user_id' => 7,
                'condition_id' => 3,
                'name' => '植物',
                'price' => 1300,
                'comment' => '痛みあり',
                'image_url' => '/images/スクリーンショット 2024-05-24 16.54.38.png',
                'brand' => 'ノーブランド',
            ],
            [
                'user_id' => 7,
                'condition_id' => 3,
                'name' => '行者ニンニク苗',
                'price' => 400,
                'comment' => '痛みあり',
                'image_url' => '/images/スクリーンショット 2024-05-24 16.54.57.png',
                'brand' => 'ノーブランド',
            ],
        ];

        foreach ($items as $item) {
            // インサートした結果のIDを取得
            $itemId = DB::table('items')->insertGetId($item);

            // この段階で$itemには'id'がないので、'id'を追加することは不適切
            // $item['id'] = $itemId;
        }
    }
}
