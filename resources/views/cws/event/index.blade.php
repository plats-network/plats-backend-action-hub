@extends('cws.layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1>Events</h1>
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
                            <td>{{ $event->start_at }}</td>
                            <td>{{ $event->end_at }}</td>
                            <td>
                                <a href="{{ route('cws.eventCreate', ['id' => $event->id, 'tab' => $tab, 'copy' => 1]) }}"
                                   class="btn btn-info">Copy</a>
                                <a href="{{ route('cws.eventEdit', ['id' => $event->id, 'tab' => $tab]) }}"
                                   class="btn btn-primary">Edit</a>
                                <a href="{{ route('cws.eventEdit', $event->id) }}" class="btn btn-danger">Delete</a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                {{ $events->links() }}
            </div>
        </div>
    </div>

@endsection
