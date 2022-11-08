<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

use App\Models\User;
use App\Models\news_infomation;
use App\Models\news_object_to;

class AdminNewsController extends Controller {
    //
    public function __construct() {
        $this->middleware('checkAdmin');
    }

    public function list() {
        $news = news_infomation::paginate(50);
        $object_to = news_object_to::get()->all();
        $user = User::where("admin", 1)->get();
        return view("admin.news.list", compact("news", "object_to", "user"));
    }
    public function detail($id) {
        $news = news_infomation::find($id);
        $objects = news_object_to::get()->all();
        return view("admin.news.detail", compact("news", "objects"));
    }

    public function registView() {
        $objects = news_object_to::get()->all();
        return view("admin.news.regist", compact("objects"));
    }

    public function regist(Request $request) {
        // データベースに登録
        $news = new news_infomation;
        $news->news_id = (string) Str::uuid();
        $news->create_user = Auth::id();
        $news->object = $request->input("object");
        $news->header = $request->input("header");
        $news->contents = $request->input("contents");

        $news->save();

        if ($request->file("images")) {
            $path = sprintf("public/news/%d", $news->id);
            // ディレクトリ作成
            Storage::disk("public")->makeDirectory(sprintf("news/%d", $news->id));

            foreach ($request->file("images") as $image) {
                $image->storeAs($path, $image->getClientOriginalName());
                $images[] = $image->getClientOriginalName();
            }

            $news->images = implode(",", $images);
            $news->save();
        }

        return redirect()->route("admin.news.regist.success")->with("news", $news);
    }

    public function regist_success() {
        return view("admin.news.regist_success");
    }

    public function update(Request $request) {
        $news = news_infomation::where("id", $request->input("id"))->firstOrFail();
        $news->object = $request->input("object");
        $news->header = $request->input("header");
        $news->contents = $request->input("contents");
        $news->save();

        return redirect()->route('admin.news.detail', ['id' => $request->input("id")])->with('success_detail', '正常に更新しました。');
    }

    public function search() {
    }

    public function delete() {
    }
}
