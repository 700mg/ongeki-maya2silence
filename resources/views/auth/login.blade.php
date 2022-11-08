@extends('main.layouts.template_b')

@section('title')
    <span>ログイン</span>
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
    <div class="d-flex align-items-center" style="height: 100vh">
        <div class="w-100 m-auto" style="max-width: 473px">
            @if (session('error'))
                <div class="alert alert-danger mt-5 mb-1" role="alert">{{ session('error') }}</div>
            @endif
            <section class="alert alert-secondary d-none" role="alert">
                <strong>メールアドレスでログイン</strong>
                <form action="{{ route('login') }}" method="post">
                    @csrf

                    {{-- エラーメッセージ --}}
                    @error('email')
                        <div class="alert alert-danger" role="alert">
                            <strong>メールアドレス、またはパスワードが間違っています。</strong>
                        </div>
                    @enderror
                    @error('password')
                        <div class="alert alert-danger" role="alert">
                            <strong>メールアドレス、またはパスワードが間違っています。</strong>
                        </div>
                    @enderror

                    {{-- Email field --}}
                    <div class="input-group mb-2">
                        <div class="input-group-text">
                            <span class="fas fa-envelope"></span>
                        </div>
                        <input type="email" name="email" class="form-control" value="{{ old('email') }}" placeholder="メールアドレス" autofocus>
                    </div>

                    {{-- Password field --}}
                    <div class="input-group mb-2">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                        <input type="password" name="password" class="form-control" placeholder="パスワード">
                    </div>

                    {{-- Login field --}}
                    <div class="row">
                        <div class="col-8">
                            <div class="icheck-primary">
                                <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                <label for="remember">パスワードを記憶する</label>
                            </div>
                        </div>
                        <div class="col-4">
                            <button type=submit class="btn btn-block {{ config('adminlte.classes_auth_btn', 'btn-flat btn-primary') }}">
                                <span class="fas fa-sign-in-alt"></span>
                                ログイン
                            </button>
                        </div>
                    </div>
                </form>
            </section>
            <section class="alert alert-secondary text-center" role="alert">
                <div class="mb-2">
                    <span>現在はTwitterでのみログインできます</span>
                </div>
                <div class="mb-2">
                    <a class="btn btn-outline-primary" href="{{ route('login.twitter', 'login') }}">
                        <i class="fa-brands fa-twitter"></i> Sign in with Twitter
                    </a>
                </div>
                <div class="mb-2">
                    <span>アカウント作成は<a class="p-1 fw-bolder" href="{{ route('regist.twitter') }}">こちら</a></span>
                </div>
            </section>
        </div>
    </div>
@endsection
