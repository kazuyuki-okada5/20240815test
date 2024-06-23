<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('category' , 20);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // category_items テーブルが存在する場合、外部キー制約を削除します
        if (Schema::hasTable('category_items')) {
            Schema::table('category_items', function (Blueprint $table) {
                $table->dropForeign(['category_id']); // 外部キー制約を削除
            });

            Schema::dropIfExists('category_items');
        }

        Schema::dropIfExists('categories');
    }
}
