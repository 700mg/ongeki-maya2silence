<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

use App\Models\AccessLog;

class CollectAccessLog {
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next) {
        $response = $next($request);
        $path = explode("/", $request->path());

        try {
            $log = new AccessLog;
            $log->to = $path[0];
            empty($path[1]) ?: $log->param = $path[1];
            $log->ip_addr = $request->ip();
            $log->save();
        } catch (\Exception $exception) {
            report($exception);
            dd($exception);
        }
        return $response;
    }
}
