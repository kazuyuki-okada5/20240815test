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
        Profile::create([
            'user_id' => 3,
            'img_url' => '/profiles/1719109715_スクリーンショット 2024-06-16 11.47.26.png',
            'post_code' => 1234567,
            'address' => 'Tokyo',
            'building' => 'Example Building',
        ]);
    }
}
