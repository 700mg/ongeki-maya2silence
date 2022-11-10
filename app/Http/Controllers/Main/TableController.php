<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use App\Models\User;
use App\Models\ongeki_song_list;
use App\Models\ongeki_song_list_master;
use App\Models\ongeki_song_list_expert;
use App\Models\ongeki_song_list_advanced;
use App\Models\ongeki_song_list_lunatic;
use App\Models\ongeki_category_list;
use App\Models\ongeki_version_list;

use App\Models\news_infomation;

class TableController extends Controller {
    //
    public function __construct() {
        // Httpリクエストログ収集
        $this->middleware('CollectHttpRequest');
    }

    public function index($lv) {
        $param = request("share");

        if (!empty($param))
            $shareData = $this->getShareData($param, $lv);
        else $shareData = "";

        $song = [];
        $constRange = [
            "14" => ["min" => 14.0, "max" => 15.9],
            "13" => ["min" => 13.0, "max" => 13.9],
            "12" => ["min" => 12.0, "max" => 12.9],
            "11" => ["min" => 11.0, "max" => 11.9]
        ];

        $master = ongeki_song_list_master::whereBetween("const", [$constRange[$lv]["min"], $constRange[$lv]["max"]])->get();
        $expert = ongeki_song_list_expert::whereBetween("const", [$constRange[$lv]["min"], $constRange[$lv]["max"]])->get();
        $advanced = ongeki_song_list_advanced::whereBetween("const", [$constRange[$lv]["min"], $constRange[$lv]["max"]])->get();
        $lunatic = ongeki_song_list_lunatic::whereBetween("const", [$constRange[$lv]["min"], $constRange[$lv]["max"]])->get();

        $news = news_infomation::where("object", "1")->orWhere("object", "2")->orderBy('created_at', 'DESC')->take(5)->get();

        foreach ($master as $e)
            if (!$this->organizedSong($e, "master")) continue;
            else $song[] = $this->organizedSong($e, "master");

        foreach ($expert as $e)
            if (!$this->organizedSong($e, "expert")) continue;
            else $song[] = $this->organizedSong($e, "expert");

        foreach ($advanced as $e)
            if (!$this->organizedSong($e, "advanced")) continue;
            else $song[] = $this->organizedSong($e, "advanced");

        foreach ($lunatic as $e)
            if (!$this->organizedSong($e, "lunatic")) continue;
            else $song[] = $this->organizedSong($e, "lunatic");

        return view("main.table.index")->with([
            "lv" => $lv,
            "song" => $song,
            "const" => $constRange[$lv],
            "version" => ongeki_version_list::get()->all(),
            "news" => $news,
        ])->with($shareData);
    }

    private function getShareData($param, $lv) {
        try {
            // 念の為URLとかが紐付いてるリストがあるか確認
            if (!Storage::exists("userdata/savedata/param_list.json"))
                throw new \Exception("Err:0001");

            // 読み込み
            $js = json_decode(Storage::get("userdata/savedata/param_list.json"));
            if (!property_exists($js, $param))
                throw new \Exception("データが見つからないか、非公開のユーザーです。");

            // ユーザーデータ読み込み
            if (!Storage::exists("userdata/savedata/{$js->$param}/config.json"))
                throw new \Exception("設定ファイルが見つかりませんでした");

            // 公開設定を確認
            $user_config = json_decode(Storage::get("userdata/savedata/{$js->$param}/config.json"), true);
            if (!array_key_exists("table_public", $user_config) || !$user_config["table_public"])
                throw new \Exception("データが見つからないか、非公開のユーザーです。");

            // 読み込み
            if (!Storage::exists("userdata/savedata/{$js->$param}/table/{$lv}.json"))
                throw new \Exception("Err:0001");
            $user_data = Storage::get("userdata/savedata/{$js->$param}/table/{$lv}.json");

            $user_name = User::find($js->$param)->name;
            $response = "{$user_name} さんのデータを読み込みました。誤って保存しないよう注意してください。";

            return ["data" => $user_data, "success" => $response];
        } catch (\Exception $e) {
            //dd($e->getMessage());
            return ["error" => $e->getMessage()];
        }
    }

    public function param_invalid() {
        return view("main.table.no_spesicy");
    }

    private function organizedSong($element, $diffucult) {
        try {
            $songDetail = ongeki_song_list::where("song_id", $element->song_id)->first();
            if (empty($songDetail) || ($songDetail->deleted == "1")) throw new \Exception();
            return [
                "title" => $songDetail->title,
                "index" => $songDetail->id,
                "const" => $element->const,
                "difficult" => $diffucult,
                "category" => ongeki_category_list::find($songDetail->category)->category,
                "version" => ongeki_version_list::find($songDetail->version)->version
            ];
        } catch (\Exception $err) {
            return false;
        }
    }

