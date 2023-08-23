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
            }
      </style>

      @vite(['resources/sass/game.scss'])
    </head>

    <body id="t" data-numbers="{{json_encode($numbers)}}">
        @for($a = 0; $a <= 4; $a++)
            <div class="output" id="output{{$a}}">--</div>
        @endfor
        <a id="a" href="#">Click</a>
        
        <script type="text/javascript">
            let audio = new Audio('https://d37c8ertxcodlq.cloudfront.net/others/soxo.mp3');
            function playSound() {
                audio.currentTime = 0;
                audio.play();
            }

            function stropSound() {
                audio.pause();
            }
            var numbers = $('#t').data('numbers');
            var a = [];

            var l = 5;

            let audio2 = new Audio('https://d37c8ertxcodlq.cloudfront.net/others/Tieng-vo-tay-www_tiengdong_com.mp3');
            function votay()
            {
                audio2.pause();
                audio2.currentTime = 0;
                audio2.play();
            }

            function phaohoa() {
                // var end = Date.now() + (15 * 1000);
                // var colors = ['#bb0000', '#ffffff'];
                // (function frame() {
                //   confetti({
                //     particleCount: 2,
                //     angle: 60,
                //     spread: 55,
                //     origin: { x: 0 },
                //     colors: colors
                //   });
                //   confetti({
                //     particleCount: 2,
                //     angle: 120,
                //     spread: 55,
                //     origin: { x: 1 },
                //     colors: colors
                //   });

                //   if (Date.now() < end) {
                //     requestAnimationFrame(frame);
                //   }
                // }());


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
                    console.log(index, l)
                    stropSound();
                    votay();
                    phaohoa();

                    

                    return;
                } else {
                    console.log(index, l)
                  var desired = numbers[index];
                  var duration = 5000;

                  var output = $('#output' + index); // Start ID with letter
                  var started = new Date().getTime();

                  animationTimer = setInterval(function() {
                    if (output.text().trim() === desired || new Date().getTime() - started > duration) {
                      clearInterval(animationTimer); // Stop the loop
                      var rnd = random_item(numbers);
                      output.text(rnd); // Print desired number in case it stopped at a different one due to duration expiration
                      generateNumber(index + 1);
                      a.push(rnd);
                      numbers = numbers.filter(item => !a.includes(item))
                      console.log(numbers);
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

            // generateNumber(0);

            function random_item(items) {
                return items[Math.floor(Math.random()*items.length)];
            }

            $('#a').on('click', function(e) {
                generateNumber(0);
                playSound();
            });
      </script>
    </body>
</html>
