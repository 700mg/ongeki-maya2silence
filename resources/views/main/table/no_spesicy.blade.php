@extends('main.layouts.template')

@section('title')
    <span>{{ config('userconst.main.table') }}</span>
@endsection

@section('css')
    <link rel="stylesheet" href="/css/main/table/no_spesicy.css" />
@endsection

@section('content')
    <div>
        <div class="outerContainer">
            <a href="/table/11">
                <div class="innerContainer">
                    <img src="{{ asset('storage/songs/jacket/687.jpg') }}" width="100">
                    <span>11.0~11.9</span>
                </div>
            </a>
            <a href="/table/12">
                <div class="innerContainer">
                    <img src="{{ asset('storage/songs/jacket/616.jpg') }}" width="100">
                    <span>12.0~12.9</span>
                </div>
            </a>
            <a href="/table/13">
                <div class="innerContainer">
                    <img src="{{ asset('storage/songs/jacket/136.jpg') }}" width="100">
                    <span>13.0~13.9</span>
                </div>
            </a>
            <a href="/table/14">
                <div class="innerContainer">
                    <img src="{{ asset('storage/songs/jacket/10.jpg') }}" width="100">
                    <span>14.0~15.9</span>
                </div>
            </a>
        </div>
    </div>
@endsection

@section('footer')
    <p>maya2 オンゲキツール 定数表 (https://ongeki.maya2silence.com/table/)</p>
    <p>不具合･要望等があれば<a href="https://twitter.com/suoineau_ac" target="_blank" rel="noopener">管理者</a>までご相談ください。</p>
@endsection
