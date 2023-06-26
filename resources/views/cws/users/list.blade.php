@extends('cws.layouts.app')

@section('name_page')
    <div class="page-title-box align-self-center d-none d-md-block">
        <h4 class="page-title mb-0">User by Event</h4>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">Search</h4>
                </div>
                <div class="card-body">
                    <form action="{{route('cws.event.users', ['id' => $id])}}">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="mb-3">
                                    <input
                                        type="text"
                                        name="name"
                                        value="{{request()->input('name') ?? ''}}"
                                        class="form-control"
                                        placeholder="name"
                                        id="name">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <button type="submit" class="btn btn-primary w-md">Search</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex flex-wrap align-items-center mb-2">
                        <h5 class="card-title">Lists Users</h5>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Avatar</th>
                                    <th>
                                        Name
                                        <br>
                                        Email
                                    </th>
                                    <th>Checkin</th>
                                    <th>
                                        Session
                                        <br>
                                        Booth
                                    </th>
                                    <th>
                                        Created
                                        <br>
                                        Logined
                                    </th>
                                    <th>Tạo code</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($users as $user)
                                    @php
                                        $userInfo = eventInfo($user->id, $id);
                                    @endphp

                                    <tr>
                                        <td style="width: 5%;">
                                            <div class="avatar">
                                                <div class="product-img avatar-title img-thumbnail bg-soft-primary border-0">
                                                    <img src="{{imgAvatar($user->avatar_path)}}" class="img-fluid" alt="{{$user->name}}">
                                                </div>
                                            </div>
                                        </td>
                                        <td class="fw-semibold" style="width: 10%;">
                                            {{$user->name}}
                                            <br>
                                            <p class="text-success" style="font-size: 11px">{{$user->email}}</p>
                                        </td>
                                        <td>
                                            {{$userInfo->is_checkin ? 'Checkin' : 'Not checkin'}}
                                        </td>
                                        <td width="15%">
                                            <p>
                                                Code: {{$userInfo->sesion_code ?? '__'}}
                                                @if (!$userInfo->sesion_code)
                                                    <button
                                                        class="genCode btn btn-primary btn-sm"
                                                        style="margin-left: 10px;"
                                                        data-id="{{$id}}"
                                                        data-user-id="{{$user->id}}"
                                                        data-type="session">Tạo mã</button>
                                                    
                                                @endif
                                            </p>
                                            <p>
                                                Code: {{$userInfo->booth_code ?? '__'}}
                                                @if (!$userInfo->booth_code)
                                                    <button
                                                        class="genCode btn btn-primary btn-sm"
                                                        style="margin-left: 10px;"
                                                        data-id="{{$id}}"
                                                        data-user-id="{{$user->id}}"
                                                        data-type="booth">Tạo mã</button>
                                                @endif
                                            </p>
                                        </td>
                                        <td>
                                            {{dateFormat($user->created_at)}}
                                            <br>
                                            {{dateFormat($user->updated_at)}}
                                        </td>
                                        <td>
                                            <a href="#">Session</a> |
                                            <a href="#">Booth</a>
                                            {{-- <div class="dropdown">
                                                <a class="text-muted dropdown-toggle font-size-18" role="button" data-bs-toggle="dropdown" aria-haspopup="true">
                                                    <i class="mdi mdi-dots-horizontal"></i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-end">
                                                    <a class="dropdown-item" href="#">Edit</a>
                                                    <a class="dropdown-item" href="#">Print</a>
                                                    <a class="dropdown-item" href="#">Delete</a>
                                                </div>
                                            </div> --}}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="row">
                            <div class="col-md-12 mt-3">
                                {!! $users->links() !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        $('.genCode').on('click', function(e) {
            var user_id = $(this).data('user-id'),
                id = $(this).data('id'),
                type = $(this).data('type');

            $.ajax({
                url: '/gen-code/'+id,
                type: 'GET',
                dataType: 'json',
                data: {
                    _token: _token,
                    user_id: user_id,
                    type: type
                },
                success: function (data) {
                    if (data.message == 'OK') {
                        location.reload();
                    } else {
                        location.reload();
                    }
                },
                error: function (data) {
                    location.reload();
                }
            })
        })

    </script>
@endsection

