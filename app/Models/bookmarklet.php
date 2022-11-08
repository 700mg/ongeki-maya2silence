<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class bookmarklet extends Model
{
    use HasFactory;
    protected $table = 'bookmarklet';

    public function getUser() {
        return $this->hasOne(User::class);
    }
}
