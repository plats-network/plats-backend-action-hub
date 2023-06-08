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

        @yield('style')
        @livewireStyles

        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js" referrerpolicy="origin"></script>

    </head>

    <body data-layout-size="boxed">
        <div id="layout-wrapper">
            @include('cws.layouts._header')
            @include('cws.layouts._nav')

            <div class="main-content">
                <div class="page-content">
                    <div class="container-fluid">
                        @yield('content')
                    </div>
                </div>
                <footer class="footer">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-sm-6">
                                <script>document.write(new Date().getFullYear())</script> &copy; plats
                            </div>
                            <div class="col-sm-6">
                                <div class="text-sm-end d-none d-sm-block">
                                    Crafted with by <a href="#" target="_blank" class="text-reset">Plats</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
        @yield('js')
        @livewireScripts

        <x-notify::notify />
        @notifyJs
        @yield('scripts')
    </body>

</html>
