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
    // 曲のデータを変えたときのログ
    //public function up() {
    //    Schema::create('songs_manage_logs', function (Blueprint $table) {
    //        $table->id();
    //        $table->string("user")->comment("操作したユーザー");
    //        $table->enum("operation_type", ["ADD", "DELETED", "UPDATED", "CHANGE"])->comment("変更した種類");
    //        $table->timestamps();
    //    });
    //}

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    //public function down() {
    //    Schema::dropIfExists('songs_manage_logs');
    //}
};
