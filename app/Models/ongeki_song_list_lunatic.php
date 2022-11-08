<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ongeki_song_list_lunatic extends Model {
    use HasFactory;
    protected $table = 'ongeki_song_list_lunatic';

    public function song_detail() {
        return $this->belongsTo('App\Models\ongeki_song_list', "song_id", "song_id");
    }
}
