@extends('admin.layout')
@section('content')
    <x-admin::top_page :title="trans('admin.task.create_page')"/>
    <div class="row">
        <div class="col-12 mb-5">
            <div class="card">
                <div class="card-body">
                    <form>
                        {{ csrf_field() }}
                        <x-forms.group :label="trans('admin.task.form.name')">
                            <x-forms.input name="name" :value="old('name')" required/>
                        </x-forms.group>

                        <x-forms.group :label="trans('admin.task.form.desc')">
                            <x-forms.textarea name="description" :value="old('description')" required/>
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
                        </div>
                        <div class="row">
                            <div class="col-lg-3">
                                <x-forms.group :label="trans('admin.task.form.reward_amount')">
                                    <x-forms.input name="reward_amount" :value="old('reward_amount')" required/>
                                </x-forms.group>
                            </div>
                            <div class="col-lg-3">
                                <x-forms.group :label="trans('admin.task.form.status')">
                                    <x-forms.select name="status" select2 required
                                        :options="[INACTIVE_TASK => 'Draft', ACTIVE_TASK => 'Active']"/>
                                </x-forms.group>
                            </div>
                        </div>

                        <div class="mt-3">
                            <a href="#" class="btn btn-icon btn-icon-start btn-outline-info">
                                <i data-acorn-icon="arrow-top-left"></i>
                                <span class="text-uppercase">{{ trans('admin.cancel_form') }}</span>
                            </a>
                            <button type="submit" class="btn btn-icon btn-icon-start btn-primary">
                                <i data-acorn-icon="save"></i>
                                <span class="text-uppercase">{{ trans('admin.save_create') }}</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
