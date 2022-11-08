<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;

class AdminUserManager extends Controller {
    //
    public function viewList() {
        $users = User::paginate(50);
        return view("admin.user.list", compact("users"));
    }

    public function viewListAdmin() {
        $users = User::where("admin", 1)->paginate(50);
        return view("admin.user.admin", compact("users"));
    }
}
