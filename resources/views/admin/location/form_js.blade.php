<div class="location-form-item js-location_form border rounded shadow p-3 mb-3">
<div class="row">
    <div class="col-md-6">
        <x-forms.group :label="trans('admin.location.form.name')">
            <x-forms.input name="name" :value="$location['name'] ?? ''" required/>
        </x-forms.group>
    </div>
    <div class="col-md-6">
        <x-forms.group :label="trans('admin.location.form.address')">
            <x-forms.input name="address" :value="$location['address'] ?? ''" required/>
        </x-forms.group>
    </div>
    <div class="col-md-6">
        <x-forms.group :label="trans('admin.location.form.phone_number')">
            <x-forms.input :placeholder="trans('admin.placeholders.phone_number')" name="phone_number" :value="$location['phone_number'] ?? ''"/>
        </x-forms.group>
    </div>
    <div class="col-md-6">
        <x-forms.group :label="trans('admin.location.form.open_time')">
            <div class="row mx-0">
                <x-forms.input class="col mr-2" type="time" name="open_time" :value="$location['open_time'] ?? ''"/>
                <x-forms.input class="col" type="time" name="close_time" :value="$location['close_time'] ?? ''"/>
            </div>
        </x-forms.group>
    </div>
</div>
<x-forms.group class="wrap-coordinate" :label="trans('admin.location.form.coordinate')">
    <x-forms.input name="coordinate"
                   onchange="handleCoordinate(event)"
                   :value="$location['coordinate'] ?? ''"
                   placeholder="21.01137235029502, 105.77812633251307"
                   required/>
    <input type="hidden" class="latitude" name="lat" value="{{ $location['lat'] ?? '' }}">
    <input type="hidden" class="longitude" name="long" value="{{ $location['long'] ?? '' }}">
</x-forms.group>
@isset($location)
    <input type="hidden" name="id" value="{{ $location['id'] ?? '' }}">
@endisset

<button {{ !isset($location) ? 'data-repeater-delete' : '' }}
        class="btn btn-sm btn-danger {{ isset($location) ? 'js-location-delete' : '' }}"
        type="button"
        data-location-id="{{ $location['id'] ?? '' }}">
    <i class="fa-solid fa-xmark"></i>
    <span>Delete</span>
</button>
</div>
<script>
function handleCoordinate(e) {
    let coordinate = e.target.value.split(',')
    console.log(coordinate)
    console.log(e.target.value)
    let parent = $(e.target).parents('.wrap-coordinate')
    parent.find('.latitude').val(coordinate[0])
    parent.find('.longitude').val(coordinate[1])
}
</script>
