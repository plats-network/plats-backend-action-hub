@extends('cws.layouts.app')

@section('style')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/notify/0.4.2/styles/metro/notify-metro.min.css" />
@endsection

@section('name_page')
    <div class="page-title-box align-self-center d-none d-md-block">
        <h4 class="page-title mb-0">Mini Games</h4>
    </div>
@endsection

@section('content')
    @php
        $imgs = [
            'bg_game_1.png' => 'Banner 1',
            'bg_game_2.png' => 'Banner 2',
            'bg_game_3.png' => 'Banner 3',
            'bg_game_4.png' => 'Banner 4'
        ];

        $prizes = [
            0 => "Đặc biệt",
            1 => "Giải Nhất",
            2 => "Giải Nhì",
            3 => "Giải Ba",
            4 => "Giải Bốn",
            5 => "Giải Năm",
            6 => "Giải Sáu",
        ];

        $types = [
            0 => 'Vòng',
            1 => 'Ô vuông'
        ];
    @endphp

    <div class="row">
        <div class="col-xl-12 mb-3">
            <a href="{{route('cws.eventPreview', [
                'id' => $event_id,
                'tab' => 0,
                'preview' => 1])}}"
                class="btn btn-danger btn-sm">Back</a>
        </div>
        <div class="col-xl-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex flex-wrap align-items-center mb-2">
                        <h5 class="card-title">Link Session Games</h5>
                    </div>
                    <table class="table table-bordered mb-0 table-responsive">
                        <thead class="table-light">
                            <tr>
                                <th>Travel Game</th>
                                <th>Link</th>
                                <th>Copy</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($miniGameSessions as $k => $session)
                                @php
                                    $link = 'https://'.config('plats.minigame').'/game/' .$session->code;
                                    $id = $session->id;
                                @endphp
                                <tr>
                                    <td width="50%">{{optional($session->travelGame)->name}}</td>
                                    <td width="20%">
                                        <a href="{{$link}}" target="_blank">Click Here!</a>
                                   </td>
                                   <td width="20%">
                                        <button type="button"
                                            class="btn btn-secondary btn-sm"
                                            data-clipboard-text="{{$link}}">Copy Link</button>
                                   </td>
                                   <td width="10%">
                                       <input
                                            type="checkbox"
                                            id="s_{{$id}}"
                                            switch="none"
                                            @if($session->status) checked @endif
                                        >
                                        <label class="mini" data-id="{{$id}}" for="s_{{$id}}" data-on-label="On" data-off-label="Off"></label>
                                   </td>
                                </tr>
                                <tr style="background-color: #f2f2f2">
                                    <td colspan="4">
                                        <div class="row">
                                            <h5 style="font-size: 14px;">Setup for <span style="color: red;">{{optional($session->travelGame)->name}}</span></h5>
                                            <div class="col-xl-3">
                                                <label class="col-form-label">Banner</label>
                                                <select name="banner_url" class="form-select" id="a-{{$id}}" disabled>
                                                    @foreach($imgs as $k => $v)
                                                        <option value="{{ $k }}" {{($k == $session->banner_url) ? 'selected' : ''}}>{{$v}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-xl-3">
                                                <label class="col-form-label ">Prize</label>
                                                <select name="type_prize" class="form-select" id="b-{{$id}}" disabled>
                                                    @foreach($prizes as $k => $v)
                                                        <option value="{{ $k }}" {{($k == $session->type_prize) ? 'selected' : ''}}>{{$v}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-xl-3">
                                                <label class="col-form-label">Number</label>
                                                <input class="form-control" type="number" value="{{$session->num}}" name="num" min="1" max="30" id="c-{{$id}}" disabled>
                                            </div>
                                            <div class="col-xl-3">
                                                <label class="col-form-label">Type Game</label>
                                                <select name="is_game" class="form-select" id="d-{{$id}}" disabled>
                                                    @foreach($types as $k => $v)
                                                        <option value="{{ $k }}" {{($k == $session->is_game) ? 'selected' : ''}}>{{$v}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-xl-12 text-right" style="padding-top: 5px;">
                                                <button
                                                    class="btn btn-primary btn-sm edit"
                                                    data-edit-id="{{$id}}"
                                                    id="tbn-{{$id}}"
                                                    data-url-game="{{route('cws.setupMiniGame')}}">Edit</button>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-xl-6">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex flex-wrap align-items-center mb-2">
                        <h5 class="card-title">Link Booth Games</h5>
                    </div>
                    <table class="table table-bordered mb-0 table-responsive">
                        <thead class="table-light">
                            <tr>
                                <th>Travel Game</th>
                                <th>Link</th>
                                <th>Copy</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($miniGameBooths as $k => $booth)
                                @php
                                    $link = 'https://'.config('plats.minigame').'/game/' .$booth->code;
                                    $id = $booth->id;
                                @endphp
                                <tr>
                                    <td width="50%">{{optional($booth->travelGame)->name}}</td>
                                    <td width="20%">
                                        <a href="{{$link}}" target="_blank">Click Here!</a>
                                   </td>
                                   <td width="20%">
                                        <button type="button"
                                            class="btn btn-secondary btn-sm"
                                            data-clipboard-text="{{$link}}">Copy Link</button>
                                   </td>
                                   <td width="10%">
                                       <input
                                            type="checkbox"
                                            id="b_{{$id}}"
                                            switch="none"
                                            @if($booth->status) checked @endif
                                        >
                                        <label class="mini" data-id="{{$id}}" for="b_{{$id}}" data-on-label="On" data-off-label="Off"></label>
                                   </td>
                                </tr>
                                <tr style="background-color: #f2f2f2">
                                    <td colspan="4">
                                        <div class="row">
                                            <h5 style="font-size: 14px;">Setup for <span style="color: red;">{{optional($booth->travelGame)->name}}</span></h5>
                                            <div class="col-xl-3">
                                                <label class="col-form-label">Banner</label>
                                                <select name="banner_url" class="form-select" id="a-{{$id}}" disabled>
                                                    @foreach($imgs as $k => $v)
                                                        <option value="{{ $k }}" {{($k == $booth->banner_url) ? 'selected' : ''}}>{{$v}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-xl-3">
                                                <label class="col-form-label ">Prize</label>
                                                <select name="type_prize" class="form-select" id="b-{{$id}}" disabled>
                                                    @foreach($prizes as $k => $v)
                                                        <option value="{{ $k }}" {{($k == $booth->type_prize) ? 'selected' : ''}}>{{$v}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-xl-3">
                                                <label class="col-form-label">Number</label>
                                                <input class="form-control"
                                                    type="number"
                                                    name="num"
                                                    value="{{$booth->num}}"
                                                    min="1" max="30" id="c-{{$id}}" disabled>
                                            </div>
                                            <div class="col-xl-3">
                                                <label class="col-form-label">Type Game</label>
                                                <select name="is_game" class="form-select" id="d-{{$id}}" disabled>
                                                    @foreach($types as $k => $v)
                                                        <option value="{{ $k }}" {{($k == $booth->is_game) ? 'selected' : ''}}>{{$v}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-xl-12 text-right" style="padding-top: 5px;">
                                                <button
                                                    class="btn btn-primary btn-sm edit"
                                                    data-edit-id="{{$id}}"
                                                    id="tbn-{{$id}}"
                                                    data-url-game="{{route('cws.setupMiniGame')}}"
                                                >Edit</button>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

{{--Script--}}
@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/2.0.11/clipboard.min.js"></script>
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/notify/0.4.2/notify.min.js"></script> --}}
    <script>
        jQuery(document).ready(function ($) {
            var clipboard = new ClipboardJS('.btn');
            clipboard.on('success', function(e) {
                $.notify("Copy link success.", "success");
                e.clearSelection();
            });

            $('.mini').on('click', function(e) {
                var id = $(this).data('id');

                $.ajax({
                    url: '/mini/upd/'+id,
                    type: 'get',
                    dataType: 'json',
                    success: function (data) {
                        $.notify('Success', 'success');
                    },
                    error: function (data) {
                        $.notify('Errors', 'error');
                    }
                });
            });

            $(document).on('click', '.edit', function (e) {
                var id = $(this).data('edit-id');
                $('#tbn-'+id).removeClass('edit').addClass('save').html('Save');
                $('#a-'+id).attr('disabled', false);
                $('#b-'+id).attr('disabled', false);
                $('#c-'+id).attr('disabled', false);
                $('#d-'+id).attr('disabled', false);

            });

            $(document).on('click', '.save', function (e) {
                var id = $(this).data('edit-id');
                var urlGame = $(this).data('url-game');
                var a = $('#a-'+id).val();
                var b = $('#b-'+id).val();
                var c = $('#c-'+id).val();
                var d = $('#d-'+id).val();
                $.ajax({
                    url: urlGame,
                    type: 'POST',
                    data: {
                        _token: _token,
                        id: id,
                        banner_url: a,
                        type_prize: b,
                        num: c,
                        is_game: d
                    },
                    success: function (data) {
                        $.notify('Success', 'success');
                        setTimeout(function(e) {
                            location.reload();
                        }, 1500);
                    },
                    error: function (data) {
                        $.notify('Errors', 'error');
                        setTimeout(function(e) {
                            location.reload();
                        }, 1500);
                    }
                });
            });
        });
    </script>
@endsection