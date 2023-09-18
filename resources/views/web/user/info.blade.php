@extends('web.layouts.event_app')

@section('content')
    @php
        $userId = optional(auth()->user())->id;
        $email = optional(auth()->user())->email;
        $roles = [
            1 => 'Cơ quan nhà nước-Chính phủ/State Agency',
            2 => 'Media - đối tác truyền thông/Media Partner',
            3 => 'Cá nhân khác/Enterprise - Individual'
        ];
    @endphp

    <style type="text/css">
        #laravel-notify {
          position: absolute;
          z-index: 99999;
        }
        .title {
            margin-top: 20px;
            margin-bottom: 10px;
            font-size: 22px;
        }

        .go {
            margin-top: 19px;
            display: inline-block;
            padding: 7px 50px;
            background: #3EA2FF;
            color: #fff;
            border-radius: 20px;
        }

        .dd {
            font-size: 18px;
            color: #000;
            line-height: 22px;
            padding-bottom: 10px;
        }

        .ddd {
            font-size: 16px;
            text-align: left;
            line-height: 20px;
            color: red;
        }
    </style>
    <section class="travel inffo" id="eInfo" data-flag="{{($user && $user->organization) || !auth()->guest() ? 0 : 1}}">
        <div class="container">
            <div class="travel-content">
                <div class="info">
                    <div class="text-center m-banner">
                        <img src="{{url('/')}}/events/banner_techfest.png">
                        <h3 style="font-size: 29px;padding-top: 12px;">WARMLY WELCOME TO TECHFEST HAIPHONG 2023</h3>
                        <p class="dd"><strong>Nhiệt liệt chào mừng các vị khách quý đến với Lễ khai mạc Techfest Haiphong 2023</strong></p>
                        {{-- <p class="ddd">Quý khách vui lòng để lại thông tin để BTC được đón tiếp chu đáo:</p> --}}
                    </div>
                    <h3 class="title">Thông tin tài khoản</h3>
                    <table class="table">
                        <tr>
                            <td width="80%"><strong>Họ Tên/Name:</strong> {{$user ? $user->name : ''}}</td>
                            <td class="text-right" width="20%">
                                <a class="editUUser" style="color: #fff;padding: 5px 10px;background-color: #3EA2FF;">Edit</a>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2"><strong>Email: </strong>{{$user ? $email : ''}}<td>
                        </tr>
                        <tr>
                            <td colspan="2"><strong>Phone: </strong>{{$user ? $user->phone : ''}}<td>
                        </tr>
                        <tr>
                            <td colspan="2"><strong>Đơn vị công tác/Organization type: </strong>
                                @php
                                    $a = $user ? (int) $user->organization : 0;
                                @endphp
                                {{$user ? $roles[$a] : ''}}
                            <td>
                        </tr>
                        <tr>
                            <td colspan="2"><strong>Tên Đơn vị-Tổ chức-Trường học/Organization: </strong>{{$user ? $user->company : ''}}<td>
                        </tr>
                        <tr>
                            <td colspan="2"><strong>Chức vụ/Position: </strong>{{$user ? $user->position : ''}}<td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </section>

    <div id="upInfo" class="modal fade" data-backdrop="static" data-keyboard="false">
        <style type="text/css">
            .text-danger, .error {
                color: red;
            }

            .btn--order {
                padding: 10px 30px;
                background: #3EA2FF;
                color: #fff;
                text-align: right;
            }
            .d-none {
                display: none!important;
            }
        </style>

        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" style="font-size: 25px; text-align: center;">{{$title}}</h5>
                    @if ($flag)
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    @endif
                </div>
                <div class="modal-body">
                    <form id="infoForm" method="POST" action="{{route('web.editEmail')}}">
                        @csrf
                        <input type="hidden" name="user_type" id="user_type" value="2">
                        <div class="row" style="display: block;">
                            <div class="col-md-12" style="margin-bottom: 15px;">
                                <label class="form-label">Họ Tên/Name <span class="text-danger">*</span></label>
                                <input
                                    type="text"
                                    class="form-control"
                                    name="name"
                                    id="name"
                                    value="{{$user->name ?? ''}}"
                                    required>
                                <label class="text-danger d-none" id="r-name">Please input name</label>
                            </div>
                            <div class="col-md-12" style="margin-bottom: 15px;">
                                <label class="form-label">Đơn vị công tác/Organization type: <span class="text-danger">*</span></label>
                                <select class="form-control" name="organization" id="organization">
                                    @foreach($roles as $k => $v)
                                        <option
                                            value="{{ $k }}"
                                            {{ $user && (int)$user->organization == $k ? 'selected="selected"' : '' }}>
                                            {{ $v }}
                                        </option>    
                                    @endforeach
                                </select>
                                <label class="text-danger d-none" id="r-organization">Please select organization</label>
                            </div>
                            <div class="col-md-12" style="margin-bottom: 15px;">
                                <label class="form-label">Tên đơn vị-Tổ chức-Trường học/Organization: <span class="text-danger">*</span></label>
                                <input
                                    type="text"
                                    class="form-control"
                                    name="company"
                                    id="company"
                                    value="{{$user->company ?? ''}}"
                                    required>
                                <label class="text-danger d-none" id="r-company">Please input company</label>
                            </div>
                            
                            <div class="col-md-12" style="margin-bottom: 15px;">
                                <label class="form-label">Chức vụ/Position: <span class="text-danger">*</span></label>
                                <input
                                    type="text"
                                    class="form-control"
                                    name="position"
                                    id="position"
                                    value="{{$user->position ?? ''}}"
                                    required>
                                <label class="text-danger d-none" id="r-position">Please input position</label>
                            </div>
                            <div class="col-md-12" style="margin-bottom: 15px;">
                                <label class="form-label">Email <span class="text-danger">*</span></label>
                                <input
                                    type="text"
                                    class="form-control"
                                    name="email"
                                    id="email"
                                    value="{{$user->email ?? ''}}"
                                    required>
                                <label class="text-danger d-none" id="r-email">Please input email</label>
                            </div>
                            <div class="col-md-12" style="margin-bottom: 15px;">
                                <label class="form-label">Phone <span class="text-danger">*</span></label>
                                <input
                                    type="text"
                                    class="form-control"
                                    id="phone"
                                    name="phone"
                                    value="{{$user->phone ?? ''}}"
                                    required>
                                <label class="text-danger d-none" id="r-phone">Please input phone</label>
                            </div>
                        </div>
                        <div class="text-center" style="margin-top: 20px;">
                            <button id="fInfo" data-url="{{route('web.editEmail')}}" type="button" class="btn btn-primary btn--order">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
