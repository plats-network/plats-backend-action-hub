@extends('web.layouts.event_app')

@section('content')
    <section class="our-schedule-area bg-white section-padding-100">
        {{-- <h3>Ready to get started with Plats Network?</h3> --}}
        <div class="container" style="margin-top: 85px;">
            <div class="row">
                <div class="col-12">
                    <div class="schedule-tab">
                        <ul class="nav nav-tabs" id="conferScheduleTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="monday-tab" data-toggle="tab" href="#step-one" role="tab" aria-controls="step-one" aria-expanded="true">Session</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="tuesday-tab" data-toggle="tab" href="#step-two" role="tab" aria-controls="step-two" aria-expanded="true">Booth</a>
                            </li>
                        </ul>
                    </div>

                    <div class="contact-form">
                        <p>Name: {{auth()->user()->name}}</p>
                    </div>

                    <div class="tab-content" id="conferScheduleTabContent">
                        <div class="tab-pane fade show active" id="step-one" role="tabpanel" aria-labelledby="monday-tab">
                            <div class="contact-form">
                                <div class="widget-wrap">
                                    <div class="vtl">
                                        @foreach($sessions as $item)
                                            {{-- active --}}
                                            <div class="event {{$item['flag'] ? 'active alert-success' : ''}}">
                                                <p class="date">{{$item['flag']}}</p>
                                                <p class="txt">{{$item['name']}}</p>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="step-two" role="tabpanel" aria-labelledby="tuesday-tab">
                            <div class="contact-form">
                                <div class="widget-wrap">
                                    <div class="vtl">
                                        @foreach($booths as $item)
                                            <div class="event {{$item['flag'] ? 'active alert-success' : ''}}">
                                                <p class="date">{{$item['flag']}}</p>
                                                <p class="txt">{{$item['name']}}</p>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection