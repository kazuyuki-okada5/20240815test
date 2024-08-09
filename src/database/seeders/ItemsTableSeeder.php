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
                'image_url' => 'https://flea-baket.s3.ap-northeast-1.amazonaws.com/public/images/001%E9%9D%92%E3%82%B7%E3%83%A3%E3%83%84.jpg',
                'brand' => 'ノーブランド',
            ],
            [
                'user_id' => 3,
                'condition_id' => 2,
                'name' => '黒パンツ',
                'price' => 1000,
                'comment' => '汚れ・ほつれ無し',
                'image_url' => 'https://flea-baket.s3.ap-northeast-1.amazonaws.com/public/images/002%E9%BB%92%E3%82%B7%E3%83%A3%E3%83%84.jpg',
                'brand' => 'ノーブランド',
            ],
            [
                'user_id' => 3,
                'condition_id' => 3,
                'name' => '柄シャツ',
                'price' => 800,
                'comment' => '一部ほつれあり',
                'image_url' => 'https://flea-baket.s3.ap-northeast-1.amazonaws.com/public/images/003%E6%9F%84%E3%82%B7%E3%83%A3%E3%83%84.jpg',
                'brand' => 'ノーブランド',
            ],
            [
                'user_id' => 3,
                'condition_id' => 4,
                'name' => 'メガネ',
                'price' => 200,
                'comment' => '一部汚れあり',
                'image_url' => 'https://flea-baket.s3.ap-northeast-1.amazonaws.com/public/images/004%E3%83%A1%E3%82%AB%E3%82%99%E3%83%8D.jpg',
                'brand' => 'ノーブランド',
            ],
            [
                'user_id' => 3,
                'condition_id' => 5,
                'name' => 'ネックレス',
                'price' => 200,
                'comment' => 'ボロボロ',
                'image_url' => 'https://flea-baket.s3.ap-northeast-1.amazonaws.com/public/images/005%E3%83%8D%E3%83%83%E3%82%AF%E3%83%AC%E3%82%B9.jpg',
                'brand' => 'ノーブランド',
            ],
            [
                'user_id' => 3,
                'condition_id' => 1,
                'name' => '紺ワンピース',
                'price' => 2000,
                'comment' => '新品同様',
                'image_url' => 'https://flea-baket.s3.ap-northeast-1.amazonaws.com/public/images/006%E6%9F%84%E3%83%AF%E3%83%B3%E3%83%92%E3%82%9A%E3%83%BC%E3%82%B9.jpg',
                'brand' => 'ノーブランド',
            ],
            [
                'user_id' => 3,
                'condition_id' => 2,
                'name' => '柄スカート',
                'price' => 1500,
                'comment' => 'ほつれ、汚れなし',
                'image_url' => 'https://flea-baket.s3.ap-northeast-1.amazonaws.com/public/images/007%E6%9F%84%E3%82%B9%E3%82%AB%E3%83%BC%E3%83%88.jpg',
                'brand' => 'ノーブランド',
            ],
            [
                'user_id' => 4,
                'condition_id' => 3,
                'name' => '白ワンピース',
                'price' => 400,
                'comment' => '普通',
                'image_url' => 'https://flea-baket.s3.ap-northeast-1.amazonaws.com/public/images/008%E7%99%BD%E3%83%AF%E3%83%B3%E3%83%92%E3%82%9A%E3%83%BC%E3%82%B9.jpg',
                'brand' => 'ノーブランド',
            ],
            [
                'user_id' => 4,
                'condition_id' => 3,
                'name' => 'バースデープレート',
                'price' => 400,
                'comment' => '普通',
                'image_url' => 'https://flea-baket.s3.ap-northeast-1.amazonaws.com/public/images/009%E3%83%8F%E3%82%99%E3%83%BC%E3%82%B9%E3%83%86%E3%82%99%E3%83%BC%E3%83%95%E3%82%9A%E3%83%AC%E3%83%BC%E3%83%88.jpg',
                'brand' => 'ノーブランド',
            ],
            [
                'user_id' => 4,
                'condition_id' => 4,
                'name' => '帽子',
                'price' => 400,
                'comment' => '一部汚れあり',
                'image_url' => 'https://flea-baket.s3.ap-northeast-1.amazonaws.com/public/images/010%E5%B8%BD%E5%AD%90.jpg',
                'brand' => 'ノーブランド',
            ],
            [
                'user_id' => 4,
                'condition_id' => 4,
                'name' => '靴',
                'price' => 400,
                'comment' => '一部汚れあり',
                'image_url' => 'https://flea-baket.s3.ap-northeast-1.amazonaws.com/public/images/011%E9%9D%B4.jpg',
                'brand' => 'ノーブランド',
            ],
            [
                'user_id' => 4,
                'condition_id' => 4,
                'name' => 'おもちゃ',
                'price' => 400,
                'comment' => 'キズ、凹みあり',
                'image_url' => 'https://flea-baket.s3.ap-northeast-1.amazonaws.com/public/images/012%E3%81%8A%E3%82%82%E3%81%A1%E3%82%83.jpg',
                'brand' => 'ノーブランド',
            ],
            [
                'user_id' => 4,
                'condition_id' => 1,
                'name' => '飲料水',
                'price' => 300,
                'comment' => '新品',
                'image_url' => 'https://flea-baket.s3.ap-northeast-1.amazonaws.com/public/images/013%E9%A3%B2%E6%96%99%E6%B0%B4.jpg',
                'brand' => 'ノーブランド',
            ],
            [
                'user_id' => 5,
                'condition_id' => 1,
                'name' => '洋菓子',
                'price' => 700,
                'comment' => '新品',
                'image_url' => 'https://flea-baket.s3.ap-northeast-1.amazonaws.com/public/images/014%E6%B4%8B%E8%8F%93%E5%AD%90.jpg',
                'brand' => 'ノーブランド',
            ],
            [
                'user_id' => 5,
                'condition_id' => 1,
                'name' => 'コーヒー',
                'price' => 1200,
                'comment' => '新品',
                'image_url' => 'https://flea-baket.s3.ap-northeast-1.amazonaws.com/public/images/015%E3%82%B3%E3%83%BC%E3%83%92%E3%83%BC.jpg',
                'brand' => 'ノーブランド',
            ],
            [
                'user_id' => 5,
                'condition_id' => 2,
                'name' => '不揃いトマト',
                'price' => 1000,
                'comment' => 'サイズ不均一',
                'image_url' => 'https://flea-baket.s3.ap-northeast-1.amazonaws.com/public/images/016%E4%B8%8D%E6%8F%83%E3%81%84%E3%83%88%E3%83%9E%E3%83%88.jpg',
                'brand' => 'ノーブランド',
            ],
            [
                'user_id' => 5,
                'condition_id' => 1,
                'name' => '洋菓子',
                'price' => 600,
                'comment' => '新品',
                'image_url' => 'https://flea-baket.s3.ap-northeast-1.amazonaws.com/public/images/017%E6%B4%8B%E8%8F%93%E5%AD%90.jpg',
                'brand' => 'ノーブランド',
            ],
            [
                'user_id' => 5,
                'condition_id' => 1,
                'name' => '洋菓子',
                'price' => 100,
                'comment' => '新品',
                'image_url' => 'https://flea-baket.s3.ap-northeast-1.amazonaws.com/public/images/018%E6%B4%8B%E8%8F%93%E5%AD%90.jpg',
                'brand' => 'ノーブランド',
            ],
            [
                'user_id' => 5,
                'condition_id' => 2,
                'name' => '訳ありスイカ',
                'price' => 1100,
                'comment' => 'サイズ不揃い',
                'image_url' => 'https://flea-baket.s3.ap-northeast-1.amazonaws.com/public/images/019%E8%A8%B3%E3%81%82%E3%82%8A%E3%82%B9%E3%82%A4%E3%82%AB.jpg',
                'brand' => 'ノーブランド',
            ],
            [
                'user_id' => 6,
                'condition_id' => 4,
                'name' => '小型犬服',
                'price' => 1100,
                'comment' => '汚れあり',
                'image_url' => 'https://flea-baket.s3.ap-northeast-1.amazonaws.com/public/images/020%E5%B0%8F%E5%9E%8B%E7%8A%AC%E6%9C%8D.jpg',
                'brand' => 'ノーブランド',
            ],
            [
                'user_id' => 6,
                'condition_id' => 1,
                'name' => '小型犬服',
                'price' => 2100,
                'comment' => '新品同様',
                'image_url' => 'https://flea-baket.s3.ap-northeast-1.amazonaws.com/public/images/021%E5%B0%8F%E5%9E%8B%E7%8A%AC%E6%9C%8D.jpg',
                'brand' => 'ノーブランド',
            ],
            [
                'user_id' => 6,
                'condition_id' => 3,
                'name' => 'ケージ小',
                'price' => 1000,
                'comment' => '普通',
                'image_url' => 'https://flea-baket.s3.ap-northeast-1.amazonaws.com/public/images/022%E3%82%B1%E3%83%BC%E3%82%B7%E3%82%99%E5%B0%8F.jpg',
                'brand' => 'ノーブランド',
            ],
            [
                'user_id' => 6,
                'condition_id' => 4,
                'name' => '鍋',
                'price' => 2100,
                'comment' => '使用感あり',
                'image_url' => 'https://flea-baket.s3.ap-northeast-1.amazonaws.com/public/images/023%E9%8D%8B.jpg',
                'brand' => 'ノーブランド',
            ],
            [
                'user_id' => 6,
                'condition_id' => 4,
                'name' => '包丁',
                'price' => 2600,
                'comment' => '使用感あり',
                'image_url' => 'https://flea-baket.s3.ap-northeast-1.amazonaws.com/public/images/024%E5%8C%85%E4%B8%81.jpg',
                'brand' => 'ノーブランド',
            ],
            [
                'user_id' => 6,
                'condition_id' => 1,
                'name' => 'シャンプー',
                'price' => 2500,
                'comment' => '新品',
                'image_url' => 'https://flea-baket.s3.ap-northeast-1.amazonaws.com/public/images/025%E3%82%B7%E3%83%A3%E3%83%B3%E3%83%95%E3%82%9A%E3%83%BC.jpg',
                'brand' => 'ノーブランド',
            ],
            [
                'user_id' => 7,
                'condition_id' => 1,
                'name' => '急須',
                'price' => 500,
                'comment' => '新品',
                'image_url' => 'https://flea-baket.s3.ap-northeast-1.amazonaws.com/public/images/026%E6%80%A5%E9%A0%88.jpg',
                'brand' => 'ノーブランド',
            ],
            [
                'user_id' => 7,
                'condition_id' => 3,
                'name' => '植物',
                'price' => 2500,
                'comment' => '痛みあり',
                'image_url' => 'https://flea-baket.s3.ap-northeast-1.amazonaws.com/public/images/027%E6%A4%8D%E7%89%A9.jpg',
                'brand' => 'ノーブランド',
            ],
            [
                'user_id' => 7,
                'condition_id' => 3,
                'name' => '植物',
                'price' => 2900,
                'comment' => '痛みあり',
                'image_url' => 'https://flea-baket.s3.ap-northeast-1.amazonaws.com/public/images/028%E6%A4%8D%E7%89%A9.jpg',
                'brand' => 'ノーブランド',
            ],
            [
                'user_id' => 7,
                'condition_id' => 3,
                'name' => '植物',
                'price' => 1300,
                'comment' => '痛みあり',
                'image_url' => 'https://flea-baket.s3.ap-northeast-1.amazonaws.com/public/images/029%E6%A4%8D%E7%89%A9.jpg',
                'brand' => 'ノーブランド',
            ],
            [
                'user_id' => 7,
                'condition_id' => 3,
                'name' => '行者ニンニク苗',
                'price' => 400,
                'comment' => '痛みあり',
                'image_url' => 'https://flea-baket.s3.ap-northeast-1.amazonaws.com/public/images/030%E8%A1%8C%E8%80%85%E3%83%8B%E3%83%B3%E3%83%8B%E3%82%AF%E8%8B%97.jpg',
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
