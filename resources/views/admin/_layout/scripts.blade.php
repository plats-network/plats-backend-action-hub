<!-- Vendor Scripts Start -->
<script src="{{ asset('js/admin/vendor.js') }}"></script>
<script src="{{ asset('theme-acorn/plugins/scrollbarByCount.js') }}"></script>

<script src="{{ asset('theme-acorn/icon/acorn-icons.js') }}"></script>
<script src="{{ asset('theme-acorn/icon/acorn-icons-interface.js') }}"></script>
<script src="{{ asset('theme-acorn/icon/acorn-icons-commerce.js') }}"></script>

@yield('js_vendor')
<!-- Vendor Scripts End -->
<!-- Template Base Scripts Start -->
<script src="{{ asset('theme-acorn/base/helpers.js') }}"></script>
<script src="{{ asset('theme-acorn/base/globals.js') }}"></script>
<script src="{{ asset('theme-acorn/base/nav.js') }}"></script>
<script src="{{ asset('theme-acorn/base/search.js') }}"></script>
<script src="{{ asset('theme-acorn/base/settings.js') }}"></script>
<!-- Template Base Scripts End -->
<!-- Page Specific Scripts Start -->
@yield('js_page')

<script src="{{ asset('theme-acorn/common.js') }}"></script>
<script src="{{ asset('theme-acorn/scripts.js') }}"></script>
<script src="{{ asset('js/admin/app.js') }}"></script>
<!-- Page Specific Scripts End -->
