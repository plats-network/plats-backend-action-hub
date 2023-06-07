@extends('cws.layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                    <h1>Events</h1>
                    <a href="{{ route('cws.eventCreate') }}" class="btn btn-primary">Create Event</a>
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
                                        <a href="{{ route('cws.eventEdit', ['id' => $event->id, 'tab' => $tab]) }}" class="btn btn-primary">Edit</a>
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
