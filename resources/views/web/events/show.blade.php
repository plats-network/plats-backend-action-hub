@extends('web.layouts.event_app')

@section('content')
    <section class="confer-blog-details-area section-padding-100-0">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="pr-lg-4 mb-100">
                        <div class="post-details-content">
                            <div class="post-blog-thumbnail mb-30">
                                <img src="{{$event->banner_url}}" alt="">
                            </div>
                            <h4 class="post-title">{{$event->name}}</h4>
                            <div class="post-meta">
                                <a class="post-date" href="#">
                                    <i class="zmdi zmdi-alarm-check"></i> {{dateFormat($event->created_at)}}
                                </a>
                                <a class="post-author" href="#"><i class="zmdi zmdi-account"></i> {{optional($event->author)->name}}</a>
                                <a class="post-author" href="#"><i class="zmdi zmdi-favorite-outline"></i> 8 Likes</a>
                            </div>
                            {!! $event->description !!}
                        </div>

                        <div class="post-tags-social-area mt-30 pb-5 d-flex flex-wrap align-items-center">
                            <div class="popular-tags d-flex align-items-center">
                                <p><i class="zmdi zmdi-label"></i></p>
                                <ul class="nav">
                                    <li><a href="#">Event</a></li>
                                </ul>
                            </div>
                            <div class="author-social-info">
                                {!!
                                    Share::page(route('web.events.show', $event->id), $event->name)
                                        ->facebook()
                                        ->twitter()
                                        ->linkedin($event->name)
                                        ->whatsapp()
                                        ->telegram()
                                !!}
                            </div>
                        </div>
                        <div class="post-author-area d-flex align-items-center my-5">
                            <div class="author-avatar">
                                <img src="{{imgAvatar(optional($event->author)->avatar_path)}}" alt="{{optional($event->author)->name}}">
                            </div>
                            <div class="author-content">
                                <h5>{{optional($event->author)->name}}</h5>
                                <span>Client Service</span>
                                {{-- <p>OK</p> --}}
                            </div>
                        </div>
                    </div>
                </div>
                <div id="fixed" class="col-lg-4">
                    <div class="confer-sidebar-area mb-100">
                        <div class="single-widget-area">
                            <div class="post-author-widget">
                                <a id="showModal" class="btn btn-info" href="#">Get Ticket</a>
                                @if ($sponsor)
                                    <hr>
                                    <div class="sponsor">
                                        <h3 style="font-size: 30px;">Sponsor</h3>
                                        <h3 class="title" title="{{$sponsor->name}}">{{$sponsor->name}}</h3>
                                        <p class="descs"  title="{{$sponsor->description}}">{{$sponsor->description}}</p>
                                        <div class="note">
                                            <p class="price">Total Price: ${{number_format($sponsor->price)}}</p>
                                            <p>Backers: 10+</p>
                                            <p>Est delivery: {{dateFormat($sponsor->end_at)}}</p>
                                        </div>

                                        <h3>Support</h3>
                                        <div class="buget">
                                            <h3>Make a pledge without a reward</h3>
                                            <div class="row text-left">
                                                <div class="col-12 text-left">
                                                    <label class="text-left" style="width: 100%; font-size: 12px;">Pledge amount</label>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4" style="padding-top: 8px; padding-right: 20px;">$</div>
                                                <div class="col-md-8">
                                                    <input id="amount" class="form-control" type="text" name="price">
                                                    <input id="sponsorId" type="hidden">
                                                </div>
                                            </div>
                                            @if (auth()->guest())
                                                <a class="guest" href="{{route('web.formLogin', ['type' => 'sponsor', 'id' => $event->id])}}">Continue</a>
                                            @else
                                                <button
                                                    class="disabled"
                                                    type="submit"
                                                    disabled
                                                    id="cSponsor"
                                                    data-type="sponsor"
                                                    data-id="{{$event->id}}"
                                                    data-url="{{route('new.sponsor')}}">Continue</button>
                                            @endif
                                        </div>

                                        <h3>Package</h3>
                                        <div class="package-item">
                                            @foreach($sponsor->sponsorDetails as $item)
                                                <div class="item price-package" data-price="{{number_format($item->price)}}" data-id="{{$item->id}}">
                                                    <p>{{$item->name}} <span class="price">${{$item->price}}</span></p>
                                                    <p class="desc">{{$item->description}}</p>
                                                    <hr>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div id="myModal" class="modal fade" data-backdrop="static" data-keyboard="false">
        <style type="text/css">
            .text-danger {
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
                    <h5 class="modal-title" style="font-size: 30px; text-align: center;">Contact information</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{route('order.ticket')}}">
                        @csrf
                        <p class="text-danger text-center" style="padding-bottom: 20px;">Vui lòng nhập đúng thông tin email or số điện thoại để nhận đc những phần quà hấp dẫn từ sự kiện.</p>

                        <input type="hidden" name="task_id" value="{{$event->id}}">

                        <div class="row my-3">
                            <div class="col-md-6">
                                <label class="form-label">First Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="first" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Last Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="last" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <label class="form-label">Email <span class="text-danger">*</span></label>
                                <input
                                    type="text"
                                    class="form-control"
                                    name="email"
                                    value="{{$user ? $user->email : ''}}"
                                    @if ($user) disabled @endif
                                    required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Phone <span class="text-danger">(optional)</span></label>
                                <input type="text" class="form-control" value="{{$user ? $user->phone : ''}}" name="phone">
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

    @include('web.layouts.subscribe')
    <a href="#" class="btn btn-primary ticket--sp">Get ticket</a>
@endsection

