<script>
    // ELEMENTS
    const WAITING_PLAYER = $('.waiting-player');
    const QUESTION_DETAIL = $('.wrap-question-detail');
    const QUIZ_COMPLETED = $('.quiz-completed');
    const SCOREBOARD = $('.wrap-scoreboard');
    const SPINNER = $('#loading-overlay');
    const STARTGAMESOUND = $('#startGameSound')[0];

    // STEP SCREEN
    const WAITING_PLAYER_STEP = 1;
    const QUESTION_DETAIL_STEP = 2;
    const QUIZ_COMPLETED_STEP = 3;
    const SCOREBOARD_STEP = 4;

    // Bind event pusher
    pusher.subscribe("NextQuestion").bind("NextQuestionEvent", handleNextQuestion);
    pusher.subscribe("UserJoinQuiz").bind("UserJoinQuizEvent", handleUserJoinQuiz);

    // Declare global variable
    const EVENT_ID = "{{ $event->id }}";
    var app = {
        userId: null,
        nickname: '',
        currentQuestion: 0,
        totalQuestion: null,
        answers: [],
        correctAnswer: '',
        countDownSeconds: 0,
        questionName: '',
        questionImage: null,
        timeToAnswer: 0,
        currentStep: 1,
        expirationQuestionTime: null
    }

    // Get variable from localStorage in case reload
    var storeQuizQuestionVariable = localStorage.getItem('quizQuestionVariable') ? JSON.parse(localStorage.getItem(
        'quizQuestionVariable')) : null;
    if (storeQuizQuestionVariable) {
        app = storeQuizQuestionVariable;
        // Check current screen step
        checkScreenStep(storeQuizQuestionVariable.currentStep);

        // Bind data question
        bindDataQuestion();
    }

    $(document).ready(function() {});

    function nextQuestion() {
        // Prevent double click next question
        QUESTION_DETAIL.find('.btn-plats').attr('disabled', true);
        SPINNER.show();

        if (app.totalQuestion && app.currentQuestion >= app.totalQuestion) {
            app.currentStep = QUIZ_COMPLETED_STEP;
            checkScreenStep(QUIZ_COMPLETED_STEP)

            // Finish sound if game is over
            STARTGAMESOUND.currentTime = 0
            STARTGAMESOUND.pause();

            // Remove localstorage
            localStorage.removeItem('quizQuestionVariable')
            SPINNER.hide();

            return;
        }
        if (app.currentQuestion === 0) {
            // Start sound if game ready
            STARTGAMESOUND.play();
        }

        $.ajax({
            url: '/quiz-game/next-question',
            method: 'POST',
            data: {
                eventId: EVENT_ID,
                questionNumber: parseInt(app.currentQuestion) + 1,
            },
            success: function(res) {
                // Handle successful submission
            },
            error: function(error) {
                // Handle submission error
            },
            complete: function(data) {
                SPINNER.hide();
                //A function to be called when the request finishes 
                // (after success and error callbacks are executed). 
            }
        });
    }

    // Listen event next question to handle on player screen
    function handleNextQuestion(data) {
        var question = data?.data

        // Show select answer screen
        checkScreenStep(QUESTION_DETAIL_STEP);

        // Assigne value for question content
        app.questionName = question.name
        app.questionImage = question.image
        app.countDownSeconds = question.timeToAnswer;
        app.currentQuestion = question.number;
        app.answers = question.answers;
        app.totalQuestion = question.totalQuestion;
        app.currentStep = QUESTION_DETAIL_STEP;

        // Bind new data question 
        bindDataQuestion()

        // Countdown second to get point
        countDownSecondsTimer(question.correctAnswer);

        // Save variable to storage
        localStorage.setItem('quizQuestionVariable', JSON.stringify(app));
    }

    // Bind data question
    function bindDataQuestion(isDataStorage = false) {
        if (isDataStorage) {
            QUESTION_DETAIL.find('.countdown').text(app.countDownSeconds);
        } else {
            QUESTION_DETAIL.find('.countdown').text(app.timeToAnswer);
        }
        QUESTION_DETAIL.find('.question-name').text(app.questionName);
        QUESTION_DETAIL.find('.wrap-question-image img').attr('src', app.questionImage);
        app.answers.forEach((value, index) => {
            let boxAnswer = QUESTION_DETAIL.find('.wrap-answers .answer-box').get(index);
            $(boxAnswer).find('p').text(value.name);
        });
    }

    // Countdown seconds to caculate the point
    function countDownSecondsTimer(correctAnswer) {
        var self = this;
        QUESTION_DETAIL.find('#' + correctAnswer).removeClass('animated flash');
        if (app.countDownSeconds > 0) {
            setTimeout(function() {
                app.countDownSeconds -= 1;
                self.countDownSecondsTimer(correctAnswer);
            }, 1000);
            QUESTION_DETAIL.find('.countdown').text(app.countDownSeconds)
        } else {
            // Show correct answer
            QUESTION_DETAIL.find('#' + correctAnswer).addClass('animated flash');

            // Enabled button next question
            QUESTION_DETAIL.find('.btn-plats').attr('disabled', false);

            // Reset countdown timer to zero 
            QUESTION_DETAIL.find('.countdown').text(0)
        }
    }

    // Change the step screen
    function checkScreenStep(step) {
        switch (step) {
            case WAITING_PLAYER_STEP:
                // Hide other screen
                QUESTION_DETAIL.hide();
                QUIZ_COMPLETED.hide();
                SCOREBOARD.hide();

                // Show welcome screen
                WAITING_PLAYER.show();
                break;

            case QUESTION_DETAIL_STEP:
                // Hide other screen
                WAITING_PLAYER.hide();
                QUIZ_COMPLETED.hide();
                SCOREBOARD.hide();

                // Show select answer screen
                QUESTION_DETAIL.show();
                break;

            case QUIZ_COMPLETED_STEP:
                // Hide other screen
                WAITING_PLAYER.hide();
                QUESTION_DETAIL.hide();
                SCOREBOARD.hide();

                // Show quiz complete screen
                QUIZ_COMPLETED.show();
                break;

            case SCOREBOARD_STEP:
                // Hide other screen
                WAITING_PLAYER.hide();
                QUESTION_DETAIL.hide();
                SCOREBOARD.hide();
                QUIZ_COMPLETED.hide();

                // Show quiz complete screen
                SCOREBOARD.show();
                break;

            default:
                break;
        }
    }

    // Handle user join quiz
    function handleUserJoinQuiz(data) {
        var usersJoined = data?.data;
        var nicknameElement = $("<span class='nickname'></span>")
        WAITING_PLAYER.find('.number-players h2').text(usersJoined.length);
        var listsElement = '';
        usersJoined.forEach(element => {
            let nicknameElement = "<span class='nickname'>" + element.name + "</span>";
            listsElement += nicknameElement;
        });
        WAITING_PLAYER.find('.lists').empty();
        WAITING_PLAYER.find('.lists').append(listsElement);
    }

    // Show scoreboard
    function showScoreboard() {
        SPINNER.show();
        $.ajax({
            url: '/quiz-game/scoreboard/' + EVENT_ID,
            method: 'GET',
            success: function(data) {
                // First rank
                let firstRank = data[0] ?? null;
                if (firstRank) {
                    SCOREBOARD.find('.first-rank .nickname').text(firstRank.user.name);
                    SCOREBOARD.find('.first-rank .point').text(firstRank.point);
                }

                // Second rank
                let secondRank = data[1] ?? null;
                if (secondRank) {
                    SCOREBOARD.find('.second-rank .nickname').text(secondRank.user.name);
                    SCOREBOARD.find('.second-rank .point').text(secondRank.point);
                }

                // Third rank
                let thirdRank = data[2] ?? null;
                if (thirdRank) {
                    SCOREBOARD.find('.third-rank .nickname').text(thirdRank.user.name);
                    SCOREBOARD.find('.third-rank .point').text(thirdRank.point);
                }

                // Mid rank
                var rankItem = SCOREBOARD.find('.mid-rank .rank-item').get(0);
                var midRank = '';
                for (let rank = 4; rank <= 10; rank++) {
                    let element = data[rank - 1] ?? null;
                    let nickname = element ? element.user.name : '_';
                    let point = element ? element.point : 0;
                    midRank +=
                        "<div class='rank-item d-flex items-center'><div class='rank' style='background-color:" +
                        getColorRank(rank) + "'>" + rank +
                        "</div><div class='wrap-point d-flex'>" +
                        "<div class='nickname'>" + nickname + "</div><div class='point'>" + point +
                        "</div></div></div>";
                }
                SCOREBOARD.find('.mid-rank').empty();
                SCOREBOARD.find('.mid-rank').append(midRank);
            },
            error: function(error) {
                // Handle submission error
            },
            complete: function(data) {
                // Show scored board
                checkScreenStep(SCOREBOARD_STEP)
                SPINNER.hide();
            }
        });

        // Get color scoreboard
        function getColorRank(rank) {
            let color = '';
            switch (rank) {
                case 1:
                    color = '#F4DB00';
                    break;
                case 2:
                    color = '#61F370';
                    break;
                case 3:
                    color = '#F361C1';
                    break;
                case 4:
                    color = '#61F3D0';
                    break;
                case 5:
                    color = '#F061F3';
                    break;
                case 6:
                    color = '#B98BF4';
                    break;
                case 7:
                    color = '#FEB4B4';
                    break;
                case 8:
                    color = '#5D4FFF';
                    break;
                case 9:
                    color = '#F48707';
                    break;
                case 10:
                    color = '#FFFAFA';
                    break;

                default:
                    break;
            }

            return color;
        }
    }
</script>
