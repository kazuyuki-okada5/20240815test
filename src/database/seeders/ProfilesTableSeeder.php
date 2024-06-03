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
            'img_url' => 'example.jpg',
            'post_code' => 1234567,
            'address' => 'Tokyo',
            'building' => 'Example Building',
        ]);
    }
}
