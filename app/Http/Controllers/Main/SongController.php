<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\SongGetter;
use App\Models\ongeki_song_list;

class SongController extends Controller {
    //
    public function __construct() {
        // Httpリクエストログ収集
        $this->middleware('CollectHttpRequest');
    }

    public function getSongDetail(SongGetter $request) {
        // sdvx.inのリンクを参照するため、難易度を認識する為の処理をする
        preg_match("/(?P<ID>\d+)(?P<DIFF>[el])*/", $request->id, $match);

        $song_id = $match["ID"];
        $song = ongeki_song_list::find($song_id);

        // フラグ指定なしだったらMasterを参照、ソレ以外はちゃんとそっち参照
        if (!empty($match["DIFF"])) {
            if ($match["DIFF"] == "l") $sdvx_in = $song->lunatic->sdvx_in;
            else if ($match["DIFF"] == "e") $sdvx_in = $song->expert->sdvx_in;
        } else
            $sdvx_in = $song->master->sdvx_in;


        return [
            "id" => $song->id,
            "jacket_src" => asset("storage/songs/jacket/{$song->id}.jpg"),
            "title" => $song->title,
            "ruby" => $song->ruby,
            "artist" => $song->artist,
            "date" => $song->date,
            "category" => $song->getCategoryName->category,
            "version" => $song->getVersionName->version,
            "sdvx_in" => $sdvx_in,
        ];
    }

    public function getSongData(SongGetter $request) {
        $song = ongeki_song_list::find($request->id);
        $difficults = ['master', 'expert', "advanced", "basic", 'lunatic'];
        $data = [];
        $data["detail"] = ["title" => $song->title];
        foreach ($difficults as $d) {
            $data[$d] = [
                "note" =>  empty($song->{$d}->notes) ? 0 : $song->{$d}->notes,
                "bell" =>  empty($song->{$d}->bells) ? 0 : $song->{$d}->bells,
                "const" => empty($song->{$d}->const) ? 0 : $song->{$d}->const,
            ];
        }
        return $data;
    }

    public function searchSongData(Request $request) {
        $keyword = $request->keywords;
        $lv = $request->lv;
        $data = [];
        $constRange = [
            "14" => ["min" => 14.0, "max" => 15.9],
            "13" => ["min" => 13.0, "max" => 13.9],
            "12" => ["min" => 12.0, "max" => 12.9],
            "11" => ["min" => 11.0, "max" => 11.9]
        ];

        // まず全楽曲リストからキーワードで一致する曲を探しだす
        $query = ongeki_song_list::query();
        $query->where(function ($query) use ($keyword) {
            $query->where("title", "LIKE", "%{$keyword}%")->orWhere("ruby", "LIKE", "%{$keyword}%");
        });

        foreach ($query->get()->all() as $q) {
            $f = false;
            if ($lv) {
                # 【重要】要改良 サーバーに負担かかるかも。
                // 定数表でレベル指定がある際の処理
                $difficult = ["master", "expert", "lunatic"];
                // 各難易度網羅して、定数内だったらフラグを立てる、ただそれだけ
                foreach ($difficult as $d) {
                    if (empty($q->{$d}->const)) continue;
                    $c = $q->{$d}->const;
                    if ($constRange[$lv]["min"] <= $c && $constRange[$lv]["max"] > $c) {
                        $f = true;
                        break;
                    }
                }
            } else $f = true;

            if (!$f) continue;
            $data[] = [
                "id" => $q->id,
                "title" => $q->title,
                "jacket_src" => asset("storage/songs/jacket/{$q->id}.jpg"),
            ];
        }
        return $data;
    }
}
