<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CommentsTableSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // 対象のアイテムID
        $itemIds = [1, 2];
        // ユーザーIDごとに異なるコメント内容
        $comments = [
            1 => '使用感はありますか？',
            2 => '値下げ交渉可能ですか？',
            3 => '新品同様です。値下げは交渉は不可です.',
        ];

        // 各アイテムに対してコメントを追加
        foreach ($itemIds as $itemId) {
            foreach ($comments as $userId => $comment) {
                DB::table('comments')->insert([
                    'user_id' => $userId,
                    'item_id' => $itemId,
                    'comment' => $comment,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}




