<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\AccessLog;
use App\Models\HttpRequest;

class AnalyzeLogController extends Controller {
    //

    public function AnalyzeAccessLog() {
        $logs = AccessLog::orderBy('id', 'DESC')->paginate(50);
        return view("admin.log_analyze.access_log", compact("logs"));
    }

    public function AnalyzeHttpRequestLog() {
        $logs = HttpRequest::orderBy('id', 'DESC')->paginate(50);
        return view("admin.log_analyze.httprequest_log", compact("logs"));
    }
}
