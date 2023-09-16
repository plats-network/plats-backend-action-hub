@extends('web.layouts.event_app')

@section('content')
    @include('web.layouts.event')

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
    </style>
    <section class="travel inffo" id="eInfo" data-flag="{{$user->organization ? 0 : 1}}">
        <div class="container">
            <div class="travel-content">
                <div class="info">
                    <h3 class="title">Thông tin tài khoản</h3>
                    <table class="table">
                        <tr>
                            <td>{{$user->name}}</td>
                            <td class="text-right">
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
                            <td colspan="2"><strong>Đơn vị công tác: </strong>
                                @php
                                    $a = (int) $user->organization;
                                @endphp
                                @if ($a == 1)
                                    {{'Cơ quan nhà nước/ Chính phủ'}}
                                @elseif ($a == 2)
                                    {{'Media - đối tác truyền thông'}}
                                @else 
                                    {{'Cá nhân khác'}}
                                @endif
                            <td>
                        </tr>
                        <tr>
                            <td colspan="2"><strong>Chức vụ: </strong>{{$user->position}}<td>
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
                                <label class="form-label">Họ và Tên <span class="text-danger">*</span></label>
                                <input
                                    type="text"
                                    class="form-control"
                                    name="name"
                                    value="{{$user->name ?? ''}}"
                                    required>
                            </div>
                            <div class="col-md-12" style="margin-bottom: 15px;">
                                <label class="form-label">Đơn vị công tác <span class="text-danger">*</span></label>
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
                                <label class="form-label">Chức vụ <span class="text-danger">*</span></label>
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
