<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Main\SongController;
use App\Http\Controllers\Main\TableController;
use App\Http\Controllers\Main\CalculatorController;
use App\Http\Controllers\Auth\TwitterController;
use App\Http\Controllers\Main\NewsController;
use App\Http\Controllers\Main\DatabaseController;
use App\Http\Controllers\Main\UserController;
use App\Http\Controllers\Main\BookmarkletController;
use App\Http\Controllers\Main\MypageController;

use App\Http\Controllers\Admin\AdminSongController;
use App\Http\Controllers\Admin\AdminNewsController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AnalyzeLogController;
use App\Http\Controllers\Admin\AdminBookmarkletController;
use App\Http\Controllers\Admin\AccessAnalyzeController;
use App\Http\Controllers\Admin\OwnerUserController;

use App\Models\news_infomation;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    $news = news_infomation::where("object", "1")->orderBy('created_at', 'DESC')->take(5)->get();
    return view('main.main')->with(compact("news"));
})->name("main");

/*-- 優先度(記述する順番)に気をつけること(3敗) --*/

// 定数表
Route::post('/table/osl/fetch', [TableController::class, "fetchToOSL"])->name("main.table.osl.fetch");
Route::post('/table/osl/fill', [TableController::class, "fillFromOSL"])->name("main.table.osl.fill");
Route::get('/table/export', [TableController::class, "exportImage"])->name("main.table.export");
Route::post('/table/user/save', [TableController::class, "saveCheckToServer"])->middleware("checkLogin")->middleware('CollectAccessLog')->name("main.table.save");
Route::post('/table/user/load', [TableController::class, "loadCheckFromServer"])->middleware("checkLogin")->middleware('CollectAccessLog')->name("main.table.load");

Route::get('/table/{lv}', [TableController::class, "index"])->where("lv", "^1[1234]$")->middleware('CollectAccessLog')->name("main.table");
Route::get('/table/{lv?}', [TableController::class, "param_invalid"])->middleware('CollectAccessLog')->name("main.table.noLv");

// 計算機
Route::get("/calculator", [CalculatorController::class, "index"])->middleware('CollectAccessLog')->name("main.calculator");

// 各種楽曲情報取得用
Route::post("/song/detail", [SongController::class, "getSongDetail"])->middleware('CollectAccessLog')->name("song.detail");
Route::post("/song/data", [SongController::class, "getSongData"])->middleware('CollectAccessLog')->name("song.data");
Route::post("/song/search", [SongController::class, "searchSongData"])->middleware('CollectAccessLog')->name("song.search");

// お知らせページ
Route::get("/news", [NewsController::class, "list"])->middleware('CollectAccessLog')->name("news.list");
Route::get("/news/{id}", [NewsController::class, "view"])->middleware('CollectAccessLog')->name("news.view");

// 楽曲の詳細が見れるページ
Route::get("/song_data", [DatabaseController::class, "list"])->middleware('CollectAccessLog')->name("database.list");
Route::post("/song_data/search", [DatabaseController::class, "search"])->middleware('CollectAccessLog')->name("database.search");
Route::get("/song_data/{id}", [DatabaseController::class, "songData"])->middleware('CollectAccessLog')->name("database.song");

//
Route::get("/bookmarklet/list", [BookmarkletController::class, "list"])->middleware('CollectAccessLog')->name("bookmarklet.list");
Route::get("/bookmarklet/{id}", [BookmarkletController::class, "detail"])->middleware('CollectAccessLog')->name("bookmarklet.detail");

// ユーザーマイページ
Route::get("/user/mypage", [MypageController::class, "view"])->middleware('CollectAccessLog')->middleware("auth")->name("user.mypage");
Route::post("/user/mypage/update", [MypageController::class, "update"])->middleware('CollectAccessLog')->middleware("auth")->name("user.mypage.update");
//Route::get("/user/mypage", [MypageController::class, "view"])->middleware('CollectAccessLog')->name("user.mypage");

/*--------------------------------*/
/*--  以下管理ページルーティング  --*/
/*--------------------------------*/
// 管理画面
Route::get('/admin', [AdminDashboardController::class, "view"])->name("admin.main")->middleware("checkAdmin");

// 楽曲管理
Route::get('/admin/songs', [AdminSongController::class, "list"])->middleware("checkAdmin")->name("admin.songs.list");
Route::post('/admin/songs', [AdminSongController::class, "search"])->middleware("checkAdmin")->middleware("checkAdmin")->name("admin.songs.search");
Route::get('/admin/songs/regist', [AdminSongController::class, "regist_view"])->middleware("checkAdmin")->name("admin.songs.viewRegist");
Route::post('/admin/songs/regist', [AdminSongController::class, "regist"])->middleware("checkAdmin")->name("admin.songs.regist");
Route::get('/admin/songs/regist/success', [AdminSongController::class, "regist_success"])->middleware("checkAdmin")->name("admin.songs.regist.success");
Route::post('/admin/songs/delete', [AdminSongController::class, "delete"])->middleware("checkAdmin")->name("admin.songs.delete");
Route::get('/admin/songs/jacket', [AdminSongController::class, "jacket"])->middleware("checkAdmin")->name("admin.songs.jacket");
Route::get('/admin/songs/{id}', [AdminSongController::class, "detail"])->where("id", "^[0-9]+")->middleware("checkAdmin")->name("admin.songs.detail");
Route::post('/admin/songs/update/detail', [AdminSongController::class, "update_detail"])->middleware("checkAdmin")->name("admin.songs.update.detail");
Route::post('/admin/songs/update/difficult', [AdminSongController::class, "update_difficult"])->middleware("checkAdmin")->name("admin.songs.update.difficult");

