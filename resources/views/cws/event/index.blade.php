@extends('cws.layouts.app')

@section('name_page')
    <div class="page-title-box align-self-center d-none d-md-block">
        <h4 class="page-title mb-0">Event</h4>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">Search</h4>
                </div>
                <div class="card-body">
                    <form action="{{route('cws.eventList')}}" method="get">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div><label for="first_name">Title</label>
                                    <input class="form-control" id="title"
                                           type="text" name="title"
                                           placeholder="Title"
                                           ></div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div><label for="last_name">Address</label>
                                    <input class="form-control" id="address"
                                           type="text" name="address"
                                           placeholder="Address"></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="form-group"><label for="email">Start Date</label>
                                    <input class="form-control"
                                           id="start"
                                           type="text"
                                           placeholder="Start"
                                           ></div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-group"><label for="phone">End Date</label>
                                    <input class="form-control"
                                           id="end" name="End"
                                           type="text"
                                           placeholder="End"
                                           ></div>
                            </div>
                        </div>
                        <div class="mt-3 text-right">
                            <button class="btn btn-primary btn-gray-800 mt-2 animate-up-2" type="submit">Search
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex flex-wrap align-items-center mb-2">
                        <h5 class="card-title">Lists events</h5>
                        <div class="ms-auto">
                            <a href="{{ route('cws.eventCreate') }}" class="btn btn-primary btn-rounded waves-effect waves-light mb-2 me-2">Create Event</a>
                        </div>
                    </div>

                    <table class="table table-bordered mb-0 table-responsive">
                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                                <th>Img</th>
                                <th>Name</th>
                                <th>Star<br>End</th>
                                <th>Customer Name</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($events as $i => $event )
                                <tr>
                                    <td style="width: 5%;">{{ $i+1 }}</td>
                                    <td style="width: 10%;">
                                        <img src="{{ commonImg($event->banner_url) }}" alt="{{$event->name}}">
                                    </td>
                                    <td style="width: 20%;">
                                        <a
                                            href="{{route('web.events.show', $event->id)}}"
                                            title="{{$event->name}}"
                                            target="_blank">{{$event->name}}</a>
                                    </td>
                                    <td style="width: 15%;">
                                        {{ dateFormat($event->start_at) }}
                                        <br>
                                        {{ dateFormat($event->end_at) }}
                                    </td>
                                    <td>ss</td>
                                    <td>
                                        <input
                                            type="checkbox"
                                            id="switch_{{ $i+1 }}"
                                            switch="none"
                                            @if($event->status) checked @endif
                                        >
                                        <label class="event" data-id="{{$event->id}}" for="switch_{{ $i+1 }}" data-on-label="On" data-off-label="Off"></label>
                                    </td>
                                    <td style="width: 20%;">
                                        <ul class="list-inline mb-0">
                                            <li class="list-inline-item">
                                                @include('cws.actions.link', [
                                                    'url' => route('cws.eventPreview', ['id' => $event->id, 'tab' => $tab, 'preview' => 1]),
                                                    'label' => 'Show',
                                                    'icon' => 'show'
                                                ])
                                                @include('cws.actions.link', [
                                                    'url' => route('cws.event.users', ['id' => $event->id]),
                                                    'label' => 'Users',
                                                    'icon' => 'user-plus'
                                                ])

                                                {{-- <a
                                                    href="{{ route('cws.eventPreview', [
                                                            'id' => $event->id,
                                                            'tab' => $tab,
                                                            'preview' => 1
                                                        ]) }}"
                                                    data-bs-toggle="tooltip"
                                                    data-bs-placement="top"
                                                    class="px-2 text-primary"
                                                    data-bs-original-title="Show"
                                                    aria-label="Show">
                                                        <i class="bx bx-show font-size-18"></i>
                                                </a> --}}
                                            </li>
                                            {{-- <li class="list-inline-item">
                                                <a href="#"
                                                    data-bs-toggle="tooltip"
                                                    data-bs-placement="top"
                                                    class="px-2 text-primary"
                                                    data-bs-original-title="Users"
                                                    aria-label="Users">
                                                        <i class="bx bx-user-plus font-size-18"></i>
                                                </a>
                                            </li> --}}
                                            <li class="list-inline-item">
                                                <a href="{{ route('cws.eventDelete', $event->id) }}"
                                                    data-bs-toggle="tooltip"
                                                    data-bs-placement="top"
                                                    class="px-2 text-danger btnDeleteRow"
                                                    data-bs-original-title="Delete"
                                                    data-url="{{ route('cws.eventDelete', $event->id)}}"
                                                    data-id="{{ $event->id}}"
                                                    aria-label="Delete">
                                                    <i class="bx bx-trash-alt font-size-18"></i>
                                                </a>
                                            </li>
                                            {{-- <li class="list-inline-item dropdown">
                                                <a class="text-muted dropdown-toggle font-size-18 px-2" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true">
                                                    <i class="bx bx-dots-vertical-rounded"></i>
                                                </a>
                                            
                                                <div class="dropdown-menu dropdown-menu-end">
                                                    <a class="dropdown-item" href="#">Action</a>
                                                    <a class="dropdown-item" href="#">Another action</a>
                                                    <a class="dropdown-item" href="#">Something else here</a>
                                                </div>
                                            </li> --}}
                                        </ul>

                                        {{-- <div class="dropdown">
                                            <a class="text-muted dropdown-toggle font-size-18"
                                                role="button"
                                                data-bs-toggle="dropdown"
                                                aria-haspopup="true">
                                                <i class="mdi mdi-dots-horizontal"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-end">
                                                <a class="dropdown-item btn btn-info" href="{{ route('cws.eventCreate', [
                                                    'id' => $event->id,
                                                    'tab' => $tab,
                                                    'copy' => 1
                                                    ]) }}"
                                                >Copy</a>
                                                <a class="dropdown-item btn btn-primary" href="{{ route('cws.eventPreview', [
                                                    'id' => $event->id,
                                                    'tab' => $tab,
                                                    'preview' => 1
                                                ]) }}"
                                                >View</a>
                                                <a
                                                    class="dropdown-item btn btn-danger btnDeleteRow"
                                                    data-url="{{ route('cws.eventDelete', $event->id)}}"
                                                    href="{{ route('cws.eventDelete', $event->id) }}"
                                                    data-id="{{ $event->id}}"
                                                >
                                                Delete</a>
                                            </div>
                                        </div> --}}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $events->links() }}
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Confirm -->
    @include('cws.layouts.data.modal_confirm_delete')
