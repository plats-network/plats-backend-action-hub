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
        });
    </script>
@endsection