    public function exportImage(Request $request) {
        try {
            // チェック用のパラメータ
            $value = explode(",", $request->value);
            $flag = empty($value) ? [] : (function ($value) {
                $arr = [];
                foreach ($value as $v) {
                    preg_match("/(?P<SID>[0-9a-f]+)+(?P<FLAG>[A-D])/", $v, $match);
                    $arr[$match["SID"]] = $match["FLAG"];
                }
                return $arr;
            })($value);
            // 出力表
            $table_type = empty($request->type) ? throw new \Exception("Table type was not specified.") : $request->type;
            // 定数幅
            $const_max = empty($request->max) ? throw new \Exception("Const range(Max) was not specified.") : $request->max;
            $const_min = empty($request->min) ? throw new \Exception("Const range(Min) was not specified.") : $request->min;

            if ($const_min > $const_max) throw new \Exception("Invalid Const range.");

            $index_ver = 'version: 1.1';

            $songs = [];

            $master = ongeki_song_list_master::whereBetween("const", [$const_min, $const_max])->get();
            $expert = ongeki_song_list_expert::whereBetween("const", [$const_min, $const_max])->get();
            $lunatic = ongeki_song_list_lunatic::whereBetween("const", [$const_min, $const_max])->get();

            foreach ($master as $e) $songs[] = $this->organizedSong($e, "master");
            foreach ($expert as $e) $songs[] = $this->organizedSong($e, "expert");
            foreach ($lunatic as $e) $songs[] = $this->organizedSong($e, "lunatic");

            return view("main.table.export")->with(compact("index_ver", "songs", "flag", "const_max", "const_min", "table_type"));
        } catch (\Exception $e) {
            return abort(400, $e->getMessage());
        }
    }

