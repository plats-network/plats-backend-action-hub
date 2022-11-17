@extends('admin.layout')

@section('content')
    <!-- Header -->
    <x-admin::top_page :title="trans('admin.reward.page_name')" :desc="trans('admin.reward.page_desc')">
        <a href="{{ route(REWARD_CREATE_ADMIN_ROUTER) }}" class="btn btn-outline-primary btn-icon btn-icon-start w-100 w-md-auto">
            <i data-acorn-icon="plus"></i>
            <span>{{ trans('admin.create') }}</span>
        </a>
    </x-admin::top_page>

    <!-- Alert -->
    <x-alert/>

    <!-- Content -->
    <div class="row">
        <div class="col-12 mb-5">
            <div class="card mb-2 bg-transparent no-shadow d-none d-md-block">
                <div class="row g-0 sh-3">
                    <div class="sw-20">
                    </div>
                    <div class="col">
                        <div class="card-body pt-0 pb-0 h-100">
                            <div class="row g-0 h-100 align-content-center">
                                <div class="col-12 col-md-5 d-flex align-items-center mb-2 mb-md-0 text-muted text-small">
                                    NAME
                                </div>
                                <div class="col-6 col-md-2 d-flex align-items-center text-alternate text-medium text-muted text-small">
                                    DESC
                                </div>
                                <div class="col-6 col-md-1 d-flex align-items-center text-alternate text-medium text-muted text-small">
                                    Image
                                </div>
                                <div class="col-6 col-md-1 d-flex align-items-center text-alternate text-medium text-muted text-small">
                                    Start At
                                </div>
                                <div class="col-6 col-md-1 d-flex align-items-center text-alternate text-medium text-muted text-small">
                                    End at
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="checkboxTable" class="mb-n2">
                @foreach($rewards as $reward)
                <div class="card mb-2">
                    <div class="row g-0 sh-19 sh-lg-18">
                        <div class="col-auto">
                            <img src="{{ $reward->image }}" alt="alternate text" class="card-img card-img-horizontal sw-20 sh-18">
                        </div>
                        <div class="col">
                            <div class="card-body pt-0 pb-0 h-100">
                                <div class="row g-0 h-100 align-content-center">
                                    <div class="col-12 col-md-7 d-flex flex-column mb-lg-0 pe-3 d-flex">
                                        <h4>
                                            <a href="{{ route(REWARD_EDIT_ADMIN_ROUTER, $reward->id) }}" class="stretched-link">
                                                {{ $reward->name }}
                                            </a>
                                        </h4>
                                    </div>
                                    <div class="col-6 col-md-1 d-flex flex-column justify-content-center">
                                        <div class="text-small text-muted d-md-block">
                                            {{ $reward->description }}
                                        </div>
                                        {{ $reward->description }}
                                    </div>
                                    <div class="col-6 col-md-1 d-flex flex-column justify-content-center">
                                        <div class="text-small text-muted d-md-block">
                                            {{ $reward->start_at }}
                                        </div>
                                    </div>
                                    <div class="col-6 col-md-1 d-flex flex-column justify-content-center">
                                        <div class="text-small text-muted d-md-block">
                                            {{ $reward->end_at }}
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-1 d-flex flex-column justify-content-center order-last order-md-last">
                                        <a href="{{ route(REWARD_EDIT_ADMIN_ROUTER, $reward->id) }}"
                                           class="btn btn-sm btn-icon btn-icon-start btn-outline-primary ms-1">
                                            <i data-acorn-icon="edit-square"></i>
                                            <span>Edit</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
