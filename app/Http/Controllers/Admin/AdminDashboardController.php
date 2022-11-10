<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\AccessLog;

class AdminDashboardController extends Controller {
    //
    public function index() {
        $today_access = [];
        $today_access += $this->getTableDailyAccess();
        $today_access += $this->getCalcDailyAccess();
        $today_access += $this->getNewsDailyAccess();
        $today_access += $this->getDBDailyAccess();
        $today_access += $this->getMypageDailyAccess();

        arsort($today_access, SORT_NUMERIC);

        return view("admin.dashboard", compact("today_access"));
    }

    private function getDailyData() {
        $db = AccessLog::whereDate("created_at", date("Y-m-d"))->get();
        return $db;
    }

    private function getMonthlyData() {
        $db = AccessLog::whereMonth("created_at", date("Y-m"))->get();
        return $db;
    }

    private function getTableDailyAccess() {
        $count = [];
        $database = AccessLog::where("to", "table")->whereDay("created_at", date("d"))->get();
        foreach ($database as $db) {
            $label = empty($db->param) ? route("main.table.noLv") : route("main.table", $db->param);
            if (empty($count[$label]))  $count[$label] = 0;
            $count[$label] += 1;
        }
        return $count;
    }

    private function getCalcDailyAccess() {
        return [route("main.calculator") => AccessLog::where("to", "calculator")->whereDay("created_at", date("d"))->count()];
    }

    private function getNewsDailyAccess() {
        $count = [];
        $database = AccessLog::where("to", "news")->whereDay("created_at", date("d"))->get();
        foreach ($database as $db) {
            $label = empty($db->param) ? route("news.list") : route("news.view", $db->param);
            if (empty($count[$label]))  $count[$label] = 0;
            $count[$label] += 1;
        }
        return $count;
    }

    private function getMypageDailyAccess() {
        return [route("user.mypage") => AccessLog::where("param", "mypage")->whereDay("created_at", date("d"))->count()];
    }

    private function getDBDailyAccess() {
        $count = [];
        $database = AccessLog::where("to", "song_data")->whereDay("created_at", date("d"))->get();
        foreach ($database as $db) {
            $label = empty($db->param) ? route("database.list") : route("database.song", $db->param);
            if (empty($count[$label]))  $count[$label] = 0;
            $count[$label] += 1;
        }
        return $count;
    }

    private function getTableWeeklyAccessChart() {
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

    private function getCalcWeeklyAccessChart() {
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
