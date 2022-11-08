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
        Schema::create('ongeki_song_list', function (Blueprint $table) {
            $table->id();
            $table->uuid("song_id")->unique();
            $table->string("title");
            $table->string("ruby")->nullable();
            $table->string("artist")->nullable();
            $table->integer("category")->nullable();
            $table->integer("version")->nullable();
            $table->integer("enemy_level")->nullable();
            $table->string('enemy_element')->nullable();
            $table->boolean('deleted')->nullable();
            $table->string('jacket_old')->nullable();
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
        });
        Schema::create('ongeki_song_list_basic', function (Blueprint $table) {
            $table->id();
            $table->uuid("song_id")->unique();
            $table->string("title");
            $table->integer("notes")->nullable();
            $table->integer('bells')->nullable();
            $table->float("const", 3, 1)->nullable();
            $table->integer('notes_before')->nullable();
            $table->integer('notes_after')->nullable();
            $table->string("sdvx_in")->nullable();
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
        });
        Schema::create('ongeki_song_list_advanced', function (Blueprint $table) {
            $table->id();
            $table->uuid("song_id")->unique();
            $table->string("title");
            $table->integer("notes")->nullable();
            $table->integer('bells')->nullable();
            $table->float("const", 3, 1)->nullable();
            $table->integer('notes_before')->nullable();
            $table->integer('notes_after')->nullable();
            $table->string("sdvx_in")->nullable();
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
        });
        Schema::create('ongeki_song_list_expert', function (Blueprint $table) {
            $table->id();
            $table->uuid("song_id")->unique();
            $table->string("title");
            $table->integer("notes")->nullable();
            $table->integer('bells')->nullable();
            $table->float("const", 3, 1)->nullable();
            $table->integer('notes_before')->nullable();
            $table->integer('notes_after')->nullable();
            $table->string("sdvx_in")->nullable();
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
        });
        Schema::create('ongeki_song_list_master', function (Blueprint $table) {
            $table->id();
            $table->uuid("song_id")->unique();
            $table->string("title");
            $table->integer("notes")->nullable();
            $table->integer('bells')->nullable();
            $table->float("const", 3, 1)->nullable();
            $table->integer('notes_before')->nullable();
            $table->integer('notes_after')->nullable();
            $table->string("sdvx_in")->nullable();
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
        });
        Schema::create('ongeki_song_list_lunatic', function (Blueprint $table) {
            $table->id();
            $table->uuid("song_id")->unique();
            $table->string("title");
            $table->integer("notes")->nullable();
            $table->integer('bells')->nullable();
            $table->float("const", 3, 1)->nullable();
            $table->integer('notes_before')->nullable();
            $table->integer('notes_after')->nullable();
            $table->string("sdvx_in")->nullable();
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
        });
        Schema::create('ongeki_version_list', function (Blueprint $table) {
            $table->integer("id");
            $table->string('version');
        });
        Schema::create('ongeki_category_list', function (Blueprint $table) {
            $table->integer("id");
            $table->string('category');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
    }
};
