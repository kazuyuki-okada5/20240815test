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
                'img_url' => 'https://flea-baket.s3.ap-northeast-1.amazonaws.com/public/profiles/%E3%82%B9%E3%82%AF%E3%83%AA%E3%83%BC%E3%83%B3%E3%82%B7%E3%83%A7%E3%83%83%E3%83%88+2024-06-16+11.47.26.png',
                'post_code' => 1234567,
                'address' => '東京都',
                'building' => 'Example Building',
            ],
            [
                'user_id' => 3,
                'img_url' => 'https://flea-baket.s3.ap-northeast-1.amazonaws.com/public/profiles/%E3%82%B9%E3%82%AF%E3%83%AA%E3%83%BC%E3%83%B3%E3%82%B7%E3%83%A7%E3%83%83%E3%83%88+2024-06-16+11.49.28.png',
                'post_code' => 1234567,
                'address' => '大阪府',
                'building' => 'Example Building',
            ],
            [
                'user_id' => 4,
                'img_url' => 'https://flea-baket.s3.ap-northeast-1.amazonaws.com/public/profiles/%E3%82%B9%E3%82%AF%E3%83%AA%E3%83%BC%E3%83%B3%E3%82%B7%E3%83%A7%E3%83%83%E3%83%88+2024-06-16+11.42.23.png',
                'post_code' => 1234567,
                'address' => '沖縄県',
                'building' => 'Example Building',
            ],
        ]);
    }
}
