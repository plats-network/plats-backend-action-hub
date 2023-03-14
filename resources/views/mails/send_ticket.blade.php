<!DOCTYPE html>
<html>
<head>
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
            background-color: #fff;
            text-align: center;
            line-height: 30px;
            z-index: 1;
        }

        .qr-holder > img {
            margin-top: 20px;
        }

        .event {
            font-size: 24px;
            color: #fff;
            letter-spacing: 1px;
        }

        .date {
            font-size: 18px;
            line-height: 30px;
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
                TO <br>
                {{date("Y-m-d H:i:s", strtotime($ticket->end_at))}}</div>
            <br/>
                        <div class="name">{{$ticket->address}}</div>
            <div class="ticket-id"> #{{mt_rand(1000000000, 9999999900)}}</div>
        </div>
    </div>

    <div class="column-2">
        <div class="qr-holder">
            <img src="https://images.viblo.asia/5974cb6b-ec70-41d0-9074-d4319b62f4c7.png" width="120px" height="120px"/>
        </div>
    </div>
</div>
</body>
</html>
