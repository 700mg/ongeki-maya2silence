@extends('adminlte::page')

@section('title', 'ユーザー管理')

@section('content')
    <div class="d-flex justify-content-between p-1">
        <a href="{{ route('admin.user.list') }}"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-caret-left-fill" viewBox="0 0 16 16">
                <path d="m3.86 8.753 5.482 4.796c.646.566 1.658.106 1.658-.753V3.204a1 1 0 0 0-1.659-.753l-5.48 4.796a1 1 0 0 0 0 1.506z"></path>
            </svg>
            リストへ戻る
        </a>
    </div>
    <!-- 曲情報 -->
    <div class="section">
        <span>ユーザー情報</span>
        @if (session('success_detail'))
            <div class="alert alert-success" role="alert">{{ session('success_detail') }}</div>
        @endif
        @if (Auth::user()->owner)
            <form class="detail form" method="POST" action={{ route('admin.user.update') }}>
                @csrf
        @endif
        <fieldset style="max-width: 478px;" {{ Auth::user()->owner ? '' : 'disabled' }}>
            {{-- DB ID --}}
            <input type="hidden" name="id" value="{{ $user->id }}">
            {{-- Name --}}
            <div class="input-group mb-1">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon1">Name</span>
                </div>
                <div class="form-control">{{ $user->name }}</div>
            </div>
            {{-- TwitterID --}}
            <div class="input-group mb-1">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon1">TwitterID</span>
                </div>
                <div class="form-control">{{ empty($user->twitter) ? '' : $user->twitter }}</div>
            </div>
            {{-- LastLogin --}}
            <div class="input-group mb-1">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon1">LastLogin</span>
                </div>
                <div class="form-control">{{ $user->updated_at }}</div>
            </div>
            {{-- Admin --}}
            <div class="input-group mb-1">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon1">Admin</span>
                </div>
                @if (!Auth::user()->owner)
                    <div class="form-control">{{ $user->admin == '1' ? 'YES' : 'NO' }}</div>
                @else
                    <select class="custom-select" name="admin">
                        <option value="0" {{ !$user->admin ? 'selected' : '' }}>NO</option>
                        <option value="1" {{ $user->admin ? 'selected' : '' }}>YES</option>
                    </select>
                @endif
            </div>
            {{-- Owner --}}
            <div class="input-group mb-1">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon1">Owner</span>
                </div>
                @if (!Auth::user()->owner)
                    <div class="form-control">{{ $user->owner == '1' ? 'YES' : 'NO' }}</div>
                @else
                    <select class="custom-select" name="owner">
                        <option value="0" {{ !$user->owner ? 'selected' : '' }}>NO</option>
                        <option value="1" {{ $user->owner ? 'selected' : '' }}>YES</option>
                    </select>
                @endif
            </div>
            {{-- Banned --}}
            <div class="input-group mb-1">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon1">Banned</span>
                </div>
                @if (!Auth::user()->owner)
                    <div class="form-control">{{ $user->banned == '1' ? 'YES' : 'NO' }}</div>
                @else
                    <select class="custom-select" name="owner">
                        <option value="0" {{ !$user->banned ? 'selected' : '' }}>NO</option>
                        <option value="1" {{ $user->banned ? 'selected' : '' }}>YES</option>
                    </select>
                @endif
            </div>
            @if (Auth::user()->owner)
                <div class="text-right mt-3">
                    <button type="submit" class="btn btn-outline-primary">Submit</button>
                </div>
            @endif
        </fieldset>
        @if (Auth::user()->owner)
            </form>
        @endif
    </div>
    <div class="section">
        <span>各種設定</span>
        <p class="fs-80p">無闇矢鱈に弄らないよう注意。</p>
        @if (Auth::user()->owner)
            <form class="detail form" method="POST" action={{ route('admin.user.conf.update', Request::route()->id) }}>
                @csrf
                <input type="hidden" name="userid" value="{{ Request::route()->id }}" />
        @endif
        <fieldset style="max-width: 478px;" {{ Auth::user()->owner ? '' : 'disabled' }}>
            {{-- Table Share Param --}}
            <div class="input-group mb-1">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon1">Table Share Param</span>
                </div>
                @if (Auth::user()->owner)
                    <input class="form-control" name="table_shareParam" type="text" maxlength="8" pattern="^[0-9a-zA-Z]+$" value="{{ empty($config['table_shareParam']) ? '' : $config['table_shareParam'] }}" />
                @else
                    <div class="form-control">{{ empty($config['table_shareParam']) ? '' : $config['table_shareParam'] }}</div>
                @endif
            </div>
            {{-- Table Public Setting --}}
            <div class="input-group mb-1">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon1">Table Public Settings</span>
                </div>
                @if (Auth::user()->owner)
                    <select class="custom-select" name="table_public">
                        <option value="0" {{ !$config['table_public'] ? 'selected' : '' }}>NO</option>
                        <option value="1" {{ $config['table_public'] ? 'selected' : '' }}>YES</option>
                    </select>
                @else
                    <div class="form-control">{{ !$config['table_public'] ? 'NO' : 'YES' }}</div>
                @endif
            </div>
            @if (Auth::user()->owner)
                <div class="text-right mt-3">
                    <button type="submit" class="btn btn-outline-primary">Submit</button>
                </div>
            @endif
        </fieldset>
        @if (Auth::user()->owner)
            </form>
        @endif
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin/song_detail.css" />
@stop

@section('js')
@stop
