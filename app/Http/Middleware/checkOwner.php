<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;

class checkOwner {
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, ...$guards) {
        // ここの仕様は知らん
        $guards = empty($guards) ? [null] : $guards;
        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                // ログイン中のユーザーがDBのadminフラグがない場合403を返すだけ
                abort_if(!Auth::user()->owner, 403, "権限がありません");
            } else {
                // ログインページにリダイレクトしたい
                return redirect()->route("login");
            }
        }
        return $next($request);
    }
}
