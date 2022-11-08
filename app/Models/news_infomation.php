<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class news_infomation extends Model {
    use HasFactory;
    protected $table = 'news_infomation';

    public function getUser() {
        return $this->hasOne(User::class);
    }

    public function getObject() {
        return $this->hasOne('App\Models\news_object_to', "id", "object");
    }
}
