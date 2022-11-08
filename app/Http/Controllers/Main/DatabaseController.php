<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\ongeki_song_list;
use App\Models\ongeki_version_list;
use App\Models\ongeki_category_list;

class DatabaseController extends Controller {
    //
    public function __construct() {
        // Httpリクエストログ収集
        $this->middleware('CollectHttpRequest');
    }

    public function list() {
        $songs = ongeki_song_list::paginate(50);
        $versions = ongeki_version_list::get()->all();
        $categories = ongeki_category_list::get()->all();
        $searching = false;

        return view("main.database.list", compact("categories", "songs", "versions"))->with(compact("searching"));
    }

    public function search(Request $request) {
        $searching = true;
        $searchKeywords = $request->input("keywords");
        $searchVersions = $request->input("version");
        $searchCategories = $request->input("category");
        $searchElements = $request->input("element");

        // 何も指定してなければ通常のページを表示させる
        if (is_null($searchKeywords) && is_null($searchVersions) && is_null($searchCategories) && is_null($searchElements)) {
            return redirect()->route('database.list');
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
        $songs = $query->paginate(100);
        $versions = ongeki_version_list::get()->all();
        $categories = ongeki_category_list::get()->all();

        return view("main.database.list", compact("songs", "categories",  "versions"))->with(compact("searching", "selected"));
    }

    public function songData($id) {
        $song = ongeki_song_list::where("id", $id)->firstOrFail();
        return view("main.database.song", compact("song"));
    }
}
