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
    <section class="d-none alert alert-secondary mt-5 mb-3">
        <p>メールアドレスで登録</p>
        <form action="{{ route('register') }}" method="post">
            @csrf
            {{-- Email field --}}
            <div class="input-group mb-2">
                <div class="input-group-text">
                    <span class="fas fa-envelope"></span>
                </div>
                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" placeholder="メールアドレス">
                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            {{-- Password field --}}
            <div class="input-group mb-2">
                <div class="input-group-text">
                    <span class="fas fa-lock"></span>
                </div>
                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="パスワード">
                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            {{-- Confirm password field --}}
            <div class="input-group mb-2">
                <div class="input-group-text">
                    <span class="fas fa-lock"></span>
                </div>
                <input type="password" name="password_confirmation" class="form-control @error('password_confirmation') is-invalid @enderror" placeholder="もう一度入力">
                @error('password_confirmation')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            {{-- Register button --}}
            <button type="submit" class="btn btn-primary">
                <span class="fas fa-user-plus"></span>
                上記内容で登録
            </button>
        </form>
    </section>
    <section class="alert alert-secondary text-center mt-5" role="alert">
        <div class="mb-2">
            <span>現在はTwitterのみ登録できます</span>
        </div>
        <div class="mb-2">
            <a class="btn btn-outline-primary" href="{{ route('regist.twitter') }}">
                <i class="fa-brands fa-twitter"></i> Sign up with Twitter
            </a>
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
