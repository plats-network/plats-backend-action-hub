@extends('cws.layouts.app')

@section('style')
    @uploadFileCSS
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.1.1/dist/select2-bootstrap-5-theme.min.css"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    {{--Editor--}}
    <link rel="stylesheet" href="https://uicdn.toast.com/editor/latest/toastui-editor.min.css" />
    <link rel="stylesheet" href="https://uicdn.toast.com/editor/latest/toastui-editor-viewer.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/notify/0.4.2/styles/metro/notify-metro.min.css" />
@endsection

@section('name_page')
    <div class="page-title-box align-self-center d-none d-md-block">
        <h4 class="page-title mb-0">
            @if($isPreview)
                Preview
            @elseif($event->id)
                Edit
            @else
                Create
            @endif
             Event
        </h4>
    </div>
@endsection

@section('content')
    <style type="text/css">
        .qr {margin: 0 auto; display: block; width: 50px; height: 50px;}
        .se-donw, .bo-donw {cursor: pointer;}
    </style>
    <div class="container-fluid">
        <div class="row">
            @if($isPreview)
                <div class="col-md-12">
                    <a class="btn btn-danger btn-sm mb-2 mr-5" style="margin-right: 10px;" href="{{ route('cws.event.overview', ['id' => $event->id]) }}">Overview</a>
                    <a class="btn btn-danger btn-sm mb-2 mr-5" style="margin-right: 10px;" href="{{ route('cws.event.miniGame', ['id' => $event->id]) }}">Mini Game</a>
                    <a class="btn btn-primary btn-sm mb-2 mr-5" style="margin-right: 10px;" href="{{ route('cws.eventEdit', ['id' => $event->id]) }}">Edit Event</a>
                    <a class="ml-5 btn btn-primary btn-sm mb-2" href="{{route('cws.event.users', ['id' => $event->id])}}">List User</a>
                </div>
            @else
                <div class="col-md-12">
                    <a class="btn btn-danger btn-sm mb-2 mr-5" style="margin-right: 10px;" href="{{ route('cws.eventPreview', ['id' => $event->id, 'preview' => 1]) }}">Back</a>
                </div>
            @endif
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header plats-step">
                        <h4 class="card-title mb-0">Forms Steps</h4>
                    </div>
                    <div class="card-body">
                        <form method="POST"
                            id="post_form"
                            action="{{$is_update ? route('cws.eventUpdate', ['id' => $event->id]) : route('cws.eventStore')}}">
                            @csrf
                            <input type="hidden" name="id" value="{{ $event->id }}">
                            {{-- Step --}}
                            @include('cws.event._step')

                            <!-- wizard-nav -->
                            <div id="tabwizard0" class="wizard-tab">
                                <div class="text-center mb-4">
                                    <h5>Overview</h5>
                                    <p class="card-title-desc text-danger">(Vui lòng nhập tất cả các ô có dấu *)</p>
                                </div>
                                <div>
                                    <div class="row">
                                        <div class="col-md-8">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="mb-3 field-name">
                                                        {{-- <x-label>Name</x-label> --}}
                                                        <label for="basicpill-firstname-input" class="form-label">Name <span class="text-danger">*</span></label>
                                                        <input type="text" value="{{ $event->name }}" required
                                                               class="form-control" placeholder="[TECH-ED PROGRAM] Cross-chain: Sidechain Solutions & BAS Case Study" id="name" name="name">
                                                        <div class="valid-feedback"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="mb-3 field-address">
                                                        <label for="basicpill-firstname-input" class="form-label">Address <span class="text-danger">*</span></label>
                                                        <input type="text" value="{{ $event->address }}"
                                                               class="form-control" placeholder="30 Đường Văn Cao Hà Nội, Hà Nội" id="address" name="address">
                                                        <div class="valid-feedback"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row d-none">
                                                <div class="col-lg-4">
                                                    <div class="mb-3 field-lat">
                                                        <input type="text" class="form-control" value="1" name="lat">
                                                    </div>
                                                </div><!-- end col -->
                                                <div class="col-lg-4">
                                                    <div class="mb-3 field-lng">
                                                        <input type="text" class="form-control" value="1" name="lng">
                                                    </div>
                                                </div>
                                                <div class="col-lg-4">
                                                    <div class="mb-3 field-order">
                                                        <input type="text" class="form-control" value="10" id="order">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <div class="mb-3 field-start_at">
                                                        <label for="basicpill-phoneno-input"
                                                            class="form-label">Start At <span class="text-danger">*</span>
                                                        </label>
                                                        <input
                                                            type="text"
                                                            class="form-control"
                                                            value="{{ dateFormat($event->start_at) }}"
                                                            placeholder="{{ dateFormat($event->start_at) ?? '2023-06-19 17:30' }}"
                                                            id="{{$isPreview ? '' : 'start_at'}}"
                                                            name="start_at">
                                                        <div class="valid-feedback"></div>
                                                    </div>
                                                </div><!-- end col -->
                                                <div class="col-lg-6">
                                                    <div class="mb-3 field-end_at">
                                                        <label for="basicpill-email-input"
                                                               class="form-label">End At <span class="text-danger">*</span></label>
                                                        <input
                                                            type="text"
                                                            class="form-control"
                                                            value="{{ dateFormat($event->end_at) }}"
                                                            placeholder="{{ dateFormat($event->end_at) ?? '2023-06-19 17:30' }}"
                                                            id="{{$isPreview ? '' : 'end_at'}}"
                                                            name="end_at">
                                                        <div class="valid-feedback"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="form-group field-article-thumbnail">
                                                        <label for="article-thumbnail" class="mb-3"><b>Banner</b></label>
                                                        <div>
                                                            <input type="hidden" id="article-thumbnail" class="empty-value"
                                                                   name="thumbnail">
                                                            <input type="file" id="w0" name="_fileinput_w0"></div>
                                                        <div class="invalid-feedback">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="mb-3">
                                                        <label for="event_description" class="form-label">Description <span class="text-danger">*</span></label>

                                                        <div id="editor"></div>
                                                        <input type="hidden" id="description" name="description" value="{{ $event->description }}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            @include('cws.event.forms._sponsor', [
                                'sessions' => $sessions,
                                'isPreview' => $isPreview,
                                'event' => $event
                            ])

                            <!-- Sessiom -->
                            @include('cws.event.forms._session', [
                                'sessions' => $sessions,
                                'isPreview' => $isPreview,
                                'event' => $event
                            ])

                            <!-- Booth -->
                            @include('cws.event.forms._booth', [
                                'booths' => $booths,
                                'isPreview' => $isPreview,
                                'event' => $event
                            ])

                            {{-- Social --}}
                            @include('cws.event.forms._social', [
                                'taskEventSocials' => $taskEventSocials,
                                'taskEventDiscords' => $taskEventDiscords,
                                'event' => $event
                            ])

                            {{-- Quiz --}}
                            @include('cws.event.forms._quiz', [
                                'quiz' => $quiz,
                                'isPreview' => $isPreview
                            ])
                            <div class="d-flex align-items-start gap-3 mt-4">
                                <button
                                    type="button"
                                    class="btn btn-primary w-sm"
                                    id="prevBtn" onclick="nextPrev(-1)">
                                    Previous</button>
                                <button
                                    type="button"
                                    class="btn btn-primary w-sm ms-auto"
                                    id="nextBtn" onclick="nextPrev(1)">Next</button>

                                @if($isPreview == false)
                                    <div id="subForm" class="w-sm ms-auto d-none">
                                        <a class="btn btn-secondary w-sm ms-auto" href="{{route('cws.eventList')}}">Cancel</a>
                                        <button type="submit" class="btn btn-primary w-sm ms-auto" >Save</button>
                                    </div>
                                @endif
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
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
    {{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
 --}}
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/notify/0.4.2/notify.min.js"></script>

    @if($isPreview == false)
        <script src="https://uicdn.toast.com/editor/latest/toastui-editor-all.min.js"></script>
    @else
        <script src="https://uicdn.toast.com/editor/latest/toastui-editor-viewer.js"></script>
    @endif
    <script src="https://uicdn.toast.com/editor/latest/i18n/ko-kr.js"></script>
    <script src="https://uicdn.toast.com/editor/latest/i18n/ja-jp.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>

    <script>
        var _token = $('meta[name="csrf-token"]').attr('content');
        var spinText = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> ';
        var fileAvatarInit = null;
        var flag_check = 1;
        var modalLoading = $('#modalLoading');
        var initial_form_state, last_form_state;
        var contentEditor = document.getElementById('description').value;
        var contentEditor2 = document.getElementById('sessions-description').value;
        var contentEditor3 = document.getElementById('booths-description').value;

        const editor = new toastui.Editor({
            el: document.querySelector('#editor'),
            previewStyle: 'vertical',
            language: 'en-US',
            initialEditType: 'wysiwyg', //markdown, wysiwyg
            height: '300px',

            initialValue: contentEditor,
            hooks: {
                addImageBlobHook(imgeBlob, callback) {
                    var fd = new FormData();
                    fd.append('file',imgeBlob);
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
                }
            }
        });

        const editor2 = new toastui.Editor({
            el: document.querySelector('#editor2'),
            previewStyle: 'vertical',
            language: 'en-US',
            initialEditType: 'wysiwyg', //markdown, wysiwyg
            height: '380px',
            initialValue: contentEditor2,
            hooks: {
                addImageBlobHook(imgeBlob, callback) {
                    var fd = new FormData();
                    fd.append('file',imgeBlob);
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
            height: '380px',
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

        $('.job').on('click', function(e) {
            var id = $(this).data('id'),
                event_id = $(this).data('detail-id'),
                _token = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                url: '/event-job/'+ id,
                type: 'GET',
                dataType: 'json',
                data: {
                    _token: _token,
                    event_id: event_id,
                },
                success: function (data) {
                    if (data.message == 'OK') {
                        $.notify("Success.", "success");
                    } else {
                        $.notify("Success", "error");
                    }
                },
                error: function (data) {
                    $.notify("Errors.", "error");
                }
            });
        })
    </script>

    <script>
        /*File Upload*/
        jQuery(document).ready(function ($) {
            var uploadUrl = '{{route('upload-storage-single', ['_token' => csrf_token()])}}';
            $('#flexCheckPaid').on('change', function () {
                if ($(this).is(':checked')) {
                    $('#row_paid').show();
                } else {
                    $('#row_paid').hide();
                }
            });
            //start_at datepicker
            var option = {
                enableTime: true,
                dateFormat: "Y-m-d H:i",
                time_24hr: true,
                locale: 'en'
            };

            if ($('#start_at').length > 0) {
                $('#start_at').flatpickr(option);
            }

            //End_at datepicker
            if ($('#end_at').length > 0) {
                $('#end_at').flatpickr(option);
            }

            if($('.date').length > 0) {
                $('.date').flatpickr(option);
            }

            var fileAvatarInit = null;
            // var fileSlideInit = null;
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

            // fileSlideInit = [
            //     @foreach($task_galleries as $key=> $fileItem)
            //     {
            //         "path": "{{$fileItem['url']}}",
            //         "base_url": "",
            //         "type": null,
            //         "size": null,
            //         "name": null,
            //         "order": null
            //     } @if($key < $total_file-1), @endif
            //     @endforeach
            // ];

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

            // jQuery('#w1').yiiUploadKit({
            //     "url": uploadUrl,
            //     "multiple": true,
            //     "sortable": false,
            //     "maxNumberOfFiles": 5,
            //     "maxFileSize": 10000000,
            //     "minFileSize": null,
            //     "acceptFileTypes": /(\.|\/)(gif|jpe?g|png|webp)$/i,
            //     "files": fileSlideInit,
            //     "previewImage": true,
            //     "showPreviewFilename": false,
            //     "errorHandler": "popover",
            //     "pathAttribute": "path",
            //     "baseUrlAttribute": "base_url",
            //     "pathAttributeName": "path",
            //     "baseUrlAttributeName": "base_url",
            //     "messages": {
            //         "maxNumberOfFiles": "Số lượng tối đa của tệp vượt quá",
            //         "acceptFileTypes": "Loại tệp không được phép",
            //         "maxFileSize": "Tập tin quá lớn",
            //         "minFileSize": "Tập tin quá nhỏ"
            //     },
            //     "start": function (e, data) {
            //         console.log('Upload Start')
            //     },
            //     "done": function (e, data) {
            //         console.log('Upload Done')
            //     },
            //     "fail": function (e, data) {
            //         console.log('Upload Fail')
            //     },
            //     "always": function (e, data) {
            //         console.log('Upload Alway')
            //     },
            //     "name": "Article[attachments]"
            // });
        });

        if ($('#list-booth-id').length > 0) {
            var boothIds = $('#list-booth-id').data('b-ids');

            if (boothIds.length > 0) {
                boothIds.forEach(function(item) {
                    var url = $("#bo-"+item).data('bo-url');
                    new QRCode(document.getElementById("bo-"+item), url);
                    new QRCode("dbo-"+item, {
                        text: url,
                        width: 300,
                        height: 300
                    });
                });
            }
            $('.bo-donw').on('click', function(e) {
                var id = $(this).data('id')
                    num = $(this).data('num'),
                    name = $(this).data('name');
                let dataUrl = document.querySelector('#dbo-'+id).querySelector('img').src;
                downloadURI(dataUrl, name+'-'+num+'.png');
            });
        }

        if ($('#list-session-id').length > 0) {
            var sessionIds = $('#list-session-id').data('s-ids');
            if (sessionIds.length > 0) {
                sessionIds.forEach(function(item) {
                    var url = $("#se-"+item).data('se-url');
                    new QRCode(document.getElementById("se-"+item), url);
                    new QRCode("dse-"+item, {
                        text: url,
                        width: 300,
                        height: 300
                    });
                });
            }

            $('.se-donw').on('click', function(e) {
                var id = $(this).data('id')
                    num = $(this).data('num'),
                    name = $(this).data('name');
                let dataUrl = document.querySelector('#dse-'+id).querySelector('img').src;
                downloadURI(dataUrl, name+'-'+num+'.png');
            })
        }

        function downloadURI(uri, name) {
          var link = document.createElement("a");
          link.download = name;
          link.href = uri;
          document.body.appendChild(link);
          link.click();
          document.body.removeChild(link);
          delete link;
        };
    </script>

    <script>
        jQuery(document).ready(function ($) {
            var modalDelete = $('#modalDelete');
            var uploadUrl = '{{config('admin.upload_url')}}';
            var flag_check = 1;

            $('#is_tweet').on('change', function(event) {
                if (event.currentTarget.checked) {
                    $('#tweetId').removeClass('d-none');
                } else {
                    $('#tweetId').addClass('d-none');
                }
            });

            $(document).on("submit", "#post_form", function (event) {
                //Get Editor content
                var content = editor.getHTML();//editor.getHTML(); getMarkdown
                var content2 = editor2.getHTML();//editor.getHTML();
                var content3 = editor3.getHTML();//editor.getHTML();
                $('[name=description]').attr('value', editor.getHTML());
                $('[id=sessions-description]').attr('value', editor2.getHTML());
                $('[id=booths-description]').attr('value', editor3.getHTML());
                $(window).off('beforeunload');
            });

            //Btn click submit post form
            $(document).on('click', '.btnSubmit', function (event) {
                $('#post_form').submit();
            });


            var isPreview = {{$isPreview}};
            //Check is preview page will disable all input
            if(isPreview){
                //Disable all input
                $('input').attr('disabled', 'disabled');
                $('textarea').attr('disabled', 'disabled');
                $('select').attr('disabled', 'disabled');
                $('input[type=checkbox]').removeAttr('disabled');
            }

            //btnAddItemSession onclick call ajax
            $(document).on('click', '#btnAddItemSession', function (event) {
                var rowCount = $('.itemSessionDetail').length;
                if(rowCount >= 30){
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
                            $('#listRowSession').append(data.html);
                            $('#q_'+(rowCount+1)).addClass('sCheck');
                            flag_check++;
                        }
                    },
                    error: function (data) {
                        console.log(data);
                    }
                });
            });

            /*Delete Image Row*/
            $(document).on('click', '.sRemove', function (event) {
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
                        $('#itemSession' + id).hide();
                        $('#sessionsFlagDelete' + id).val(1);
                    }
                });

            });

            $(document).on('change', '.sCheck', function (event) {
                var id = $(this).data('id');

                if (event.currentTarget.checked) {
                    $('#s-'+id).removeClass('d-none');
                    // $('#s-'+id).val(true);
                } else {
                    $('#s-'+id).addClass('d-none');
                    // $('#s-'+id).val(false);
                }
            });
            // End Session

            /*Start Booth*/
            $(document).on('click', '#btnAddItemBooth', function (event) {
                var rowCount = $('.itemBoothDetail').length;
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
                            $('#listRowBooth').append(data.html);
                            $('#b_'+(rowCount+1)).addClass('bCheck');
                            flag_check++;
                        }
                    },
                    error: function (data) {
                        console.log(data);
                    }
                });
            });

            /*Delete Image Row*/
            $(document).on('click', '.bRemove', function (event) {
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

            $(document).on('change', '.bCheck', function (event) {
                var id = $(this).data('id');

                if (event.currentTarget.checked) {
                    $('#b-'+id).removeClass('d-none');
                } else {
                    $('#b-'+id).addClass('d-none');
                }
            });
            // End Booth

            // Sponsor
            $(document).on('click', '#btnAddSponsor', function (event) {
                var flag_check = Math.floor(Math.random() * 10000);
                var rowCount = $('.itemSponsorDetail').length;
                $.ajax({
                    url: '{{route('cws.eventTemplate')}}' + '?type=4&flag_check=' + flag_check + '&inc=' + rowCount,
                    type: 'GET',
                    dataType: 'json',
                    data: {
                        _token: _token,
                        id: flag_check
                    },
                    success: function (data) {
                        console.log(data.html);
                        if (data.status == 200) {
                            $('#listSponsor').append(data.html);
                            flag_check++;
                        }
                    },
                    error: function (data) {
                        console.log(data);
                    }
                });
            });

            /*Delete Image Row*/
            $(document).on('click', '.spRemove', function (event) {
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
                        $('#itemSponsor' + id).hide();
                        $('#sponsorFlagDelete' + id).val(1);
                    }
                });

            });
            // End sponsor

            /*Quiz*/
            $(document).on('click', '#btnAddItemQuiz', function (event) {
                var rowCount = $('.itemQuizDetail').length;
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
                        //Find all input chrildren and remove required

                        //Remover required input
                        //Input quiz[8325][name]
                        $('#quiz[' + id + '][name]').removeAttr('required');
                        $('#quiz[' + id + '][time_quiz]').removeAttr('name');
                        $('#quiz[' + id + '][order]').removeAttr('name');
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
                $('#nextBtn').addClass('d-none');
                $('#subForm').removeClass('d-none');
                //Type submit
            } else {
                document.getElementById("nextBtn").innerHTML = "Next";
                $('#nextBtn').removeClass('d-none');
                $('#subForm').addClass('d-none');
            }
            //... and run a function that will display the correct step indicator:
            fixStepIndicator(n)
        }

        function nextPrev(n) {
            //Todo check validate then next
            //Check if n = 1 and validate form before next
            if ( validateForm(n) == false){
                return false;
            } else{
                var x = document.getElementsByClassName("wizard-tab");
                x[currentTab].style.display = "none";
                currentTab = currentTab + n;
                if (currentTab >= x.length) {
                    currentTab = currentTab - n;
                    x[currentTab].style.display = "block";
                }
                showTab(currentTab)
            }


        }
        //validateForm step
        function validateForm(step){
            let isValid = true
            if(step==1){
                //Check name input is empty
                //Check empty input, name, lat, lng, address

                if($('#name').val() == '' ||
                    $('#lat').val() == '' ||
                    $('#lng').val() == '' ||
                    $('#address').val() == '') {
                    //alert('Please input name');
                    //Trigger validation

                    $('#post_form').data('yiiActiveForm').submitting = true;
                    $('#post_form').yiiActiveForm('validate');


                    //Force focus input
                    $('#name').focus();
                    //Scroll to top
                    $('html, body').animate({
                        scrollTop: $("#name").offset().top - 250
                    });
                    isValid = false;
                }

                if($('#address').val() == '') {
                }

            }

            return isValid;
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

        //Check if edit not alow click
        @if($isPreview || $event->id)
            $(document).on('click', '.step-icon', function (event) {
                event.preventDefault();
                var id = $(this).attr('data-step');
                // alert(id);
                showTab(id);
                $('#tabwizard0').css('display', 'none');
                $('#tabwizard' + id).css('display', 'block');

                for (var i = 1; i <= 5; i++) {
                    if (i != id) {
                        $('#tabwizard' + i).css('display', 'none');
                    }
                }
            });
        @endif
    </script>

    {{--validate--}}
    <script>
        //https://yii2-cookbook-test.readthedocs.io/forms-activeform-js/
        jQuery(function ($) {
            jQuery('#post_form').yiiActiveForm([
                {
                    "id": "name",
                    "name": "name",
                    "container": ".field-name",
                    "input": "#name",
                    "error": ".valid-feedback",
                    "validate": function (attribute, value, messages, deferred, $form) {
                        yii.validation.required(value, messages, {"message": "{{__('validation-inline.required') }}"});
                    }
                },
                /*address*/
                {
                    "id": "address",
                    "name": "address",
                    "container": ".field-address",
                    "input": "#address",
                    "error": ".valid-feedback",
                    "validate": function (attribute, value, messages, deferred, $form) {
                        yii.validation.required(value, messages, {"message": "{{__('validation-inline.required') }}"});
                    }
                },
                {
                    "id": "category_name",
                    "name": "category_name",
                    "container": ".field-category_name",
                    "input": "#category_name",
                    "error": ".valid-feedback",
                    "validate": function (attribute, value, messages, deferred, $form) {
                        yii.validation.required(value, messages, {"message": "{{__('validation-inline.required') }}"});
                    }
                },
                /*lat*/
                {
                    "id": "lat",
                    "name": "lat",
                    "container": ".field-lat",
                    "input": "#lat",
                    "error": ".valid-feedback",
                    "validate": function (attribute, value, messages, deferred, $form) {
                        yii.validation.required(value, messages, {"message": "{{__('validation-inline.required') }}"});
                        //Validate lat
                        if (value && (value < -90 || value > 90)) {
                            yii.validation.required(value, messages, {"message": "{{__('validation-inline.latitude') }}"});
                        }
                    }
                },
                //lng
                {
                    "id": "lng",
                    "name": "lng",
                    "container": ".field-lng",
                    "input": "#lng",
                    "error": ".valid-feedback",
                    "validate": function (attribute, value, messages, deferred, $form) {
                        yii.validation.required(value, messages, {"message": "{{__('validation-inline.required') }}"});
                        //Validate long
                        if (value && (value < -180 || value > 180)) {
                            yii.validation.required(value, messages, {"message": "{{__('validation-inline.longitude') }}"});
                        }
                    }
                },

                //start_date
                {
                    "id": "start_at",
                    "name": "start_at",
                    "container": ".field-start_at",
                    "input": "#start_at",
                    "error": ".valid-feedback",
                    "validate": function (attribute, value, messages, deferred, $form) {
                        yii.validation.required(value, messages, {"message": "{{__('validation-inline.required') }}"});
                        //Validate date check less than end_date
                        if (value && $('#end_at').val()) {
                            if (value > $('#end_at').val()) {
                                yii.validation.addMessage(messages, "{{__('validation-inline.start_date_less_than_end_date') }}");
                            }
                        }
                    }
                },
                //end_date
                {
                    "id": "end_at",
                    "name": "end_at",
                    "container": ".field-end_at",
                    "input": "#end_at",
                    "error": ".valid-feedback",
                    "validate": function (attribute, value, messages, deferred, $form) {
                        yii.validation.required(value, messages, {"message": "{{__('validation-inline.required') }}"});
                        //Validate date check grater than end_date
                        if (value && $('#start_at').val()) {
                            if (value < $('#start_at').val()) {
                                yii.validation.addMessage(messages, "{{__('validation-inline.end_date_greater_than_start_date') }}");
                            }
                        }
                    }
                },

            ], []);
        });
    </script>
@endsection
