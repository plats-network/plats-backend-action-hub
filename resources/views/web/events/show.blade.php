@extends('web.layouts.event_app')

@section('content')
    <section class="confer-blog-details-area section-padding-100-0">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12 col-lg-8 col-xl-9">
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
                                    {{-- <li><a href="#">Workshops</a></li> --}}
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
                                <p>OK</p>
                            </div>
                        </div>
                        {{-- <div class="pager-area d-flex align-items-center flex-wrap mb-80">
                            <div class="pager-single-post d-flex align-items-center">
                                <div class="post-thumb">
                                    <a href="#"><img src="img/bg-img/54.jpg" alt=""></a>
                                </div>
                                <div class="post-meta">
                                    <a href="#" class="post-title">Strategic Planning</a>
                                    <span>Previous Post</span>
                                </div>
                            </div>
                            <div class="pager-single-post d-flex align-items-center">
                                <div class="post-thumb">
                                    <a href="#"><img src="img/bg-img/55.jpg" alt=""></a>
                                </div>
                                <div class="post-meta">
                                    <a href="#" class="post-title">Petroleum Refining</a>
                                    <span>Next Post</span>
                                </div>
                            </div>
                        </div> --}}
                    </div>
                </div>
                <div id="fixed" class="col-12 col-md-6 col-lg-4 col-xl-3">
                    <div class="confer-sidebar-area mb-100" style="position: fixed;">
                        {{-- <div class="single-widget-area">
                            <div class="search-widget">
                                <form action="#" method="post">
                                    <input type="search" name="search-form" id="searchForm" placeholder="Search">
                                    <button type="submit"><i class="zmdi zmdi-search"></i></button>
                                </form>
                            </div>
                        </div>
                        <div class="single-widget-area">
                            <div class="post-author-widget">
                                <div class="post-author-avatar">
                                    <img src="img/bg-img/50.jpg" alt="">
                                </div>
                                <div class="post-author-content">
                                    <h5>Crystal Perkins</h5>
                                    <span>Photographer</span>
                                    <p>On the other hand, de-nounce with righteous</p>
                                </div>
                                <div class="author-social-info">
                                    <a href="#"><i class="zmdi zmdi-facebook"></i></a>
                                    <a href="#"><i class="zmdi zmdi-instagram"></i></a>
                                    <a href="#"><i class="zmdi zmdi-twitter"></i></a>
                                    <a href="#"><i class="zmdi zmdi-linkedin"></i></a>
                                </div>
                            </div>
                        </div> --}}
                        <div class="single-widget-area">
                            <h5 class="widget-title mb-30">Categories</h5>
                            <ul class="categories-list">
                                <li><a href="#">Technology <span>(5)</span></a></li>
                                <li><a href="#">Medical <span>(7)</span></a></li>
                                <li><a href="#">Conference <span>(3)</span></a></li>
                                <li><a href="#">Workshops <span>(10)</span></a></li>
                                <li><a href="#">Event <span>(12)</span></a></li>
                                <li><a href="#">Progress <span>(4)</span></a></li>
                            </ul>
                        </div>
                        {{-- <div class="single-widget-area">
                            <h5 class="widget-title mb-30">Tag Cloud</h5>
                            <ul class="tag-cloud">
                                <li><a href="#">Speakears</a></li>
                                <li><a href="#">Business</a></li>
                                <li><a href="#">Conference</a></li>
                                <li><a href="#">Digital</a></li>
                            </ul>
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>
    </section>

    @include('web.layouts.subscribe')
@endsection