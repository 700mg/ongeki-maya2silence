<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use App\Models\User;

class OwnerUserController extends Controller {
    //
    public function list() {
        $users = User::paginate(50);
        return view("admin.user.list", compact("users"));
    }

    public function detail($id) {
        $user = User::where("id", $id)->firstOrFail();
        try {
            $user_id = $id;

            if (empty($user_id))
                throw new \Exception();
            if (!Storage::exists("userdata/savedata/{$user_id}/config.json"))
                throw new \Exception();

            $config = json_decode(Storage::get("userdata/savedata/{$user_id}/config.json"), true);
        } catch (\Exception $err) {
            $config = [];
        }

        return view("admin.user.detail", compact("user", "config"));
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

    public function confUpdate(Request $request, $id) {
        try {
            // まあ念の為
            if (empty($id) || empty($request->input("userid")))
                throw new \Exception("UserID is Empty");
            if ($id != $request->input("userid"))
                throw new \Exception("UserID Invalid");

            $user_id = $id;
            if (!Storage::exists("userdata/savedata/{$user_id}/config.json"))
                throw new \Exception();

            $config = json_decode(Storage::get("userdata/savedata/{$user_id}/config.json"), true);
            $config["table_public"] = $request->input("table_public") == "1" ? true : false;

            if ($config["table_shareParam"] != $request->input("table_shareParam")) {
                if (!Storage::exists("userdata/savedata/param_list.json"))
                    $user = [];
                else
                    $user = json_decode(Storage::get("userdata/savedata/param_list.json"), true);

                if (array_key_exists((string)$config["table_shareParam"], $user))
                    unset($user[$config["table_shareParam"]]);

                $user[$request->input("table_shareParam")] = (int)$user_id;
                Storage::put("userdata/savedata/param_list.json", json_encode($user, JSON_PRETTY_PRINT));
                $config["table_shareParam"] = $request->input("table_shareParam");
            }

            Storage::put("userdata/savedata/{$user_id}/config.json", json_encode($config, JSON_PRETTY_PRINT));
            return redirect()->route('admin.user.detail', $id)->with('success_detail', '正常に更新しました。');
        } catch (\Exception $err) {
            return redirect()->route('admin.user.detail', $id)->with('error_detail', $err->getMessage());
        }
    }

    public function viewListAdmin() {
        $users = User::where("admin", 1)->paginate(50);
        return view("admin.user.admin", compact("users"));
    }
}
