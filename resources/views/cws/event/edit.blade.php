<?php

/**
 * @var App\Models\Task\ $event
 * @var \App\Models\Quiz\Quiz $itemQuiz
 * @var \App\Models\Event\TaskEvent $sessions
 * @var \App\Models\Event\TaskEventDetail $sessionDetail
 * @var array $categories
 */

?>

@extends('cws.layouts.app')
@section('style')

    @uploadFileCSS


    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/>
    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.1.1/dist/select2-bootstrap-5-theme.min.css"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

    {{--Editor--}}
    <link rel="stylesheet" href="https://uicdn.toast.com/editor/latest/toastui-editor.min.css" />
@endsection
@section('content')
    <div class="container-fluid">

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title mb-0">Forms Steps</h4>
                    </div><!-- end card header -->
                    <div class="card-body">
                        <form method="POST" id="post_form" action="{{$is_update ? route('cws.eventUpdate', ['id' => $event->id]) : route('cws.eventStore')}}">
                            @csrf

                            <input type="hidden" name="id" value="{{ $event->id }}">
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul class="list-unstyled">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <ul class="wizard-nav mb-5">
                                <li class="wizard-list-item">
                                    <div class="list-item">
                                        <div class="step-icon" data-step="0"  data-bs-toggle="tooltip" data-bs-placement="top"
                                             title="Seller Details">
                                            <i class="bx bx-user-circle"></i>
                                        </div>
                                    </div>
                                </li>
                                <li class="wizard-list-item">
                                    <div class="list-item">
                                        <div class="step-icon" data-step="1"  data-bs-toggle="tooltip" data-bs-placement="top"
                                             title="Sessions">
                                            <i class="bx bx-file"></i>
                                        </div>
                                    </div>
                                </li>

                                <li class="wizard-list-item">
                                    <div class="list-item">
                                        <div class="step-icon" data-step="2"  data-bs-toggle="tooltip" data-bs-placement="top"
                                             title="Booths">
                                            <i class="bx bx-edit"></i>
                                        </div>
                                    </div>
                                </li>
                                {{--Social--}}
                                <li class="wizard-list-item">
                                    <div class="list-item">
                                        <div class="step-icon" data-step="3"  data-bs-toggle="tooltip" data-bs-placement="top"
                                             title="Social">
                                            <i class="bx bx-edit"></i>
                                        </div>
                                    </div>
                                </li>
                                <li class="wizard-list-item">
                                    <div class="list-item">
                                        <div class="step-icon" data-step="4"  data-bs-toggle="tooltip" data-bs-placement="top"
                                             title="Quiz">
                                            <i class="bx bx-edit"></i>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                            <!-- wizard-nav -->

                            <div  id="tabwizard0" class="wizard-tab">
                                <div class="text-center mb-4">
                                    <h5>Event Details</h5>
                                    <p class="card-title-desc">Detail Event</p>
                                </div>
                                <div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="mb-3">
                                                        <label for="basicpill-firstname-input" class="form-label">Name</label>
                                                        <input type="text" value="{{ $event->name }}"
                                                               class="form-control" placeholder="Event Name" id="name" name="name">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="mb-3">
                                                        <label for="basicpill-firstname-input" class="form-label">Address</label>
                                                        <input type="text" value="{{ $event->address }}"
                                                               class="form-control" placeholder="Enter Event Address" id="address" name="address">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <div class="mb-3">
                                                        <label for="basicpill-firstname-input" class="form-label">Lat</label>
                                                        <input type="text" class="form-control" value="{{ $event->lat }}"
                                                               placeholder="Enter Event Name" id="lat" name="lat">
                                                    </div>
                                                </div><!-- end col -->
                                                <div class="col-lg-6">
                                                    <div class="mb-3">
                                                        <label for="basicpill-lastname-input" class="form-label">Lng</label>
                                                        <input type="text" class="form-control" value="{{ $event->lng }}"
                                                               placeholder="Enter Last Name" name="lng" id="lng">
                                                    </div>
                                                </div><!-- end col -->
                                            </div><!-- end row -->

                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="mb-3">
                                                        <label for="event_description" class="form-label">Description</label>

                                                        <div id="editor"></div>
                                                        <input type="hidden" id="description" name="description" value="{{ $event->description }}">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-lg-3">
                                                    <div class="form-group field-article-thumbnail">
                                                        <label for="article-thumbnail" class="mb-3"><b>Ảnh Thumbnail</b></label>
                                                        <div>
                                                            <input type="hidden" id="article-thumbnail" class="empty-value"
                                                                   name="thumbnail">
                                                            <input type="file" id="w0" name="_fileinput_w0"></div>
                                                        <div class="invalid-feedback">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-9">

                                                    <div class="col-sm-12 mb-3">
                                                        <label class="form-label" for="ap-category">Ảnh Slide <span
                                                                class="text-danger">*</span>
                                                        </label>
                                                        <div><input type="hidden" id="article-attachments" class="empty-value"
                                                                    name="Article[attachments]">
                                                            <input type="file" id="w1" name="_fileinput_w1" multiple>
                                                        </div>
                                                        <div class="invalid-feedback"></div>
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <div class="mb-3">
                                                        <label for="basicpill-address-input"
                                                               class="form-label">Order</label>
                                                        <input type="text" class="form-control" placeholder="" value="{{ $event->order }}" id="order" name="order">
                                                    </div>
                                                </div><!-- end col -->
                                                <div class="col-lg-6">
                                                    <div class="mb-3">
                                                        <label for="basicpill-address-input"
                                                               class="form-label">&nbsp;</label>
                                                        <div class="form-check mt-1">
                                                            <input class="form-check-input" type="checkbox" value="1" name="is_paid" id="is_paid" @if($event->is_paid)  checked @endif>
                                                            <label class="form-check-label" for="flexCheckPaid">
                                                                Paid
                                                            </label>
                                                        </div>
                                                    </div>

                                                </div><!-- end col -->
                                            </div><!-- end row -->
                                            <div class="row" id="row_paid">
                                                <div class="col-lg-6">
                                                </div><!-- end col -->
                                                <div class="col-lg-3">
                                                    <div class="mb-3">
                                                        <div class="mb-3">
                                                            <input type="text" class="form-control" placeholder="reward" id="reward" name="reward" value="{{$event->reward}}">
                                                        </div>
                                                    </div>

                                                </div><!-- end col -->
                                                <div class="col-lg-3">
                                                    <div class="mb-3">
                                                        <div class="mb-3">
                                                            <select class="form-select" name="reward_type" id="reward_type" aria-label="Default select example">
                                                                <option value="0" {{ ( $event->reward_type == 0) ? 'selected' : '' }} >Web</option>
                                                                <option value="1" {{ ( $event->reward_type == 1) ? 'selected' : '' }}>User</option>
                                                            </select>
                                                        </div>
                                                    </div>

                                                </div><!-- end col -->
                                            </div><!-- end row -->


                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <div class="mb-3">
                                                        <label for="basicpill-phoneno-input"
                                                               class="form-label">Start At</label>
                                                        <input type="text" class="form-control" value="{{ $event->start_at }}"
                                                               placeholder="" id="start_at" name="start_at">
                                                    </div>
                                                </div><!-- end col -->
                                                <div class="col-lg-6">
                                                    <div class="mb-3">
                                                        <label for="basicpill-email-input"
                                                               class="form-label">End At</label>
                                                        <input type="text" class="form-control" value="{{ $event->end_at }}"
                                                               placeholder="" id="end_at" name="end_at">
                                                    </div>
                                                </div><!-- end col -->
                                            </div><!-- end row -->
                                        </div>

                                    </div>


                                </div>

                            </div>
                            <!-- wizard-tab -->

                            <div  id="tabwizard1" class="wizard-tab">
                                <div>
                                    <div class="text-center mb-4">
                                        <h5>Sessions</h5>
                                        <p class="card-title-desc">Fill all information below</p>
                                    </div>
                                    <div>
                                        {{--Id--}}
                                        <input type="hidden" name="sessions[id]" id="sessions[id]" value="{{$sessions->id}}">
                                        {{--Event Id--}}
                                        <input type="hidden" name="sessions[task_id]" id="sessions[task_id]" value="{{$event->id}}">
                                        {{--Session Id--}}
                                        <div class="row">
                                            <div class="col-lg-9">
                                                <div class="mb-3">
                                                    <label for="basicpill-pancard-input" class="form-label">Session Name</label>
                                                    <input type="text" class="form-control" value="{{$sessions->name}}" placeholder="Session Name" id="sessions[name]" name="sessions[name]">
                                                </div>
                                            </div><!-- end col -->

                                            <div class="col-lg-2">
                                                <div class="mb-3">
                                                    <label for="basicpill-vatno-input"
                                                           class="form-label">&nbsp;</label>
                                                    <input type="text" class="form-control" placeholder="" value="{{$sessions->max_job}}" id="sessions[max_job]" name="sessions[max_job]">
                                                </div>
                                            </div><!-- end col -->
                                        </div><!-- end row -->
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="mb-3">
                                                    <label for="basicpill-cstno-input" class="form-label">Mô tả session</label>
                                                    <div id="editor2"></div>
                                                    <input type="hidden" class="form-control" id="sessions-description" name="sessions[description]" value="{{$sessions->description}}"  />

                                                </div>
                                            </div><!-- end col -->

                                        </div><!-- end row -->
                                        <div class="row mt-3">
                                            <div class="listRowSession" id="listRowSession">
                                                @if($sessions->detail)

                                                @foreach($sessions->detail as $sessionDetail)

                                                    <div class="mb-3 row itemSessionDetail" id="itemImage{{$sessionDetail->id}}">
                                                        {{--Id--}}
                                                        <input type="hidden" name="sessions[detail][{{$sessionDetail->id}}][id]" id="sessions[detail][{{$sessionDetail->id}}][id]" value="{{$sessionDetail->id}}">
                                                        {{--Session Id--}}
                                                        {{--Is delete--}}
                                                        <input type="hidden" name="sessions[detail][{{$sessionDetail->id}}][is_delete]" id="sessionsFlagDelete{{$sessionDetail->id}}" value="0">

                                                        <label for="inputPassword" class="col-sm-2 col-form-label">Session 1</label>
                                                        <div class="col-sm-4">
                                                            {{--name--}}
                                                            <input type="text" class="form-control" id="sessions[detail][{{$sessionDetail->id}}][name]" name="sessions[detail][{{$sessionDetail->id}}][name]" value="{{$sessionDetail->name}}">
                                                        </div>
                                                        <div class="col-sm-4">
                                                            {{--description--}}
                                                            <input type="text" class="form-control" id="sessions[detail][{{$sessionDetail->id}}][description]" name="sessions[detail][{{$sessionDetail->id}}][description]" value="{{$sessionDetail->description}}">
                                                        </div>
                                                        <div class="col-sm-2">
                                                            {{--Button delete--}}
                                                            <div class="col-auto">
                                                                <button type="button" data-id="{{$sessionDetail->id}}" onclick="deleteImageReform({{$sessionDetail->id}})"  class="btn btn-danger mb-3 btnDeleteImage">Xoá</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                                @endif
                                            </div>

                                            <div class="row mt-3">

                                                <div class="d-flex flex-row-reverse">
                                                    <div class="p-2">
                                                        <button id="btnAddItemSession" type="button" class="btn btn-success btn-rounded waves-effect waves-light mb-2 me-2"><i class="mdi mdi-plus me-1"></i> Thêm Item</button>
                                                    </div>
                                                </div>
                                                <hr>
                                            </div>
                                        </div>
                                    </div><!-- end form -->
                                </div>
                            </div>
                            <!-- wizard-tab -->

                            <div  id="tabwizard2" class="wizard-tab">
                                <div>
                                    <div class="text-center mb-4">
                                        <h5>Booths</h5>
                                        <p class="card-title-desc">Fill all information below</p>
                                    </div>
                                    <div>
                                        <div class="row">
                                            {{--Id--}}
                                            <input type="hidden" name="booths[id]" id="booths[id]" value="{{$booths->id}}">
                                            {{--Event Id--}}
                                            <input type="hidden" name="booths[task_id]" id="booths[task_id]" value="{{$event->id}}">
                                            {{--Session Id--}}
                                            <div class="col-lg-9">
                                                <div class="mb-3">
                                                    <label for="booths[name]" class="form-label">Scan Booth</label>
                                                    <input type="text" class="form-control" value="{{$booths->name}}" placeholder="Booth Name" id="booths[name]" name="booths[name]" />
                                                </div>
                                            </div><!-- end col -->

                                            <div class="col-lg-2">
                                                <div class="mb-3">
                                                    <label for="basicpill-vatno-input"
                                                           class="form-label">&nbsp;</label>
                                                    <input type="text" class="form-control" value="{{$booths->max_job}}" placeholder="max_job" id="booths[max_job]" name="booths[max_job]" >
                                                </div>
                                            </div><!-- end col -->
                                        </div><!-- end row -->
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="mb-3">
                                                    <label for="booths[description]" class="form-label">Mô tả Booth</label>
                                                    <div id="editor3"></div>
                                                    <input type="hidden" class="form-control" id="booths-description" name="booths[description]" value="{{$booths->description}}"  />

                                                </div>
                                            </div><!-- end col -->

                                        </div><!-- end row -->
                                        <div class="row mt-3">
                                            <div class="listRowBooth" id="listRowBooth">
                                                @if($booths->detail)

                                                    @foreach($booths->detail as $boothDetail)

                                                        <div class="mb-3 row itemBoothDetail" id="itemBooth{{$boothDetail->id}}">
                                                            {{--Id--}}
                                                            <input type="hidden" name="booths[detail][{{$boothDetail->id}}][id]" id="booths[detail][{{$boothDetail->id}}][id]" value="{{$boothDetail->id}}">
                                                            {{--Session Id--}}
                                                            {{--Is delete--}}
                                                            <input type="hidden" name="booths[detail][{{$boothDetail->id}}][is_delete]" id="boothFlagDelete{{$boothDetail->id}}" value="0">


                                                            <label for="inputPassword" class="col-sm-2 col-form-label">Booth 1</label>
                                                            <div class="col-sm-4">
                                                                {{--name--}}
                                                                <input type="text" class="form-control" id="booths[detail][{{$boothDetail->id}}][name]" name="booths[detail][{{$boothDetail->id}}][name]" value="{{$boothDetail->name}}">
                                                            </div>
                                                            <div class="col-sm-4">
                                                                {{--description--}}
                                                                <input type="text" class="form-control" id="booths[detail][{{$boothDetail->id}}][description]" name="booths[detail][{{$boothDetail->id}}][description]" value="{{$boothDetail->description}}">
                                                            </div>
                                                            <div class="col-sm-2">
                                                                {{--Button delete--}}
                                                                <div class="col-auto">
                                                                    <button type="button" data-id="{{$boothDetail->id}}" onclick="deleteImageReform({{$boothDetail->id}})"  class="btn btn-danger mb-3 btnDeleteImageBooth">Xoá</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                @endif
                                            </div>

                                            <div class="row mt-3">

                                                <div class="d-flex flex-row-reverse">
                                                    <div class="p-2">
                                                        <button id="btnAddItemBooth" type="button" class="btn btn-success btn-rounded waves-effect waves-light mb-2 me-2"><i class="mdi mdi-plus me-1"></i> Thêm Item</button>
                                                    </div>
                                                </div>
                                                <hr>
                                            </div>
                                        </div>
                                    </div><!-- end form -->

                                </div>
                            </div>

                            <div  id="tabwizard3" class="wizard-tab">
                                <div>
                                    <div class="text-center mb-4">
                                        <h5>Social</h5>
                                        <p class="card-title-desc">Fill all information below</p>
                                    </div>
                                    <div>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="card">
                                                    <div class="card-header">
                                                        Social
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="row">
                                                            {{--Id--}}
                                                            <input type="hidden" name="task_event_socials[id]" id="booths[id]" value="{{$taskEventSocials->id}}">
                                                            {{--Event Id--}}
                                                            <input type="hidden" name="task_event_socials[task_id]" id="booths[task_id]" value="{{$event->id}}">
                                                            <div class="col-md-2">
                                                                <div class="form-check form-check-inline">
                                                                    {{--Checkbox is_comment--}}
                                                                    <input class="form-check-input" @if( $taskEventSocials->is_comment) checked @endif type="checkbox" id="task_event_socials[is_comment]" name="task_event_socials[is_comment]" value="1">
                                                                    <label class="form-check-label" for="inlineCheckbox1">Comment</label>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" @if( $taskEventSocials->is_like) checked @endif type="checkbox" id="task_event_socials[is_like]" name="task_event_socials[is_like]" value="1">
                                                                    <label class="form-check-label" for="inlineCheckbox2">like</label>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" @if( $taskEventSocials->is_retweet) checked @endif type="checkbox" id="task_event_socials[is_retweet]" name="task_event_socials[is_retweet]" value="1">
                                                                    <label class="form-check-label" for="inlineCheckbox3">Retweet</label>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" @if( $taskEventSocials->is_tweet) checked @endif type="checkbox" id="task_event_socials[is_tweet]" name="task_event_socials[is_tweet]" value="1">
                                                                    <label class="form-check-label" for="inlineCheckbox4">Tweet</label>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="mt-3">
                                                            <div class="mb-3">
                                                                <label for="basicpill-cardno-input"
                                                                       class="form-label">Url</label>
                                                                <input type="text" value="{{$taskEventSocials->url}}" class="form-control" placeholder="Url" id="task_event_socials[url]" name="task_event_socials[url]">
                                                            </div>

                                                            <div class="mb-3">
                                                                <label for="basicpill-cardno-input"
                                                                       class="form-label">Text</label>
                                                                <input type="text"  value="{{$taskEventSocials->text}}" class="form-control" placeholder="Text" id="task_event_socials[text]" name="task_event_socials[text]">
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                                <div class="card">
                                                    <div class="card-header">
                                                        Discord
                                                    </div>
                                                    <div class="card-body">
                                                        {{--Id--}}
                                                        <input type="hidden" name="task_event_discords[id]" id="booths[id]" value="{{$taskEventDiscords->id}}">
                                                        {{--Event Id--}}
                                                        <input type="hidden" name="task_event_discords[task_id]" id="booths[task_id]" value="{{$event->id}}">
                                                        <div class="mb-3">
                                                            <label for="basicpill-cardno-input"
                                                                   class="form-label">Bot Token</label>
                                                            <input type="text" class="form-control" placeholder="Bot Token" value="{{$taskEventDiscords->bot_token}}" name="task_event_discords[bot_token]" id="task_event_discords[bot_token]">
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-lg-6">
                                                                <div class="mb-3">
                                                                    <label for="basicpill-cardno-input"
                                                                           class="form-label">Channel Id</label>
                                                                    <input type="text" class="form-control" placeholder="Channel Id" value="{{$taskEventDiscords->channel_id}}" name="task_event_discords[channel_id]" id="task_event_discords[channel_id]">
                                                                </div>
                                                            </div><!-- end col -->
                                                            <div class="col-lg-6">
                                                                <div class="mb-3">
                                                                    <label for="basicpill-cardno-input"
                                                                           class="form-label">Channel Url</label>
                                                                    <input type="text" class="form-control" placeholder="Channel Url" value="{{$taskEventDiscords->channel_url}}" name="task_event_discords[channel_url]" id="task_event_discords[channel_url]">
                                                                </div>
                                                            </div><!-- end col -->
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>

                                            </div>
                                        </div><!-- end row -->
                                    </div><!-- end form -->

                            </div>

                            <div  id="tabwizard4" class="wizard-tab">
                                <div>
                                    <div class="text-center mb-4">
                                        <h5>Quiz</h5>
                                        <p class="card-title-desc">Fill all information below</p>
                                    </div>
                                    <div>
                                        <div class="listQuiz" id="listRowQuiz">
                                            @foreach($quiz as $itemQuiz)
                                                <div class="mb-3 row itemQuizDetail" id="itemQuiz{{$itemQuiz->id}}">
                                                    {{--id --}}
                                                    <input type="hidden" name="quiz[{{$itemQuiz->id}}][id]" value="{{$itemQuiz->id}}">
                                                    {{--Event Id--}}
                                                    <input type="hidden" name="quiz[{{$itemQuiz->id}}][task_id]" value="{{$event->id}}">
                                                    {{--Is delete--}}
                                                    <input type="hidden" name="quiz[{{$itemQuiz->id}}][is_delete]" id="quizFlagDelete{{$event->id}}" value="0">

                                                    <div class="row">
                                                        <div class="col-lg-7">
                                                            <div class="mb-3">
                                                                <label for="basicpill-expiration-input"
                                                                       class="form-label">Question {{$loop->index +1}}</label>
                                                                {{--Item question--}}
                                                                <input type="text" class="form-control" id="quiz[{{$itemQuiz->id}}][name]"
                                                                       placeholder="Question {{$loop->index +1}}" name="quiz[{{$itemQuiz->id}}][name]" value="{{$itemQuiz->name}}">

                                                            </div>
                                                        </div>
                                                        <div class="col-lg-2">
                                                            <div class="mb-3">
                                                                <label for="basicpill-expiration-input"
                                                                       class="form-label">Time</label>
                                                                <input type="text" class="form-control" id="quiz[{{$itemQuiz->id}}][time_quiz]"
                                                                       placeholder="Time" name="quiz[{{$itemQuiz->id}}][time_quiz]" value="{{$itemQuiz->time_quiz}}">
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-1">
                                                            <div class="mb-3">
                                                                <label for="basicpill-expiration-input"
                                                                       class="form-label">Order</label>
                                                                <input type="text" class="form-control" id="quiz[{{$itemQuiz->id}}][order]"
                                                                       placeholder="Order" name="quiz[{{$itemQuiz->id}}][order]" value="{{$itemQuiz->order}}">
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-2">
                                                            <label for="basicpill-expiration-input"
                                                                   class="form-label">&nbsp;</label>
                                                            <div class="form-check form-switch">
                                                                <input class="form-check-input" type="checkbox" role="switch" id="quiz[{{$itemQuiz->id}}][status]"
                                                                       name="quiz[{{$itemQuiz->id}}][status]" @if($itemQuiz->status == 1) checked @endif>
                                                                <label class="form-check-label" for="flexSwitchCheckChecked">Status</label>
                                                            </div>
                                                        </div>
                                                    </div><!-- end row -->
                                                    <br>
                                                    {{--QuizAnswer--}}
                                                    @foreach($itemQuiz->detail as $keyIndex => $itemQuizAnswer)
                                                        {{--id --}}
                                                        <input type="hidden" name="quiz[{{$itemQuiz->id}}][detail][{{$keyIndex}}][id]" value="{{$itemQuizAnswer->id}}">
                                                        {{--quiz_id --}}
                                                        <input type="hidden" name="quiz[{{$itemQuiz->id}}][detail][{{$keyIndex}}][quiz_id]" value="{{$itemQuizAnswer->quiz_id}}">

                                                        <div class="row">
                                                            <div class="mb-3 row offset-md-1">
                                                                <label for="inputPassword" class="col-sm-2 col-form-label">Answer {{$keyIndex +1}}</label>
                                                                <div class="col-sm-7">
                                                                    {{--name--}}
                                                                    <input type="text" class="form-control" id="quiz[{{$itemQuiz->id}}][detail][{{$keyIndex}}][name]"
                                                                           placeholder="Answer 1" name="quiz[{{$itemQuiz->id}}][detail][{{$keyIndex}}][name]" value="{{$itemQuizAnswer->name}}">
                                                                </div>
                                                                <div class="col-sm-2">

                                                                    <div class="form-check mt-2">
                                                                        {{--status--}}
                                                                        <input class="form-check-input" type="checkbox" value="1" id="quiz[{{$itemQuiz->id}}][detail][{{$keyIndex}}][status]"
                                                                               name="quiz[{{$itemQuiz->id}}][detail][{{$keyIndex}}][status]" @if($itemQuizAnswer->status == 1) checked @endif>
                                                                        <label class="form-check-label" for="flexCheckDefault">
                                                                            Option
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach

                                                    {{--Delete Item--}}
                                                    <div class="row">
                                                        <div class="col-lg-12">
                                                            <div class="mb-3">
                                                                <label for="basicpill-expiration-input"
                                                                       class="form-label">&nbsp;</label>
                                                                <button type="button" data-id="{{$itemQuiz->id}}" class="btnDeleteImageQuiz btn btn-danger btn-rounded waves-effect waves-light mb-2 me-2" onclick="deleteItemQuiz({{$itemQuiz->id}})"><i class="mdi mdi-delete me-1"></i> Delete</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>


                                        <div class="row mt-3">

                                            <div class="d-flex flex-row-reverse">
                                                <div class="p-2">
                                                    <button id="btnAddItemQuiz" type="button" class="btn btn-success btn-rounded waves-effect waves-light mb-2 me-2"><i class="mdi mdi-plus me-1"></i> Thêm câu hỏi</button>
                                                </div>
                                            </div>
                                            <hr>
                                        </div>
                                    </div><!-- end form -->

                                </div>
                            </div>
                            <!-- wizard-tab -->

                            <div class="d-flex align-items-start gap-3 mt-4">
                                <button type="button" class="btn btn-primary w-sm" id="prevBtn" onclick="nextPrev(-1)">Previous</button>
                                <button type="button" class="btn btn-primary w-sm ms-auto" id="nextBtn" onclick="nextPrev(1)">Next</button>
                            </div>

                            {{--Submit button--}}
                            <div class="d-flex flex-wrap gap-3 mt-3">
                                <button type="submit" class="btn btn-lg btn-primary" >Submit</button>
                                <a  class="btn btn-secondary btn-lg" href="{{route('cws.eventList')}}" >Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div><!-- end col -->
        </div><!-- end row -->




    </div>
    {{--Modal Loading--}}
    <div class="modal fade" id="modalLoading" tabindex="-1" role="dialog" aria-labelledby="modal-default"
         aria-hidden="true">
        <div class="modal-dialog modal-primary modal-dialog-centered" role="document">
            <div class="modal-content bg-gradient-secondary">
                <div class="modal-body">
                    <div class="d-flex align-items-center">
                        <strong class="text-white">Uploading...</strong>

                        <div class="spinner-border ms-auto" role="status" aria-hidden="true"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    {{--End Modal Loading--}}
