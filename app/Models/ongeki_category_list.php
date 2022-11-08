<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class ongeki_category_list extends Model {
    use HasFactory;
    protected $table = 'ongeki_category_list';
    public function song_detail() {
        return $this->belongsTo('App\Models\ongeki_song_list', "id");
    }
}
