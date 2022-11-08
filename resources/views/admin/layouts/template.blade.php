<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=no" />
    <title>maya2 オンゲキ 管理ツール</title>
    <link rel="stylesheet" href="/css/main/common.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    @yield('css')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    @yield('script')
</head>

<body>
    <div id="main_header">
        <div class="header_first">
            <span class="title">
                @yield('title')
            </span>
            <span class="menu_btn">
                <span class="menu_btn_inner"></span>
            </span>
        </div>
        @if (View::hasSection('header_menu'))
            <div class="header_sec">
                @yield('header_menu')
            </div>
        @endif
    </div>
    <div class="container">
        @yield('content')
    </div>
    @yield('outer_content')
    <footer>
        <div class="contact">
            @yield('footer')
        </div>
    </footer>
    <div class="menu">
        <input type="checkbox" id="menu_btn_check" style="display: none;">
        <div class="menu_content">
            <span class="menu_btn">
                <span class="menu_btn_inner"></span>
            </span>
            <p class="menu_title">他ツール</p>
            @include('main.layouts.menu')
        </div>
        <div id='menu_background' onclick='closeMenu()'></div>
    </div>
    <script type="text/javascript">
        function handle(event) {
            event.preventDefault();
        }
        $("div.container").css({
            marginTop: $("#main_header").height() + 10,
            marginBottom: $("#main_footer").height() + 10,
        });

        document.addEventListener("dblclick", handle, {
            passive: false
        });

        $(".menu_btn").on("click", function(e) {
            if (!menu_btn_check.checked)
                $("#menu_background").fadeIn("fast");
            else
                $("#menu_background").fadeOut("fast");
            menu_btn_check.checked = !menu_btn_check.checked;
        });

        function closeMenu() {
            menu_btn_check.checked = false;
            $("#menu_background").fadeOut("fast");
        };
    </script>
</body>

</html>
