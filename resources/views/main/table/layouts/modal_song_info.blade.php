{{-- 長押しのやつモーダル --}}
<div class="modal fade" id="modal_song_info" tabindex="-1" aria-labelledby="modal_song_info_label" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal_song_info_label">楽曲情報</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" aria-expanded="false"></button>
            </div>
            <div class="modal-body">
                <div class="row align-items-center justify-content-center">
                    <div class="col-sm-5 text-center mb-2 p-0">
                        <img id="song_info_jacket" width="175">
                    </div>
                    <div class="col-sm-6 p-0">
                        <dl class="p-2 mb-0">
                            <dt>タイトル</dt>
                            <dd><span id="song_info_title"></span></dd>
                            <dt>アーティスト</dt>
                            <dd><span id="song_info_artist"></span></dd>
                            <dt>実装日</dt>
                            <dd><span id="song_info_date"></span></dd>
                            <dt>バージョン</dt>
                            <dd><span id="song_info_version"></span>～</dd>
                            <dt>カテゴリ</dt>
                            <dd><span id="song_info_category"></span></dd>
                            <dt>リンク</dt>
                            <dd><a id="song_info_database" target="_blank" rel="noopener">データベース</a></dd>
                            {{-- 許可を取ってリンクを貼りたい --}}
                            {{-- <dd><a id="song_info_sdvxin" target="_blank" rel="noopener"></a></dd> --}}
                        </dl>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">閉じる</button>
            </div>
        </div>
    </div>
</div>
