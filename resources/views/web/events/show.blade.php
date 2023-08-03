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
                    </div>
                </div>
                <div id="fixed" class="col-12 col-md-6 col-lg-4 col-xl-3">
                    <div class="confer-sidebar-area mb-100" style="position: fixed; z-index: 10;">
                        <div class="single-widget-area">
                            <div class="post-author-widget">
                                <a id="showModal" class="btn btn-info" href="#">Get Ticket</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div id="myModal" class="modal fade" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Modal Title</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="#">
                        <input type="hidden" name="task_id" value="{{$event->id}}">
                      <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Name</label>
                        <input type="text" class="form-control" name="name" id="name" placeholder="Fullname">
                        <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
                      </div>
                      <div class="mb-3">
                        <label for="exampleInputPassword1" class="form-label">Password</label>
                        <input type="password" class="form-control" id="exampleInputPassword1">
                      </div>
                      <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="exampleCheck1">
                        <label class="form-check-label" for="exampleCheck1">Check me out</label>
                      </div>
                      <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary">Save</button>
                </div>
            </div>
        </div>
    </div>

    @include('web.layouts.subscribe')

    <a href="#" class="btn btn-primary ticket--sp">Get ticket</a>
@endsection