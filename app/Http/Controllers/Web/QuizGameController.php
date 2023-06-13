<?php

namespace App\Http\Controllers\Web;

use App\Events\NextQuestionEvent;
use App\Events\UserJoinQuizGameEvent;
use App\Http\Controllers\Controller;
use App\Models\Quiz\Quiz;
use App\Models\Quiz\QuizResult;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Cache;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class QuizGameController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request The request object.
     * @param string $eventId  The UUID of the event.
     */
    public function index(Request $request, $eventId): mixed
    {
        $isUuid = Str::isUuid($eventId);
        // Validate uuid event id
        if (!$isUuid) {
            return redirect()->route(DASHBOARD_WEB_ROUTER);
        }

        $event = $this->getEventById($eventId);
        $totalQuiz = $event->quizs->count();
        // Check event not found
        if (!$event) {
            return redirect()->route(DASHBOARD_WEB_ROUTER);
        }
        $urlAnswers = route('quiz-name.answers', $eventId);
        $qrCode = QrCode::format('png')->size(300)->generate($urlAnswers);

        return view('quiz-game.questions', compact('qrCode', 'event', 'totalQuiz'));
    }

    /**
     * Show answers screen
     *
     * @param Request $request The request object.
     * @param string $eventId  The UUID of the event.
     */
    public function showAnswers(Request $request, $eventId): mixed
    {
        $isUuid = Str::isUuid($eventId);
        // Validate uuid event id
        if (!$isUuid) {
            return redirect()->route(DASHBOARD_WEB_ROUTER);
        }

        $user = $request->user();
        $event = $this->getEventById($eventId);
        $listJoinedUsers = Cache::get('list_joined_users_' . $eventId) ?? [];
        $data = [
            'id' => $user->id,
            'name' => $user->name,
            'point' => 0
        ];
        $isUserJoined = false;
        // Check is user exist in cache
        foreach ($listJoinedUsers as $userJoined) {
            if ($user->id === $userJoined['id']) {
                $isUserJoined = true;
            }
        }

        if (!$isUserJoined || !$listJoinedUsers) {
            array_push($listJoinedUsers, $data);
        }

        Cache::put('list_joined_users_' . $eventId, $listJoinedUsers, now()->addMinutes(60));

        // Notify new user join and show total users
        event(new UserJoinQuizGameEvent($listJoinedUsers, $eventId));

        return view('quiz-game.answers', [
            'eventId' => $eventId,
            'userName' => $user->name,
            'eventName' => $event->name,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Request $request The request object.
     * @return \Illuminate\Http\JsonResponse The JSON response containing the data.
     */
    public function getQuestionByNumber(Request $request)
    {
        $questionNumber = (int)$request->questionNumber;
        $eventId = $request->eventId;
        $question = Quiz::with('detail')
            ->where('task_id', $eventId)
            ->skip((int)$questionNumber - 1)
            ->take(1)
            ->first();

        $correctAnswerKey = $question->detail->search(function ($answer) {
            return $answer->status;
        });
        $answerSymbols = ['A', 'B', 'C', 'D'];
        $data = [
            'number' => $questionNumber,
            'name' => 'Question number ' . $questionNumber . ' : ' . $question->name,
            'answers' => $question->detail,
            'correctAnswer' => $answerSymbols[$correctAnswerKey],
            'timeToAnswer' => $question->time_quiz,
            'totalQuestion' => Quiz::where('task_id', $eventId)->count(),
            'image' => $request->getSchemeAndHttpHost() . '/events/quiz-game/' . rand(1, 4) . '.jpg'
        ];
        event(new NextQuestionEvent($data, $request->eventId));

        return response()->json([$data]);
    }

    /**
     * User send total score after finish the quiz
     *
     * @param Request $request The request object.
     * @return \Illuminate\Http\JsonResponse The JSON response containing the message.
     */
    public function sendTotalScore(Request $request)
    {
        $user = $request->user();

        // Save point to DB
        QuizResult::updateOrCreate(
            [
                'task_id' => $request->eventId,
                'user_id' => $user->id
            ],
            [
                'point'   => $request->totalPoint,
                'answer'   => $request->answer
            ]
        );

        return response()->json(['message' => 'Send point successful.']);
    }

    /**
     * Get scoreboard in the end of the game
     *
     * @param Request $request The request object.
     * @param string $eventId The UUID of the event.
     * 
     * @return \Illuminate\Http\JsonResponse The JSON response containing the data.
     */
    public function getScoreboard(Request $request, $eventId)
    {
        $quizResult = QuizResult::with('user:name,id')
            ->select('id', 'user_id', 'point')
            ->where('task_id', $eventId)
            ->orderBy('point', 'DESC')
            ->limit(10)
            ->get();

        // Delete cache
        Cache::forget('list_joined_users_' . $eventId);

        return response()->json($quizResult);
    }

    /**
     * Get event by id
     *
     * @param string $eventId The UUID of the event
     * @return Task The retrieve instance model
     */
    public function getEventById($eventId)
    {
        return Task::where('id', $eventId)->where('status', TASK_PUBLIC)->first();
    }

    /**
     * Get summary results answers
     *
     * @param string $eventId The UUID of the event
     * @return \Illuminate\Http\JsonResponse The JSON response containing the data.
     */
    public function getSummaryResults($eventId)
    {
        define('TOP_HIGHEST_SCORE', 10);
        $summaryAnswer = QuizResult::where('task_id', $eventId)->get();
        $countByAnswer = $summaryAnswer->countBy('answer');
        $totalAnswered = $summaryAnswer->count();
        $scoreboard = QuizResult::with('user:name,id')
            ->select('id', 'user_id', 'point')
            ->where('task_id', $eventId)
            ->orderBy('point', 'DESC')
            ->limit(TOP_HIGHEST_SCORE)
            ->get();

        // Reset answers
        QuizResult::where('task_id', $eventId)->update(['answer' => null]);

        return response()->json([
            'summaryAnswer' => [
                [
                    'label' => 'A',
                    'total' => $countByAnswer['A'] ?? 0
                ],
                [
                    'label' => 'B',
                    'total' => $countByAnswer['B'] ?? 0
                ],
                [
                    'label' => 'C',
                    'total' => $countByAnswer['C'] ?? 0
                ],
                [
                    'label' => 'D',
                    'total' => $countByAnswer['D'] ?? 0
                ],
            ],
            'scoreboard' => $scoreboard,
            'totalAnswered' => $totalAnswered
        ]);
    }
}
