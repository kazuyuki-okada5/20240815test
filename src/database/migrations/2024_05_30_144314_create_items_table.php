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
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('condition_id')->constrained('conditions')->onDelete('cascade');
            $table->string('name', 50);
            $table->unsignedBigInteger('price');
            $table->text('comment');
            $table->string('image_url', 255);
            $table->string('brand', 50)->nullable();
            $table->foreignId('sold_user_id')->nullable()->constrained('users')->onDelete('set null');
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
            $table->dropForeign(['user_id']);
            $table->dropForeign(['condition_id']);
            $table->dropForeign(['sold_user_id']);
        });

        Schema::dropIfExists('items');
    }
}
