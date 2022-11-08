<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

use Socialite;

use App\Models\User;
use App\Models\UserTwitter;

class TwitterController extends Controller {
    public function viewRegistPage() {
        return view("auth.regist_twitter");
    }

    // ユーザー登録処理
    public function saveToDatabase(Request $request) {
        // Cookieがあるか確認
        if ($request->session()->has('twitter_regist')) {
            $twitter = session()->get("twitter_regist");
            // DBに保存
            $user = new User();
            $user->name = "@" . $twitter->name;
            $user->twitter = $twitter->userid;
            $user->save();

            // Twitter情報を保存
            $user_twitter = new UserTwitter();
            $user_twitter->userid = $twitter->userid;
            $user_twitter->name =  $twitter->name;
            $user_twitter->nickname = $twitter->nickname;
            $user_twitter->avatar = $twitter->avatar;
            $user_twitter->email = $twitter->email;
            $user_twitter->save();

            // 取り敢えずログイン
            Auth::login($user);

            // 登録用セッション破壊
            session()->forget("twitter_regist");

            // どこかにリダイレクト 多分マイページかな
            return redirect()->route("main");
        } else {
            // なかったら登録ページにリダイレクト
            return redirect()->route("regist.twitter")->with("error", "Twitterからデータの取得に失敗しました。(Err:26)");
        }
    }

    // Twitterログイン
    public function redirectToProvider(string $handle) {
        session()->put('twitter_auth', $handle);
        return Socialite::driver("twitter")->redirect();
    }

    // Twitterコールバック
    public function handleProviderCallback() {
        // 念の為毎回ぶっ壊す
        if (session()->exists("twitter_regist")) session()->forget("twitter_regist");

        // アクセス種別を取得したらセッション削除
        $handle = session()->get("twitter_auth");
        session()->forget("twitter_auth");
        if ($handle == "regist") {
            return $this->verifyTwitter();
        } else if ($handle == "login") {
            return $this->loginWithTwitter();
        } else {
            return redirect()->route("main");
        }
    }

    private function loginWithTwitter() {
        ### TwitterLoginエラー一覧 ###
        # エラー10: TwitterDBには登録されているがユーザーDBに紐づいているデータが見つからない。
        # エラー12: TwitterDBで指定ユーザーが見つからない。
        # エラー14: Twitterから取得したデータが空。
        # エラー99: BANされている

        try {
            // ユーザー詳細情報の取得
            $twitterUser = Socialite::driver('twitter')->user();
            if (empty($twitterUser)) {
                // エラー14: Twitterから取得したデータが空
                throw new \Exception("Twitterからデータの取得に失敗しました。(Err:14)");
            }
            if (UserTwitter::where("userid", $twitterUser->getId())->first()) {
                if ($db_user = User::where("twitter", $twitterUser->getId())->first()) {
                    // BANされている?
                    if ($db_user->banned) throw new \Exception("このユーザーはログインが禁止されています。(Err:99)");

                    // これでいいのかは知らない
                    $db_twitter = UserTwitter::where("userid", $twitterUser->getId())->first();
                    $db_twitter->name = "@" . $twitterUser->getName();
                    $db_twitter->nickname = $twitterUser->getNickname();
                    $db_twitter->avatar = str_replace("_normal", "", $twitterUser->getAvatar());
                    $db_twitter->save();

                    // 表示用のユーザー名も更新しておく
                    $db_user->name = $db_twitter->name;
                    $db_user->touch(); // update_atが最終ログイン日になる
                    $db_user->save();

                    Auth::login($db_user);

                    // ログイン前のページに遷移
                    if (session()->has('url.intended'))
                        return redirect()->intended(RouteServiceProvider::HOME);
                    else
                        return redirect()->route("main");
                } else {
                    // エラー10: TwitterDBには登録されているがユーザーDBに紐づいているデータが見つからない
                    throw new \Exception("ユーザーデータが見つかりませんでした。(Err:10)");
                }
            } else {
                // エラー12: TwitterDBで指定ユーザーが見つからない
                throw new \Exception("ユーザーデータが見つかりませんでした。(Err:12)");
            }
        } catch (\Exception $e) {
            return redirect()->route("login")->with("error", $e->getMessage());
        }
    }

    private function verifyTwitter() {
        ### TwitterRegistエラー一覧 ###
        # エラー20: 既に登録されているアカウントで、再度登録を試みた。
        # エラー22: UserDBには登録されていないが、既にTwitterDBに登録されている。
        # エラー24: Twitterから取得したデータが空。
        # エラー26: セッション切れ。

        try {
            // ユーザー詳細情報の取得
            $twitterUser = Socialite::driver('twitter')->user();
            if (empty($twitterUser)) {
                // エラー24: Twitterから取得したデータが空
                throw new \Exception("Twitterからデータの取得に失敗しました。(Err:24)");
            }
            if (!UserTwitter::where("userid", $twitterUser->getId())->exists()) {
                // 一応念の為にUSERデータベースも確認する
                if (User::where("twitter", $twitterUser->getId())->exists()) {
                    // エラーを返しておく
                    throw new \Exception("DBのデータ整合性が確認できません。管理者までお問い合わせ下さい。(Err:22)");
                } else {
                    // データベースに無かった場合新規登録処理をする
                    $twitter = new UserTwitter();
                    $twitter->userid = $twitterUser->getId();
                    $twitter->name =  $twitterUser->getName();
                    $twitter->nickname = $twitterUser->getNickname();
                    $twitter->avatar = $twitterUser->getAvatar();
                    $twitter->email = $twitterUser->getEmail();

                    // Cookieなりセッションなりで一度保存する
                    session()->put('twitter_regist', $twitter);

                    return redirect()->route("regist.twitter");
                }
            } else {
                throw new \Exception("既に登録されているアカウントです。(Err:20)");
            }
        } catch (\Exception $e) {
            return redirect()->route("regist.twitter")->with("error", $e->getMessage());
        }
    }

    //　Twitterログアウト
    public function logout(Request $request) {
        Auth::logout();
        if (session()->has('url.intended'))
            return redirect()->intended(RouteServiceProvider::HOME);
        else
            return redirect()->route("main");
    }
}
