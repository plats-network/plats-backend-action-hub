@extends('web.layouts.event_app')

@section('content')
    <section class="travel">
        <div class="container">
            <div class="travel-content">
                <div class="info">
                    <table class="table">
                        <tr>
                            <td>{{auth()->user()->email}}</td>
                            <td class="text-center">
                                <a href="#">Edit</a>
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
@endsection
