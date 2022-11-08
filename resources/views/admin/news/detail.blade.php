@extends('adminlte::page')

@section('title', 'お知らせ編集 - ongeki.maya2silence.com')

@section('content_header')
    <h1>お知らせを編集</h1>
@stop

@section('content')
    <div class="d-flex justify-content-between p-1">
        <a href="{{ route('admin.news.list') }}"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-caret-left-fill" viewBox="0 0 16 16">
                <path d="m3.86 8.753 5.482 4.796c.646.566 1.658.106 1.658-.753V3.204a1 1 0 0 0-1.659-.753l-5.48 4.796a1 1 0 0 0 0 1.506z"></path>
            </svg>
            リストへ戻る
        </a>
        <form id="news_delete" method="post" action="{{ route('admin.news.delete') }}">
            @csrf
            <input type="hidden" name="news_id" value="">
            <a class="btn btn-outline-danger" style="font-size:50%" id="deleteBtn">このお知らせを削除</a>
        </form>
    </div>
    <!-- 曲情報 -->
    <div class="section">
        @if (session('success_detail'))
            <div class="alert alert-success" role="alert">{{ session('success_detail') }}</div>
        @endif
        <form class="main_form" method="post" action="{{ route('admin.news.update') }}">
            @csrf
            <fieldset disabled>
                <input type="hidden" name="id" value="{{ $news->id }}">
                <!-- 表示先 -->
                <div class="form-group row mb-3">
                    <label for="inputArtist" class="col-sm-2 col-form-label">表示先</label>
                    <div class="col-sm-8">
                        <select class="form-select form-control" name="object" aria-label="Default select example">
                            @foreach ($objects as $object)
                                @if ($object->id == $news->object)
                                    <option value="{{ $object->id }}" selected>{{ $object->name_jp }}</option>
                                @else
                                    <option value="{{ $object->id }}">{{ $object->name_jp }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group row mb-3">
                    <label for="inputTitle" class="col-sm-2 col-form-label">見出し</label>
                    <div class="col-sm-10">
                        <input type="text" name="header" class="form-control" id="inputHeader" placeholder="見出し" value="{{ $news->header }}">
                        <div class="invalid-feedback">見出しが入力されていません</div>
                    </div>
                </div>
                <!-- ルビ -->
                <div class="form-group row mb-3">
                    <label for="inputRuby" class="col-sm-2 col-form-label">本文</label>
                    <div class="col-sm-10">
                        <textarea type="text" name="contents" class="form-control" id="inputContents" placeholder="本文">{{ $news->contents }}</textarea>
                        <div class="invalid-feedback">本文が入力されていません</div>
                    </div>
                </div>
                <div>
                    <p>幾つかのHTMLタグが使えます。</p>
                </div>
            </fieldset>
        </form>
        <div class="m-2 text-right">
            <div class="submit_btn d-block">
                <span class="btn btn-secondary" id="editBtn">編集</span>
            </div>
            <div class="submit_btn d-none">
                <span class="btn btn-outline-success" id="submitBtn">確定</span>
                <span class="btn m-2 btn-outline-secondary" onclick="location.reload()">キャンセル</span>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="{{ asset('/script/admin/news_detail.js') }}"></script>
@endsection

@section('css')
@endsection
