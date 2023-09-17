@extends('web.layouts.event_app')

@section('content')
    {{-- @include('web.layouts.event') --}}

    @php
        $userId = auth()->user()->id;
        $email = auth()->user()->email;
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
    <section class="travel inffo" id="eInfo" data-flag="{{$user->organization ? 0 : 1}}">
        <div class="container">
            <div class="travel-content">
                <div class="info">
                    <div class="text-center m-banner">
                        <img src="{{url('/')}}/events/banner_techfest.png">
                        <h3 style="font-size: 29px;padding-top: 12px;">LỄ KHAI MẠC TECHFEST HAIPHONG</h3>
                        <p class="dd"><strong>Nhiệt liệt chào mừng các vị khách quý đến với Lễ khai mạc Techfest Haiphong 2023</strong></p>
                        {{-- <p class="ddd">Quý khách vui lòng để lại thông tin để BTC được đón tiếp chu đáo:</p> --}}
                    </div>
                    <h3 class="title">Thông tin tài khoản</h3>
                    <table class="table">
                        <tr>
                            <td width="80%"><strong>Họ Tên/Name:</strong> {{$user->name}}</td>
                            <td class="text-right" width="20%">
                                <a class="editUUser" style="color: #fff;padding: 5px 10px;background-color: #3EA2FF;">Edit</a>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2"><strong>Email: </strong>{{$email}}<td>
                        </tr>
                        <tr>
                            <td colspan="2"><strong>Phone: </strong>{{$user->phone}}<td>
                        </tr>
                        <tr>
                            <td colspan="2"><strong>Đơn vị công tác/Organization type: </strong>
                                @php
                                    $a = (int) $user->organization;
                                @endphp
                                @if ($a == 1)
                                    {{'Cơ quan nhà nước - Chính phủ/State Agency'}}
                                @elseif ($a == 2)
                                    {{'Media - đối tác truyền thông/Media Partner'}}
                                @else 
                                    {{'Cá nhân khác/Enterprise - Individual'}}
                                @endif
                            <td>
                        </tr>
                        <tr>
                            <td colspan="2"><strong>Tên Đơn vị-Tổ chức-Trường học/Organization: </strong>{{$user->company}}<td>
                        </tr>
                        <tr>
                            <td colspan="2"><strong>Chức vụ/Position: </strong>{{$user->position}}<td>
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
        </style>

        @php
            $roles = [
                1 => 'Cơ quan nhà nước/ Chính phủ',
                2 => 'Media - đối tác truyền thông',
                3 => 'Cá nhân khác'
            ];
        @endphp

        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" style="font-size: 25px; text-align: center;">Cập nhật thông tin</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <form id="infoForm" method="POST" action="{{route('web.editEmail')}}">
                        @csrf
                        <input type="hidden" name="user_type" value="2">
                        <div class="row" style="display: block;">
                            <div class="col-md-12" style="margin-bottom: 15px;">
                                <label class="form-label">Họ Tên/Name <span class="text-danger">*</span></label>
                                <input
                                    type="text"
                                    class="form-control"
                                    name="name"
                                    value="{{$user->name ?? ''}}"
                                    required>
                            </div>
                            <div class="col-md-12" style="margin-bottom: 15px;">
                                <label class="form-label">Đơn vị công tác/Organization type: <span class="text-danger">*</span></label>
                                <select class="form-control" name="organization">
                                    @foreach($roles as $k => $v)
                                        <option
                                            value="{{ $k }}"
                                            {{ (int)$user->organization == $k ? 'selected="selected"' : '' }}>
                                            {{ $v }}
                                        </option>    
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-12" style="margin-bottom: 15px;">
                                <label class="form-label">Tên Đơn vị-Tổ chức-Trường học/Organization: <span class="text-danger">*</span></label>
                                <input
                                    type="text"
                                    class="form-control"
                                    name="company"
                                    value="{{$user->company ?? ''}}"
                                    required>
                            </div>
                            
                            <div class="col-md-12" style="margin-bottom: 15px;">
                                <label class="form-label">Chức vụ/Position: <span class="text-danger">*</span></label>
                                <input
                                    type="text"
                                    class="form-control"
                                    name="position"
                                    value="{{$user->position ?? ''}}"
                                    required>
                            </div>
                            <div class="col-md-12" style="margin-bottom: 15px;">
                                <label class="form-label">Email <span class="text-danger">*</span></label>
                                <input
                                    type="text"
                                    class="form-control"
                                    name="email"
                                    value="{{$user->email ?? ''}}"
                                    required>
                            </div>
                            <div class="col-md-12" style="margin-bottom: 15px;">
                                <label class="form-label">Phone <span class="text-danger">*</span></label>
                                <input
                                    type="text"
                                    class="form-control"
                                    name="phone"
                                    value="{{$user->phone ?? ''}}"
                                    required>
                            </div>
                        </div>
                        <div class="text-center" style="margin-top: 20px;">
                            <button type="submit" class="btn btn-primary btn--order">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
