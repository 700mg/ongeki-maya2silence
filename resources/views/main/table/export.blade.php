<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=no" />
    <meta http-equiv="content-language" content="ja">
    <link rel="stylesheet" href="./css/common.css" />
    <style>
        @font-face {
            font-family: "meiryo";
            src: url('meiryo.ttf');
        }

        body {
            background-color: #343434 !important;
            width: 100%;
            margin: 0;
            padding: 0;
            font-family: "meiryo" !important;
            position: relative;
        }

        table {
            width: 100%;
            background-image: url("./bg.jpg");
            background-size: cover;
            background-position: center center;
        }

        html {
            touch-action: manipulation;
            -ms-touch-action: manipulation;
            background-color: #e9e9e9;
            background-image: repeating-linear-gradient(45deg, #fff, #fff 3px, transparent 0, transparent 16px);
        }

        body {
            min-height: 100vh;
        }

        div.container>table {
            width: 100%;
        }

        html h1 {
            text-align: center;
            font-size: large;
        }

        .constant {
            margin: 15px 0 0 5px;
            text-align: left;
        }

        .jacket {
            display: block;
            width: 150px;
            height: 150px;
            margin: 13px;
            padding: 0;
            border: black solid 2px;
            border-radius: 5px;
        }

        .j-200 {
            width: 200px !important;
            height: 200px !important;
        }

        .checkedA {
            margin: 4px;
            border-width: 12px;
            border-style: solid;
            border-color: rgb(51, 217, 98);
            border-image: initial;
        }

        .checkedB {
            margin: 4px;
            border-width: 12px;
            border-style: solid;
            border-image: initial;
            border-color: #e84015;
        }

        .checkedC {
            margin: 4px;
            border-width: 12px;
            border-style: solid;
            border-image: initial;
            border-color: #15bde8;
        }

        .checkedD {
            opacity: 0.5;
        }

        .slashA {
            background-image: linear-gradient(to right top, transparent 47%, #33d962 47%, #33d962 53%, transparent 53%);
        }

        .slashB {
            background-image: linear-gradient(to right top, transparent 47%, #e84015 47%, #e84015 53%, transparent 53%);
        }

        .slashC {
            background-image: linear-gradient(to right top, transparent 47%, #15bde8 47%, #15bde8 53%, transparent 53%);
        }

        .slash {
            width: 90%;
            height: 90%;
            top: 0;
            right: 0;
            bottom: 0;
            left: 0;
            margin: auto;
            position: absolute;
            pointer-events: none;
        }

        .wrapper {
            display: inline-block;
            position: relative;
            align-items: center;
        }

        .expert {
            color: white;
            font-size: 27px;
            position: absolute;
            bottom: 35px;
            right: 60px;
            width: 15px;
            font-weight: bold;
            z-index: 2;
            pointer-events: none;
            letter-spacing: 1px;
            text-shadow: 2px 2px 1px #ff0000, -2px 2px 1px #ff0000, 2px -2px 1px #ff0000, -2px -2px 1px #ff0000, 2px 0px 1px #ff0000, 0px 2px 1px #ff0000, -2px 0px 1px #ff0000, 0px -2px 1px #ff0000;
        }

        .lunatic {
            color: white;
            font-size: 27px;
            position: absolute;
            bottom: 35px;
            right: 60px;
            width: 15px;
            font-weight: bold;
            z-index: 2;
            pointer-events: none;
            letter-spacing: 1px;
            /* 文字間 */
            text-shadow: 2px 2px 1px #ff66ff, -2px 2px 1px #ff66ff, 2px -2px 1px #ff66ff, -2px -2px 1px #ff66ff, 2px 0px 1px #ff66ff, 0px 2px 1px #ff66ff, -2px 0px 1px #ff66ff, 0px -2px 1px #ff66ff;
        }

        .th_const {
            width: 4em;
            background-color: rgba(200, 200, 200, 0.25);
        }

        .box {
            background-color: rgba(200, 200, 200, 0.5);
            line-height: 0;
        }

        table {
            border-collapse: collapse;
        }

        td,
        th {
            padding: 0;
            border: 2px #000;
        }

        #ver_6h {
            background-position-x: 75% !important;
        }

        #ver_7h {
            background-position-x: 40% !important;
        }

        .bg {
            background-blend-mode: screen;
            background-color: rgba(80%, 80%, 80%, 0.9) !important;
            border-width: 2px 0;
            border-style: solid;
            border-color: #222;
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }

        .bgh {
            border-width: 2px 0;
            border-style: solid;
            border-color: #222;
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            width: 100px;
            background-color: rgba(204, 204, 204, 0.8) !important;
            background-blend-mode: screen;
        }

        .th_const {
            color: #eee;
            font-weight: bold;
            font-size: 28px;
            text-shadow: 3px 3px 3px #222, -3px -3px 3px #222, -3px 3px 3px #222, 3px -3px 3px #222, 3px 0px 3px #222, -3px -0px 3px #222, 0px 3px 3px #222, 0px -3px 3px #222;
        }

        .bdr {
            border-width: 4px 0;
            border-style: solid;
            border-color: #222;
            background-color: rgba(255, 255, 255, 0.5);
            padding: 10px 0;
        }

        .flagCount {
            margin: 0 auto;
            padding: 0 0.5em;
            text-align: center;
            display: inline-block;
        }

        #head_info {
            position: absolute;
            right: 0;
            top: 1em;
        }
    </style>
</head>

<body>
    @if (empty($songs) || empty($table_type))
        <p>Parameter error.</p>
    @else
        <div id="contents">
            <p style='color:white;text-align:right; margin: 0 1em 0 0; font-size:200%'><?= $index_ver ?></p>
            <p style='color:white;text-align:right; margin: 0 1em 0 0; font-size:200%'><?= date('Y/m/d - H:i:s') ?></p>
            @if (!empty($name))
                <h2 style='color:white;text-align:center; margin:0; padding:5px 0; font-size:500%'><?= $_POST['name'] ?></h2>
            @endif
            <table id="">
                <tbody>
                    @if ($table_type == 'const')
                        @for ($i = $const_max; $i > $const_min; $i -= 0.1)
                            @php
                                $c = array_filter($songs, function ($e) use ($i) { return $e['const'] == round($i, 1);});
                            @endphp
                            @if ($c)
                                <tr>
                                    <th class="th_const bdr">{{ $i }}</th>
                                    <td class="box bdr">
                                        @php
                                            // @foreachで記述するとできる空白を回避する為にechoで処理
                                            foreach ($c as $detail) {
                                                $id = $detail['index'];
                                                $_id = $id;
                                                $_label = '';
                                                $_jacket_url = 'url("' . asset("storage/songs/jacket/{$detail['index']}.jpg") . '")';

                                                if ($detail['difficult'] != 'master') {
                                                    // idが重複してしまう為、最後にフラグを添える
                                                    $_id .= $detail['difficult'] == 'expert' ? 'e' : '';
                                                    $_id .= $detail['difficult'] == 'lunatic' ? 'l' : '';
                                                    $_label = "<span class='{$detail['difficult']} label_diff'></span>";
                                                }

                                                if(array_key_exists($_id, $flag)){
                                                    echo "<div id='c_{$_id}' class='wrapper' data-id='{$id}' data-sid='{$_id}' data-flag='0' data-long-press-delay='1000'>\n";
                                                    echo "<div class='jacket checked{$flag[$_id]}' style='background-image:{$_jacket_url}; background-size:cover'>{$_label}</div>\n";
                                                    echo "<div class='slash slash{$flag[$_id]}'></div>\n";
                                                    echo "</div>\n";
                                                } else {                                                                                                    // 記述
                                                    echo "<div id='c_{$_id}' class='wrapper' data-id='{$id}' data-sid='{$_id}' data-flag='0' data-long-press-delay='1000'>\n";
                                                    echo "<div class='jacket' style='background-image:{$_jacket_url}; background-size:cover'>{$_label}</div>\n";
                                                    echo "</div>\n";
                                                }
                                            }
                                        @endphp
                                    </td>
                                </tr>
                            @endif
                        @endfor
                    @endif
                </tbody>
            </table>
            <div id="main_footer" style="display: block; font-size:150%;text-align:center">
                <p class="flagCount" style="background-color: #eee;">Total: <span style="font-weight: bold;"></span></p>
                <p class="flagCount" style="background-color: lightgreen;">Green: <span style="font-weight: bold;"></span></p>
                <p class="flagCount" style="background-color: pink;">Red: <span style="font-weight: bold;"></span></p>
                <p class="flagCount" style="background-color: lightblue;">Blue: <span style="font-weight: bold;"></span></p>
                <p class="flagCount" style="background-color: #eee">Clear: <span style="font-weight: bold;"></span></p>
            </div>
            <p style='color:white;text-align:center; margin:0;font-size:200%'>maya2 オンゲキツール 定数表 (https://ongeki.maya2silence.com/table/)</p>
        </div>
    @endif
</body>

</html>
