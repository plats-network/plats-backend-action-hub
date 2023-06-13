@extends('quiz-game.layout_answer')
@section('content')
    <div class="answers">
        <header>
            <div class="container">
                <h2>Welcome to Plats Quiz !</h2>
            </div>
        </header>
        {{-- WELCOME PLAYER --}}
        <div class="welcome-users body-section">
            <div class="container">
                <h2>You're in!</h2>
            </div>
        </div>
        {{-- END WELCOME PLAYER --}}

        {{-- PREPARE ANSWER --}}
        <div class="prepare-answer body-section" style="display: none">
            <div class="container">
                <h3 class="question-name text-white">Question number</h3>
                <div class="loading-icon lds-dual-ring"></div>
                <div class="text-white">Loading...</div>
            </div>
        </div>
        {{-- END PREPARE ANSWER --}}

        {{-- SELECT ANSWER --}}
        <div class="select-answers body-section" style="display: none">
            <div class="container">
                <div class="row">
                    <div class="col-6">
                        <div class="answer-box polygon" data-id="">
                            <img src="{{ url('events/quiz-game/polygon.png') }}" alt="polygon" class="img-fluid">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="answer-box ellipse" data-id="">
                            <img src="{{ url('events/quiz-game/ellipse.png') }}" alt="ellipse" class="img-fluid">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <div class="answer-box star" data-id="">
                            <img src="{{ url('events/quiz-game/star.png') }}" alt="star" class="img-fluid">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="answer-box rectangle" data-id="">
                            <img src="{{ url('events/quiz-game/rectangle.png') }}" alt="rectangle" class="img-fluid">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- END SELECT ANSWER --}}

        {{-- CORRECT ANSWER --}}
        <div class="correct-answer status-answer body-section" style="display: none">
            <div class="container">
                <h3>Correct</h3>
                <img src="{{ url('events/quiz-game/correct-answer.svg') }}" alt="">
                <div class="point">+368</div>
            </div>
        </div>
        {{-- END CORRECT ANSWER --}}

        {{-- INCORRECT ANSWER --}}
        <div class="incorrect-answer status-answer body-section" style="display: none">
            <div class="container">
                <h3>Incorrect</h3>
                <img src="{{ url('events/quiz-game/incorrect-answer.svg') }}" alt="">
                <div class="point">+368</div>
            </div>
        </div>
        {{-- END INCORRECT ANSWER --}}

        {{-- QUIZ COMPLETED --}}
        <div class="quiz-completed status-answer body-section" style="display: none">
            <div class="container">
                <img src="{{ url('events/quiz-game/logo.png') }}" alt="Logo" style="max-width: 100%;">
                <h4>{{ $eventName }}</h4>
                <h2>Quiz Completed</h2>
            </div>
        </div>
        {{-- END QUIZ COMPLETED --}}

        {{-- SOUND AFFECT --}}
        <div class="wrap-sound-affect" style="display: none">
            <audio id="correctSound">
                <source src="{{ url('static/sound/quiz-game/correct.mp3') }}" type="audio/mpeg">
            </audio>
            <audio id="incorrectSound">
                <source src="{{ url('static/sound/quiz-game/incorrect.mp3') }}" type="audio/mpeg">
            </audio>
        </div>
        {{-- END SOUND AFFECT --}}

        {{-- FLASH MESSAGE --}}
        <div id="flashMessage" class="alert alert-success"></div>
        {{-- FLASH MESSAGE --}}
        <footer>
            <div class="container">
                <div class="d-flex justify-content-between align-items-center">
                    <div class="col-md-6">
                        <h4 class="text-white">{{ $userName }}</h4>
                    </div>
                    <div class="col-md-6 text-end">
                        <div class="wrap-point">
                            <span class="point mx-2">0</span>Points
                        </div>
                    </div>
                </div>
            </div>
        </footer>

    </div>
@endsection
