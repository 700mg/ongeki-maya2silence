@extends('adminlte::page')

@section('title', '新規登録 - ongeki.maya2silence.com')

@section('content_header')
    <h1>新規登録</h1>
@stop

@section('js')
    <script src="{{ asset('/script/admin/song_regist.js') }}"></script>
@endsection

@section('css')
    <style>
        div.outerImg {
            height: 200px;
            width: 200px;
            border: 1px dashed #888;
        }

        img#imgJacket {
            max-height: 100%;
            max-width: 100%;
        }
    </style>
@endsection

@section('content')
    <form class="main_form" method="post" action="{{ route('admin.songs.regist') }}" enctype="multipart/form-data">
        @csrf
        <!-- ジャケット -->
        <div class="form-row">
            <div class="input-group mb-3">
                <label class="col-sm-2 col-form-label">ジャケット</label>
                <div class="col-auto mb-2">
                    <div class="outerImg d-flex justify-content-center align-items-center">
                        <img id="imgJacket">
                    </div>
                </div>
                <div class="col-sm-5 mb-2">
                    <div class="custom-file">
                        <input type="file" name="jacket" class="custom-file-input" id="inputJacket" accept="image/jpeg">
                        <label class="custom-file-label" for="inputJacket">選択して下さい</label>
                        <div class="invalid-feedback">ジャケットが選択されていません</div>
                    </div>
                </div>
                <div class="col-sm-5 mb-2">
                    <span id="jacketResolution"></span>
                </div>
            </div>
        </div>
        <!-- タイトル -->
        <div class="form-group row mb-3">
            <label for="inputTitle" class="col-sm-2 col-form-label">タイトル</label>
            <div class="col-sm-10">
                <input type="text" name="title" class="form-control" id="inputTitle" placeholder="タイトル">
                <div class="invalid-feedback">タイトルが入力されていません</div>
            </div>
        </div>
        <!-- ルビ -->
        <div class="form-group row mb-3">
            <label for="inputRuby" class="col-sm-2 col-form-label">フリガナ</label>
            <div class="col-sm-10">
                <input type="text" name="ruby" class="form-control" id="inputRuby" placeholder="フリガナ">
            </div>
        </div>
        <!-- コンポーザー -->
        <div class="form-group row mb-3">
            <label for="inputArtist" class="col-sm-2 col-form-label">アーティスト</label>
            <div class="col-sm-10">
                <input type="text" name="artist" class="form-control" id="inputArtist" placeholder="アーティスト">
            </div>
        </div>
        <!-- バージョンとか -->
        <div class="form-group row mb-3">
            <div class="input-group">
                <label class="col-sm-2 col-form-label">情報</label>
                <div class="col-sm-5 mb-2">
                    <label class="sr-only" for="inlineFormInputGroup">Version</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <div class="input-group-text">バージョン</div>
                        </div>
                        <select class="form-select form-control" name="version" aria-label="Default select example">
                            @foreach ($versions as $key => $version)
                                <option value="{{ $version->id }}">{{ $version->version }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-sm-5 mb-2">
                    <label class="sr-only" for="inlineFormInputGroup">Category</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <div class="input-group-text">カテゴリ</div>
                        </div>
                        <select class="form-select form-control" name="category" aria-label="Default select example">
                            @foreach ($categories as $key => $category)
                                <option value="{{ $category->id }}">{{ $category->category }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <!-- 対戦相手 -->
        <div class="form-row mb-3">
            <label class="col-sm-2 col-form-label">対戦相手</label>
            <div class="col-auto">
                <label class="sr-only" for="inlineFormInputGroup">Element</label>
                <div class="input-group mb-2">
                    <div class="input-group-prepend">
                        <div class="input-group-text">属性</div>
                    </div>
                    <select class="form-select form-control" name="element" aria-label="Default select example">
                        <option value=" ">未設定</option>
                        <option value="aqua">Aqua</option>
                        <option value="fire">Fire</option>
                        <option value="leaf">Leaf</option>
                        <option value="all">All</option>
                    </select>
                </div>
            </div>
            <div class="col-auto">
                <label class="sr-only" for="inputRivalLevel">Rival Level</label>
                <div class="input-group mb-2">
                    <div class="input-group-prepend">
                        <div class="input-group-text">Lv.</div>
                    </div>
                    <input type="number" name="level" inputmode="numeric" class="form-control" id="inputRivalLevel" placeholder="レベル">
                </div>
            </div>
        </div>
        <!-- その他 -->
        <div class="form-row mb-3">
            <label class="col-sm-2 col-form-label">削除曲</label>
            <div class="col-auto mb-2">
                <label class="sr-only" for="inlineFormInputGroup">Deleted</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <div class="input-group-text">削除曲</div>
                    </div>
                    <select class="form-select form-control" name="deleted" aria-label="Default select example">
                        <option value="false">いいえ</option>
                        <option value="true">はい</option>
                    </select>
                </div>
            </div>
        </div>
    </form>
    <div class="text-right mt-3">
        <span id="submitBtn" class="btn btn-primary mb-3">上記内容で登録</span>
    </div>
@endsection
