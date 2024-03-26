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

    <style type="text/css">
        .tab-job {
            justify-content: center;
            order-bottom: none;
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
            color: #258CC7!important;
            font-weight: bold!important;
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
                                <a id="editInfo" href="#" style="color: red;">{{Str::contains($email, 'guest') ? 'Add' : 'Edit'}}</a>
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
                        Sự kiện 1000 CEO 2023 tại TP HCM 22/12/2023

                        <p class="pp">1. Quy mô: một trong những sự kiện về chủ doanh nghiệp và NĐT lớn nhất VN với quy mô 1000 CEO + nhà đầu tư </p>

                        <p class="pp">2. Uy tín: Sự kiện diễn ra lần đầu năm 2017. Năm nay 2023 là lần thứ 6 và là năm thứ 7 diễn ra sự kiện. Các sự kiện trước ghi nhận tỉ lệ hài lòng của người tham dự lên tới 98.18% với sự tham gia của nhiều doanh nghiệp lớn hàng đầu tại VN </p>


                        <div id="seeMore1" style="display: none;">
                            <p class="pp">➤ 3. Kết nối: Thành viên tham dự được chọn lọc đa dạng ngành nghề: gồm các chủ doanh nghiệp, quản lý cấp cao và nhà đầu tư với rất nhiều ngành nghề khác nhau. 90% là các chủ doanh nghiệp SME, trong đó có 8% doanh nghiệp có doanh số trên 5M USD/năm và 3% doanh nghiệp có doanh số trên 50M USD/năm. Có 3 cơ hội giao lưu kết nối: session lớn với toàn bộ hội trường, lunch networking và VIP dinner networking với các doanh nghiệp VIP. </p>

                            <p class="pp">➤ 4. Diễn giả và khách mời là những chuyên gia uy tín và doanh nghiệp lớn ở VN và quốc tế:</p>
                            <p class="pp">1. Vietnam:</p>
                            <p class="pp">1. Mr. Hoàng Đình Trọng - CT PDCA - trường đào tạo 30,000 CEO tại VN</p>
                            <p class="pp">  2. Mr. Hoàng Ngọc Gia Long - chủ tịch KW Vietnam, CEO & Founder SharkLand, SharkAgent, Zeniius với 5,000 CEO, nhà đầu tư và agent tại VN, ban chấp hành YBA HCM - tổ chức dành cho doanh nghiệp có lịch sử 30 năm và uy tín hàng đầu VN.</p>
                            <p class="pp">  3. Mr. Cao Minh Tuấn - chủ tịch tập đoàn nha khoa Saigon Tâm Đức với chuỗi 50 phòng khám</p>
                            <p class="pp">   4. Mrs. Lê Thị Ngọc Thủy - chủ tịch Viva International với chuỗi 400 quán cafe Viva Coffee</p>
                            <p class="pp">   5. 20 chủ doanh nghiệp có chuyên môn và thành tích trong 20 lĩnh vực khác nhau.</p>

                            <p class="pp">➤    2. Quốc tế:</p>
                            <p class="pp">    1. thầy Adrian Wee - founder MMC với 40,000 doanh nghiệp tại Malaysia, Singapore, Thailand, Brunei...</p>
                            <p class="pp">    2. Dr. Dolf De Roos - từ USA- chuyên gia bất động sản hàng đầu thế giới và cố vấn của tổng thống Donald Trump, cố vấn của cha giàu và viết cùng sách với Donald Trump, Robert Kiyosaki, mạng lưới quan hệ có thể giúp mở rộng kinh doanh ra 27 quốc gia</p>
                            <p class="pp">    3. Mr. Park Bong Kyu - chủ tịch Korea CEO Summit với 8,000 doanh nghiệp Hàn Quốc như Samsung, Lotte và mạng lưới quan chức chính phủ Hàn Quốc -phó thủ tướng, bộ trưởng, thị trưởng Seoul, Busan...</p>
                            <p class="pp">    4. Mr. Abdulaziz Qambar - từ Trung Đông: Global Telecommunication leader: đã sáng lập nhiều công ty mạng di động với giá trị đầu tư vượt quá 10 tỷ đô la Mỹ giúp kết nối kinh doanh tại các nước Trung Đông.</p>
                            <p class="pp">    5. Mr. Mark Yamamoto - từ Nhật Bản: chủ tịch KW Nhật Bản với 15 sàn bất động sản và mạng lưới nhà đầu tư cá nhân, tổ chức có giá trị tài sản lớn tại Nhật Bản.</p>
                            <p class="pp">   6. Mr. Brady: Nexus - mạng lưới đầu tư bất động sản tại Anh
                            <p class="pp">    7. Freewill Capital: mạng lưới family office với các gia đình có tài sản trên 100M USD tại VN & USA

                            <p class="pp">    5. Công nghệ: sự kiện duy nhất mà người tham dự có thể kết nối cùng lúc với gần 1000 CEO & nhà đầu tư thông qua app SharkLand với tính năng thẻ năng lực & MXH CEO - nhà đầu tư với thông tin đầy đủ, tìm kiếm và kết nối dễ dàng.</p>

                            <p class="pp">     6. Ban tổ chức: KW Vietnam và PDCA - thương hiệu nhượng quyền BDS top 1 thế giới (với networking mối quan hệ trên 60 nước) và thương hiệu đào tạo CEO top Vietnam với 30,000 CEO đã từng học</p>

                            <p class="pp">➤   7. Nội dung:</p>
                            <p class="pp">    - có các phiên chính với nội dung về phương thức giúp CEO & nhà đầu tư vượt qua thời kỳ khó khăn và tận dụng những cơ hội lớn với kiến thức đến từ tập đoàn số 1 thế giới với chủ đề "Xuyên bão:" chiến lược CHUYỂN ĐỔI trong 2 đợt khủng hoảng đã đưa một doanh nghiệp lên top 1 thế giới & doanh số 535 tỷ USD như thế nào?</p>
                            <p class="pp">   - 2 phiên tọa đàm với nhiều góc nhìn và kinh nghiệm thực tế chia sẻ từ các CEO VN và quốc tế</p>
                            <p class="pp">    - cùng 20 workshop nhỏ về 20 nội dung khác nhau cho CEO & nhà đầu tư</p>

                        </div>
                        <p class="text-center" id="see1" style="cursor: pointer;">Read more</p>
                    </div>
                </div>

                <ul class="nav nav-tabs">
                  <li><a data-toggle="tab" href="#sesion">Sessions Game</a></li>
                </ul>

                <div class="tab-content">
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
//                                dd($codes);
                                if ($session->note) {
                                    $sTests = explode('-', $session->note);
                                }
                            @endphp

                            <div class="item">
                                <h3 class="text-center">{{$session->name}}</h3>
                                <p>
                                    <strong>Missions:  Scan the QR to receive a Lucky Draw Code.</strong>
                                </p>
                                <p><strong>Lucky Code:</strong> <span class="fs-25">{{$codes ? $codes : '---'}}</span></p>

                                <p><strong>Joined:  <span style="color:green">{{$totalCompleted}}</span> / 8 sessions</strong></p>
                                @if(false)
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

                </div>

                <div class="event-info" style="border-top: 0; margin-top: 15px;">
                    <div class="aaa mt-2">
                        Plats Event: Web3 Event Platform <br>
                        Nền tảng tổ chức sự kiện mới nhất, hỗ trợ Travel game, Session game và quay thưởng vui nhộn. Ngoài ra Plats Event còn

                        cung cấp các dịch vụ khác như Tạo và Phân phối NFT trong các sự kiện, Tạo và Thực hiện các nhiệm vụ truyền thống như
                        Social Tasks hay các nhiệm vụ Onchain Tasks.
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

    <div id="infoEditEmail" class="modal fade @if (Str::contains($email, 'guest')) show @endif" data-backdrop="static" data-keyboard="false">
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
                    <h5 class="modal-title" style="font-size: 25px; text-align: center;">Đăng ký Check-in Sự Kiện</h5>
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
