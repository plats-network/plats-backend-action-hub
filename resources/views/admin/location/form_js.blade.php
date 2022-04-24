<div class="row">
    <div class="col-md-6">
        <x-forms.group :label="trans('admin.location.form.name')">
            <x-forms.input name="location[{{ $lId ?? 0 }}][name]" :value="$lName ?? ''" required/>
        </x-forms.group>
    </div>
    <div class="col-md-6">
        <x-forms.group :label="trans('admin.location.form.address')">
            <x-forms.input name="location[{{ $lId ?? 0 }}][address]" :value="$lAddress ?? ''" required/>
        </x-forms.group>
    </div>
</div>
<x-forms.group :label="trans('admin.location.form.coordinate')">
    <x-forms.input name="location[{{ $lId ?? 0 }}][coordinate]" :value="$lCoordinate ?? ''"
                   placeholder="21.01137235029502, 105.77812633251307"
                   required/>
</x-forms.group>
