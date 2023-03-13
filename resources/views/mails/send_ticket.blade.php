{{--<!doctype html>--}}
{{--<html lang="en">--}}
{{--<head>--}}
{{--    <meta charset="UTF-8">--}}
{{--    <meta name="viewport"--}}
{{--          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">--}}
{{--    <meta http-equiv="X-UA-Compatible" content="ie=edge">--}}
{{--    <title>Ticket</title>--}}
{{--    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">--}}
{{--</head>--}}
{{--<body>--}}
{{--<div class="ticket">--}}
{{--    <div class="left">--}}
{{--        <div class="image">--}}
{{--            <p class="admit-one">--}}
{{--                <span>Plats</span>--}}
{{--                <span>Plats</span>--}}
{{--                <span>Plats</span>--}}
{{--            </p>--}}
{{--            <div class="ticket-number">--}}
{{--                <p>--}}
{{--                    #{{mt_rand(1000000000, 9999999900)}}--}}
{{--                </p>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--        <div class="ticket-info">--}}
{{--            <p class="date">--}}
{{--                <span class="nov-10">{{date("Y-m-d H:i:s")}}</span>--}}
{{--            </p>--}}
{{--            <div class="show-name">--}}
{{--                <h1>{{Str::limit($ticket->name , 80)}}</h1>--}}
{{--                <div>{!! Str::limit($ticket->description , 50) !!}</div>--}}
{{--            </div>--}}
{{--            <div class="time">--}}
{{--                {{date("Y-m-d H:i:s", strtotime($ticket->start_at))}} TO--}}
{{--                {{date("Y-m-d H:i:s", strtotime($ticket->end_at))}}--}}
{{--            </div>--}}
{{--            <p class="location">--}}
{{--                <span class="separator"></span><span>Địa chỉ : {{$ticket->address}}</span>--}}
{{--            </p>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--    <div class="right">--}}
{{--        <p class="admit-one">--}}
{{--            <span>Plats</span>--}}
{{--            <span>Plats</span>--}}
{{--            <span>Plats</span>--}}
{{--        </p>--}}
{{--        <div class="right-info-container">--}}
{{--            <div class="show-name">--}}
{{--                <h1>{{Str::limit($ticket->name , 30)}}</h1>--}}
{{--            </div>--}}
{{--            <div class="time">--}}
{{--                <p>13.10.2022</p>--}}
{{--                <p>12:49 PM <span>TO</span> TBD</p>--}}
{{--            </div>--}}
{{--            <div class="barcode">--}}
{{--                <img src="https://images.viblo.asia/5974cb6b-ec70-41d0-9074-d4319b62f4c7.png" alt="QR code">--}}
{{--            </div>--}}
{{--            <p class="ticket-number">--}}
{{--                #{{mt_rand(1000000000, 9999999900)}}--}}
{{--            </p>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--</div>--}}
{{--</body>--}}
{{--</html>--}}
{{--<style lang="scss" scoped>--}}
{{--    @import url("https://fonts.googleapis.com/css2?family=Barlow&display=swap");--}}
{{--    @import url("https://fonts.googleapis.com/css2?family=Saira+Stencil+One&display=swap");--}}

{{--    * {--}}
{{--        margin: 0;--}}
{{--        padding: 0;--}}
{{--        box-sizing: border-box;--}}
{{--    }--}}

{{--    body,--}}
{{--    html {--}}
{{--        height: 100vh;--}}
{{--        display: grid;--}}
{{--        font-family: "Barlow", sans-serif;--}}
{{--        color: black;--}}
{{--        font-size: 14px;--}}
{{--        letter-spacing: 0.1em;--}}
{{--    }--}}

{{--    .ticket {--}}
{{--        margin: auto;--}}
{{--        display: flex;--}}
{{--        background: white;--}}
{{--        box-shadow: rgba(0, 0, 0, 0.3) 0px 19px 38px, rgba(0, 0, 0, 0.22) 0px 15px 12px;--}}
{{--    }--}}

{{--    .left {--}}
{{--        display: flex;--}}
{{--    }--}}

{{--    .image {--}}
{{--        height: 250px;--}}
{{--        width: 350px;--}}
{{--        background-image: url("{{$ticket->banner_url}}");--}}
{{--        background-size: 100%;--}}
{{--        background-repeat: round;--}}
{{--        opacity: 1;--}}
{{--    }--}}

{{--    .admit-one {--}}
{{--        position: absolute;--}}
{{--        color: darkgray;--}}
{{--        height: 250px;--}}
{{--        padding: 0 10px;--}}
{{--        letter-spacing: 0.15em;--}}
{{--        font-size: 12px;--}}
{{--        display: flex;--}}
{{--        text-align: center;--}}
{{--        justify-content: space-around;--}}
{{--        writing-mode: vertical-rl;--}}
{{--        transform: rotate(-180deg);--}}
{{--    }--}}

{{--    .admit-one span:nth-child(2) {--}}
{{--        color: white;--}}
{{--        font-weight: 700;--}}
{{--    }--}}

{{--    .left .ticket-number {--}}
{{--        height: 250px;--}}
{{--        width: 350px;--}}
{{--        display: flex;--}}
{{--        justify-content: flex-end;--}}
{{--        align-items: flex-end;--}}
{{--        padding: 10px;--}}
{{--        color: white;--}}
{{--    }--}}

{{--    .ticket-info {--}}
{{--        padding: 10px 20px;--}}
{{--        display: flex;--}}
{{--        flex-direction: column;--}}
{{--        text-align: center;--}}
{{--        justify-content: space-between;--}}
{{--        align-items: center;--}}
{{--    }--}}

{{--    .date {--}}
{{--        border-top: 1px solid gray;--}}
{{--        border-bottom: 1px solid gray;--}}
{{--        padding: 5px 0;--}}
{{--        font-weight: 700;--}}
{{--    }--}}

{{--    .date span:first-child {--}}
{{--        text-align: left;--}}
{{--        width: 100px;--}}
{{--    }--}}

{{--    .date span:last-child {--}}
{{--        text-align: right;--}}
{{--        width: 100px;--}}
{{--    }--}}

{{--    .date .nov-10 {--}}
{{--        color: #d62839;--}}
{{--        font-size: 20px;--}}
{{--        width: 150px;--}}
{{--    }--}}

{{--    .show-name {--}}
{{--        font-size: 20px;--}}
{{--        color: #d62839;--}}
{{--        font-weight: 700;--}}
{{--    }--}}

{{--    .show-name h1 {--}}
{{--        font-size: 36px;--}}
{{--        letter-spacing: 0.05em;--}}
{{--        margin-bottom: 4px;--}}
{{--        color: #93229f;--}}
{{--        font-family: "Saira Stencil One", sans-serif;--}}
{{--    }--}}

{{--    .time {--}}
{{--        color: #505050;--}}
{{--        text-align: center;--}}
{{--        display: flex;--}}
{{--        flex-direction: column;--}}
{{--        gap: 10px;--}}
{{--        font-weight: 700;--}}
{{--    }--}}

{{--    .time span {--}}
{{--        font-weight: 400;--}}
{{--        color: gray;--}}
{{--    }--}}

{{--    .left .time {--}}
{{--        font-size: 16px;--}}
{{--        margin-bottom: 10px;--}}
{{--    }--}}

{{--    .tagline {--}}
{{--        font-style: italic;--}}
{{--        font-weight: 700;--}}
{{--        font-size: 16px;--}}
{{--    }--}}

{{--    .location {--}}
{{--        display: flex;--}}
{{--        justify-content: space-between;--}}
{{--        align-items: center;--}}
{{--        width: 100%;--}}
{{--        padding-top: 8px;--}}
{{--        border-top: 1px solid gray;--}}
{{--        font-weight: 700;--}}
{{--    }--}}

{{--    .location span:first-child {--}}
{{--        text-align: left;--}}
{{--    }--}}

{{--    .location span:last-child {--}}
{{--        text-align: right;--}}
{{--    }--}}

{{--    .location .separator {--}}
{{--        font-size: 20px;--}}
{{--    }--}}

{{--    .right {--}}
{{--        width: 225px;--}}
{{--        border-left: 1px dashed #404040;--}}
{{--    }--}}

{{--    .right .admit-one {--}}
{{--        color: darkgray;--}}
{{--    }--}}

{{--    .right .admit-one span:nth-child(2) {--}}
{{--        color: #505050;--}}
{{--    }--}}

{{--    .right .right-info-container {--}}
{{--        height: 250px;--}}
{{--        padding: 10px 10px 10px 30px;--}}
{{--        display: flex;--}}
{{--        flex-direction: column;--}}
{{--        justify-content: space-evenly;--}}
{{--        align-items: center;--}}
{{--    }--}}

{{--    .right .show-name h1 {--}}
{{--        font-size: 18px;--}}
{{--        font-family: "Barlow", sans-serif;--}}
{{--    }--}}

{{--    .right .time {--}}
{{--        margin-top: 10px;--}}
{{--    }--}}

{{--    .barcode {--}}
{{--        height: 135px;--}}
{{--    }--}}

{{--    .barcode img {--}}
{{--        height: 100%;--}}
{{--    }--}}

{{--    .right .ticket-number {--}}
{{--        color: #505050;--}}
{{--        font-weight: 700;--}}
{{--    }--}}

{{--</style>--}}
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
            {{--            <div class="name">John Smith</div>--}}
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
