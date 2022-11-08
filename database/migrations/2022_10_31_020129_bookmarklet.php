<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        //
        Schema::create('bookmarklet', function (Blueprint $table) {
            $table->id();
            $table->string("bookmarklet_id")->unique()->comment("UUID");
            $table->integer('create_user')->comment("製作者ID");
            $table->string("header")->nullable()->comment("見出し");
            $table->text("contents")->nullable()->comment("内容");
            $table->string("images")->nullable()->comment("内容");
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
        Schema::dropIfExists('bookmarklet');
    }
};
