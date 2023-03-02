<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Tickỉt</title>
</head>
<body>
    <div class="box-content-letters container">
        <div class="box-body-letters">
            <div class="box-info-event">
                <p class="info-event-date">June 30, 2023</p>
                <p class="info-event-name">{{$ticket->name}}</p>
                <p class="info-event-tikcet">Free Event Ticket</p>
                <p class="info-event-tikcet">for</p>
                <p class="info-event-des">{{Str::limit($ticket->name, 25)}}</p>
            </div>
            <div class="box-info-address">
                <div class="box-content-address">
                    <div class="box-event-logo">
                        <img src="https://d37c8ertxcodlq.cloudfront.net/icon/logo-event.png" class="image-full" alt="">
                    </div>
                    <div class="box-event-address">
                        <p class="info-event-address">Address: {{$ticket->address}}</p>
                        <p class="info-event-time">
                            <span>Start: {{$ticket->end_at}}</span>
                            <span>
                                <span>
                                    End: {{$ticket->end_at}}
                                </span>
                            </span>
                        </p>
                    </div>
                    <div class="box-event-qrcode">
                        <img src="https://images.viblo.asia/5974cb6b-ec70-41d0-9074-d4319b62f4c7.png" class="image-full" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
<style lang="scss" scoped>
    @import url('https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap');
    html, body {
        margin: 0;
        padding: 0;
        overflow-x: hidden;
        height: 100%;
        background: #ffffff;
    }
    .box-content-letters {
        font-family: 'Roboto', sans-serif;
        /*    rgb(33, 131, 217)    */
        background-image: linear-gradient(140deg, #2183d9 0%, #2183d9 50%, #2183d9 75%);
        padding: 30px 0;
        color: #252525;
    }
    .box-body-letters{
        border-top: 2px solid;
        border-bottom: 2px solid;
    }
    .box-info-event {
        text-align: center;
        padding: 45px 0;
    }
    .box-info-event .info-event-date {
        font-size: 30px;
        font-weight: bold;
    }
    .box-info-event .info-event-name {
        font-size: 33px;
        font-weight: bold;
    }
    .box-info-event .info-event-tikcet {
        font-size: 18px;
    }
    .box-info-event .info-event-des {
        font-size: 30px;
        font-weight: bold;
        margin: 0;
    }
    .box-info-address {
        border-top: 2px dashed;
        border-spacing: 10px;
    }
    .box-content-address {
        display: flex;
        margin: 20px 20px;
        background: #ffffff;
        justify-content: space-evenly;
        align-items: center;
        padding: 0;
    }
    .box-event-logo {
        width: 150px;
    }
    .box-event-qrcode {
        width: 100px;
    }
    .image-full {
        width: 100%;
        height: auto;
    }
    .info-event-address {
        font-size: 18px;
    }
    .info-event-time {
        display: flex;
        justify-content: space-evenly;
    }

    @media screen and (max-width: 768px) {
        .box-content-address {
            display: flex;
            gap:20px;
            flex-direction: column;
            margin: 20px 20px;
            background: #ffffff;
            justify-content: space-evenly;
            align-items: center;
            padding: 20px;
        }
        .info-event-time {
            margin: 0;
        }
        .box-content-letters {
            height: 100vh;
        }
        .box-info-event .info-event-date {
            font-size: 20px;
            font-weight: bold;
        }
        .box-info-event .info-event-name {
            font-size: 23px;
            font-weight: bold;
        }
        .box-info-event .info-event-tikcet {
            font-size: 16px;
        }
        .box-info-event .info-event-des {
            font-size: 20px;
            font-weight: bold;
            margin: 0;
        }
        .info-event-address {
            font-size: 16px;
        }
        .info-event-time {
            font-size: 14px;
        }
    }
    @media screen and (max-width: 375px) {
        .box-info-event {
            text-align: center;
            padding: 35px 0;
        }
        .box-content-address {
            display: flex;
            gap:10px;
            flex-direction: column;
            margin: 20px 20px;
            background: #ffffff;
            justify-content: space-evenly;
            align-items: center;
            padding: 15px;
        }
        .box-info-event .info-event-date {
            margin-bottom: 8px;
        }
        .box-info-event .info-event-name {
            margin-bottom: 8px;
        }
        .box-info-event .info-event-tikcet {
            margin-bottom: 8px;
        }
        .box-info-event .info-event-des {
            font-size: 20px;
            font-weight: bold;
            margin: 0;
        }
    }
</style>