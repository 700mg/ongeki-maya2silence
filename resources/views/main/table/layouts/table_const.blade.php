<table id="table_const" class="p-1">
    <tbody>
        @for ($i = $const['max']; $i > $const['min']; $i -= 0.1)
            @php
                $c = array_filter($song, function ($e) use ($i) {
                    return $e['const'] == round($i, 1);
                });
            @endphp
            @if ($c)
                <tr>
                    <th class="th_const bdr">{{ $i }}</th>
                    <td class="box bdr" id={{ $i }}>
                        @php
                            // @foreachで記述するとできる空白を回避する為にechoで処理
                            foreach ($c as $detail) {
                                $id = $detail['index'];
                                $_id = $id;
                                $_jacket_url = 'url("' . asset("storage/songs/jacket/{$detail['index']}.jpg") . '")';

                                if ($detail['difficult'] != 'master') {
                                    // idが重複してしまう為、最後にフラグを添える
                                    $_id .= $detail['difficult'] == 'expert' ? 'e' : '';
                                    $_id .= $detail['difficult'] == 'lunatic' ? 'l' : '';
                                }
                                // 記述
                                echo "<div id='c_{$_id}' class='wrapper' data-id='{$id}' data-sid='{$_id}' data-flag='0' data-long-press-delay='1000'>\n";
                                echo "<div class='jacket' style='background-image:{$_jacket_url}; background-size:cover'>\n";
                                echo "<div class='{$detail['difficult']} label_title'>{$detail['title']}</div>\n";
                                echo "</div>\n";
                                echo "<div class='slash'></div>\n";
                                echo "</div>";
                            }
                        @endphp
                    </td>
                </tr>
            @endif
        @endfor
    </tbody>
</table>
