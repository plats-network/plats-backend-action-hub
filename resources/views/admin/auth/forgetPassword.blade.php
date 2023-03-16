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
<body>
<div >
    <div class="container">
        <div class="row justify-content-center">
            <div class="row">
                <div class=" col-12">
                    <div class="card">
                        <div class="card-header">Reset Password</div>
                        <div class="card-body">
                            <x-alert/>
                            <form action="{{ route('admin.forget.password.post') }}" method="POST">
                                @csrf
                                <div class="form-group row">
                                    <label for="email_address" class="col-md-4 col-form-label text-md-right">E-Mail Address</label>
                                    <div class="col-md-6">
                                        <input type="text" id="email_address" class="form-control" name="email" required autofocus>

                                    </div>
                                </div>
                                <div class="col-md-6 mt-1 offset-md-8">
                                    <button type="submit" class="btn btn-primary">
                                        Send Password Reset Link
                                    </button>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
