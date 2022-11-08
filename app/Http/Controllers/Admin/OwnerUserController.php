<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\User;

class OwnerUserController extends Controller {
    //
    public function list() {
        $users = User::paginate(50);
        return view("admin.user.list", compact("users"));
    }

    public function detail($id) {
        $user = User::where("id", $id)->firstOrFail();
        return view("admin.user.detail", compact("user"));
    }

    public function update(Request $request) {
        $_id = $request->id;
        $_admin = $request->admin == "1" ? "1" : "0";
        $_owner = $request->owner == "1" ? "1" : "0";

        $user = User::where("id", $_id)->firstOrFail();
        $user->admin = $_admin;
        $user->owner = $_owner;
        $user->save();

        return redirect()->route('admin.user.detail', $_id)->with('success_detail', '正常に更新しました。');
    }

    public function viewListAdmin() {
        $users = User::where("admin", 1)->paginate(50);
        return view("admin.user.admin", compact("users"));
    }
}
