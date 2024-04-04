@extends('web.layouts.event_app')

@section('content')
    @php
        $userId = auth()->user()->id;
        $email = auth()->user()->email;
        $userCode = new App\Models\Event\UserCode();
    @endphp

    <style type="text/css">
        .timeline-container ul.tl li {
            list-style: none;
            margin: auto;
            min-height: 50px;
            border-left: 1px solid #86D6FF;
            padding: 0 0 15px 25px;
            position: relative;
            display: flex;
            flex-direction: row;
        }

        #laravel-notify {
            z-index: 1000;
            position: absolute;
        }

        .fs-25 {
            font-size: 25px;
            color: #228b22;
        }

        .pp {
            padding-left: 20px;
            line-height: 20px !important;
            color: #000 !important;
        }

        .aaa,.infor-description {
            background-color: #fff8ea;
            padding: 7px 10px;
            border-radius: 10px;
            margin-bottom: 15px;
            color: #000;
            line-height: 20px;
            font-size: 15px;
            border: 2px solid #fab501;
        }

        #laravel-notify {
            position: absolute;
            z-index: 99999;
        }
    </style>

    <style type="text/css">
        .tab-job {
            justify-content: center;
            border-bottom: none;
        }

        .nav-link {
            border: 2px solid #177FE2;
        }

        .b1 {
            border-radius: 10px 0 0 10px;
        }

        .b2 {
            border-radius: 0px 10px 10px 0;
        }

        .active-job {
            background-color: #177FE2;
            color: #fff;
        }

        .ac-color {
            color: #258CC7 !important;
            font-weight: bold !important;
        }

        .desc-prize {
            background-color: #fff8ea;
            padding: 7px 10px;
            border-radius: 10px;
            margin-bottom: 15px;
            color: #000;
            line-height: 20px;
            font-size: 15px;
            border: 2px solid #fab501;
        }

        #laravel-notify {
            position: absolute;
            z-index: 99999;
        }
    </style>

    <section class="travel" id="flagU" data-flag="{{$flagU}}">
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
                                <a id="editInfo" href="#"
                                   style="color: red;">{{Str::contains($email, 'guest') ? 'Add' : 'Edit'}}</a>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="event-info">
                    <h3 style="padding-bottom: 0;">{{$event->name}}</h3>
                    {{-- <img src="{{$event->banner_url}}" alt="{{$event->name}}"> --}}
                    <div class="text-center" style="margin: 5px auto;">
                        <img style="width: 100%;" src="{{$event->banner_url}}" alt="{{$event->name}}">
                    </div>
                    <div class="aaa mt-2" style="margin-top: 15px; line-height: 20px;">
                        {!! $event['description'] !!}
                        <!-- <p class="text-center" id="see1" style="cursor: pointer;">Read more</p> -->
                    </div>
                </div>
                <div class="tab-content">
                    <nav>
                        <ul class="nav nav-tabs" id="nav-tab" role="tablist">
                            <li>
                                <a class="nav-link active" data-toggle="tab" href="#sesion" id="nav-sesion-tab" data-toggle="tab" data-target="#nav-session"  role="tab" aria-controls="nav-session" aria-selected="true">Sessions Game</a>
                            </li>
                            <li>
                                <a class="nav-link" data-toggle="tab" href="#booth" id="nav-booth-tab" data-toggle="tab" data-target="#nav-booth"  role="tab" aria-controls="nav-booth" aria-selected="true">Booths Game</a>
                            </li>
                        </ul>
                    </nav>
                    <div class="tab-content" id="nav-tabContent">
                        <div class="tab-pane fade show active" id="nav-session" role="tabpanel" aria-labelledby="nav-sesion-tab">
                            <div class="infor-description mt-2" >
                        
                                {!! $sessions['description'] !!}
                                {{--  <p class="text-center" id="see1" style="cursor: pointer;">Read more</p>  --}}
                            </div>
                            @foreach($travelSessions as $k => $session)
                                @php
                                    $codes = $userCode->where('user_id', $userId)
                                        ->where('travel_game_id', $session->id)
                                        ->where('task_event_id', $session_id)
                                        ->where('type', 0)
                                        ->pluck('number_code')
                                        ->implode(',');
                                    $sTests = [];
                                    if ($session->note) {
                                        $sTests = explode('-', $session->note);
                                    }
                                @endphp
                             
                                <div class="item">
                                    <h3 class="text-center">{{$session->name}}</h3>
                                  
                                    <p>
                                        <strong>Missions: Scan the QR to receive a Lucky Draw Code.</strong>
                                    </p>
                                    <p><strong>Lucky Code:</strong> <span class="fs-25">{{$codes ? $codes : '---'}}</span>
                                    </p>

                                    <p><strong>Joined: <span style="color:green">{{ $totalSessionCompleted }}</span> / {{  count($sessions['detail']) }}
                                            sessions</strong></p>
                                    @if(false)
                                        <p><strong>Prize drawing time:</strong> {{dateFormat($session->prize_at)}}</p>
                                        <p><strong>Position:</strong> Main Stage</p>
                                        <p><strong>Reward:</strong></p>

                                        <p style="padding-left: 15px; line-height: 20px;">
                                            @foreach($sTests as $item)
                                                @if($item)
                                                    {!! '➤ '.$item.'<br>' !!}
                                                @endif
                                            @endforeach
                                        </p>
                                    @endif
                                </div>
                                <div class="timeline-container">
                                    @foreach($groupSessions as  $itemDatas)
                                        <div id="day{{($loop->index+1)}}">&nbsp;</div>
                                        @if(false)
                                            <h3 class="step">{{$itemDatas && $itemDatas[0] ? $itemDatas[0]['travel_game_name'] : ''}}</h3>
                                        @endif
                                        <ul class="tl">
                                            @foreach($itemDatas as $item)
                                                <li class="tl-item {{ $item['flag'] ? '' : 'dashed'}}">
                                                    <div class="item-icon {{ $item['flag'] ? '' : 'not__active'}}"></div>
                                                    <div class="item-text">
                                                        <div class="item-title {{$item['flag'] ? '' : 'not-active'}}">
                                                            <p class="{{$item['flag'] ? 'ac-color' : ''}}">
                                                                {{Str::limit($item['name'], 50)}}
                                                            </p>
                                                        </div>
                                                        {{-- <div class="item-detail {{$item['flag'] ? 'ac-color' : ''}}">{{Str::limit($item['desc'], 20)}}</div> --}}
                                                    </div>
                                                    @if ($item['date'])
                                                        <div class="item-timestamp">
                                                            {{$item['date']}}<br> {{$item['time']}}
                                                        </div>
                                                    @endif
                                                </li>
                                            @endforeach
                                        </ul>
                                    @endforeach
                                </div>
                            @endforeach
                        </div>

                        <div class="tab-pane fade" id="nav-booth" role="tabpanel" aria-labelledby="nav-booth-tab">
                            <div class="infor-description a-2">
                        
                                {!! $booths['description'] !!}
                                {{--  <p class="text-center" id="see1" style="cursor: pointer;">Read more</p>  --}}
                            </div>
                            @foreach($travelBooths as $k => $booth)
                                @php
                                    $codes = $userCode->where('user_id', $userId)
                                        ->where('travel_game_id', $booth->id)
                                        ->where('task_event_id', $session_id)
                                        ->where('type', 0)
                                        ->pluck('number_code')
                                        ->implode(',');
                                    $sTests = [];
                                    if ($booth->note) {
                                        $sTests = explode('-', $booth->note);
                                    }
                                @endphp
                             
                                <div class="item">
                                    <h3 class="text-center">{{$booth->name}}</h3>
                                  
                                    <p>
                                        <strong>Missions: Scan the QR to receive a Lucky Draw Code.</strong>
                                    </p>
                                    <p><strong>Lucky Code:</strong> <span class="fs-25">{{$codes ? $codes : '---'}}</span>
                                    </p>

                                    <p><strong>Joined: <span style="color:green">{{ $totalBoothCompleted }}</span> / {{  count($booths['detail']) }}
                                            sessions</strong></p>
                                    @if(false)
                                        <p><strong>Prize drawing time:</strong> {{dateFormat($booth->prize_at)}}</p>
                                        <p><strong>Position:</strong> Main Stage</p>
                                        <p><strong>Reward:</strong></p>

                                        <p style="padding-left: 15px; line-height: 20px;">
                                            @foreach($sTests as $item)
                                                @if($item)
                                                    {!! '➤ '.$item.'<br>' !!}
                                                @endif
                                            @endforeach
                                        </p>
                                    @endif
                                </div>
                                <div class="timeline-container">
                                    @foreach($groupBooths as  $itemDatas)
                                        <div id="day{{($loop->index+1)}}">&nbsp;</div>
                                        @if(false)
                                            <h3 class="step">{{$itemDatas && $itemDatas[0] ? $itemDatas[0]['travel_game_name'] : ''}}</h3>
                                        @endif
                                        <ul class="tl">
                                            @foreach($itemDatas as $item)
                                                <li class="tl-item {{ $item['flag'] ? '' : 'dashed'}}">
                                                    <div class="item-icon {{ $item['flag'] ? '' : 'not__active'}}"></div>
                                                    <div class="item-text">
                                                        <div class="item-title {{$item['flag'] ? '' : 'not-active'}}">
                                                            <p class="{{$item['flag'] ? 'ac-color' : ''}}">
                                                                {{Str::limit($item['name'], 50)}}
                                                            </p>
                                                        </div>
                                                        {{-- <div class="item-detail {{$item['flag'] ? 'ac-color' : ''}}">{{Str::limit($item['desc'], 20)}}</div> --}}
                                                    </div>
                                                    @if ($item['date'])
                                                        <div class="item-timestamp">
                                                            {{$item['date']}}<br> {{$item['time']}}
                                                        </div>
                                                    @endif
                                                </li>
                                            @endforeach
                                        </ul>
                                    @endforeach
                                </div>
                            @endforeach
                        </div>
                    </div>


                </div>

                <div class="event-info" style="border-top: 0; margin-top: 15px;">
                    <div class="aaa mt-2">
                        Plats Event: Web3 Event Platform <br>
                        Latest event organization platform, supporting Travel game, Session game and fun prize drawing.
                        In addition, Plats Event also provides other services such as Creating and Distributing NFTs
                        during events, Creating and Performing traditional tasks such as Social Tasks or Onchain Tasks.
                    </div>
                    <div class="app text-center">
                        <a href="https://apps.apple.com/us/app/plats/id1672212885" style="padding-right: 20px;"
                           target="_blank">
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

    @include('web.events._modal_nft', [
        'nft' => $nft,
        'url' => $url
    ])

    <div id="infoEditEmail" class="modal fade @if (Str::contains($email, 'guest')) show @endif" data-backdrop="static"
         data-keyboard="false">
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

        <div class="modal-dialog ">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" style="font-size: 25px; text-align: center;">Register for Event Check-in</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <form id="infoForm" method="POST" action="{{route('web.editEmail')}}">
                        @csrf
                        <input type="hidden" name="task_id" value="{{$event->id}}">
                        <div class="row" style="display: block;">
                            <div class="col-md-12">
                                <label class="form-label">Name <span class="text-danger">*</span></label>
                                <input
                                    type="text"
                                    class="form-control"
                                    name="name"
                                    required>
                            </div>
                            <div class="col-md-12 mt-3">
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
