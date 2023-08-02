<header class="text-center" style="background-color: #409EFF; padding: 20px;">
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <!-- Empty column for spacing -->
            </div>
            <div class="col-md-4">
                <a href="/">
                    <img src="{{ url('events/quiz-game/logo.png') }}" alt="Logo" style="max-width: 100%;">
                </a>
            </div>
            <div class="wrap-header-audio align-items-center col-md-4 d-flex justify-content-end">
                <audio id="startGameSound" controls controlsList="nodownload noplaybackrate">
                    <source src="{{ url('static/sound/quiz-game/start_game.mp3') }}" type="audio/mpeg">
                </audio>
            </div>
        </div>
    </div>
</header>
