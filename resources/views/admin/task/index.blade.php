@extends('admin.layout')
@section('content')
    <x-admin::top_page :title="trans('admin.task.page_name')" :desc="trans('admin.task.page_desc')">
        <!-- Add New Button Start -->
        <a href="{{ route(TASK_CREATE_ADMIN_ROUTER) }}" class="btn btn-outline-primary btn-icon btn-icon-start w-100 w-md-auto">
            <i data-acorn-icon="plus"></i>
            <span>{{ trans('admin.create') }}</span>
        </a>
        <!-- Add New Button End -->
    </x-admin::top_page>

    <!-- Task List Start -->
    <div class="row">
        <div class="col-12 mb-5">
            <div class="card mb-2 bg-transparent no-shadow d-none d-md-block">
                <div class="row g-0 sh-3">
                    <div class="col">
                        <div class="card-body pt-0 pb-0 h-100">
                            <div class="row g-0 h-100 align-content-center">
                                <div class="col-12 col-md-3 d-flex align-items-center mb-2 mb-md-0 text-muted text-small">
                                    NAME
                                </div>
                                <div class="col-6 col-md-3 d-flex align-items-center text-alternate text-medium text-muted text-small">
                                    REWARD
                                </div>
                                <div class="col-6 col-md-3 d-flex align-items-center text-alternate text-medium text-muted text-small">
                                    STARTED AT
                                </div>
                                <div class="col-6 col-md-2 d-flex align-items-center text-alternate text-medium text-muted text-small">STATUS</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="checkboxTable" class="mb-n2">
                <div class="card mb-2">
                    <div class="row g-0 sh-21 sh-md-7">
                        <div class="col">
                            <div class="card-body pt-0 pb-0 h-100">
                                <div class="row g-0 h-100 align-content-center">
                                    <div class="col-11 col-md-3 d-flex flex-column justify-content-center mb-2 mb-md-0 order-1 order-md-1 h-md-100 position-relative">
                                        <div class="text-muted text-small d-md-none">NAME</div>
                                        <a href="#" class="text-truncate stretched-link">
                                            Check-in at Jules Verne cafe chain
                                        </a>
                                    </div>
                                    <div class="col-6 col-md-3 d-flex flex-column justify-content-center mb-2 mb-md-0 order-3 order-md-2">
                                        <div class="text-muted text-small d-md-none">REWARD</div>
                                        <div class="text-alternate">3.000</div>
                                    </div>
                                    <div class="col-6 col-md-3 d-flex flex-column justify-content-center mb-2 mb-md-0 order-4 order-md-3">
                                        <div class="text-muted text-small d-md-none">STARTED AT</div>
                                        <div class="text-alternate">
                                            2022/04/10
                                        </div>
                                    </div>
                                    <div class="col-6 col-md-2 d-flex flex-column justify-content-center mb-2 mb-md-0 order-last order-md-5">
                                        <div class="text-muted text-small d-md-none">Status</div>
                                        <div class="text-alternate">
                                            <span class="badge rounded-pill bg-outline-primary">ACTIVE</span>
                                        </div>
                                    </div>
                                    <div class="col-1 col-md-1 d-flex flex-column justify-content-center order-2 order-md-last">
                                        <a href="#" class="btn btn-sm btn-icon btn-icon-start btn-outline-primary">
                                            <i data-acorn-icon="edit-square"></i>
                                            <span>Edit</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Task List End -->
@endsection
