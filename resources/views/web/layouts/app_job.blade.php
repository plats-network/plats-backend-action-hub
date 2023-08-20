<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8" />
        {!! seo() !!}
        <link rel="shortcut icon" href="assets/images/favicon.ico">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1"/>
        <meta name="csrf-token" content="{{ csrf_token() }}"/>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        @notifyCss
        @vite(['resources/sass/event-job.scss'])
    </head>
    <body>
        <div id="auth" class="row justify-content-center">
            <div class="col-md-12">
                @yield('content')
            </div>
        </div>

        <x-notify::notify />
        @notifyJs
    </body>
</html>
