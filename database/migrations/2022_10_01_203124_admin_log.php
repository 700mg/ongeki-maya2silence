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
        Schema::create('admin_log', function (Blueprint $table) {
            $table->id();
            $table->integer('type')->comment("");               // アクセスとかログインとか... 種別?
            $table->string("url")->nullable()->comment("");     // アクセス先
            $table->string("user")->nullable()->comment("");    // ログインしていたらユーザーID
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
        Schema::dropIfExists('admin_log');
    }
};