// お知らせ管理
Route::get("/admin/news/list/", [AdminNewsController::class, "list"])->middleware("checkAdmin")->name("admin.news.list");
Route::get("/admin/news/{id}", [AdminNewsController::class, "detail"])->where("id", "^[0-9]+")->middleware("checkAdmin")->name("admin.news.detail");
Route::get("/admin/news/regist", [AdminNewsController::class, "registView"])->middleware("checkAdmin")->name("admin.news.registView");
Route::get('/admin/news/regist/success', [AdminNewsController::class, "regist_success"])->middleware("checkAdmin")->name("admin.news.regist.success");
Route::post("/admin/news/regist", [AdminNewsController::class, "regist"])->middleware("checkAdmin")->name("admin.news.regist");
Route::post("/admin/news/search", [AdminNewsController::class, "search"])->middleware("checkAdmin")->name("admin.news.search");
Route::post("/admin/news/update", [AdminNewsController::class, "update"])->middleware("checkAdmin")->name("admin.news.update");
Route::post("/admin/news/delete", [AdminNewsController::class, "delete"])->middleware("checkAdmin")->name("admin.news.delete");

// ログ解析
Route::get("/admin/log/access", [AnalyzeLogController::class, "AnalyzeAccessLog"])->middleware("checkAdmin")->name("admin.log.access");

// ユーザー管理
Route::get("/admin/user/list", [OwnerUserController::class, "list"])->middleware("checkAdmin")->name("admin.user.list");
Route::get("/admin/user/{id}", [OwnerUserController::class, "detail"])->middleware("checkAdmin")->name("admin.user.detail");
Route::get("/admin/user/list/admin", [OwnerUserController::class, "viewListAdmin"])->middleware("checkAdmin")->middleware("checkOwner")->name("admin.user.listAdmin");
Route::post("/admin/user/update", [OwnerUserController::class, "update"])->middleware("checkAdmin")->middleware("checkOwner")->name("admin.user.update");
Route::post("/admin/user/conf/update/{id}", [OwnerUserController::class, "confUpdate"])->middleware("checkAdmin")->middleware("checkOwner")->name("admin.user.conf.update");

// ブックマークレットのやつ
Route::get("/admin/bookmarklet/list", [AdminBookmarkletController::class, "list"])->middleware("checkAdmin")->name("admin.bookmarklet.list");
Route::get("/admin/bookmarklet/{id}", [AdminBookmarkletController::class, "detail"])->where("id", "^[0-9]+")->middleware("checkAdmin")->name("admin.bookmarklet.detail");
Route::get("/admin/bookmarklet/regist", [AdminBookmarkletController::class, "viewRegist"])->middleware("checkAdmin")->name("admin.bookmarklet.viewRegist");
Route::get('/admin/bookmarklet/regist/success', [AdminBookmarkletController::class, "regist_success"])->middleware("checkAdmin")->name("admin.bookmarklet.regist.success");
Route::post("/admin/bookmarklet/regist", [AdminBookmarkletController::class, "regist"])->middleware("checkAdmin")->name("admin.bookmarklet.regist");
Route::post("/admin/bookmarklet/update", [AdminBookmarkletController::class, "update"])->middleware("checkAdmin")->name("admin.bookmarklet.update");
Route::post("/admin/bookmarklet/delete", [AdminBookmarkletController::class, "delete"])->middleware("checkAdmin")->name("admin.bookmarklet.delete");

Route::get('/admin/access_analyze/get/{param}', [AccessAnalyzeController::class, "getData"])->name("admin.access_analyze.get");

// 認証
Auth::routes();

// Twitter Auth
Route::get('regist/twitter', [TwitterController::class, "viewRegistPage"])->middleware('CollectAccessLog')->name("regist.twitter"); // TwitterログインURL
Route::get('regist/twitter/save', [TwitterController::class, "saveToDatabase"])->name("regist.twitter.save"); // TwitterログインURL
Route::get('auth/twitter/callback', [TwitterController::class, "handleProviderCallback"]); // TwitterコールバックURL
Route::get('auth/twitter/{handle}', [TwitterController::class, "redirectToProvider"])->name("login.twitter"); // TwitterログインURL
Route::get('auth/twitter/logout', [TwitterController::class, "logout"]); // TwitterログアウトURL

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
