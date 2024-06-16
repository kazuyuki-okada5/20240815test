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
            'user_id' => 1,
            'img_url' => '/profiles/スクリーンショット 2024-06-16 11.42.23.png',
            'post_code' => 1234567,
            'address' => 'Tokyo',
            'building' => 'Example Building',
        ]);
    }
}
