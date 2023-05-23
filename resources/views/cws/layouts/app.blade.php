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
        <script src="https://unpkg.com/@popperjs/core@2"></script>
        @notifyCss
        @vite([
            'resources/sass/admin.scss',
            'resources/js/admin.js'
        ])

        @livewireStyles
    </head>

    <body
        x-data="main"
        class="relative overflow-x-hidden font-nunito text-sm font-normal antialiased light boxed-layout ltr"
        :class="[ $store.app.sidebar ? 'toggle-sidebar' : '', $store.app.theme, $store.app.menu, $store.app.layout,$store.app.rtlClas]">

        <div class="fixed inset-0 z-50 bg-[black]/60 lg:hidden"></div>
            <div class="main-container min-h-screen text-black dark:text-white-dark" :class="[$store.app.navbar]">
                @include('cws.layouts._nav')
                <div class="main-content">
                    @include('cws.layouts._header')

                    <div class="animate__animated p-6" :class="[$store.app.animation]">
                        @yield('content')

                        <p class="pt-6 text-center dark:text-white-dark ltr:sm:text-left rtl:sm:text-right">
                            &copy; <span id="footer-year">{{now()->format('Y')}}</span>. Plats All rights reserved.
                        </p>
                    </div>
                </div>
            </div>
        </body>

        {{-- @include('cws.layouts._loading') --}}

        <div class="fixed bottom-6 z-50 ltr:right-6 rtl:left-6" x-data="scrollToTop">
            <template x-if="showTopButton">
                <button
                    type="button"
                    class="btn btn-outline-primary animate-pulse rounded-full bg-[#fafafa] p-2 dark:bg-[#060818] dark:hover:bg-primary"
                    @click="goToTop"
                >
                    <svg width="24" height="24" class="h-4 w-4" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path
                            opacity="0.5"
                            fill-rule="evenodd"
                            clip-rule="evenodd"
                            d="M12 20.75C12.4142 20.75 12.75 20.4142 12.75 20L12.75 10.75L11.25 10.75L11.25 20C11.25 20.4142 11.5858 20.75 12 20.75Z"
                            fill="currentColor"
                        />
                        <path
                            d="M6.00002 10.75C5.69667 10.75 5.4232 10.5673 5.30711 10.287C5.19103 10.0068 5.25519 9.68417 5.46969 9.46967L11.4697 3.46967C11.6103 3.32902 11.8011 3.25 12 3.25C12.1989 3.25 12.3897 3.32902 12.5304 3.46967L18.5304 9.46967C18.7449 9.68417 18.809 10.0068 18.6929 10.287C18.5768 10.5673 18.3034 10.75 18 10.75L6.00002 10.75Z"
                            fill="currentColor"
                        />
                    </svg>
                </button>
            </template>
        </div>

        @yield('js')
        @livewireScripts

        <x-notify::notify />
        @notifyJs
    </body>
</html>
