@extends('adminlte::page')

@section('title', '新規登録 - ongeki.maya2silence.com')

@section('content_header')
    <h1>お知らせ登録</h1>
@stop

@section('js')
    <script src="{{ asset('/script/admin/news_regist.js') }}"></script>
@endsection

@section('css')
@endsection

@section('content')
    <form class="main_form" method="post" action="{{ route('admin.news.regist') }}" enctype="multipart/form-data">
        @csrf
        <!-- 表示先 -->
        <div class="form-group row mb-3">
            <label for="inputArtist" class="col-sm-2 col-form-label">表示先</label>
            <div class="col-sm-8">
                <select class="form-select form-control" name="object" aria-label="Default select example">
                    @foreach ($objects as $object)
                        <option value="{{ $object->id }}">{{ $object->name_jp }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-group row mb-3">
            <label for="inputTitle" class="col-sm-2 col-form-label">見出し</label>
            <div class="col-sm-10">
                <input type="text" name="header" class="form-control" id="inputHeader" placeholder="見出し">
                <div class="invalid-feedback">見出しが入力されていません</div>
            </div>
        </div>
        <!-- ルビ -->
        <div class="form-group row mb-3">
            <label for="inputRuby" class="col-sm-2 col-form-label">本文</label>
            <div class="col-sm-10">
                <textarea type="text" name="contents" class="form-control" id="inputContents" placeholder="本文"></textarea>
                <div class="invalid-feedback">本文が入力されていません</div>
            </div>
        </div>
        <!-- 画像 -->
        <div class="form-group row mb-3">
            <label for="inputRuby" class="col-sm-2 col-form-label">画像</label>
            <div class="col-sm-10">
                <div class="row flex-column" id="files_column">
                    <input type="file" class="mb-1" name="images[]" accept=".jpg,.png" />
                </div>
                <div class="btn btn-outline-primary fs-75p" onclick="addInputTag()">画像を追加</div>
            </div>
        </div>
        <div>
            <p>画像を使う際は、<strong>##IMG+数字を追加した順番に記入してください。</strong></p>
            <p>(例) ##IMG0 ##IMG1</p>
        </div>
    </form>
    <div class="m-2 text-center">
        <div class="difficult_btn">
            <span class="btn btn-secondary" id="submitBtn">確定</span>
        </div>
    </div>
@endsection
