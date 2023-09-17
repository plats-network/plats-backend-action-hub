@extends('cws.layouts.app')

@section('name_page')
    <div class="page-title-box align-self-center d-none d-md-block">
        <h4 class="page-title mb-0">Lists user</h4>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex flex-wrap align-items-center mb-2">
                        <h5 class="card-title">Lists user</h5>
                        <div class="ms-auto">
                            <a href="{{ route('cws.event.overview', ['id' => $id]) }}" class="btn btn-danger btn-sm mb-2 me-2">Back</a>
                        </div>
                    </div>
                    <table class="table table-bordered mb-0 table-responsive">
                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                                <th>Time Checkin</th>
                                <th>
                                    Họ Tên <br>
                                    Đơn vị công tác <br>
                                    Chức vụ <br>
                                    Email <br>
                                    Số điện thoại
                                </th>
                                <th>Total booth done</th>
                                <th>List booth</th>
                                <th>Vị trí hiện tại</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($userCodes as $k => $userCode)
                                @php
                                    $a = (int) optional($userCode->user)->organization;
                                    $userId = optional($userCode->user)->id;
                                    $eventId = $userCode->task_event_id;
                                    $travelId = $userCode->travel_game_id;
                                    $listJobs = listJobs($userId, $eventId, $travelId);
                                @endphp
                                <tr>
                                    <td>{{$k+1}}</td>
                                    <td>
                                        {{optional($userCode->user)->updated_at}}
                                    </td>
                                    <td>
                                        {{optional($userCode->user)->name}}<br>
                                        @if ($a == 1)
                                            {{'Cơ quan nhà nước/ Chính phủ'}}
                                        @elseif ($a == 2)
                                            {{'Media - đối tác truyền thông'}}
                                        @else 
                                            {{'Cá nhân khác'}}
                                        @endif
                                        <br>
                                        {{optional($userCode->user)->name}}<br>
                                        {{optional($userCode->user)->email}}<br>
                                        {{optional($userCode->user)->phone}}
                                    </td>
                                    <td>{{countJob($userId, $eventId, $travelId)}}</td>
                                    <td>
                                        @foreach($listJobs as $i => $item)
                                            <p id="bb-{{$k+1}}-{{$i+1}}" class="{{$i >= 4 ? 'd-none' : ''}}" style="margin-bottom: 0;">{{$item}}</p>
                                        @endforeach

                                        @if (count($listJobs) >= 5)
                                            <a class="ssee" data-id="{{$k+1}}" data-k="{{$i+1}}" style="cursor: pointer;">Show</a>
                                        @endif
                                    </td>
                                    <td>{{$userCode->number_code}}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5">
                                        <p class="text-danger text-center">No results!</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        $(document).on('click', '.ssee', function (event) {
            var a = $(this).data('id');

            for(var i = 4; i < 110; i++) {
              if ($('#bb-'+a+'-'+i).length > 0) {
                $('#bb-'+a+'-'+i).removeClass('d-none');
              }
            }
            $(this).addClass('less').removeClass('ssee').text('Less');
          });

        $(document).on('click', '.less', function (event) {
            var a = $(this).data('id');

            for(var i = 4; i < 110; i++) {
              if ($('#bb-'+a+'-'+i).length > 0) {
                $('#bb-'+a+'-'+i).addClass('d-none');
              }
            }
            $(this).addClass('ssee').removeClass('less').text('Show');
          });
    </script>
@endsection
