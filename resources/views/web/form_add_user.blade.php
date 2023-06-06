<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-url-prefix="/" data-footer="true" data-color="light-blue">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1"/>
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <title>Action Hub Control Panel</title>
    <meta name="description" content=""/>
    <style>
        .flex-container {
            padding: 0;
            margin: 0;
            list-style: none;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .full-page-content-right-border{
            border: none !important;
        }

    </style>
    @include('web._layout.head')
</head>

<body class="h-100">
<div id="root" class="h-100">
    <div class="fixed-background" style="background-image: url({{ asset('img/admin/background/background-blue.webp') }})"></div>
    <div class="container-fluid p-0 h-100 position-relative">
        <div class="row g-0 h-100">
            <!-- Right Side Start -->
            <div class="flex-container">
                <div class="sw-lg-70 bg-foreground d-flex justify-content-center align-items-center shadow-deep py-5 full-page-content-right-border">
                    <div class="sw-lg-50 px-5">
                        <div>
                            <x-alert/>
                            <x-form::open action="{{ route('web.createUser') }}" class="tooltip-end-bottom" >
                                <div class="mb-3 filled form-group tooltip-end-top">
                                    <i data-acorn-icon="user"></i>
                                    <input class="form-control" placeholder="Name" name="name" value="{{ old('name') }}"/>
                                </div>
                                <div class="mb-3 filled form-group tooltip-end-top">
                                    <i data-acorn-icon="email" ></i>
                                    <input class="form-control" placeholder="Email or Phone" name="email" value="{{ old('email') }}"/>
                                </div>
                                <button type="submit" class="btn btn-lg btn-primary">Create</button>
                            </x-form::open>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Right Side End -->
        </div>
    </div>
</div>

@include('admin._layout.scripts')
</body>
</html>
