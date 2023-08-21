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
                    </div>
                </div>
                <div id="fixed" class="col-lg-4">
                    <div class="confer-sidebar-area mb-100">
                        <div class="single-widget-area">
                            <div class="post-author-widget">
                                @if ($sponsor)
                                    <div class="sponsor">
                                        <h3 style="font-size: 30px;">Sponsor</h3>
                                        <h3 class="title" title="{{$sponsor->name}}">{{$sponsor->name}}</h3>
                                        <p class="descs"  title="{{$sponsor->description}}">{{$sponsor->description}}</p>
                                        <div class="note">
                                            <p class="price">Total Price: ${{$sponsor->price}}</p>
                                            <p>Backers: 10+</p>
                                            <p>Est delivery: {{dateFormat($sponsor->end_at)}}</p>
                                        </div>

                                        <h3>Support</h3>
                                        <div class="buget">
                                            <h3>Make a pledge without a reward</h3>
                                            <div class="row text-left">
                                                <div class="col-12">
                                                    <label class="text-left" style="width: 100%; font-size: 12px;">Pledge amount</label>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-4">$</div>
                                                <div class="col-md-8">
                                                    <input id="amount" class="form-control" type="text" name="price">
                                                </div>
                                            </div>
                                            @if (auth()->guest())
                                                <a class="guest" href="{{route('web.formLogin', ['type' => 'sponsor', 'id' => $event->id])}}">Continue</a>
                                            @else
                                                <button type="submit">Continue</button>
                                            @endif
                                        </div>

                                        <h3>Package</h3>
                                        <div class="package-item">
                                            @foreach($sponsor->sponsorDetails as $item)
                                                <div class="item price-package" data-price="{{$item->price}}">
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
@endsection