@endsection


@section('scripts')
    @uploadFileJS
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    <script src="{{asset('plugins/yii2-assets/yii.js')}}"></script>
    <script src="{{asset('plugins/yii2-assets/yii.activeForm.js')}}"></script>
    <script src="{{asset('plugins/yii2-assets/yii.validation.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://uicdn.toast.com/editor/latest/toastui-editor-all.min.js"></script>
    <script src="https://uicdn.toast.com/editor/latest/i18n/ko-kr.js"></script>
    <script src="https://uicdn.toast.com/editor/latest/i18n/ja-jp.js"></script>

    <script>
        var _token = $('meta[name="csrf-token"]').attr('content');
        var spinText = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> ';
        var fileAvatarInit = null;
        var flag_check = 1;

        var modalLoading = $('#modalLoading');

        const { Editor } = toastui;


        Editor.setLanguage('en-US', {
            Write: 'Viết',
            Preview: 'Xem trước',
            Headings: 'Tiêu đề',
            Paragraph: 'Trang',
            Bold: 'In đậm',
            Italic: 'Nghiêng',
            Strike: 'Gạch xuyên ngang',
            Code: 'Inline code',
            Line: 'Dòng',
            Blockquote: 'Blockquote',
            'Unordered list': 'Danh sách không thứ tự',
            'Ordered list': 'Danh sách có thứ tự',
            Task: 'Công việc',
            Indent: 'Indent',
            Outdent: 'Outdent',
            'Insert link': 'Chèn link',
            'Insert CodeBlock': 'Chèn codeBlock',
            'Insert table': 'Chèn bảng',
            'Insert image': 'Chèn ảnh',
            Heading: 'Tiêu đề',
            'Image URL': 'Image URL',
            'Select image file': 'Hãy chọn file hình ảnh',
            'Choose a file': 'Chọn file',
            'No file': 'Chưa chọn file',
            Description: 'Miêu tả',
            OK: 'OK',
            More: 'Thêm',
            Cancel: 'Huỷ',
            File: 'File',
            URL: 'URL',
            'Link text': '',
            'Add row to up': 'Thêm dòng lên trên',
            'Add row to down': 'Thêm dòng xuống dưới',
            'Add column to left': 'Thêm cột trái',
            'Add column to right': 'Thêm cột phải',
            'Remove row': 'Xoá hàng',
            'Remove column': 'Xoá cột',
            'Align column to left': 'Căn cột trái',
            'Align column to center': 'Căn cột giữa',
            'Align column to right': 'Căn cột phải',
            'Remove table': 'Xoá bảng',
            'Would you like to paste as table?': 'Bạn có muốn chèn nội dung như bảng?',
            'Text color': 'Màu chữ',
            'Auto scroll enabled': 'Tự động cuộn',
            'Auto scroll disabled': 'Không tự động cuộn',
            'Choose language': 'Chọn ngôn ngữ',
        });

        var initial_form_state, last_form_state;
        var contentEditor = document.getElementById('description').value;
        var contentEditor2 = document.getElementById('sessions-description').value;
        var contentEditor3 = document.getElementById('booths-description').value;

        const editor = new toastui.Editor({
            el: document.querySelector('#editor'),
            previewStyle: 'vertical',
            language: 'en-US',
            initialEditType: 'wysiwyg', //markdown, wysiwyg
            height: '350px',
            initialValue: contentEditor,
            hooks: {
                addImageBlobHook(imgeBlob, callback) {
                    // write your code
                    //console.log(imgeBlob)
                    var fd = new FormData();
                    fd.append('file',imgeBlob);
                    //Show loading
                    modalLoading.modal("show");

                    $.ajax({
                        url :  "{{route('uploadEditor')}}",
                        type: 'POST',
                        data: fd,
                        contentType: false,
                        processData: false,
                        cache: false,

                        success: function(data) {
                            urlImage = data.url_full;
                            callback(urlImage, data.name)

                            modalLoading.modal("hide");
                        },
                        error: function() {
                            //alert("not so boa!");
                        }
                    });
                    // ...
                }
            }
        });

        const editor2 = new toastui.Editor({
            el: document.querySelector('#editor2'),
            previewStyle: 'vertical',
            language: 'en-US',
            initialEditType: 'wysiwyg', //markdown, wysiwyg
            height: '350px',
            initialValue: contentEditor2,
            hooks: {
                addImageBlobHook(imgeBlob, callback) {
                    // write your code
                    //console.log(imgeBlob)
                    var fd = new FormData();
                    fd.append('file',imgeBlob);
                    //Show loading
                    modalLoading.modal("show");

                    $.ajax({
                        url :  "{{route('uploadEditor')}}",
                        type: 'POST',
                        data: fd,
                        contentType: false,
                        processData: false,
                        cache: false,

                        success: function(data) {
                            urlImage = data.url_full;
                            callback(urlImage, data.name)

                            modalLoading.modal("hide");
                        },
                        error: function() {
                            //alert("not so boa!");
                        }
                    });
                    // ...
                }
            }
        });

        const editor3 = new toastui.Editor({
            el: document.querySelector('#editor3'),
            previewStyle: 'vertical',
            language: 'en-US',
            initialEditType: 'wysiwyg', //markdown, wysiwyg
            height: '350px',
            initialValue: contentEditor3,
            hooks: {
                addImageBlobHook(imgeBlob, callback) {
                    // write your code
                    //console.log(imgeBlob)
                    var fd = new FormData();
                    fd.append('file',imgeBlob);
                    //Show loading
                    modalLoading.modal("show");

                    $.ajax({
                        url :  "{{route('uploadEditor')}}",
                        type: 'POST',
                        data: fd,
                        contentType: false,
                        processData: false,
                        cache: false,

                        success: function(data) {
                            urlImage = data.url_full;
                            callback(urlImage, data.name)

                            modalLoading.modal("hide");
                        },
                        error: function() {
                            //alert("not so boa!");
                        }
                    });
                    // ...
                }
            }
        });

    </script>
    <script>
        jQuery(document).ready(function ($) {
            // display a modal (small modal)
            var uploadUrl = '{{route('upload-storage-single', ['_token' => csrf_token()])}}';

            //Check flexCheckPaid is checked then show div #paid
            $('#flexCheckPaid').on('change', function () {
                if ($(this).is(':checked')) {
                    $('#row_paid').show();
                } else {
                    $('#row_paid').hide();
                }
            });
            //start_at datepicker
            $('#start_at').flatpickr(
                {
                    enableTime: true,
                    dateFormat: "Y-m-d H:i",
                    time_24hr: true,
                    locale: 'vn'
                }
            )
            //End_at datepicker
            $('#end_at').flatpickr(
                {
                    enableTime: true,
                    dateFormat: "Y-m-d H:i",
                    time_24hr: true,
                    locale: 'vn'

                }
            )

            var fileAvatarInit = null;
            var fileSlideInit = null;

            @if($event->banner_url)
                fileAvatarInit = [{
                "path": "{{$event->banner_url}}",
                "base_url": "",
                "type": null,
                "size": null,
                "name": null,
                "order": null
            }];
            @endif

                fileSlideInit = [
                    @foreach($task_galleries as $key=> $fileItem)
                {
                    "path": "{{$fileItem['url']}}",
                    "base_url": "",
                    "type": null,
                    "size": null,
                    "name": null,
                    "order": null
                } @if($key < $total_file-1), @endif
                @endforeach
            ];

            //Update init image
            jQuery('#w0').yiiUploadKit({
                "url": uploadUrl,
                "multiple": false,
                "sortable": false,
                "maxNumberOfFiles": 1,
                "maxFileSize": 5000000,
                "minFileSize": null,
                "acceptFileTypes": /(\.|\/)(gif|jpe?g|png|webp)$/i,
                "files": fileAvatarInit,
                "previewImage": true,
                "showPreviewFilename": true,
                "errorHandler": "popover",
                "pathAttribute": "path",
                "baseUrlAttribute": "base_url",
                "pathAttributeName": "path",
                "baseUrlAttributeName": "base_url",
                "messages": {
                    "maxNumberOfFiles": "Số lượng tối đa của tệp vượt quá",
                    "acceptFileTypes": "Loại tệp không được phép",
                    "maxFileSize": "Tập tin quá lớn",
                    "minFileSize": "Tập tin quá nhỏ"
                },
                "start": function (e, data) {
                    console.log('Upload Start')
                },
                "done": function (e, data) {
                    console.log('Upload Done')
                },
                "fail": function (e, data) {
                    console.log('Upload Fail')
                },
                "always": function (e, data) {
                    console.log('Upload Alway')
                },
                "name": "thumbnail"
            });

            jQuery('#w1').yiiUploadKit({
                "url": uploadUrl,
                "multiple": true,
                "sortable": false,
                "maxNumberOfFiles": 30,
                "maxFileSize": 10000000,
                "minFileSize": null,
                "acceptFileTypes": /(\.|\/)(gif|jpe?g|png|webp)$/i,
                "files": fileSlideInit,
                "previewImage": true,
                "showPreviewFilename": false,
                "errorHandler": "popover",
                "pathAttribute": "path",
                "baseUrlAttribute": "base_url",
                "pathAttributeName": "path",
                "baseUrlAttributeName": "base_url",
                "messages": {
                    "maxNumberOfFiles": "Số lượng tối đa của tệp vượt quá",
                    "acceptFileTypes": "Loại tệp không được phép",
                    "maxFileSize": "Tập tin quá lớn",
                    "minFileSize": "Tập tin quá nhỏ"
                },
                "start": function (e, data) {
                    console.log('Upload Start')
                },
                "done": function (e, data) {
                    console.log('Upload Done')
                },
                "fail": function (e, data) {
                    console.log('Upload Fail')
                },
                "always": function (e, data) {
                    console.log('Upload Alway')
                },
                "name": "Article[attachments]"
            });

        });
    </script>
    <script>
        jQuery(document).ready(function ($) {
            // display a modal (small modal)
            var modalDelete = $('#modalDelete');
            var uploadUrl = '{{config('admin.upload_url')}}';
            var flag_check = 1;
            $(document).on("submit", "#post_form", function (event) {
                //Get Editor content
                var content = editor.getHTML();//editor.getHTML(); getMarkdown
                var content2 = editor2.getHTML();//editor.getHTML();
                var content3 = editor3.getHTML();//editor.getHTML();
                //console.log(content);

                $('[name=description]').attr('value', editor.getHTML());
                $('[id=sessions-description]').attr('value', editor2.getHTML());

                $('[id=booths-description]').attr('value', editor3.getHTML());

                $(window).off('beforeunload');
            });
            //Btn click submit post form
            $(document).on('click', '.btnSubmit', function (event) {
                //event.preventDefault();
                //console.log('123');
                $('#post_form').submit();
            });

            //btnAddItemSession onclick call ajax

            $(document).on('click', '#btnAddItemSession', function (event) {
                //alert('123');
                //Add loading on btnAddImageReform button

                var rowCount = $('.itemSessionDetail').length;
                //console.log(rowCount);
                //Check max image
                if(rowCount >= 20){
                    alert('{{__('Maximum number of Item is')}} 20');
                    return false;
                }
                //initImageWidge(1);
                flag_check = Math.floor(Math.random() * 10000);
                /*Ajax call get template*/
                $.ajax({
                    url: '{{route('cws.eventTemplate')}}' + '?from_reform=1&flag_check=' + flag_check + '&inc=' + rowCount,
                    type: 'GET',
                    dataType: 'json',
                    data: {
                        _token: _token,
                        id: flag_check
                    },
                    success: function (data) {
                        if (data.status == 200) {
                            //console.log(data);
                            $('#listRowSession').append(data.html);
                            flag_check++;
                        }
                    },
                    error: function (data) {
                        console.log(data);
                    }
                });
            });

            /*Delete Image Row*/
            $(document).on('click', '.btnDeleteImage', function (event) {
                event.preventDefault();

                var id = $(this).attr('data-id');
                //Swal confirm
                Swal.fire({
                    title: '{{__('Are you sure?')}}',
                    text: '{{__('You will not be able to recover this imaginary file!')}}',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: '{{__('Yes, delete it!')}}',
                    cancelButtonText: '{{__('Cancel')}}',
                }).then((result) => {
                    if (result.isConfirmed) {
                        $('#itemImage' + id).hide();
                        //sessionsFlagDelete ID set value 1
                        $('#sessionsFlagDelete' + id).val(1);
                    }
                });

            });

            /*Booth*/
            $(document).on('click', '#btnAddItemBooth', function (event) {
                //alert('123');
                //Add loading on btnAddImageReform button

                var rowCount = $('.itemBoothDetail').length;
                //console.log(rowCount);
                //Check max image
                if(rowCount >= 20){
                    alert('{{__('Maximum number of Item is')}} 20');
                    return false;
                }
                //initImageWidge(1);
                flag_check = Math.floor(Math.random() * 10000);
                /*Ajax call get template*/
                $.ajax({
                    url: '{{route('cws.eventTemplate')}}' + '?type=2&flag_check=' + flag_check + '&inc=' + rowCount,
                    type: 'GET',
                    dataType: 'json',
                    data: {
                        _token: _token,
                        id: flag_check
                    },
                    success: function (data) {
                        if (data.status == 200) {
                            //console.log(data);
                            $('#listRowBooth').append(data.html);
                            flag_check++;
                        }
                    },
                    error: function (data) {
                        console.log(data);
                    }
                });
            });

            /*Delete Image Row*/
            $(document).on('click', '.btnDeleteImageBooth', function (event) {
                event.preventDefault();

                var id = $(this).attr('data-id');
                //Swal confirm
                Swal.fire({
                    title: '{{__('Are you sure?')}}',
                    text: '{{__('You will not be able to recover this imaginary file!')}}',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: '{{__('Yes, delete it!')}}',
                    cancelButtonText: '{{__('Cancel')}}',
                }).then((result) => {
                    if (result.isConfirmed) {
                        $('#itemBooth' + id).hide();
                        $('#boothFlagDelete' + id).val(1);
                    }
                });

            });

            /*Quiz*/

            $(document).on('click', '#btnAddItemQuiz', function (event) {
                //alert('123');
                //Add loading on btnAddImageReform button

                var rowCount = $('.itemQuizDetail').length;
                //console.log(rowCount);
                //Check max image
                if(rowCount >= 20){
                    alert('{{__('Maximum number of Item is')}} 20');
                    return false;
                }
                //initImageWidge(1);
                flag_check = Math.floor(Math.random() * 10000);
                /*Ajax call get template*/
                $.ajax({
                    url: '{{route('cws.eventTemplate')}}' + '?type=3&flag_check=' + flag_check + '&inc=' + rowCount,
                    type: 'GET',
                    dataType: 'json',
                    data: {
                        _token: _token,
                        id: flag_check
                    },
                    success: function (data) {
                        if (data.status == 200) {
                            //console.log(data);
                            $('#listRowQuiz').append(data.html);
                            flag_check++;
                        }
                    },
                    error: function (data) {
                        console.log(data);
                    }
                });
            });

            /*Delete Item Quiz*/
            $(document).on('click', '.btnDeleteImageQuiz', function (event) {
                event.preventDefault();

                var id = $(this).attr('data-id');
                //Swal confirm
                Swal.fire({
                    title: '{{__('Are you sure?')}}',
                    text: '{{__('You will not be able to recover this imaginary file!')}}',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: '{{__('Yes, delete it!')}}',
                    cancelButtonText: '{{__('Cancel')}}',
                }).then((result) => {
                    if (result.isConfirmed) {
                        $('#itemQuiz' + id).hide();
                        $('#quizFlagDelete' + id).val(1);
                    }
                });

            });


        });

        var currentTab = {{$activeTab}}; // Current tab is set to be the first tab (0)
        showTab(currentTab); // Display the current tab

        function showTab(n) {
            // This function will display the specified tab of the form...
            var x = document.getElementsByClassName("wizard-tab");

            x[n].style.display = "block";
            //... and fix the Previous/Next buttons:
            if (n == 0) {
                document.getElementById("prevBtn").style.display = "none";
            } else {
                document.getElementById("prevBtn").style.display = "inline";
            }
            if (n == (x.length - 1)) {
                document.getElementById("nextBtn").innerHTML = "Submit";
                //Type submit
            } else {
                document.getElementById("nextBtn").innerHTML = "Next";
            }
            //... and run a function that will display the correct step indicator:
            fixStepIndicator(n)
        }

        function nextPrev(n) {
            // This function will figure out which tab to display
            var x = document.getElementsByClassName("wizard-tab");
            //console.log(x)

            // Hide the current tab:
            x[currentTab].style.display = "none";
            // Increase or decrease the current tab by 1:
            currentTab = currentTab + n;
            // if you have reached the end of the form...
            if (currentTab >= x.length) {
                currentTab = currentTab - n;
                x[currentTab].style.display = "block";
            }
            // Otherwise, display the correct tab:
            showTab(currentTab)
        }

        function fixStepIndicator(n) {
            // This function removes the "active" class of all steps...
            var i, x = document.getElementsByClassName("list-item");
            for (i = 0; i < x.length; i++) {
                x[i].className = x[i].className.replace(" active", "");
            }
            //... and adds the "active" class on the current step:
            x[n].className += " active";
        }

        //step-icon onclick show tab
        $(document).on('click', '.step-icon', function (event) {
            event.preventDefault();
            var id = $(this).attr('data-step');
            //console.log(id);

            showTab(id);
            //Display tab with id tabwizard-index

            $('#tabwizard0').css('display', 'none');
            $('#tabwizard' + id).css('display', 'block');
            //Hide other tab
            for (var i = 1; i <= 4; i++) {
                if (i != id) {
                    $('#tabwizard' + i).css('display', 'none');
                }
            }
            //fixStepIndicator(id);
        });
    </script>
@endsection
