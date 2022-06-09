<x-alert/>
<x-form::open :action="route(TASK_STORE_ADMIN_ROUTER)" files="true">
    <input type="hidden" name="id" value="{{ old('id') }}">
    <div class="row">
        <div class="col-12 mb-5">
            <h2 class="small-title">Basic information</h2>
            <div class="row">
                <div class="col-lg-7">
                    <div class="card">
                        <div class="card-body">
                            <x-forms.group :label="trans('admin.task.form.name')">
                                <x-forms.input name="name" :value="old('name')" required/>
                            </x-forms.group>
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
                                        <x-forms.input type="number" name="reward_amount" :value="old('reward_amount')" required/>
                                    </x-forms.group>
                                </div>
                                <div class="col-lg-6">
                                    <x-forms.group :label="trans('admin.task.form.total_reward')">
                                        @if (old('id'))
                                            <div class="form-control-plaintext fw-bold">
                                                {{ old('total_reward') }}
                                            </div>
                                        @else
                                            <x-forms.input type="number" name="total_reward" :value="old('total_reward')" required/>
                                        @endif
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
                            <x-forms.group :label="trans('admin.task.form.desc')">
                                <x-forms.textarea name="description" :value="old('description')"/>
                            </x-forms.group>
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
                    <section class="scroll-section" id="teams">
                        <h2 class="small-title">Guilds</h2>
                        <div class="card h-100-card">
                            <div class="card-body mb-n2 scroll-out">
                                <div class="scroll-by-count" data-count="3" data-childSelector="div.item" data-subtractMargin="false">
                                    @for ($i = 0; $i < 10; $i++)
                                    <div class="row g-0 align-items-start align-content-start align-content-md-center align-items-md-center sh-13
                                    sh-md-7 mb-2 item">
                                        <div class="col-auto d-flex align-items-center mb-md-0">
                                            <div class="sw-12 me-1 mb-1">
                                                <img src="{{ asset('img/admin/demo/list/01.webp') }}" class="img-fluid rounded-md sh-7 sw-10"
                                                     alt="thumb">
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="row g-0 h-100 align-items-start align-content-start align-content-md-center align-items-md-center">
                                                <div class="col-12 col-md-6 d-flex flex-column pe-2 mb-2 mb-md-0">
                                                    <div>Plats Hanoi</div>
                                                    <div class="text-muted text-small">5 Members</div>
                                                </div>
                                                <div class="col-auto col-md-4 d-flex flex-column align-items-start align-items-md-end pe-3">
                                                    <div>{{ rand(2, 12) }} Tasks</div>
                                                    <div class="text-small text-muted">Active</div>
                                                </div>
                                                <div class="col-auto col-md-2 d-flex flex-column align-items-start align-items-md-end">
                                                    <label class="form-check custom-icon mb-0">
                                                        <input type="checkbox" class="form-check-input" name="guilds[{{ $i }}]" value="{{ $i }}"
                                                               {{ $i < 3 ? 'checked' : '' }} />
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endfor
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
            <!--- END Basic information -->
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
                <div class="card-body js-repeater">
                    <div data-repeater-list="location">
                        @isset($task)
                        @foreach($task->locations as $location)
                            <div class="" data-repeater-item="{{ $location->id }}">
                            @include('admin.location.form_js', ['location' => $location])
                            </div>
                        @endforeach
                        @else
                        <div class="" data-repeater-item>
                            @include('admin.location.form_js')
                        </div>
                        @endisset
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
