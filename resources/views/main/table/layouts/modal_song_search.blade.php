{{-- 検索モーダル --}}
<div class="modal fade" id="modal_search" tabindex="-1" aria-labelledby="modal_search_label" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal_search_label">キーワードで検索</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" aria-expanded="false"></button>
            </div>
            <div class="d-flex p-2">
                <input class="form-control" type="search" id="keywords" placeholder="search for keywords" value="">
                <button class="btn btn-primary" id="search_submit">
                    <i class="fas fa-search"></i>
                </button>
            </div>
            <hr class="mt-1 mb-1" />
            <div class="modal-body" style="height:100vh">
                {{-- ここに結果が入る --}}
                <div id="search_result"></div>
            </div>
        </div>
    </div>
</div>
