@extends('admin.layout')

@section('content')
    <x-admin::top_page :title="trans('admin.guild.page_name')" :desc="trans('admin.guild.page_desc')">
        <a href="#" class="btn btn-outline-primary btn-icon btn-icon-start w-100 w-md-auto">
            <i data-acorn-icon="plus"></i>
            <span>{{ trans('admin.create') }}</span>
        </a>
    </x-admin::top_page>
    <x-alert />

    <div class="row">
        <div class="col-12 mb-5">
            <div class="card mb-2 bg-transparent no-shadow d-none d-md-block">
                <div class="row g-0 sh-3">
                    <div class="sw-20">
                    </div>
                    <div class="col">
                        <div class="card-body pt-0 pb-0 h-100">
                            <div class="row g-0 h-100 align-content-center">
                                <div class="col-12 col-md-6 d-flex align-items-center mb-2 mb-md-0 text-muted text-uppercase">
                                    NAME
                                </div>
                                <div class="col-6 col-md-2 d-flex align-items-center text-medium text-muted text-uppercase">
                                    Admin Name
                                </div>
                                <div class="col-6 col-md-1 d-flex align-items-center text-medium text-muted text-uppercase">
                                    Members
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div id="checkboxTable" class="mb-n2">
            @for ($i = 0; $i < 5; $i++)
                <div class="card mb-2">
                    <div class="row g-0 sh-19 sh-lg-18">
                        <div class="col-auto">
                            <img src="{{ asset('img/admin/demo/list/01.webp') }}" alt="alternate text" class="card-img card-img-horizontal sw-20 sh-18">
                        </div>
                        <div class="col">
                            <div class="card-body pt-0 pb-0 h-100">
                                <div class="row g-0 h-100 align-content-center">
                                    <div class="col-12 col-md-6 d-flex flex-column mb-lg-0 mb-3 mb-lg-0 pe-3 d-flex">
                                        <div class="text-muted text-small d-md-none">NAME</div>
                                        <h4>
                                            <a href="#" class="text-truncate stretched-link">
                                                Plat HaNoi
                                            </a>
                                        </h4>
                                        <div class="text-small text-muted text-truncate">
                                            @plat_hanoi
                                        </div>
                                    </div>
                                    <div class="col-4 col-md-2 d-flex flex-column pe-1 mb-2 mb-lg-0 justify-content-center">
                                        <div class="text-muted text-small d-md-none">Admin Name</div>
                                        <div class="lh-1 mb-0 text-alternate">
                                            <strong>
                                              Luis Thao
                                            </strong>
                                        </div>
                                    </div>
                                    <div class="col-6 col-md-1 d-flex flex-column justify-content-center">
                                        <div class="text-muted text-small d-md-none">Status</div>
                                        <h4 class="mb-0">
                                            <span class="badge rounded-pill text-uppercase bg-outline-primary">
                                                2.300
                                            </span>
                                        </h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endfor
            </div>
        </div>
    </div>
@endsection
