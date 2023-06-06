<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8" />
        {!! seo() !!}
        <link rel="shortcut icon" href="assets/images/favicon.ico">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1"/>
        <meta name="csrf-token" content="{{ csrf_token() }}"/>
        @notifyCss
        @vite(['resources/sass/event-auth.scss'])
    </head>
    <body>
        <div id="auth" class="row justify-content-center">
            <div class="col-md-12">
                <p class="text-center">
                    <a href="{{url('/')}}" class="text-center home">Home</a>
                </p>
                @yield('content')
            </div>
        </div>

        <x-notify::notify />
        @notifyJs
    </body>
</html>
