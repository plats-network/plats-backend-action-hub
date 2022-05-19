<div class="location-form-item js-location_form border rounded shadow p-3 mb-3">
<div class="row">
    <div class="col-md-6">
        <x-forms.group :label="trans('admin.location.form.name')">
            <x-forms.input name="name" :value="$location->name ?? ''" required/>
        </x-forms.group>
    </div>
    <div class="col-md-6">
        <x-forms.group :label="trans('admin.location.form.address')">
            <x-forms.input name="address" :value="$location->address ?? ''" required/>
        </x-forms.group>
    </div>
</div>
<x-forms.group :label="trans('admin.location.form.coordinate')">
    <x-forms.input name="coordinate"
                   :value="$location->coordinate ?? ''"
                   placeholder="21.01137235029502, 105.77812633251307"
                   required/>
</x-forms.group>
@isset($location)
    <input type="hidden" name="id" value="{{ $location->id }}">
@endisset

<button {{ !isset($location) ? 'data-repeater-delete' : '' }}
        class="btn btn-sm btn-danger {{ isset($location) ? 'js-location-delete' : '' }}"
        type="button"
        data-location-id="{{ $location->id ?? '' }}">
    <i class="fa-solid fa-xmark"></i>
    <span>Delete</span>
</button>
</div>
