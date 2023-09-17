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

        .pp {
            padding-left: 20px;
            line-height: 20px !important;
            color: #000 !important;
        }

        .aaa {
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
                                {{$email}}
                                {{-- @if (Str::contains($email, 'guest'))
                                    <p class="text-danger">Please add email.</p>
                                @else
                                    {{$email}}
                                @endif --}}
                            </td>
                            <td class="text-right">
                                <a href="{{route('user.Info', ['code' => 'techfest2023'])}}" style="color: #fff;padding: 5px 10px;background-color: #3EA2FF;">Thông tin</a>
                                {{-- <a id="editInfo" href="#" style="color: red;">{{Str::contains($email, 'guest') ? 'Add' : 'Edit'}}</a> --}}
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="event-info">
                    <h3 style="padding-bottom: 0;">CHƠI GAME NHẬN QUÀ</h3>
                    <div class="row" style="margin-top: 30px;">
                        <div class="col-6" style="padding-right: 7px;">
                            <img src="{{url('/')}}/events/apac.png">
                        </div>
                        <div class="col-6" style="padding-left: 7px;">
                            <img src="{{url('/')}}/events/near.png">
                        </div>
                    </div>
                    <div class="text-center" style="margin: 5px auto; display: none;">
                        <img style="width: 70%;" src="{{url('/')}}/events/prize.png" alt="{{$event->name}}">
                    </div>
                    <div class="aaa mt-2" style="margin-top: 15px; line-height: 20px; display: none;">
                        Tham gia các Games tại sự kiện với tổng giải thưởng có giá trị.
                        <p class="pp" style="padding-top: 10px; color: red!important;">➤ Không nên dùng Zalo để quét QR code, nên quét từ Camera</p>
                        <div id="seeMore1" style="display: none;">
                            <p class="pp">➤ Có 3 game là "Travel Game", "Session game day 1" và "Session game day 2" độc lập nhau. Bạn có thể tham gia 1 hoặc cả 3 game.</p>
                            <p class="pp">➤ Thu thập Mã số quay thưởng (MSQT) để tham gia vòng quay may mắn.</p>
                            <p class="pp">➤ Bạn cần nhập Email (phía trên của màn hình) để tham gia quay thưởng. Vì quyền lợi của bạn, Email này phải  trùng với Email bạn đã đăng ký vé tham gia sự kiện.</p>
                            <p class="pp">➤ Riêng với Travel Game sau khi quét mã QR tại bất kỳ Booth nào sẽ hiển thị 1 của sổ thông báo cần Claim bộ NFT ở các Booth để hoàn thành nhiệm vụ, người tham gia cần đăng nhập bằng các tài khoản mạng xã hội như Facebook, Google hoặc Apple Icloud để được tặng ví lưu trữ NFT và Claim NFT. Việc đăng nhập này chỉ thực hiện 1 lần duy nhất.</p>
                            <p class="pp" style="padding-bottom: 10px;">➤ Tại giờ quay thưởng vào cuối ngày, nếu bạn trúng thưởng mà không có mặt sẽ bị loại và giành cơ hội cho người khác.</p>
                            Chi tiết từng Game ở bên dưới.
                        </div>
                        <p class="text-center" id="see1" style="cursor: pointer;">Read more</p>
                    </div>
                </div>

                {{-- <ul class="nav" style="border-bottom: 1px solid #dee2e6;">
                  <li><a href="#" style="background-color: #3EA2FF; color: #fff;">Sessions Game</a></li>
                </ul> --}}
                {{-- @foreach($travelSessions as $k => $session)
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

                    <div class="item" style="border-bottom: 0;">
                        <h3 class="text-center d-none" style="display: none;">{{$session->name}}</h3>
                        <p><strong>Mã số quay thưởng (Lucky Code):</strong> <span class="fs-25">{{$codes ? $codes : '---'}}</span></p>
                        <p>
                            <strong>Nhiệm vụ (Missions):</strong>
                            <a href="{{route('web.jobEvent', ['id' => $event->code, 'type' => 0])}}#day{{$k+1}}">Click Here!</a>
                        </p>
                        <p><strong>Thời gian quay thưởng (Time):</strong> {{dateFormat($session->prize_at)}}</p>
                        <p><strong>Địa điểm (Position):</strong> Hội trường chính (Main Stage)</p>
                        <p><strong>Phần thưởng (Reward):</strong></p>
                        <p style="padding-left: 15px; line-height: 20px;">
                            @foreach($sTests as $item)
                                @if($item)
                                    {!! '➤ '.$item.'<br>' !!}
                                @endif
                            @endforeach
                        </p>
                    </div>
                @endforeach --}}

                <ul class="nav" style="border-bottom: 1px solid #dee2e6; margin-top: 20px;">
                  <li><a href="#" style="background-color: #3EA2FF; color: #fff;">Travel Game</a></li>
                </ul>
                @foreach($travelBooths as $booth)
                    @php
                        $codeBooths = $userCode->where('user_id', $userId)
                            ->where('travel_game_id', $booth->id)
                            ->where('task_event_id', $booth_id)
                            ->where('type', 1)
                            ->pluck('number_code')
                            ->implode(',');
                        $aTests = [];
                        if ($booth->note) {
                            $aTests = explode('-', $booth->note);
                        }
                    @endphp
                    <div class="item" style="border-bottom: 0;">
                        <h3 class="text-center" style="display: none;">{{$booth->name}}</h3>
                        <p><strong>Đứng vị trí thứ:</strong> <span class="fs-25">{{$maxCode ? $maxCode : '---'}}</span></p>
                        <p><strong>Thời gian phát thưởng:</strong> 15h ngày 19/09/2023</p>
                        <p>
                            <strong>Nhiệm vụ (Missions):</strong>
                            <a href="{{route('web.jobEvent', ['id' => $event->code, 'type' => 1])}}">Click Here!</a>
                        </p>
                        <p><strong>Địa điểm phát thưởng: </strong> Gian hàng Plats Network</p>
                        <p><strong>Bạn đã thăm quan: :</strong> {{$count}}/60 Gian hàng</p>
                    </div>
                @endforeach


                {{-- <div class="tab-content">
                    <div id="sesion" class="tab-pane fade in active">
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
                                <p><strong>Mã số quay thưởng (Lucky Code):</strong> <span class="fs-25">{{$codes ? $codes : '---'}}</span></p>
                                <p>
                                    <strong>Nhiệm vụ (Missions):</strong>
                                    <a href="{{route('web.jobEvent', ['id' => $event->code, 'type' => 0])}}#day{{$k+1}}">Click Here!</a>
                                </p>
                                <p><strong>Thời gian quay thưởng (Time):</strong> {{dateFormat($session->prize_at)}}</p>
                                <p><strong>Địa điểm (Position):</strong> Hội trường chính (Main Stage)</p>
                                <p><strong>Phần thưởng (Reward):</strong></p>
                                <p style="padding-left: 15px; line-height: 20px;">
                                    @foreach($sTests as $item)
                                        @if($item)
                                            {!! '➤ '.$item.'<br>' !!}
                                        @endif
                                    @endforeach
                                </p>
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
                                $aTests = [];
                                if ($booth->note) {
                                    $aTests = explode('-', $booth->note);
                                }
                            @endphp
                            <div class="item">
                                <h3 class="text-center">{{$booth->name}}</h3>
                                <p><strong>Mã số quay thưởng (Lucky Code):</strong> <span class="fs-25">{{$codeBooths ? $codeBooths : '---'}}</span></p>
                                <p>
                                    <strong>Nhiệm vụ (Missions):</strong>
                                    <a href="{{route('web.jobEvent', ['id' => $event->code, 'type' => 1])}}">Click Here!</a>
                                </p>
                                <p><strong>Thời gian quay thưởng (Time):</strong> {{dateFormat($booth->prize_at)}}</p>
                                <p><strong>Địa điểm (Position):</strong> Hội trường chính (Main Stage)</p>
                                <p><strong>Phần thưởng (Reward ):</strong></p>
                                <p style="padding-left: 15px; line-height: 20px;">
                                    @foreach($aTests as $item)
                                        @if($item)
                                            {!! '➤ '.$item.'<br>' !!}
                                        @endif
                                    @endforeach
                                </p>
                            </div>
                        @endforeach
                    </div>
                </div> --}}

                <div class="event-info" style="border-top: 0; margin-top: 15px;">
                    <div class="aaa mt-2">
                        Plats Network: Web 2.5 Event Platform.<br>
                        <p style="padding-left: 20px;line-height: 20px;color: #000;">➤ Thăm quan gian hàng Plats Network, tham gia các trò chơi vui nhộn với những phần quà hấp dẫn.</p>
                        <p style="padding-left: 20px;line-height: 20px;color: #000;">➤ Games, Gifts and Good Times Await at Plats Network's Booth!</p>
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

            {{-- <div class="row">
                <div class="col-12">
                    <div class="schedule-tab list-job">
                        <p class="text-center" style="padding-bottom: 10px;">
                            <a class="back" href="{{route('job.getTravelGame', ['task_id' => $task_id, 'type' => $type])}}">{{'< Back to Event!'}}</a>
                        </p>
                        <p class="desc-prize">
                            @if ($type == 0)
                                ➤ Quét QR code sau mỗi phiên thảo luận tại hội trường chính và hội trường builder, quét 2 phiên thảo luận nhận được 1 Mã số quay thưởng (MSQT).<br>
                                ➤ Hãy thu thập càng nhiều MSQT cơ hội trúng thưởng càng cao. <br>
                                (Scan 2 Session QR Code to receive 1 Lucky Code).
                            @else
                                ➤ Luật chơi: 100 bạn đầu tiên thăm quan trên 40/60 gian hàng (Booths) bằng cách quét QR Code tại gian hàng, để nhận được một thẻ Danh thiếp điện tử NFC hiện đại, đẳng cấp trị giá 300K VND."<br>
                                ➤ Thời gian phát thưởng: 15h ngày 19/09/2023.<br>
                                ➤ Địa điểm phát thưởng: Gian hàng Plats Network.<br>
                                ➤ Bạn đã thăm quan: {{$count}}/60 Gian hàng<br>
                                ➤ Bạn hoàn thành nhiệm vụ thứ : {{$maxCode ? $maxCode : '---'}}<br>
                                ➤ Danh sách Booths:
                            @endif
                        </p>

                        <ul class="nav tab-job">
                            <li class="nav-item b2">
                                <a class="nav-link {{$type == 1 ? 'active-job' : ''}}" href="{{route('web.jobEvent', ['id' => $id, 'type' => 1])}}">Travel Game</a>
                            </li>
                        </ul>

                        <style type="text/css">
                            .desc {
                                line-height: 20px;
                                background: antiquewhite;
                                color: #000;
                                border-radius: 10px;
                                padding: 10px;
                                margin-top: 20px;
                            }
                            .swal2-title {
                                margin: -32px 13px;
                            }

                            .back {
                                display: inline-block;
                                margin: 5px 0;
                                padding: 6px 35px;
                                background: aqua;
                                border-radius: 15px;
                                color: #000;
                            }

                            .tab {
                                padding: 10px 30px!important;
                            }
                        </style>
                    </div>

                    <div class="tab-content">
                        <style type="text/css">
                            .d-none {
                                display: none!important;
                            }
                            .see, .less {
                                padding: 5px 20px;
                                background: #177FE2;
                                border-radius: 28px;
                                color: #fff!important;
                                cursor: pointer;
                            }
                        </style>

                        <div class="tab-pane {{$type == '1' ? 'fade show in active' : ''}}" id="step2" role="tabpanel" aria-labelledby="booth-tab">
                            <div class="timeline-container">
                                @foreach($groupBooths as $itemDatas)
                                    <hr style="margin-bottom: 20px;">
                                    <h3 class="step d-none" style="display: none;">
                                        {{$itemDatas && $itemDatas[0] ? $itemDatas[0]['travel_game_name'] : ''}}
                                    </h3>
                                    <ul class="tl">
                                        @foreach($itemDatas as $k => $item)
                                            <li id="s-{{$k}}" class="{{$k >= 3 ? 'd-none' : ''}}" class="tl-item {{ $item['flag'] ? '' : 'dashed'}}">
                                                <div class="item-icon {{ $item['flag'] ? '' : 'not__active'}}"></div>
                                                <div class="item-text">
                                                    <div class="item-title {{$item['flag'] ? '' : 'not-active'}}">
                                                        <p class="{{$item['flag'] ? 'ac-color' : ''}}">
                                                            {{Str::limit($item['name'], 50)}}
                                                        </p>
                                                    </div>
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
                                <div class="text-center">
                                    <a class="btn btn-info see">See More</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> --}}
        </div>
    </section>

    @include('web.events._modal_nft', [
        'nft' => $nft,
        'url' => $url
    ])

    @include('web.events._info', [
        'task_id' => $event->id,
        'user' => $user
    ])

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
                        <input type="hidden" name="user_type" value="1">
                        <div class="row" style="display: block;">
                            <div class="col-md-12">
                                <label class="form-label">Name <span class="text-danger">*</span></label>
                                <input
                                    type="text"
                                    class="form-control"
                                    name="name"
                                    required>
                            </div>
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
