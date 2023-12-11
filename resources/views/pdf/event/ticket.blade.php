<!DOCTYPE html>

<html>

<head>

    <title>Ticket Information</title>

</head>

<body>

<h1>Event: {{ $event->name }}</h1>
{{--Date, Location--}}
<h31>Date {{ $event->start_at }} {{ $event->end_at }}</h31>
<h31>Location {{ $event->address }}</h31>

<h2>Ticket Information</h2>
{{--QR Code--}}
<img src="data:image/png;base64, {!! base64_encode(QrCode::format('png')->size(100)->generate($userTicket->id)) !!} ">
{{--Ticket ID--}}
<h31>Ticket ID: {{$userTicket->id}}</h31>
{{--Ticket Type--}}

If you have any questions, please contact us at info@plats.network.

</body>

</html>
