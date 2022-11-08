<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller {
    //
    public function mypage() {
        return view("welcome");
    }
}
