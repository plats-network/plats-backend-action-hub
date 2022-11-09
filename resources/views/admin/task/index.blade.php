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

    <x-alert/>
    <!-- Task List Start -->
    <div class="row">
        <div class="col-12 mb-5">
            <div class="card mb-2 bg-transparent no-shadow d-none d-md-block">
                <div class="row g-0 sh-3">
                    <div class="sw-20">
                    </div>
                    <div class="col">
                        <div class="card-body pt-0 pb-0 h-100">
                            <div class="row g-0 h-100 align-content-center">
                                <div class="col-12 col-md-7 d-flex align-items-center mb-2 mb-md-0 text-muted text-small">
                                    NAME
                                </div>
                                <div class="col-6 col-md-1 d-flex align-items-center text-alternate text-medium text-muted text-small">
                                    REWARD
                                </div>
                                <div class="col-6 col-md-1 d-flex align-items-center text-alternate text-medium text-muted text-small">
                                    STATUS
                                </div>
                                <div class="col-6 col-md-2 d-flex align-items-center text-alternate text-medium text-muted text-small text-uppercase">
                                    Locations / Participants
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="checkboxTable" class="mb-n2">
                @foreach($tasks as $task)
                <div class="card mb-2">
                    <div class="row g-0 sh-19 sh-lg-18">
                        <div class="col-auto">
                            <img src="{{ $task->cover_url }}" alt="alternate text" class="card-img card-img-horizontal sw-20 sh-18">
                        </div>
                        <div class="col">
                            <div class="card-body pt-0 pb-0 h-100">
                                <div class="row g-0 h-100 align-content-center">
                                    <div class="col-12 col-md-7 d-flex flex-column mb-lg-0 pe-3 d-flex">
                                        <h4>
                                            <!-- <img class="border-gray" height="50px;" src="{{$task->cover_url}}" alt="{{$task->name}}"> -->
                                            <a href="{{ route(TASK_EDIT_ADMIN_ROUTER, $task->id) }}" class="stretched-link">
                                            {{ $task->name }}
                                        </a>
                                        </h4>
                                        <div class="text-small text-muted d-none d-md-block">
                                            {{ $task->description }}
                                        </div>
                                    </div>
                                    <div class="col-4 col-md-1 d-flex flex-column pe-1 mb-2 mb-lg-0 align-items-lg-center justify-content-center">
                                        <div class="text-muted text-small d-md-none">VALID AMOUNT</div>
                                        <div class="lh-1 h4 mb-0 text-alternate">
                                            <span>
                                              {{ $task->valid_amount }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-6 col-md-1 d-flex flex-column justify-content-center">
                                        <div class="text-muted text-small d-none">Status</div>
                                        <div class="text-alternate">
                                            <span class="badge rounded-pill text-uppercase
                                            bg-outline-{{ $task->status == INACTIVE_TASK ? 'muted' : 'primary' }}">
                                                {{ trans('admin.task.status.' . $task->status) }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-6 col-md-2 d-none d-md-flex flex-column justify-content-center align-items-lg-center">
                                        <div class="text-muted text-small d-md-none">Locations/Participants</div>
                                        <div class="h3">
                                            <span class="text-danger text-small">{{ $task->locations->count() }}</span> /
                                            <span class="text-success">{{ $task->participants->count() }}</span>
                                        </div>
                                    </div>

                                    <div class="col-12 col-md-1 d-flex flex-column justify-content-center order-last order-md-last">
                                        <a href="{{ route(TASK_EDIT_ADMIN_ROUTER, $task->id) }}"
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
    <!-- Task List End -->
@endsection
