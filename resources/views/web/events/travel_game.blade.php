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
                    <h3 style="padding-bottom: 0;">{{$event->name}}</h3>
                    {{-- <img src="{{$event->banner_url}}" alt="{{$event->name}}"> --}}
                    <div class="text-center" style="margin: 5px auto;">
                        <img style="width: 70%;" src="{{url('/')}}/events/prize.png" alt="{{$event->name}}">
                    </div>
                    <div class="aaa mt-2" style="margin-top: 15px; line-height: 20px;">
                        Tham gia các Games tại sự kiện với tổng giải thưởng lên tới 300 triệu.
                        <div id="seeMore1" style="display: none;">
                            <p class="pp" style="padding-top: 10px;">➤ Có 3 game là "Travel Game", "Session game day 1" và "Session game day 2" độc lập nhau. Bạn có thể tham gia 1 hoặc cả 3 game.</p>
                            <p class="pp">➤ Thu thập Mã số quay thưởng (MSQT) để tham gia vòng quay may mắn.</p>
                            <p class="pp">➤ Bạn có thể dùng bất kỳ nền tảng nào như Camera hay Zalo... để quét QR code, nhưng cần dùng  1 nền tảng duy nhất  để quét trong suốt sự kiện. Ví dụ nếu đã dùng Zalo để quét lần đầu thì các lần sau cũng dùng Zalo.</p>
                            <p class="pp">➤ Bạn cần nhập Email (phía trên của màn hình) để tham gia quay thưởng. Vì quyền lợi của bạn, Email này phải  trùng với Email bạn đã đăng ký vé tham gia sự kiện.</p>
                            <p class="pp">➤ Riêng với Travel Game sau khi quét mã QR tại bất kỳ Booth nào sẽ hiển thị 1 của sổ thông báo cần Claim bộ NFT ở các Booth để hoàn thành nhiệm vụ, người tham gia cần đăng nhập bằng các tài khoản mạng xã hội như Facebook, Google hoặc Apple Icloud để được tặng ví lưu trữ NFT và Claim NFT. Việc đăng nhập này chỉ thực hiện 1 lần duy nhất.</p>
                            <p class="pp" style="padding-bottom: 10px;">➤ Tại giờ quay thưởng vào cuối ngày, nếu bạn trúng thưởng mà không có mặt sẽ bị loại và giành cơ hội cho người khác.</p>
                            Chi tiết từng Game ở bên dưới.
                        </div>
                        <p class="text-center" id="see1" style="cursor: pointer;">Read more</p>
                    </div>
                </div>

                <ul class="nav nav-tabs">
                  <li><a data-toggle="tab" href="#sesion">Sessions Game</a></li>
                  <li><a data-toggle="tab" href="#booth">Travel Game</a></li>
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
                                $sTests = [];
                                if ($session->note) {
                                    $sTests = explode('-', $session->note);
                                }
                            @endphp

                            <div class="item">
                                <h3 class="text-center">{{$session->name}}</h3>
                                <p><strong>Mã số quay thưởng (Lucky Code):</strong> <span class="fs-25">{{$codes ? $codes : '---'}}</span></p>
                                <p>
                                    <strong>Missions (nhiệm vụ):</strong>
                                    <a href="{{route('web.jobEvent', ['id' => $event->code, 'type' => 0])}}">Click Here!</a>
                                </p>
                                <p><strong>Thời gian quay thưởng (Time):</strong> {{dateFormat($session->prize_at)}}</p>
                                <p><strong>Địa điểm (Position):</strong> Hội trường chính (Main Stage)</p>
                                <p><strong>Reward (phần thưởng):</strong></p>
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
                                <p><strong>Reward (phần thưởng):</strong></p>
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
                </div>

                <div class="event-info" style="border-top: 0; margin-top: 15px;">
                    <div class="aaa mt-2">
                        Plats Network: Web 2.5 Event Platform.<br>
                        Thăm quan gian hàng Plats Network, bạn có cơ hội tham gia các trò chơi vui nhộn với những phần quà hấp dẫn.<br>
                        Games, Gifts, and Good Times Await at Plats Network's Booth!
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

    @include('web.events._modal_nft', [
        'nft' => $nft,
        'url' => $url
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
