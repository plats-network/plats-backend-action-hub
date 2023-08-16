@extends('web.layouts.event_app')

@section('content')
    <style type="text/css">
        #laravel-notify {
            z-index: 1000;
            position: absolute;
        }
    </style>
    <section class="travel">
        <div class="container">
            <div class="travel-content">
                <div class="info">
                    <table class="table">
                        <tr>
                            <td>{{auth()->user()->email}}</td>
                            <td class="text-center">
                                <a id="editInfo" href="#" style="color: red;">Edit</a>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="event-info">
                    <h3>{{$event->name}}</h3>
                    <img src="{{$event->banner_url}}" alt="{{$event->name}}">
                    <h4>Thông tin sự kiện:</h4>
                    <div class="content mt-2">
                        {!! $event->description !!}
                    </div>
                </div>

                <ul class="nav nav-tabs">
                  <li><a data-toggle="tab" href="#sesion">Sessions</a></li>
                  <li><a data-toggle="tab" href="#booth">Booths</a></li>
                </ul>

                <div class="tab-content">
                    <div id="sesion" class="tab-pane fade in active">
                        @foreach($travelSessions as $session)
                            <div class="item">
                                <h3 class="text-center">{{$session->name}}</h3>
                                <p><strong>Mã số quay thưởng:</strong> ___</p>
                                <p>
                                    <strong>Nhiệm vụ phải làm:</strong>
                                    <a href="{{route('web.jobEvent', ['id' => $event->code])}}">Click Here!</a>
                                </p>
                                <p>Thời giam quay thưởng:</strong> {{$session->prize_at}}</p>
                                <p>Phân thưởng:</strong> {{$session->note}}</p>
                            </div>
                        @endforeach
                    </div>
                    <div id="booth" class="tab-pane fade">
                        @foreach($travelBooths as $booth)
                            <div class="item">
                                <h3 class="text-center">{{$booth->name}}</h3>
                                <p><strong>Mã số quay thưởng:</strong> ___</p>
                                <p>
                                    <strong>Nhiệm vụ phải làm:</strong>
                                    <a href="{{route('web.jobEvent', ['id' => $event->code])}}">Click Here!</a>
                                </p>
                                <p><strong>Thời giam quay thưởng:</strong> {{$booth->prize_at}}</p>
                                <p><strong>Phân thưởng:</strong> {{$booth->note}}</p>
                            </div>
                        @endforeach
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
