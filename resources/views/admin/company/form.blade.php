<x-alert/>
<x-form::open :action="route(COMPANY_STORE_ADMIN_ROUTER)" files="true">
    <input type="hidden" name="id" value="{{ old('id') }}">
    <div class="row">
        <div class="col-12 mb-5">
            <h2 class="small-title">Basic information</h2>
            <div class="row">
                <div class="col-lg-7">
                    <div class="card">
                        <div class="card-body">
                            <!-- <div class="col-lg-6">
                                <x-forms.group :label="trans('admin.task.form.type')">
                                    <x-forms.select name="type" select2 required
                                                    :options="trans('admin.task.type')"
                                                    :selected="old('type')"/>
                                </x-forms.group>
                            </div> -->
                            <x-forms.group :label="trans('admin.company.form.name')">
                                <x-forms.input name="name" :value="old('name')" required/>
                            </x-forms.group>

                            <x-forms.group :label="trans('admin.company.form.desc')">
                                <x-forms.textarea name="address" :value="old('address')" required/>
                            </x-forms.group>

                            <x-forms.group :label="trans('admin.company.form.phone')">
                                <x-forms.input name="phone" :value="old('phone')" required/>
                            </x-forms.group>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="card mb-3">
                        <div class="card-body">
                            <x-form::label :label="trans('admin.company.form.logo')"/>
                            <div class="position-relative" id="taskImgCover">
                                <img
                                        src="{{ old('logo_path', 'https://via.placeholder.com/250x130?text=Cover Image') }}"
                                        alt="cover"
                                        class="border border-separator-light border-4"
                                        id="taskImgCoverThumb" style="width: 250px; height: 130px"
                                />
                                <button class="btn btn-sm btn-icon btn-icon-only btn-separator-light position-absolute rounded-xl s-0 b-0"
                                        type="button">
                                    <i data-acorn-icon="upload"></i>
                                </button>
                                <input class="file-upload d-none" type="file" name="logo_path" accept="image/*" value="" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mt-3">
                <a href="{{ route(COMPANY_LIST_ADMIN_ROUTER) }}" class="btn btn-icon btn-icon-start btn-outline-info">
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
