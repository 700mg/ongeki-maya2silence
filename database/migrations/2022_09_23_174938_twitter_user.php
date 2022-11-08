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
        Schema::create('users_twitter', function (Blueprint $table) {
            $table->id();
            $table->string('userid')->unique();
            $table->string('name')->nullable();
            $table->string('nickname')->nullable();
            $table->string("avatar")->nullable();
            $table->string('email')->nullable();
            $table->string('token')->nullable();
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
        Schema::dropIfExists('users_twitter');
    }
};
