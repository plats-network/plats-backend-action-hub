<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        {!! seo() !!}
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <link rel="icon" type="image/x-icon" href="favicon.png" />
        <link rel="preconnect" href="https://fonts.googleapis.com" />
        <link rel="preconnect" href="https://fonts.gstatic.com" />
        @notifyCss
        @vite([
            'resources/sass/admin.scss',
            'resources/js/admin.js'
        ])

        @livewireStyles
    </head>

    <body data-layout-size="boxed">
        <div id="layout-wrapper">
            @include('cws.layouts._header')
            @include('cws.layouts._nav')

            @yield('content')
        </div>
        @yield('js')
        @livewireScripts

        <x-notify::notify />
        @notifyJs
    </body>
</html>
