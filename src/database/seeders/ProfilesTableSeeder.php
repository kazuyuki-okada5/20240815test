<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Profile;

class ProfilesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Profile::insert([
            [
                'user_id' => 1,
                'img_url' => 'https://flea-baket.s3.ap-northeast-1.amazonaws.com/public/images/seederes/%E3%83%95%E3%82%9A%E3%83%AD%E3%83%95%E3%82%A3%E3%83%BC%E3%83%AB001.jpg',
                'post_code' => 1234567,
                'address' => '東京都',
                'building' => 'Example Building',
            ],
            [
                'user_id' => 3,
                'img_url' => 'https://flea-baket.s3.ap-northeast-1.amazonaws.com/public/images/seederes/%E3%83%95%E3%82%9A%E3%83%AD%E3%83%95%E3%82%A3%E3%83%BC%E3%83%AB002.jpg',
                'post_code' => 1234567,
                'address' => '大阪府',
                'building' => 'Example Building',
            ],
            [
                'user_id' => 4,
                'img_url' => 'https://flea-baket.s3.ap-northeast-1.amazonaws.com/public/images/seederes/%E3%83%95%E3%82%9A%E3%83%AD%E3%83%95%E3%82%A3%E3%83%BC%E3%83%AB001.jpg',
                'post_code' => 1234567,
                'address' => '沖縄県',
                'building' => 'Example Building',
            ],
        ]);
    }
}
