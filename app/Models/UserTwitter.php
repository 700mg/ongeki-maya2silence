<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserTwitter extends Model {
    use HasFactory;
    protected $table = 'users_twitter';

    public function user() {
        return $this->belongsTo('App\Models\User', "twitter");

    }
}
