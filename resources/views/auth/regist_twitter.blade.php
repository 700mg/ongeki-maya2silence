@extends('main.layouts.template_b')

@section('title')
    <span>新規登録</span>
@endsection

@section('css')
    <link href="{{ asset('/css/app.css') }}" rel="stylesheet">
@endsection

@section('script')
    <script type="text/javascript">
        body_margin = true;
    </script>
@endsection

@section('content')
    @if (session('error'))
        <div class="alert alert-danger mt-5 mb-1" role="alert">{{ session('error') }}</div>
        <section class="alert alert-secondary mb-3">
    @endif
    @if (!session('error'))
        {{-- コードの見た目の問題でElseは使わないで表記する --}}
        <section class="alert alert-secondary mt-5 mb-3">
    @endif
    <div class="mb-3">
        <p>1. Twitterと連携</p>
        <a class="btn btn-outline-primary" href="{{ route('login.twitter', 'regist') }}">
            <i class="fa-brands fa-twitter"></i>Link with Twitter
        </a>
    </div>
    <div class="mb-3">
        <p>2. 登録するアカウントを確認</p>
        <div class="input-group mb-1">
            <div class="input-group-text">@</div>
            <input type="text" name="user_id" class="form-control " value="{{ session('twitter_regist') ? session('twitter_regist.nickname') : '' }}" placeholder="Twitter ID" disabled>
        </div>
        <div class="input-group mb-1">
            <div class="input-group-text">
                <span class="fa-brands fa-twitter"></span>
            </div>
            <input type="text" name="user_name" class="form-control " value="{{ session('twitter_regist') ? session('twitter_regist.name') : '' }}" placeholder="Nickname" disabled>
        </div>
    </div>
    <div class="mb-3">
        <p>3. 登録</p>
        <form method="GET" action="{{ route('regist.twitter.save') }}">
            <fieldset {{ session('twitter_regist') ? '' : 'disabled' }}>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="" id="defaultCheck1" required>
                    <label class="form-check-label" for="defaultCheck1">利用規約に同意して登録</label>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </fieldset>
        </form>
    </div>
    </section>
@endsection

@section('auth_footer')
    <p class="my-0">
        <a href="{{ route('login') }}">
            {{ __('adminlte::adminlte.i_already_have_a_membership') }}
        </a>
    </p>
@endsection
