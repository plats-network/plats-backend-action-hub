<x-alert/>
<x-form::open :action="route(TASK_STORE_ADMIN_ROUTER)" files="true">
    <input type="hidden" name="id" value="{{ old('id') }}">
    <div class="row">
        <div class="col-12 mb-5">
            <h2 class="small-title">Basic information222</h2>
            <div class="row">
                <div class="col-lg-7">
                    <div class="card">
                        <div class="card-body">
                            <div class="col-lg-6">
                                <x-forms.group :label="trans('admin.task.form.type')">
                                    <x-forms.select name="type" select2 required
                                                    :options="trans('admin.task.type')"
                                                    :selected="old('type')"/>
                                </x-forms.group>
                            </div>
                            <x-forms.group :label="trans('admin.task.form.name')">
                                <x-forms.input name="name" :value="old('name')" required/>
                            </x-forms.group>
                            <x-forms.group :label="trans('admin.task.form.desc')">
                                <x-forms.textarea name="description" :value="old('description')"/>
                            </x-forms.group>
                            <div class="row">
                                <div class="col-lg-6">
                                    <x-forms.group :label="trans('admin.task.form.duration')">
                                        <x-forms.input type="number" name="duration" :value="old('duration')" required/>
                                    </x-forms.group>
                                </div>
                                <div class="col-lg-6">
                                    <x-forms.group :label="trans('admin.task.form.order')">
                                        <x-forms.select name="order" select2 required
                                                        :options="trans('admin.task.order')"
                                                        :selected="old('order')"/>
                                    </x-forms.group>
                                </div>
                                <div class="col-lg-6">
                                    <x-forms.group :label="trans('admin.task.form.valid_amount')">
                                        <x-forms.input name="valid_amount" type="number" min="1"  :placeholder="trans('admin.placeholders.valid_amount')" :value="old('valid_amount')" required/>
                                    </x-forms.group>
                                </div>
                                <div class="col-lg-6">
                                    <x-forms.group :label="trans('admin.task.form.status')">
                                        <x-forms.select name="status" select2 required
                                                        :options="[INACTIVE_TASK => 'Draft', ACTIVE_TASK => 'Active']"
                                                        :selected="old('status')"/>
                                    </x-forms.group>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="card mb-3">
                        <div class="card-body">
                            <x-form::label :label="trans('admin.task.form.image')"/>
                            <div class="position-relative" id="taskImgCover">
                                <img
                                        src="{{ old('cover_url', 'https://via.placeholder.com/250x130?text=Cover Image') }}"
                                        alt="cover"
                                        class="border border-separator-light border-4"
                                        id="taskImgCoverThumb" style="width: 250px; height: 130px"
                                />
                                <button class="btn btn-sm btn-icon btn-icon-only btn-separator-light position-absolute rounded-xl s-0 b-0"
                                        type="button">
                                    <i data-acorn-icon="upload"></i>
                                </button>
                                <input class="file-upload d-none" type="file" name="image" accept="image/*" value="" />
                            </div>
                        </div>
                    </div>
                    <!-- END cover image -->
                    <h2 class="small-title mt-3">Task galleries</h2>
                    <div class="card">
                        <div class="card-body">
                            <div class="dropzone" id="taskGallery">
                            </div>
                            <div class="fallback"> <!-- this is the fallback if JS isn't working -->
                                <input name="gallery" type="file" class="d-none" multiple />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--- END Basic information -->
            <!--- Guilds -->
            @include('admin.task._form.guild')
            <!--- End Guilds -->


            <h2 class="small-title mt-3">Locations</h2>
            <div class="card">
                <div class="card-body js-repeater">
                    <div data-repeater-list="locations">
                        @if((isset($task) && count($task->locations)) || old('locations'))
                        @php
                            $locations = old('locations') ? old('locations') : $task->locations
                        @endphp
                        @foreach($locations as $key => $location)
                            <div class="" data-repeater-item="{{ $location->id ?? '' }}">
                            @include('admin.location.form_js', ['location' => $location])
                            </div>
                        @endforeach
                        @else
                        <div class="" data-repeater-item>
                            @include('admin.location.form_js')
                        </div>
                        @endif
                    </div>
                    <button data-repeater-create class="btn btn-icon btn-icon-start btn-info" type="button">
                        <i data-acorn-icon="plus"></i>
                        <span>Add a new location</span>
                    </button>
                </div>
            </div>
            <div class="mt-3">
                <a href="{{ route(TASK_LIST_ADMIN_ROUTER) }}" class="btn btn-icon btn-icon-start btn-outline-info">
                    <i data-acorn-icon="arrow-top-left"></i>
                    <span class="text-uppercase">{{ trans('admin.cancel_form') }}</span>
                </a>
                <button type="submit" class="btn btn-icon btn-icon-start btn-primary">
                    <i data-acorn-icon="save"></i>
                    <span class="text-uppercase">
                        {{ old('id') ? trans('admin.save_edit') : trans('admin.save_create') }}
                    </span>
                </button>
            </div>


        </div>
    </div>
</x-form::open>
