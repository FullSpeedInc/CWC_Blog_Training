<!DOCTYPE html>
<html>
<head>
    <title>Blog: @yield('sitetitle')</title>
    @include("layout.head")
</head>
<body>
    @if (strpos(Request::path(),'/') === 0 ||strpos(Request::path(),'login') === 0 ||
          strpos(Request::path(),'user/logout') === 0)
    @else
        @include("layout.nav")
    @endif

    <main class="valign-wrapper">
        <div class="container">
            @yield("content")
        </div>
    </main>
</body>
</html>