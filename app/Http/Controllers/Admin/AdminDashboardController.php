<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\AccessLog;

class AdminDashboardController extends Controller {
    //
    public function index() {
        $table_weekly = $this->getTableWeeklyAccess();
        $calc_weekly = $this->getCalcWeeklyAccess();
        $table_weekly_total = AccessLog::where("to", "table")->whereYear("created_at", date("Y"))->whereMonth("created_at", date("m"))->count();
        $calc_weekly_total = AccessLog::where("to", "calculator")->whereYear("created_at", date("Y"))->whereMonth("created_at", date("m"))->count();
        return view("admin.dashboard", compact("table_weekly", "calc_weekly", "table_weekly_total", "calc_weekly_total"));
    }

    private function getDailyData() {
        $db = AccessLog::whereDate("created_at", date("Y-m-d"))->get();
        return $db;
    }

    private function getMonthlyData() {
        $db = AccessLog::whereMonth("created_at", date("Y-m"))->get();
        return $db;
    }

    private function getTableWeeklyAccess() {
        // 各グラフの設定
        $levels = ["11", "12", "13", "14"];
        // グラフの色
        $colors = ["#53D448", "#F3D92E", "#F269B3", "#A758CB"];

        $datasets = array();
        $labels = (function ($n) {
            $arr = array();
            for ($i = 1; $i <= $n; $i++) array_push($arr, $i . "日");
            return $arr;
        })(date('t'));

        $query = AccessLog::query();
        $query->where("to", "table");
        $query->whereYear("created_at", date("Y"))->whereMonth("created_at", date("m"));
        $db = $query->get();

        foreach ($levels as $key => $l) {
            $label = "Lv{$l}";
            $data = [];
            foreach ($db as $d) {
                for ($i = 1; $i <= date('t'); $i++)
                    $data[] = $d->where("param", $l)->whereDay("created_at", $i)->count();
            }
            array_push($datasets, ["label" => $label, "data" => $data, "backgroundColor" => $colors[$key]]);
        }
        return [
            "type" => "bar",
            "data" => ["labels" => $labels, "datasets" => $datasets],
            "options" => ["scales" => ["x" => ["stacked" => true], "y" => ["stacked" => true, "ticks" => ["stepSize" => 1]]]],
        ];
    }

    private function getCalcWeeklyAccess() {
        // 各グラフの設定
        $label = "計算機";
        // グラフの色
        $color = "#f00";

        $datasets = array();
        $data = [];

        $labels = (function ($n) {
            $arr = array();
            for ($i = 1; $i <= $n; $i++) array_push($arr, $i . "日");
            return $arr;
        })(date('t'));

        foreach (AccessLog::All() as $d)
            for ($i = 1; $i <= date('t'); $i++)
                $data[] = $d->where("to", "calculator")->whereDate("created_at", "=", date("Y-m-") . $i)->count();

        array_push($datasets, ["label" => $label, "data" => $data, "backgroundColor" => $color]);

        return [
            "type" => "bar",
            "data" => ["labels" => $labels, "datasets" => $datasets],
            "options" => ["scales" => ["x" => ["stacked" => true], "y" => ["stacked" => true, "ticks" => ["stepSize" => 1]]]],
        ];
    }
}
