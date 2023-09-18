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
                    </div>
                    <div class="row" style="margin-bottom: 20px;">
                        <div class="col-xl-6">
                            <a href="{{ route('cws.event.overview', ['id' => $id]) }}" class="btn btn-danger">Back</a>
                            <a href="{{route('user.listMax', ['id' => $id])}}" class="btn btn-primary">Top 200 Code</a>
                            <a href="{{route('user.listMax', ['id' => $id, 'type' => 1])}}" class="btn btn-primary">List All Users</a>
                            <a href="{{route('user.listMax', ['id' => $id, 'type' => 2])}}" class="btn btn-danger">Export Excel</a>
                        </div>
                        <div class="col-xl-6" style="font-size: 30px;">
                            <strong>Total users: </strong>{{number_format($total)}}
                        </div>
                    </div>
                    <table class="table table-bordered mb-0 table-responsive">
                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                                <th>Time Checkin</th>
                                <th>Họ Tên</th>
                                <th>Đơn vị công tác</th>
                                <th>Chức vụ</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Booth done</th>
                                <th>List booth</th>
                                <th>Vị trí hiện tại</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $type = request()->input('type');
                                if($type == 1) {
                                    $booth = App\Models\Event\TaskEvent::where('task_id', $id)->where('type', 1)->first();
                                    $detail = App\Models\Event\TaskEventDetail::where('task_event_id', optional($booth)->id)->first();
                                }
                            @endphp

                            @forelse($userCodes as $k => $userCode)
                                @php
                                    $type = request()->input('type');
                                    $a = (int) optional($userCode->user)->organization;
                                    $userId = optional($userCode->user)->id;
                                    $time = App\Models\Event\EventUserTicket::where('user_id', $userId)->where('task_id', $id)->first();

                                    if ($type == 1) {
                                        $eventId = optional($booth)->id;
                                        $travelId = optional($detail)->travel_game_id;
                                        $listJobs = listJobs($userId, optional($booth)->id, optional($detail)->travel_game_id);
                                        $code = App\Models\Event\UserCode::where('user_id', $userId)->where('task_event_id', optional($booth)->id)->max('number_code');
                                    } else {
                                        $eventId = $userCode->task_event_id;
                                        $travelId = $userCode->travel_game_id;
                                        $listJobs = listJobs($userId, $eventId, $travelId);
                                    }
                                @endphp
                                <tr>
                                    <td>{{$k+1}}</td>
                                    <td>
                                        {{$time ? $time->created_at : ''}}
                                    </td>
                                    <td>
                                        {{optional($userCode->user)->name}}
                                    </td>
                                    <td>
                                        @if ($a == 1)
                                            {{'Cơ quan nhà nước/ Chính phủ'}}
                                        @elseif ($a == 2)
                                            {{'Media - đối tác truyền thông'}}
                                        @else 
                                            {{'Cá nhân khác'}}
                                        @endif
                                    </td>
                                    <td>
                                        {{optional($userCode->user)->position}}
                                    </td>
                                    <td>
                                        {{optional($userCode->user)->email}}
                                    </td>
                                    <td>
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
                                    <td>
                                        {{$type == 1 ? $code : $userCode->number_code}}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5">
                                        <p class="text-danger text-center">No results!</p>
                                    </td>
                                </tr>
                            @endforelse

                            @if ($type == 1)
                                <tr>
                                    <td colspan="10">
                                        {!!$userCodes->appends(['type' => 1])->links()!!}
                                    </td>
                                </tr>
                            @endif
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
