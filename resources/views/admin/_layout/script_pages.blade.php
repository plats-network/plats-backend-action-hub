@switch(request()->route()->getName())
    @case(TASK_CREATE_ADMIN_ROUTER)
    @case(TASK_EDIT_ADMIN_ROUTER)
    <script src="{{ asset('js/admin/theme/plugins/singleimageupload.js') }}"></script>
    <script src="{{ asset('js/admin/theme//plugins/dropzone.templates.js') }}"></script>
    <script src="{{ mix('/static/js/admin/pages/task.js') }}"></script>
    @break
    @case(TASK_DEPOSIT_ADMIN_ROUTER)
    <script src="{{ mix('/static/js/admin/pages/deposit.js') }}"></script>
    @break
    @case(ANALYSIS_DASHBOARD_ADMIN_ROUTER)
    <script src="https://acorn-laravel-classic-dashboard.coloredstrategies.com/js/vendor/Chart.bundle.min.js"></script>
    <script src="https://acorn-laravel-classic-dashboard.coloredstrategies.com/js/vendor/chartjs-plugin-rounded-bar.min.js"></script>
    <script src="https://acorn-laravel-classic-dashboard.coloredstrategies.com/js/vendor/chartjs-plugin-crosshair.js"></script>
    <script src="https://acorn-laravel-classic-dashboard.coloredstrategies.com/js/vendor/chartjs-plugin-datalabels.js"></script>
    <script src="https://acorn-laravel-classic-dashboard.coloredstrategies.com/js/vendor/select2.full.min.js"></script>
    <script src={{ asset('js/admin/theme/plugins/chart.extends.js') }}></script>
    <script src="{{ mix('/static/js/admin/pages/analysis.js') }}"></script>
    <script src="https://acorn-laravel-classic-dashboard.coloredstrategies.com/js/forms/controls.rating.js"></script>
    <script src="https://acorn-laravel-classic-dashboard.coloredstrategies.com/js/vendor/jquery.barrating.min.js"></script>


    @break
@endswitch
