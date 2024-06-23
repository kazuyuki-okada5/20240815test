<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PaymentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $payments = [
            ['payment' => 'クレジットカード'],
            ['payment' => 'コンビニ決済'],
            ['payment' => '銀行振込'],
        ];
        DB::table('payments')->insert($payments);
    }
}
