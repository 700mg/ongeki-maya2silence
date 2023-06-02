<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AccessLog;

class AccessAnalyzeController extends Controller {
    //
    public function getData($param) {
        if ($param == "daily")
            return self::getDailyData();
        if ($param == "month")
            return self::getMonthData();
    }

    public function getDailyCount() {
        return AccessLog::whereDate("created_at", date("Y-m-d"))->get()->count();
    }

    public function getMonthlyCount() {
        return AccessLog::whereMonth("created_at", date("m"))->get()->count();
    }

    private function getDailyData() {
        $data = AccessLog::whereDate("created_at", date("Y-m-d"))->get();
        $return = [];
        foreach ($data as $column) {
            // トップページのtoが空の為、分かりやすくする為記述
            $to = $column->to ?: "TopPage";
            // カラムが空だったら配列に新規追加
            if (empty($return[$to]))
                $return[$to] = 0;
            $return[$to]++;
        }
        // 無理矢理手動で変換
        return self::convertArray($return);
    }

    private function getMonthData() {
        $data = AccessLog::whereMonth("created_at", date("m"))->get();
        $return = [];
        foreach ($data as $column) {
            // トップページのtoが空の為、分かりやすくする為記述
            $at = $column->created_at->format('j') . "日";
            // カラムが空だったら配列に新規追加
            if (empty($return[$at]))
                $return[$at] = 0;
            $return[$at]++;
        }
        // 無理矢理手動で変換
        return self::convertArray($return);
    }

    private function convertArray(array $arr) {
        $_r = [];
        foreach ($arr as $k => $v)
            $_r[] = [$k, $v];
        return $_r;
    }
}
