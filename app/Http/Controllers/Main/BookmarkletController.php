<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\bookmarklet;

class BookmarkletController extends Controller {
    //
    public function list() {
        $bookmarklets = bookmarklet::paginate(50);
        return view("main.bookmarklet.list", compact("bookmarklets"));
    }

    public function detail($id) {
        $bookmarklet = bookmarklet::where("id", $id)->firstOrFail();
        return view("main.bookmarklet.index", compact("bookmarklet"));
    }
}
