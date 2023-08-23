<html>
    <head>
      <title>Event | Vòng quay may mắn</title>
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
      <script type="text/javascript" src="{{url('/')}}/js/Winwheel.min.js"></script>
      <script src="http://cdnjs.cloudflare.com/ajax/libs/gsap/latest/TweenMax.min.js"></script>
      <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js"></script>
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js"></script>
      <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.browser.min.js"></script>

      <style type="text/css">
          .output {
            margin: 20px;
            padding: 20px;
            background: gray;
            border-radius: 10px;
            font-size: 20px;
            width: 80px;
            color: white;
            float: left;
        }

        body {
            background-image: url("https://cdn.dribbble.com/userupload/3369133/file/original-d568dabe73b516a4d787a229a0d0ab24.png");
            background-size: cover;
        }
        .start {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            box-shadow: 0 0 60px rgba(0, 255, 203, 0.64);
        }

        .item {
            width: 25%;
            background-color: #187fe2;
            color: #fff;
            font-size: 40px;
        }
        .btn-stop {
            background-color: red;
            color: #fff;
        }

        .btn:hover {color: #fff!important;}

        .btn-start {
            background-color: #187fe2;
            color: #fff;
            border: 2px solid red;
            box-shadow: 0 0 60px rgba(0, 255, 203, 0.64);
        } 

        .logo {
            text-align: center;
            padding-top: 24px;
        }
      </style>

      @vite(['resources/sass/game.scss'])
    </head>

    <body
        {{-- style="background-image: url({{url('/')}})/game/{{$img}}" --}}
        id="t"
        data-numbers="{{json_encode($numbers)}}"
        data-env="{{env('APP_ENV') == 'local' ? false : true}}">
        <div class="container">
            <div class="logo">
                <a href="#">
                    <img class="logo-img" src="{{url('/')}}/game/logo-game.svg">
                </a>
            </div>
            <div style="margin: 20% 0 50px; display: block;">
                <div class="row text-center">
                    @for($a = 0; $a <= 5; $a++)
                        <div class="item output" id="output{{$a}}">--</div>
                    @endfor
                </div>
            </div>
            <div style="margin: 0 auto;" class="text-center">
                <button class="btn btn-start start" id="a">Start</button>
            </div>
        </div>

        <script type="text/javascript">
            // Lock
            var env = $('#t').data('env');

            if (env) {
                document.addEventListener('keydown', function() {
                if (event.keyCode == 123) {
                  return false;
                } else if (event.ctrlKey && event.shiftKey && event.keyCode == 73) {
                  return false;
                } else if (event.ctrlKey && event.keyCode == 85) {
                  return false;
                }
              }, false);
              
              if (document.addEventListener) {
                document.addEventListener('contextmenu', function(e) {
                  e.preventDefault();
                }, false);
              } else {
                document.attachEvent('oncontextmenu', function() {
                  window.event.returnValue = false;
                });
              }
            }
            // End Lock


            let audio = new Audio('https://d37c8ertxcodlq.cloudfront.net/others/soxo.mp3');
            let audio2 = new Audio('https://d37c8ertxcodlq.cloudfront.net/others/Tieng-vo-tay-www_tiengdong_com.mp3');
            var numbers = $('#t').data('numbers');
            var a = [];
            var l = 6;
            function playSound() {
                audio.currentTime = 0;
                audio.play();
            }
            function stropSound() {
                audio.pause();
            }
            function votay() {
                audio2.pause();
                audio2.currentTime = 0;
                audio2.play();
            }

            function phaohoa() {
                var duration = 30 * 1000;
                var animationEnd = Date.now() + duration;
                var defaults = { startVelocity: 30, spread: 360, ticks: 60, zIndex: 0 };

                function randomInRange(min, max) {
                  return Math.random() * (max - min) + min;
                }

                var interval = setInterval(function() {
                  var timeLeft = animationEnd - Date.now();

                  if (timeLeft <= 0) {
                    return clearInterval(interval);
                  }

                  var particleCount = 50 * (timeLeft / duration);
                  confetti(Object.assign({}, defaults, { particleCount, origin: { x: randomInRange(0.1, 0.3), y: Math.random() - 0.2 } }));
                  confetti(Object.assign({}, defaults, { particleCount, origin: { x: randomInRange(0.7, 0.9), y: Math.random() - 0.2 } }));
                }, 100);
            }

            function generateNumber(index) {
                if(index >= l) {
                    $('#a').removeClass('btn-danger').addClass('btn-stop b').attr('disabled', false).attr('id', 'stop').html('Reset');
                    stropSound();
                    votay();
                    phaohoa();
                    return;
                } else {
                  var desired = numbers[index];
                  var duration = 5000;

                  var output = $('#output' + index); // Start ID with letter
                  var started = new Date().getTime();

                  animationTimer = setInterval(function() {
                    if (output.text().trim() === desired || new Date().getTime() - started > duration) {
                      clearInterval(animationTimer); // Stop the loop
                      var rnd = random_item(numbers);
                      a.push(rnd);
                      output.text(rnd); // Print desired number in case it stopped at a different one due to duration expiration
                      generateNumber(index + 1);
                      numbers = numbers.filter(item => !a.includes(item))
                    } else {
                      output.text(
                        '' +
                        Math.floor(Math.random() * 10) +
                        Math.floor(Math.random() * 10)
                      );
                    }
                  }, 40);
                }
            }

            function random_item(items) {
                return items[Math.floor(Math.random()*items.length)];
            }

            $(document).on('click', '#a', function (e) {
                $(this).removeClass('btn-start').addClass('btn-danger').attr('disabled', true).html('Running');
                generateNumber(0);
                playSound();
            });

            $(document).on('click', '.b', function (e) {
                location.reload();
            });
      </script>
    </body>
</html>
