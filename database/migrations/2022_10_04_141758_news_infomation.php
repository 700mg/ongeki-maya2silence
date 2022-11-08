<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        //
        Schema::create('news_infomation', function (Blueprint $table) {
            $table->id();
            $table->string("news_id")->unique()->comment("UUID");
            $table->integer('create_user')->comment("製作者ID");
            $table->integer("object")->comment("対象ツール");
            $table->string("label")->nullable()->comment("ラベル");
            $table->string("header")->nullable()->comment("見出し");
            $table->text("contents")->nullable()->comment("内容");
            $table->string("images")->nullable()->comment("画像");
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        //
        Schema::dropIfExists('news_information');
    }
};
