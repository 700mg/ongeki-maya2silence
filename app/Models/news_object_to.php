<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class news_object_to extends Model {
    use HasFactory;
    protected $table = 'news_object_to';

    public function getObject() {
        return $this->belongsTo('App\Models\news_infomation', "id");
    }
}
