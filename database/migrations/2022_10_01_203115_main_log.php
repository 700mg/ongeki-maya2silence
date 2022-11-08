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
        // 純粋なツールへのアクセスログを収集するDB
        Schema::create('accesslog_main', function (Blueprint $table) {
            $table->id();
            $table->string("to")->nullable()->comment("アクセス先");
            $table->string("param")->nullable()->comment("パラメーター");
            $table->string("user_id")->nullable()->comment("ユーザーID");
            $table->string("ip_addr")->nullable()->comment("IPアドレス");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        //
        Schema::dropIfExists('accesslog_main');
    }
};
