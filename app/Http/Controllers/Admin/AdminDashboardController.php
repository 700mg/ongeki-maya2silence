<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\Admin\AccessAnalyzeController;

class AdminDashboardController extends Controller {
    //
    function view() {
        $aa = new AccessAnalyzeController;
        $count = ["daily" => $aa->getDailyCount(), "monthly" => $aa->getMonthlyCount()];
        return view("admin.dashboard")->with(compact("count"));
    }
}
