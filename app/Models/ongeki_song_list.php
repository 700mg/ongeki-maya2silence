<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ongeki_song_list extends Model {
    use HasFactory;
    protected $table = 'ongeki_song_list';

    // 各テーブルのリレーション
    public function getVersionName() {
        return $this->hasOne("App\Models\ongeki_version_list", "id", "version");
    }
    public function getCategoryName() {
        return $this->hasOne("App\Models\ongeki_category_list", "id", "category");
    }

    public function lunatic() {
        return $this->hasOne("App\Models\ongeki_song_list_lunatic", "song_id", "song_id");
    }
    public function master() {
        return $this->hasOne("App\Models\ongeki_song_list_master", "song_id", "song_id");
    }
    public function expert() {
        return $this->hasOne("App\Models\ongeki_song_list_expert", "song_id", "song_id");
    }
    public function advanced() {
        return $this->hasOne("App\Models\ongeki_song_list_advanced", "song_id", "song_id");
    }
    public function basic() {
        return $this->hasOne("App\Models\ongeki_song_list_basic", "song_id", "song_id");
    }
}
