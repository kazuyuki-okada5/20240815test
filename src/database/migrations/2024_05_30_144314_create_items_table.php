<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('condition_id')->constrained('conditions');
            $table->string('name' , 255);
            $table->integer('price');
            $table->text('comment');
            $table->string('image_url' , 255);
            $table->string('brand' ,255);
            $table->foreignId('sold_user_id')->nullable()->constrained('users');
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
            // 外部キー制約を一時的に削除
        Schema::table('items', function (Blueprint $table) {
            $table->dropForeign(['condition_id']);
    });
        Schema::dropIfExists('items');
    }
}
