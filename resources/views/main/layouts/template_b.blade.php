<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=no,viewport-fit-cover" />
    <title>maya2 オンゲキツール</title>
    <link rel="stylesheet" href="/css/main/common.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    @yield('css')
    <link rel="stylesheet" href="{{ asset('vendor/bootstrap/css/bootstrap.min.css') }}" />
    {{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script> --}}
    <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('vendor/popper/popper.min.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.min.js') }}"></script>
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
            @include('main.layouts.menu')
        </div>
        <div id='menu_background' onclick='closeMenu()'></div>
    </div>
    <script type="text/javascript">
        document.addEventListener("DOMContentLoaded", function() {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl)
            });
        });

        function handle(event) {
            event.preventDefault();
        }

        if (typeof body_margin === 'undefined')
            $("body").css({
                marginTop: $("#main_header").height() + 10 + "px",
                marginBottom: $("#main_footer").height() + 10 + "px",
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
        }
    </script>
</body>

</html>
