<?php

namespace App\Http\Controllers\Main;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Main\MypageRequest;

class MypageController extends Controller {
    //
    public function view() {
        $config = $this->existShareURL();
        return view("main.mypage.index", compact("config"));
    }

    private function existShareURL() {
        if (!$this->loadConfigFromServer()) {
            if (!$this->createConfigFile())
                return false;
        }
        return $this->loadConfigFromServer();
    }

    private function createConfigFile() {
        try {
            $user_id = Auth::user()->id;
            if (Storage::exists("userdata/savedata/{$user_id}/config.json"))
                throw new \Exception("既に存在します。");

            $user = json_decode(Storage::get("userdata/savedata/param_list.json"), true);

            // シェア用のパラメータ作成
            $param = (function () use ($user) {
                for (;;) {
                    $rand = substr(str_shuffle("ABCDEFGHJKLMNPQRSTUVWXYZabcdefghijkmnpqrstuvwxyz0123456789"), 0, 8);
                    if (!array_key_exists($rand, $user)) return $rand;
                }
            })();

            // パラメータリストに追加･保存
            $user[$param] = $user_id;
            Storage::put("userdata/savedata/param_list.json", json_encode($user, JSON_PRETTY_PRINT));

            $default = json_encode([
                "table_shareParam" => $param,   // シェア用のパラメータ
                "table_public" => false,        // 定数表の公開設定
                "osl_id" => ""                  // oslのid、いつか使う予定
            ], JSON_PRETTY_PRINT);

            Storage::put("userdata/savedata/{$user_id}/config.json", $default);
            if (!Storage::exists("userdata/savedata/{$user_id}/config.json"))
                throw new \Exception("ファイルが作成できませんでした");

            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function update(MypageRequest $request) {
        try {
            $user_id = Auth::user()->id;

            if (empty($user_id))
                throw new \Exception("ログインしてください!!!");
            if (!$config = $this->loadConfigFromServer()) {
                $this->createConfigFile();
                if (!$config = $this->loadConfigFromServer())
                    throw new \Exception("どうしようもないエラー");
            }

            if (!$this->saveConfigToServer($config, $request))
                throw new \Exception("保存に失敗しました");

            return redirect()->route("user.mypage")->with("success", "設定を保存しました");
        } catch (\Exception $e) {
            return redirect()->route("user.mypage")->with("error", $e->getMessage());
        }
    }

    private function loadConfigFromServer() {
        try {
            $user_id = Auth::user()->id;

            if (empty($user_id))
                throw new \Exception();
            if (!Storage::exists("userdata/savedata/{$user_id}/config.json"))
                throw new \Exception();

            return json_decode(Storage::get("userdata/savedata/{$user_id}/config.json"), true);
        } catch (\Exception $err) {
            return false;
        }
    }

    private function saveConfigToServer($config, $request) {
        try {
            $user_id = Auth::user()->id;

            $c = json_encode([
                "table_shareParam" => $config["table_shareParam"],
                "table_public" => empty($request->input('table_public')) ? false : true,
                "osl_id" => $request->input('osl_id'),
            ], JSON_PRETTY_PRINT);

            Storage::put("userdata/savedata/{$user_id}/config.json", $c);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
}