    public function fetchToOSL(Request $request) {
        $time_start = microtime(true);  // 処理時間計測開始
        try {
            $user_id = $request->value;
            $downloadURL = sprintf("https://ongeki-score.net/user/%s/technical", $user_id);
            $ch = curl_init($downloadURL);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
            $URLdata = curl_exec($ch);

            // ページにアクセスできないときエラー
            if (!$URLdata) throw new \Exception("ongeki-score.netにアクセスできません");

            $header = curl_getinfo($ch);
            curl_close($ch);
            $u_header = $URLdata ? $header['http_code'] : false;

            // 4xx か 5xx でエラー
            if (preg_match("/^[45]..$/", $u_header))
                throw new \Exception(sprintf("ダウンロードできませんでした (ID:%s)", empty($user_id) ? "NULL" : $user_id));

            $URLdata = mb_convert_encoding($URLdata, 'HTML-ENTITIES', 'auto');

            $HTMLdom = new \DOMDocument;
            @$HTMLdom->loadHTML($URLdata);
            $xpath = new \DOMXPath($HTMLdom);

            // データがあるかチェック
            $data_isset = $xpath->query("/html/body/main/div[1]/div[2]")->item(0);
            if ($data_isset !== NULL) throw new \Exception("楽曲データが登録されていません");

            // ユーザー名を取得
            $u_name = $xpath->query("//html/body/main/div[1]/article[1]/table/tbody/tr[1]/td")->item(0)->nodeValue;
            // フレンドコードを取得
            $u_code = $xpath->query("//html/body/main/div[1]/article[1]/table/tbody/tr[8]/td")->item(0)->nodeValue;

            // テーブルリストを取得
            $u_s_list = $xpath->query("//*[@id='sort_table']/table/tbody/tr");
            $u_s_arr = [];

            // テーブルから全曲のリストをぶっこ抜く
            foreach ($u_s_list as $a) {

                $u_s_title = $a->childNodes->item(1)->firstChild->nodeValue;
                $u_s_diff =  $a->childNodes->item(3)->lastChild->nodeValue;
                $u_s_level = (int)str_replace("+", "", $a->childNodes->item(5)->nodeValue);
                $u_s_score = $a->childNodes->item(9)->firstChild->nodeValue;
                $u_s_url = $a->childNodes->item(1)->childNodes->item(1)->getAttribute("href");
                $u_s_lamp = $a->childNodes->item(7)->firstChild->nodeValue;

                if ($u_s_level < 11) continue;
                if ($u_s_score == 0) continue;

                $u_s_title = (mb_strpos($u_s_title, "Singularity") === false) ? $u_s_title : $this->check_Singularity($u_s_url);
                if ($u_s_level == 15) $u_s_level = 14;

                $t_array = array(
                    "title" => $u_s_title,
                    "level" => $u_s_level,
                    "difficult" => $u_s_diff,
                    "score" => $u_s_score,
                    "lamp" => $u_s_lamp
                );
                array_push($u_s_arr, $t_array);
            }

            // 保存する内容を配列でまとめる
            $j_array = [
                "username" => $u_name,
                "usercode" => $u_code,
                "osl" => $user_id,
                "get" => date("Y/m/d H:i:s"),
                "data" => $u_s_arr
            ];

            // jsonで保存する
            $e_j = json_encode($j_array, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
            Storage::put("userdata/osl/u-{$user_id}.json", $e_j);

            // 気休めにsuccessを返しておく
            header("HTTP/1.1 200 OK");
            echo json_encode([
                "status" => "success",
                "userid" => $user_id,
                "execTime" => number_format(microtime(true) - $time_start, 2) . "s",
            ]);
        } catch (\Exception $err) {
            abort(400, $err->getMessage());
        }
        return;
    }

    public function fillFromOSL(Request $request) {
        $time_start = microtime(true);  // 処理時間計測開始
        try {
            $user_id = $request->id;
            $lv = $request->lv;
            $result = [];

            // 各種チェック
            if (empty($user_id))
                throw new \Exception("IDが空っぽです!!");
            if (empty($lv))
                throw new \Exception("LVが指定されてませんです!!");
            if (empty($request->target))
                throw new \Exception("塗りつぶす条件が指定されていません!!");

            // 目標スコア取得
            foreach ($request->target as $key => $t) {
                // 1=FB 2=FC 3=FB+FC 4=AB 5=FC+FB+AB
                $targets[] = [
                    "color" => $key,
                    "value" => $t["value"],
                    "lamp" => $t["lamp"],
                ];
            }

            // やりやすいようにスコア順にソート
            $ids = array_column($targets, "value");
            array_multisort($ids, SORT_DESC, $targets);

            $datafile = Storage::get("userdata/osl/u-{$user_id}.json");
            if (empty($datafile))
                throw new \Exception("データが見つかりませんでした💢");

            $data_json = json_decode($datafile, true);

            // 削除曲のリストを配列で取得
            $deleted = array_map(function ($e) {
                return $e["title"];
            }, ongeki_song_list::where("deleted", 1)->get(["title"])->toArray());

            // 比較
            foreach ($data_json["data"] as $idx => $data) {
                // 検索対象レベルかチェック
                if ($data["level"] != $lv) continue;
                // 削除曲じゃないかチェック
                if (in_array($data["title"], $deleted)) continue;

                foreach ($targets as $key => $target) {
                    // lampの設定確認
                    if ($target["lamp"] != "0") {
                        if ($data["lamp"] == "5") $data["lamp"] = 7;
                        $tm = decbin($data["lamp"]) & decbin($target["lamp"]);
                        if ($tm != decbin($target["lamp"])) continue;
                    }
                    if ($key == 0) {
                        if ($data["score"] >= $target["value"]) {
                            $difficult_flag = ($data["difficult"] == "Exp") ? "e" : (($data["difficult"] == "Lun") ? "l" : "");
                            $result[$target["color"]][] = $this->getSongId($data["title"]) . $difficult_flag;
                            break;
                        }
                    } else {
                        if ($data["score"] < $targets[$key - 1]["value"] && $data["score"] >= $target["value"]) {
                            $difficult_flag = ($data["difficult"] == "Exp") ? "e" : (($data["difficult"] == "Lun") ? "l" : "");
                            $result[$target["color"]][] = $this->getSongId($data["title"]) . $difficult_flag;
                            break;
                        }
                    }
                }
            }
            header("HTTP/1.1 200 OK");
            echo json_encode([
                "status" => "success",
                "data" => $result,
                "execTime" => number_format(microtime(true) - $time_start, 3) . "s",
            ]);
        } catch (\Exception $err) {
            abort(503, $err->getMessage());
        }
        return;
    }

    public function saveCheckToServer(Request $request) {
        try {
            $user_id = Auth::user()->id;
            $lv = $request->lv;
            $js = json_encode($request->value);

            if (empty($user_id))
                throw new \Exception("ログインしてください!!!");
            if (empty($lv))
                throw new \Exception("Lvが指定されてません!!");

            Storage::put("userdata/savedata/{$user_id}/table/{$lv}.json", $js);
            if (!Storage::exists("userdata/savedata/{$user_id}/table/{$lv}.json"))
                throw new \Exception("ファイルが作成できませんでした");

            echo json_encode([
                "status" => "success",
                "message" => "保存しました。"
            ]);
        } catch (\Exception $err) {
            abort(503, $err->getMessage());
        }
    }

    public function loadCheckFromServer(Request $request) {
        try {
            $user_id = Auth::user()->id;
            $lv = $request->lv;

            if (empty($user_id))
                throw new \Exception("ログインしてください!!!");
            if (empty($lv))
                throw new \Exception("Lvが指定されてません!!");

            $js = Storage::get("userdata/savedata/{$user_id}/table/{$lv}.json");
            if (!Storage::exists("userdata/savedata/{$user_id}/table/{$lv}.json"))
                throw new \Exception("ファイルが見つかりませんでした");

            echo json_encode([
                "status" => "success",
                "message" => "読み込みました。",
                "data" => $js,
            ]);
        } catch (\Exception $err) {
            abort(503, $err->getMessage());
        }
    }

    private function getSongId(string $title) {
        $song = ongeki_song_list::where("title", $title)->first();
        return empty($song->id) ? $title : $song->id;
    }

    private function check_Singularity($url) {
        preg_match("/music\/[0-9]+/", $url, $str);
        $url_num = str_replace("music/", "", $str)[0];

        if ($url_num == "362") return "Singularity";
        else if ($url_num == "425") return "Singularity - ETIA.";
        else if ($url_num == "487") return "Singularity - SEGA SOUND STAFF「セガNET麻雀 MJ」";
        else return "Unknown Singularity";
    }
}
