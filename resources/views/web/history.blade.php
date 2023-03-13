@extends('web.layout')
@section('content')
    @if(empty(auth()->user()->name))
        <section class="scroll-section" >
            <h2 class="small-title">Vui lòng đăng nhập , nếu chưa có tài khoản xin vui lòng đăng ký</h2>
            <div class="row">
                <div class="col-auto mb-5">
                    <div class="card w-100 sw-sm-50 sh-19 hover-img-scale-up">
                        <div class="card-img-overlay d-flex flex-column justify-content-between bg-transparent">
                            <div>
                                <div class="cta-3 mb-3 text-black w-75 w-md-50">Log In</div>
                                <a href="{{ route(LOGIN_WEB_ROUTE) }}" class="btn btn-icon btn-icon-start btn-primary stretched-link">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="cs-icon cs-icon-chevron-right"><path d="M7 4L12.6464 9.64645C12.8417 9.84171 12.8417 10.1583 12.6464 10.3536L7 16"></path></svg>
                                    <span>View</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-auto mb-5">
                    <div class="card w-100 sw-sm-50 sh-19 hover-img-scale-up">
                        <div class="card-img-overlay d-flex flex-column justify-content-between bg-transparent">
                            <div>
                                <div class="cta-3 mb-3 text-black w-75 w-md-50">Sign Up</div>
                                <a href="{{ route('web.client.showSignup') }}" class="btn btn-icon btn-icon-start btn-primary stretched-link">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="cs-icon cs-icon-chevron-right"><path d="M7 4L12.6464 9.64645C12.8417 9.84171 12.8417 10.1583 12.6464 10.3536L7 16"></path></svg>
                                    <span>View</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    @else
        <div id="app">
            <history>

            </history>
        </div>
    @endif
@endsection
