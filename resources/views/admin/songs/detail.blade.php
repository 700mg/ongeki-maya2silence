@extends('adminlte::page')

@section('title', "楽曲編集:$detail->title - ongeki.maya2silence.com")

@section('content')
    <div class="d-flex justify-content-between p-1">
        <a href="{{ route('admin.songs.list') }}"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-caret-left-fill" viewBox="0 0 16 16">
                <path d="m3.86 8.753 5.482 4.796c.646.566 1.658.106 1.658-.753V3.204a1 1 0 0 0-1.659-.753l-5.48 4.796a1 1 0 0 0 0 1.506z"></path>
            </svg>
            リストへ戻る
        </a>
        <form id="song_delete" method="post" action="{{ route('admin.songs.delete') }}">
            @csrf
            <input type="hidden" name="song_id" value="{{ $detail->song_id }}">
            <a class="btn btn-outline-danger" style="font-size:50%" onclick="deleteData()">この曲を削除</a>
        </form>
    </div>
    <!-- 曲情報 -->
    <div class="section">
        <span>楽曲情報</span>
        @if (session('success_detail'))
            <div class="alert alert-success" role="alert">{{ session('success_detail') }}</div>
        @endif
        @error('title')
            <div class="alert alert-danger" role="alert">{{ $message }}</div>
        @enderror
        @error('level')
            <div class="alert alert-danger" role="alert">{{ $message }}</div>
        @enderror
        @error('jacket')
            <div class="alert alert-danger" role="alert">{{ $message }}</div>
        @enderror
        <form class="detail form" method="POST" action={{ route('admin.songs.update.detail') }} enctype="multipart/form-data">
            @csrf
            <fieldset disabled>
                <input type="hidden" name="id" value="{{ $detail->id }}">
                <div class="form-row">
                    <div class="col-sm-auto d-flex align-items-center justify-content-center">
                        <div class="img_outer rounded">
                            <img id="jacket" src="{{ asset("storage/songs/jacket/$detail->id.jpg") }}">
                            <input type="file" accept="image/jpeg" name="jacket" id="i_jacket">
                        </div>
                    </div>
                    <div class="col-sm">
                        <!-- タイトル -->
                        <div class="input-group mb-1">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">タイトル</span>
                            </div>
                            <input type="text" name="title" class="form-control" placeholder="タイトル" aria-label="タイトル" value="{{ $detail->title }}">
                            <div class="invalid-feedback">タイトルが入力されていません</div>
                        </div>
                        <!-- フリガナ -->
                        <div class="input-group mb-1">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">フリガナ</span>
                            </div>
                            <input type="text" name="ruby" class="form-control" placeholder="未入力" aria-label="フリガナ" value="{{ $detail->ruby }}">
                        </div>
                        <!-- コンポーザー -->
                        <div class="input-group mb-1">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">アーティスト</span>
                            </div>
                            <input type="text" name="artist" class="form-control" placeholder="未入力" aria-label="アーティスト" value="{{ $detail->artist }}">
                        </div>
                        <!-- バージョン･カテゴリ -->
                        <div class="form-row mb-1">
                            <div class="col-md mb-1">
                                <label class="sr-only" for="inlineFormInputGroup">Version</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">バージョン</div>
                                    </div>
                                    <select class="custom-select" name="version">
                                        @foreach ($versions as $key => $version)
                                            @if ($detail->version == $key)
                                                <option value="{{ $version->id }}" selected>{{ $version->version }}</option>
                                            @else
                                                <option value="{{ $version->id }}">{{ $version->version }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md">
                                <label class="sr-only" for="inlineFormInputGroup">Category</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">カテゴリ</div>
                                    </div>
                                    <select class="custom-select" name="category">
                                        @foreach ($categories as $key => $category)
                                            @if ($detail->category == $key)
                                                <option value="{{ $category->id }}" selected>{{ $category->category }}</option>
                                            @else
                                                <option value="{{ $category->id }}">{{ $category->category }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <!-- 対戦相手 -->
                        <div class="form-row mb-1">
                            <div class="col input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">属性</div>
                                </div>
                                <select class="custom-select" name="element">
                                    <option value=" ">未設定</option>
                                    <option value="aqua" {{ $detail->enemy_element == 'aqua' ? 'selected' : '' }}>Aqua</option>
                                    <option value="fire" {{ $detail->enemy_element == 'fire' ? 'selected' : '' }}>Fire</option>
                                    <option value="leaf" {{ $detail->enemy_element == 'leaf' ? 'selected' : '' }}>Leaf</option>
                                    <option value="all" {{ $detail->enemy_element == 'all' ? 'selected' : '' }}>All</option>
                                </select>
                                <div class="input-group-prepend">
                                    <div class="input-group-text">Lv.</div>
                                </div>
                                <input type="number" name="level" inputmode="numeric" class="form-control" id="inputRivalLevel" placeholder="レベル" value="{{ $detail->enemy_level }}">
                            </div>
                        </div>
                        <!-- 削除曲? -->
                        <div class="input-group mb-1">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">削除曲</span>
                            </div>
                            <select class="custom-select" name="deleted">
                                <option value="1" {{ $detail->deleted == '1' ? 'selected' : '' }}>はい</option>
                                <option value="0" {{ $detail->deleted != '1' ? 'selected' : '' }}>いいえ</option>
                            </select>
                        </div>
                    </div>
                </div>
            </fieldset>
        </form>
        <div class="m-2 text-center">
            <div class="detail_btn d-block">
                <span class="btn btn-secondary" onclick="detailEdit()">楽曲情報を編集</span>
            </div>
            <div class="detail_btn d-none">
                <span class="btn btn-outline-success" onclick="sendForm('detail')">確定</span>
                <span class="btn m-2 btn-outline-secondary" onclick="location.reload()">キャンセル</span>
            </div>
        </div>
    </div>
    <!-- 譜面情報 -->
    <div class="section">
        <span>詳細</span>
        @if (session('success_difficult'))
            <div class="alert alert-success" role="alert">{{ session('success_difficult') }}</div>
        @endif
        @error('*')
            <div class="alert alert-danger" role="alert">{{ $message }}</div>
        @enderror

        <form class="difficult form" method="POST" action={{ route('admin.songs.update.difficult') }}>
            <fieldset disabled>
                @csrf
                <input type="hidden" name="id" value="{{ $detail->id }}">
                <!-- basic -->
                <div class="form-group row m-0 mb-1 p-2 basic">
                    <label for="inputArtist" class="col col-form-label">BASIC</label>
                    <div class="d-flex flex-column">
                        <div class="form-row align-items-center">
                            <div class="col">
                                <label for="inputCity">ノーツ数</label>
                                <input type="number" name="basic[notes]" class="form-control" inputmode="numeric" placeholder="未設定" value="{{ !empty($detail->basic->notes) ? $detail->basic->notes : '' }}">
                            </div>
                            <div class="col">
                                <label for="inputCity">ベル</label>
                                <input type="number" name="basic[bells]" class="form-control" inputmode="numeric" placeholder="未設定" value="{{ !empty($detail->basic->bells) ? $detail->basic->bells : '' }}">
                            </div>
                            <div class="col">
                                <label for="inputCity">定数</label>
                                <input type="number" name="basic[const]" class="form-control" inputmode="numeric" placeholder="未設定" value="{{ !empty($detail->basic->const) ? $detail->basic->const : '' }}">
                            </div>
                        </div>
                        <div class="form-row align-items-center">
                            <div class="form-group col">
                                <label for="inputCity">ノーツ数(前半)</label>
                                <input type="number" name="basic[noteA]" class="form-control" inputmode="numeric" placeholder="未設定" value="{{ !empty($detail->basic->notes_before) ? $detail->basic->notes_before : '' }}">
                            </div>
                            <div class="form-group col">
                                <label for="inputCity">ノーツ数(後半)</label>
                                <input type="number" name="basic[noteB]" class="form-control" inputmode="numeric" placeholder="未設定" value="{{ !empty($detail->basic->notes_after) ? $detail->basic->notes_after : '' }}">
                            </div>
                        </div>
                    </div>
                </div>
                <!-- advanced -->
                <div class="form-group row m-0 mb-1 p-2 advanced">
                    <label for="inputArtist" class="col col-form-label">ADVANCED</label>
                    <div class="d-flex flex-column">
                        <div class="form-row align-items-center">
                            <div class="col">
                                <label for="inputCity">ノーツ数</label>
                                <input type="number" name="advanced[notes]" class="form-control" inputmode="numeric" placeholder="未設定" value="{{ !empty($detail->expert->notes) ? $detail->expert->notes : '' }}">
                            </div>
                            <div class="col">
                                <label for="inputCity">ベル</label>
                                <input type="number" name="advanced[bells]" class="form-control" inputmode="numeric" placeholder="未設定" value="{{ !empty($detail->expert->bells) ? $detail->expert->bells : '' }}">
                            </div>
                            <div class="col">
                                <label for="inputCity">定数</label>
                                <input type="number" name="advanced[const]" class="form-control" inputmode="numeric" placeholder="未設定" value="{{ !empty($detail->expert->const) ? $detail->expert->const : '' }}">
                            </div>
                        </div>
                        <div class="form-row align-items-center">
                            <div class="form-group col">
                                <label for="inputCity">ノーツ数(前半)</label>
                                <input type="number" name="advanced[noteA]" class="form-control" inputmode="numeric" placeholder="未設定" value="{{ !empty($detail->expert->notes_before) ? $detail->expert->notes_before : '' }}">
                            </div>
                            <div class="form-group col">
                                <label for="inputCity">ノーツ数(後半)</label>
                                <input type="number" name="advanced[noteB]" class="form-control" inputmode="numeric" placeholder="未設定" value="{{ !empty($detail->expert->notes_after) ? $detail->expert->notes_after : '' }}">
                            </div>
                        </div>
                    </div>
                </div>
                <!-- expert -->
                <div class="form-group row m-0 mb-1 p-2 expert">
                    <label for="inputArtist" class="col col-form-label">EXPERT</label>
                    <div class="d-flex flex-column">
                        <div class="form-row align-items-center">
                            <div class="col">
                                <label for="inputCity">ノーツ数</label>
                                <input type="number" name="expert[notes]" class="form-control" inputmode="numeric" placeholder="未設定" value="{{ !empty($detail->expert->notes) ? $detail->expert->notes : '' }}">
                            </div>
                            <div class="col">
                                <label for="inputCity">ベル</label>
                                <input type="number" name="expert[bells]" class="form-control" inputmode="numeric" placeholder="未設定" value="{{ !empty($detail->expert->bells) ? $detail->expert->bells : '' }}">
                            </div>
                            <div class="col">
                                <label for="inputCity">定数</label>
                                <input type="number" name="expert[const]" class="form-control" inputmode="numeric" placeholder="未設定" value="{{ !empty($detail->expert->const) ? $detail->expert->const : '' }}">
                            </div>
                        </div>
                        <div class="form-row align-items-center">
                            <div class="form-group col">
                                <label for="inputCity">ノーツ数(前半)</label>
                                <input type="number" name="expert[noteA]" class="form-control" inputmode="numeric" placeholder="未設定" value="{{ !empty($detail->expert->notes_before) ? $detail->expert->notes_before : '' }}">
                            </div>
                            <div class="form-group col">
                                <label for="inputCity">ノーツ数(後半)</label>
                                <input type="number" name="expert[noteB]" class="form-control" inputmode="numeric" placeholder="未設定" value="{{ !empty($detail->expert->notes_after) ? $detail->expert->notes_after : '' }}">
                            </div>
                        </div>
                    </div>
                </div>
                <!-- master -->
                <div class="form-group row m-0 mb-1 p-2 master">
                    <label for="inputArtist" class="col col-form-label">MASTER</label>
                    <div class="d-flex flex-column">
                        <div class="form-row align-items-center">
                            <div class="col">
                                <label for="inputCity">ノーツ数</label>
                                <input type="number" name="master[notes]" class="form-control" inputmode="numeric" placeholder="未設定" value="{{ old('master[notes]', !empty($detail->master->notes) ? $detail->master->notes : '') }}">
                            </div>
                            <div class="col">
                                <label for="inputCity">ベル</label>
                                <input type="number" name="master[bells]" class="form-control" inputmode="numeric" placeholder="未設定" value="{{ old('master[bells]', !empty($detail->master->bells) ? $detail->master->bells : '') }}">
                            </div>
                            <div class="col">
                                <label for="inputCity">定数</label>
                                <input type="number" name="master[const]" class="form-control" inputmode="numeric" placeholder="未設定" value="{{ old('master[const]', !empty($detail->master->const) ? $detail->master->const : '') }}">
                            </div>
                        </div>
                        <div class="form-row align-items-center">
                            <div class="form-group col">
                                <label for="inputCity">ノーツ数(前半)</label>
                                <input type="number" name="master[noteA]" class="form-control" inputmode="numeric" placeholder="未設定" value="{{ old('master[noteA]', !empty($detail->master->notes_before) ? $detail->master->notes_before : '') }}">
                            </div>
                            <div class="form-group col">
                                <label for="inputCity">ノーツ数(後半)</label>
                                <input type="number" name="master[noteB]" class="form-control" inputmode="numeric" placeholder="未設定" value="{{ old('master[noteB]', !empty($detail->master->notes_after) ? $detail->master->notes_after : '') }}">
                            </div>
                        </div>
                    </div>
                </div>
                <!-- lunatic -->
                <div class="form-group row m-0 mb-1 p-2 lunatic">
                    <label for="inputArtist" class="col col-form-label">LUNATIC</label>
                    <div class="d-flex flex-column">
                        <div class="form-row align-items-center">
                            <div class="col">
                                <label for="inputCity">ノーツ数</label>
                                <input type="number" name="lunatic[notes]" class="form-control" inputmode="numeric" placeholder="未設定" value="{{ !empty($detail->lunatic->notes) ? $detail->lunatic->notes : '' }}">
                            </div>
                            <div class="col">
                                <label for="inputCity">ベル</label>
                                <input type="number" name="lunatic[bells]" class="form-control" inputmode="numeric" placeholder="未設定" value="{{ !empty($detail->lunatic->bells) ? $detail->lunatic->bells : '' }}">
                            </div>
                            <div class="col">
                                <label for="inputCity">定数</label>
                                <input type="number" name="lunatic[const]" class="form-control" inputmode="numeric" placeholder="未設定" value="{{ !empty($detail->lunatic->const) ? $detail->lunatic->const : '' }}">
                            </div>
                        </div>
                        <div class="form-row align-items-center">
                            <div class="form-group col">
                                <label for="inputCity">ノーツ数(前半)</label>
                                <input type="number" name="lunatic[noteA]" class="form-control" inputmode="numeric" placeholder="未設定" value="{{ !empty($detail->lunatic->notes_before) ? $detail->lunatic->notes_before : '' }}">
                            </div>
                            <div class="form-group col">
                                <label for="inputCity">ノーツ数(後半)</label>
                                <input type="number" name="lunatic[noteB]" class="form-control" inputmode="numeric" placeholder="未設定" value="{{ !empty($detail->lunatic->notes_after) ? $detail->lunatic->notes_after : '' }}">
                            </div>
                        </div>
                    </div>
                </div>
            </fieldset>
        </form>
        <div class="m-2 text-center">
            <div class="difficult_btn d-block">
                <span class="btn btn-secondary" onclick="difficultEdit()">譜面情報を編集</span>
            </div>
            <div class="difficult_btn d-none">
                <span class="btn btn-outline-success" onclick="sendForm('difficult')">確定</span>
                <span class="btn m-2 btn-outline-secondary" onclick="location.reload()">キャンセル</span>
            </div>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin/song_detail.css" />
@stop

@section('js')
    <script src="/script/admin/song_detail.js"></script>
@stop
