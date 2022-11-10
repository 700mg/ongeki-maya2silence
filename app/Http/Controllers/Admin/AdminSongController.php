<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ongeki_song_list;
use App\Models\ongeki_song_list_master;
use App\Models\ongeki_song_list_expert;
use App\Models\ongeki_song_list_advanced;
use App\Models\ongeki_song_list_basic;
use App\Models\ongeki_song_list_lunatic;
use App\Models\ongeki_version_list;
use App\Models\ongeki_category_list;

use App\Http\Requests\Admin\AdminSongRegist;
use App\Http\Requests\Admin\AdminSongUpdateDetail;
use App\Http\Requests\Admin\AdminSongUpdateDifficult;
use \App\Http\Requests\Admin\AdminSongDelete;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use \Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class AdminSongController extends Controller {
    //
    public function __construct() {
        $this->middleware('checkAdmin');
    }

    public function list() {
        $songs = ongeki_song_list::paginate(50);
        $versions = ongeki_version_list::get()->all();
        $categories = ongeki_category_list::get()->all();
        $searching = false;
        $status = [];

        foreach ($songs as $song) {
            $difficults = ['master', 'expert', 'lunatic'];
            $tmp = [];
            foreach ($difficults as $d) {
                if (empty($song->{$d}->notes) && empty($song->{$d}->bells) && empty($song->{$d}->const))
                    $tmp[$d] = "-";
                elseif ((empty($song->{$d}->notes) || empty($song->{$d}->bells)) && !empty($song->{$d}->const))
                    $tmp[$d] = "▲";
                elseif (!empty($song->{$d}->notes) && !empty($song->{$d}->bells) && empty($song->{$d}->const))
                    $tmp[$d] = "▼";
                elseif (!empty($song->{$d}->notes) && !empty($song->{$d}->bells) && !empty($song->{$d}->const))
                    $tmp[$d] = "○";
                else
                    $tmp[$d] = "?";
            }
            array_push($status, $tmp);
        }

        return view("admin.songs.list", compact("categories", "status", "searching"))->with(compact("songs", "versions"));
    }

    public function search(Request $request) {
        $searching = true;
        $searchKeywords = $request->input("keywords");
        $searchVersions = $request->input("version");
        $searchCategories = $request->input("category");
        $searchElements = $request->input("element");

        // 何も指定してなければ通常のページを表示させる
        if (is_null($searchKeywords) && is_null($searchVersions) && is_null($searchCategories) && is_null($searchElements)) {
            return redirect()->route('admin.songs.list');
        }

        $query = ongeki_song_list::query();

        $selected = [];
        if (!is_null($searchKeywords)) {
            $query->where(function ($query) use ($searchKeywords) {
                $query->where("title", "LIKE", "%{$searchKeywords}%")->orWhere("ruby", "LIKE", "%{$searchKeywords}%");
            });
            $selected["keyword"] = $searchKeywords;
        }
        if (!is_null($searchVersions)) {
            $query->whereIn("version", $searchVersions);
            $selected["version"] = $searchVersions;
        }
        if (!is_null($searchCategories)) {
            $query->whereIn("category", $searchCategories);
            $selected["category"] = $searchCategories;
        }
        if (!is_null($searchElements)) {
            foreach ($searchElements as $e)
                $query->where("enemy_element", $e == "na" ? NULL : $e);
            $selected["element"] = $searchElements;
        }

        // ビューを使いまわしてる為pagenate対策として100ぐらいに設定
        // 数が膨大になる可能性あるけど検索前提だし、pagenateだとpost維持できないから苦肉の策
        $searchResult = $query->paginate(100);
        $status = $this->checkSongStatus($searchResult);
        $versions = ongeki_version_list::get()->all();
        $categories = ongeki_category_list::get()->all();

        //dd($selected);

        return view("admin.songs.list", compact("versions", "categories", "searching"))
            ->with(["songs" => $searchResult, "status" => $status, "selected" => $selected]);
    }

    public function detail($id) {
        $detail = ongeki_song_list::where("id", $id)->firstOrFail();
        $versions = ongeki_version_list::get()->all();
        $categories = ongeki_category_list::get()->all();

        return view("admin.songs.detail", compact("detail", "versions", "categories"));
    }


    private function checkSongStatus($array) {
        $status = [];
        foreach ($array as $arr) {
            $difficults = ['master', 'expert', 'lunatic'];
            $tmp = [];
            foreach ($difficults as $d) {
                if (empty($arr->{$d}->notes) && empty($arr->{$d}->bells) && empty($arr->{$d}->const))
                    $tmp[$d] = "-";
                elseif ((empty($arr->{$d}->notes) || empty($arr->{$d}->bells)) && !empty($arr->{$d}->const))
                    $tmp[$d] = "▲";
                elseif (!empty($arr->{$d}->notes) && !empty($arr->{$d}->bells) && empty($arr->{$d}->const))
                    $tmp[$d] = "▼";
                elseif (!empty($arr->{$d}->notes) && !empty($arr->{$d}->bells) && !empty($arr->{$d}->const))
                    $tmp[$d] = "○";
                else
                    $tmp[$d] = "?";
            }
            array_push($status, $tmp);
        }
        return $status;
    }

    public function update_detail(AdminSongUpdateDetail $request) {
        //dd($request);
        $detail = ongeki_song_list::where("id", $request->id)->firstOrFail();
        $detail->title = $request->title;
        $detail->ruby = $request->ruby;
        $detail->artist = $request->artist;
        $detail->category = $request->category;
        $detail->version = $request->version;
        $detail->enemy_element = $request->element;
        $detail->enemy_level = $request->level;
        $detail->deleted = $request->deleted;
        // 画像が送信された際に保存
        if (!empty($request->file("jacket"))) {
            $folderPath = "public/songs/jacket/";
            $jpgName = "{$request->id}.jpg";
            $randName = uniqid() . ".jpg";
            $detail->jacket_old = $randName;
            // 既存のファイルをランダム文字列に改名後、バックアップフォルダに移動
            Storage::move($folderPath . $jpgName, $folderPath . "backup/" .  $randName);
            $request->file("jacket")->storeAs($folderPath, $jpgName);
        }
        $detail->save();
        return redirect()->route('admin.songs.detail', ['id' => $request->id])->with('success_detail', '正常に更新しました。');
    }

    public function update_difficult(AdminSongUpdateDifficult $request) {
        //dd($request);
        $detail = ongeki_song_list::where("id", $request->id)->firstOrFail();
        $difficults = ["master", "expert", "advanced", "basic", "lunatic"];
        foreach ($difficults as $d) {
            // 多分コレ以外にいい方法があると思う
            // 取り敢えず仮組みする
            if (empty($detail->{$d})) {
                $difficult = "";
                if ($d == "master") $difficult = new ongeki_song_list_master;
                elseif ($d == "expert") $difficult = new ongeki_song_list_expert;
                elseif ($d == "advanced") $difficult = new ongeki_song_list_advanced;
                elseif ($d == "basic") $difficult = new ongeki_song_list_basic;
                elseif ($d == "lunatic") $difficult = new ongeki_song_list_lunatic;

                $difficult->title = $detail->title;
                $difficult->song_id = $detail->song_id;
                $difficult->notes = $request->{$d}["notes"];
                $difficult->bells = $request->{$d}["bells"];
                $difficult->const = $request->{$d}["const"];
                $difficult->notes_before = $request->{$d}["noteA"];
                $difficult->notes_after = $request->{$d}["noteB"];
                $difficult->save();
            } else {
                $detail->{$d}->notes = $request->{$d}["notes"];
                $detail->{$d}->bells = $request->{$d}["bells"];
                $detail->{$d}->const = $request->{$d}["const"];
                $detail->{$d}->notes_before = $request->{$d}["noteA"];
                $detail->{$d}->notes_after = $request->{$d}["noteB"];
                $detail->{$d}->save();
            }
        }
        return redirect()->route('admin.songs.detail', ['id' => $request->id])->with('success_difficult', '正常に更新しました。');
    }

    public function regist_view() {
        $versions = ongeki_version_list::get()->all();
        $categories = ongeki_category_list::get()->all();
        return view("admin.songs.regist")->with(compact("versions", "categories"));
    }

    public function regist(AdminSongRegist $request) {
        // データベースに登録
        $detail = new ongeki_song_list;
        $detail->song_id = (string) Str::uuid();
        $detail->title = $request->title;
        $detail->ruby = $request->ruby;
        $detail->artist = $request->artist;
        $detail->category = $request->category;
        $detail->version = $request->version;
        $detail->enemy_level = $request->level;
        $detail->enemy_element = $request->element;
        $detail->save();

        // 画像を保存
        $song_detail = ongeki_song_list::orderBy('id', 'desc')->first();
        $folderPath = "public/songs/jacket/";
        $request->jacket()->storeAs($folderPath, "{$song_detail->id}.jpg");
        return redirect("admin/songs/regist/success")->with("song", $song_detail);
    }

    public function regist_success() {
        return view("admin.songs.regist_success");
    }

    public function jacket() {
        $songs = ongeki_song_list::where("deleted", NULL)->paginate(50);

        return view("admin.songs.jacket_list")->with(compact("songs"));
    }

    public function delete(AdminSongDelete $request) {
        try {
            $song = ongeki_song_list::where("song_id", $request->song_id)->firstOrFail();
            if (empty($song)) throw new \Exception("楽曲が見つかりませんでした");

            if (!empty($song->master)) $song->master->delete();
            if (!empty($song->expert)) $song->expert->delete();
            if (!empty($song->advanced)) $song->advanced->delete();
            if (!empty($song->basic)) $song->basic->delete();
            if (!empty($song->lunatic)) $song->lunatic->delete();

            if (empty($song->master) && empty($song->expert) && empty($song->advanced) && empty($song->basic) && empty($song->lunatic))
                $song->delete();
            else
                throw new \Exception("削除できませんでした");

            return redirect()->route("admin.songs.list")->with("success_message", "削除に成功しました");
        } catch (\Exception $err) {
            return redirect()->route("admin.songs.list")->with("error_message", $err->getMessage());
        }
    }
}
