@extends('cws.layouts.app')

@section('name_page')
    <div class="page-title-box align-self-center d-none d-md-block">
        <h4 class="page-title mb-0">Event</h4>
    </div>
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <a href="{{ route('cws.eventCreate') }}" class="btn btn-primary">Create Event</a>
                <div class="card mt-3">
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
                <hr>
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>Title</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($events as $event)
                        <tr>
                            <td>{{ $event->name }}</td>
                            <td>{{ dateFormat($event->start_at) }}</td>
                            <td>{{ dateFormat($event->end_at) }}</td>
                            <td>
                                <a href="{{ route('cws.eventCreate', ['id' => $event->id, 'tab' => $tab, 'copy' => 1]) }}"
                                   class="btn btn-info">Copy</a>
                                <a href="{{ route('cws.eventPreview', ['id' => $event->id, 'tab' => $tab, 'preview' => 1]) }}"
                                   class="btn btn-primary">View</a>
                                <button  data-url="{{ route('cws.eventDelete', $event->id)}}" href="{{ route('cws.eventDelete', $event->id) }}" data-id="{{ $event->id}}" class="btn btn-danger btnDeleteRow">Delete</button>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                {{ $events->links() }}
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
        });
    </script>

@endsection

