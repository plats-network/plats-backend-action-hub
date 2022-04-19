@switch(request()->route()->getName())
    @case(TASK_CREATE_ADMIN_ROUTER)
    @case(TASK_EDIT_ADMIN_ROUTER)
    <script src="{{ asset('js/admin/theme/plugins/singleimageupload.js') }}"></script>
    <script src="{{ asset('js/admin/theme//plugins/dropzone.templates.js') }}"></script>
    <script src="{{ mix('/static/js/admin/pages/task.js') }}"></script>
    @break
@endswitch