@endsection

{{--Script--}}

@section('scripts')
    <script>
        var _token = $('meta[name="csrf-token"]').attr('content');
        var spinText = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> ';
        var hasPage = {{Request::get('page', 0)}};

        jQuery(document).ready(function ($) {
            // display a modal (small modal)
            var modalDelete = $('#modalDelete');
            var btnDeleteRow = $('.btnDeleteRow');

            $(document).on('click', '.btnDeleteRow', function (event) {
                event.preventDefault();
                let urlDelete = $(this).attr('data-url');
                let id = $(this).attr('data-id');
                $('#formDeleteItem').attr('action', urlDelete);
                modalDelete.modal("show");
            });

            $(document).on('click', '#hideModalDelete', function (event) {
                modalDelete.modal("hide");
            });

            $('.event').on('click', function (e) {
                var id = $(this).data('id');
                var _token = $('meta[name="csrf-token"]').attr('content');
                if (confirm('Are you sure you change status?')) {
                    $.ajax({
                        url: '/event-status/'+ id,
                        type: 'GET',
                        dataType: 'json',
                        data: {_token: _token},
                        success: function (data) {
                            if (data.status == 200) {
                                console.log(data);
                            }
                        },
                        error: function (data) {
                            console.log(data);
                        }
                    });
                };

            });
        });
    </script>

@endsection

