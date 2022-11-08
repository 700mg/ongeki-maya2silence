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
        Schema::create('http_requests', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->char('name', 255);
            $table->char('method', 10);
            $table->char('path', 255);
            $table->char('ip_addr', 255);
            $table->json('data')->comment("通信されたデータ");
            $table->integer('milliseconds')->comment("処理速度");
            $table->integer('user_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('http_requests');
    }
};
