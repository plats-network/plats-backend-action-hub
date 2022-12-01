<div class="social-form-item js_form border rounded shadow p-3 mb-3">
    <div class="row">
        <div class="col-md-6">
            <x-forms.group :label="trans('admin.task.social.platform')">
                <x-forms.select name="platform" select2
                    :options="trans('admin.task.social.platform_option')"
                    :selected="$social['platform'] ?? ''" required />
            </x-forms.group>
        </div>
        <div class="col-md-6">
            <x-forms.group :label="trans('admin.task.social.action')">
                <x-forms.select name="type_social" select2
                    :options="trans('admin.task.social.type')"
                    :selected="$social['type'] ?? ''" required />
            </x-forms.group>
        </div>
        <div class="col-md-12">
            <x-forms.group :label="trans('admin.task.social.name')">
                <x-forms.input name="name" :value="$social['name'] ?? ''" required/>
            </x-forms.group>
        </div>
        <div class="col-md-12">
            <x-forms.group :label="trans('admin.task.form.desc')">
                <x-forms.textarea name="description" :value="$social['description'] ?? ''"/>
            </x-forms.group>
        </div>
        <div class="col-md-12">
            <x-forms.group :label="trans('admin.task.social.url')">
                <x-forms.input name="url" :value="$social['url'] ?? ''" required />
            </x-forms.group>
        </div>
    </div>

    @isset($social)
        <input type="hidden" name="id" value="{{ $social['id'] ?? '' }}">
    @endisset

    <button {{ !isset($social) ? 'data-repeater-delete' : '' }}
        class="btn btn-sm btn-danger {{ isset($social) ? 'js-delete' : '' }}"
        type="button"
        data-id="{{ $social['id'] ?? '' }}">
        <span>Delete</span>
    </button>
</div>
