<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccessLog extends Model {
    use HasFactory;
    protected $table = 'accesslog_main';
    //
    protected static function boot() {
        parent::boot();
        static::saving(function (Model $model) {
            if (auth()) {
                $model->user_id = auth()->id();
            }
        });
    }
}
