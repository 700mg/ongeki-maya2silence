<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

use App\Models\ongeki_song_list;
use App\Models\ongeki_song_list_master;
use App\Models\ongeki_song_list_expert;
use App\Models\ongeki_song_list_lunatic;
use App\Models\ongeki_category_list;
use App\Models\ongeki_version_list;

use App\Models\news_infomation;

class CalculatorController extends Controller {
    //
    public function __construct() {
        // Httpリクエストログ収集
        $this->middleware('CollectHttpRequest');
    }

    public function index() {
        $songs = ongeki_song_list::orderBy('title', 'asc')->get()->all();
        $categories = ongeki_category_list::get()->all();
        $versions = ongeki_version_list::get()->all();

        $news = news_infomation::where("object", "1")->orWhere("object", "3")->orderBy('created_at', 'DESC')->take(5)->get();

        return view("main.calculator.index", compact("songs", "categories", "versions", "news"));
    }
}
