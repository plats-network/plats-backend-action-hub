
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Document</title>
    <style>
        body {
            font-size: 16px;
            font-family: 'Helvetica', Arial, sans-serif;
            margin: 0;
        }

        .container {
            width: 602px;
            height: 300px;
            margin: 0 auto;
            border-radius: 4px;
            background-color: #4537de;
            box-shadow: 0 8px 16px rgba(35, 51, 64, 0.25);
        }

        .column-1 {
            float: left;
            width: 400px;
            height: 300px;
            border-right: 2px dashed #fff;
        }

        .column-2 {
            float: right;
            width: 200px;
            height: 300px;
        }

        .text-frame {
            padding: 40px;
            height: 120px;
        }

        .qr-holder {
            position: relative;
            padding-top: 10px;
            width: 160px;
            height: 160px;
            margin: 20px;
            text-align: center;
            line-height: 30px;
            z-index: 1;
        }

        .qr-holder > img {
            margin-top: 20px;
        }

        .event {
            font-size: 18px;
            color: #fff;
            letter-spacing: 1px;
        }

        .date {
            font-size: 14px;
            margin-top: 5px;
            line-height: 16px;
            color: #a8bbf8;
        }

        .name,
        .ticket-id {
            font-size: 16px;
            line-height: 22px;
            color: #fff;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="column-1">
        <div class="text-frame">
            <div class="event">{{Str::limit($ticket->name , 80)}}</div>
            <div class="date">
                {{date("Y-m-d H:i:s", strtotime($ticket->start_at))}} <br>
                - <br>
                {{date("Y-m-d H:i:s", strtotime($ticket->end_at))}}</div>
            <br/>
            <div class="name">
                Address : <br>{{$ticket->address}}</div>

        </div>
    </div>

    <div class="column-2">
        <div class="qr-holder">
            <div>
                    <img src="data:image/png;base64, {!! base64_encode(\QrCode::format('png')->size(100)->generate(config('app.link_qrc_confirm').'events/ticket?type=checkin&code='.$user->hash_code)) !!} ">
            </div>
            <div style="color: white">{{$user->name}}</div>
            <div class="ticket-id"> #{{Str::limit($user->hash_code , 15)}}</div>
        </div>
    </div>
</div>
</body>
</html>
