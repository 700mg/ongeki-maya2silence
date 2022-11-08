<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

use App\Models\bookmarklet;
use App\Models\User;

class AdminBookmarkletController extends Controller {
    //
    public function list() {
        $bookmarklets = bookmarklet::paginate(50);
        $users = User::where("admin", 1)->get();

        return view("admin.bookmarklet.list", compact("bookmarklets", "users"));
    }
    public function detail($id) {
        $bookmarklet = bookmarklet::find($id);
        return view("admin.bookmarklet.detail", compact("bookmarklet"));
    }

    public function viewRegist() {
        return view("admin.bookmarklet.regist");
    }

    public function regist(Request $request) {
        // データベースに登録
        $bookmarklet = new bookmarklet;
        $bookmarklet->bookmarklet_id = (string) Str::uuid();
        $bookmarklet->create_user = Auth::id();
        $bookmarklet->header = $request->input("header");
        $bookmarklet->contents = $request->input("contents");

        $bookmarklet->save();

        if ($request->file("images")) {
            $path = sprintf("public/bookmarklet/%d", $bookmarklet->id);
            // ディレクトリ作成
            Storage::disk("public")->makeDirectory(sprintf("bookmarklet/%d", $bookmarklet->id));
            foreach ($request->file("images") as $image) {
                $image->storeAs($path, $image->getClientOriginalName());
                $images[] = $image->getClientOriginalName();
            }

            $bookmarklet->images = implode(",", $images);
            $bookmarklet->save();
        }

        return redirect()->route("admin.bookmarklet.regist.success")->with("bookmarklet", $bookmarklet);
    }

    public function regist_success() {
        return view("admin.bookmarklet.regist_success");
    }

    public function update(Request $request) {
        $bookmarklet = bookmarklet::where("id", $request->input("id"))->firstOrFail();
        $bookmarklet->header = $request->input("header");
        $bookmarklet->contents = $request->input("contents");
        $bookmarklet->save();

        return redirect()->route('admin.bookmarklet.detail', $request->input("id"))->with('success_detail', '正常に更新しました。');
    }
}
