<ul>
    <p class="menu_title">アカウント</p>
    @auth
        <div style="text-align:center">{{ Auth::user()->name }}</div>
        @if (Auth::user()->admin == '1')
            <li><a href="{{ route('admin.main') }}">管理者ページ</a></li>
        @endif
        <li><a href="{{ route('user.mypage') }}">マイページ</a></li>
        <li><a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();logoutForm.submit();">ログアウト</a></li>
        <form id="logoutForm" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
    @else
        <li><a href="{{ route('login') }}">ログイン</a></li>
        <li><a href="{{ route('register') }}">新規登録</a></li>
    @endauth
</ul>
<ul>
    <p class="menu_title">他ツール</p>
    <li><a href="/">メインページ</a></li>
    <li><a href="{{ route('news.list') }}">{{ config('userconst.main.news') }}</a></li>
    <li><a href="{{ route('main.table.noLv') }}">{{ config('userconst.main.table') }}</a></li>
    <li><a href="{{ route('main.calculator') }}">{{ config('userconst.main.calculator') }}</a></li>
    <li><a href="{{ route('database.list') }}">{{ config('userconst.main.database') }}</a></li>
    <li><a href="{{ route('bookmarklet.list') }}">{{ config('userconst.main.bookmarklet') }}</a></li>
    <li style="display: none"><a href="">課題曲ガチャ</a></li>
</ul>
