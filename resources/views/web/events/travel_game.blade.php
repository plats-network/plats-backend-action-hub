@extends('web.layouts.event_app')

@section('content')
    @php
        $userId = auth()->user()->id;
        $email = auth()->user()->email;
        $userCode = new App\Models\Event\UserCode();
    @endphp

    <style type="text/css">
        #laravel-notify {
            z-index: 1000;
            position: absolute;
        }
        .fs-25 {
            font-size: 25px;
            color: #228b22;
        }
    </style>
    <section class="travel">
        <div class="container">
            <div class="travel-content">
                <div class="info">
                    <table class="table">
                        <tr>
                            <td>
                                @if (Str::contains($email, 'guest'))
                                    <p class="text-danger">Please add email.</p>
                                @else
                                    {{$email}}
                                @endif
                            </td>
                            <td class="text-center">
                                <a id="editInfo" href="#" style="color: red;">{{Str::contains($email, 'guest') ? 'Add' : 'Edit'}}</a>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="event-info">
                    <h3>{{$event->name}}</h3>
                    <img src="{{$event->banner_url}}" alt="{{$event->name}}">
                    <div class="content mt-2 text-center" style="margin-top: 15px;">
                        Tham gia sự kiện để nhận những phần quà có giá trị với tổng giải thưởng lên đến 300 triệu.
                    </div>
                </div>

                <ul class="nav nav-tabs">
                  <li><a data-toggle="tab" href="#sesion">Session Game</a></li>
                  <li><a data-toggle="tab" href="#booth">Booth Game</a></li>
                </ul>

                <div class="tab-content">
                    <div id="sesion" class="tab-pane fade in active">
                        @foreach($travelSessions as $session)
                            @php
                                $codes = $userCode->where('user_id', $userId)
                                    ->where('travel_game_id', $session->id)
                                    ->where('task_event_id', $session_id)
                                    ->where('type', 0)
                                    ->pluck('number_code')
                                    ->implode(',');
                            @endphp

                            <div class="item">
                                <h3 class="text-center">{{$session->name}}</h3>
                                <p><strong>Mã số:</strong> <span class="fs-25">{{$codes ? $codes : '---'}}</span></p>
                                <p>
                                    <strong>Nhiệm vụ:</strong>
                                    <a href="{{route('web.jobEvent', ['id' => $event->code, 'type' => 0])}}">Click Here!</a>
                                </p>
                                <p><strong>Thời gian:</strong> {{dateFormat($session->prize_at)}}</p>
                                <p><strong>Phân thưởng:</strong> {{$session->note}}</p>
                            </div>
                        @endforeach
                    </div>

                    <div id="booth" class="tab-pane fade">
                        @foreach($travelBooths as $booth)
                            @php
                                $codeBooths = $userCode->where('user_id', $userId)
                                    ->where('travel_game_id', $booth->id)
                                    ->where('task_event_id', $booth_id)
                                    ->where('type', 1)
                                    ->pluck('number_code')
                                    ->implode(',');
                            @endphp
                            <div class="item">
                                <h3 class="text-center">{{$booth->name}}</h3>
                                <p><strong>Mã số:</strong> <span class="fs-25">{{$codeBooths ? $codeBooths : '---'}}</span></p>
                                <p>
                                    <strong>Nhiệm vụ:</strong>
                                    <a href="{{route('web.jobEvent', ['id' => $event->code, 'type' => 1])}}">Click Here!</a>
                                </p>
                                <p><strong>Thời gian:</strong> {{dateFormat($booth->prize_at)}}</p>
                                <p><strong>Phân thưởng:</strong> {{$booth->note}}</p>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="event-info" style="border-top: 0; margin-top: 15px;">
                    <div class="content mt-2 text-center" style="background-color: #ffe0f6;">
                        Cài app Plats bạn có cơ hội quay thưởng và trúng những phần thưởng có giá trị.
                    </div>
                    <div class="app text-center">
                        <a href="https://apps.apple.com/us/app/plats/id1672212885" style="padding-right: 20px;" target="_blank">
                            <img style="width: 150px;" src="{{url('/')}}/events/apple-store.svg">
                        </a>
                        <a href="https://play.google.com/store/apps/details?id=network.plats.action" target="_blank">
                            <img style="width: 150px;" src="{{url('/')}}/events/ggplay.svg">
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div id="infoEditEmail" class="modal fade" data-backdrop="static" data-keyboard="false">
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

        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" style="font-size: 25px; text-align: center;">Cập nhật email</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <form id="infoForm" method="POST" action="{{route('web.editEmail')}}">
                        @csrf
                        <input type="hidden" name="task_id" value="{{$event->id}}">
                        <div class="row" style="display: block;">
                            <div class="col-md-12">
                                <label class="form-label">Email <span class="text-danger">*</span></label>
                                <input
                                    type="text"
                                    class="form-control"
                                    name="email"
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
