<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <title>{!! seo($page ?? null) !!}</title>
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <link rel="icon" type="image/x-icon" href="favicon.png" />
        <link rel="preconnect" href="https://fonts.googleapis.com" />
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />

        @notifyCss
        @vite(['resources/sass/admin.scss', 'resources/js/admin.js'])
    </head>

    <body class="relative overflow-x-hidden font-nunito text-sm font-normal antialiased">
        {{-- @include('cws.layouts._loading') --}}

        <div class="main-container min-h-screen text-black dark:text-white-dark">
            <div class="flex min-h-screen items-center justify-center bg-cover bg-center" style="background-image: url('imgs/map.svg')">
                @yield('content')
            </div>
        </div>

        {{-- <script>
            // main section
            document.addEventListener('alpine:init', () => {
                Alpine.data('scrollToTop', () => ({
                    showTopButton: false,
                    init() {
                        window.onscroll = () => {
                            this.scrollFunction();
                        };
                    },

                    scrollFunction() {
                        if (document.body.scrollTop > 50 || document.documentElement.scrollTop > 50) {
                            this.showTopButton = true;
                        } else {
                            this.showTopButton = false;
                        }
                    },

                    goToTop() {
                        document.body.scrollTop = 0;
                        document.documentElement.scrollTop = 0;
                    },
                }));
            });
        </script> --}}

        <x-notify::notify />
        @notifyJs
    </body>
</html>
