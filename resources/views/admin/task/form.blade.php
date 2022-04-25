<x-alert/>
<x-form::open :action="route(TASK_STORE_ADMIN_ROUTER)" files="true">
    <input type="hidden" name="id" value="{{ old('id') }}">
    <div class="row">
        <div class="col-12 mb-5">
            <h2 class="small-title">Basic information</h2>
            <div class="card">
                <div class="card-body">
                    <x-forms.group :label="trans('admin.task.form.name')">
                        <x-forms.input name="name" :value="old('name')" required/>
                    </x-forms.group>

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="row">
                                <div class="col-lg-6">
                                    <x-forms.group :label="trans('admin.task.form.duration')">
                                        <x-forms.input name="duration" :value="old('duration')" required/>
                                    </x-forms.group>
                                </div>
                                <div class="col-lg-6">
                                    <x-forms.group :label="trans('admin.task.form.distance')">
                                        <x-forms.input name="distance" :value="old('distance')" required/>
                                    </x-forms.group>
                                </div>
                                <div class="col-lg-6">
                                    <x-forms.group :label="trans('admin.task.form.reward_amount')">
                                        <x-forms.input name="reward_amount" :value="old('reward_amount')" required/>
                                    </x-forms.group>
                                </div>
                                <div class="col-lg-6">
                                    <x-forms.group :label="trans('admin.task.form.status')">
                                        <x-forms.select name="status" select2 required
                                                        :options="[INACTIVE_TASK => 'Draft', ACTIVE_TASK => 'Active']"/>
                                    </x-forms.group>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
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

                    <x-forms.group :label="trans('admin.task.form.desc')">
                        <x-forms.textarea name="description" :value="old('description')"/>
                    </x-forms.group>
                </div>
            </div>
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

            <h2 class="small-title mt-3">Locations</h2>
            <div class="card">
                <div class="card-body ">
                    <div class="js-append-location">
                        <div class="js-location_form">
                            @include('admin.location.form_js')
                            <hr/>
                        </div>
                    </div>
                    <p class="m-0">
                        <button type="button" class="btn btn-icon btn-icon-only btn-outline-secondary js-plus-location">
                            <i data-acorn-icon="plus"></i>
                        </button>
                    </p>
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
