<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\news_infomation;

class NewsController extends Controller {
    //
    public function view($id) {
        $news = news_infomation::where("id", $id)->firstOrFail();
        return view("main.news.index", compact("news"));
    }

    public function list(){
        $news = news_infomation::orderBy('created_at', 'DESC')->paginate(50);
        return view("main.news.list", compact("news"));
    }
}
