<?php

namespace App\Http\Controllers\Api\Beta\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Beta\TaskRequest;
use App\Http\Resources\Api\Beta\Admin\TaskResource;
use App\Models\Event\TaskEvent;
use App\Models\Quiz\Quiz;
use App\Models\Task;
use App\Models\TaskGallery;
use App\Models\TaskGroup;
use App\Models\Url;
use App\Services\Admin\EventService;
use App\Services\Admin\TaskService;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class TaskController extends Controller
{
    public function __construct(
        private TaskService  $taskService,
        private EventService $eventService
    )
    {
    }

    public function index(Request $request)
    {
        try {
            $limit = !empty($request->get('limit')) ? $request->get('limit') : PAGE_SIZE;
            $tasks = $this->taskService->search(['limit' => $limit, 'type' => EVENT]);
            $datas = TaskResource::collection($tasks);
            $pages = [
                'current_page' => (int)$request->get('page'),
                'last_page' => $tasks->lastPage(),
                'per_page' => (int)$limit,
                'total' => $tasks->total()
            ];
            return $this->responseApiSuccess([
                'list' => $datas,
                'paging' => $pages
            ]);
        } catch (\Exception $exception) {
            return $this->responseApiError([], $exception->getMessage());
        }
    }

    public function show(Request $request)
    {
        try {
            $id = $request->id;
            if (empty($id)) {
                return $this->responseApiError([], 'id is not required');
            }
            $task = Task::with('taskSocials', 'taskLocations', 'taskEventSocials', 'taskGenerateLinks', 'taskEventDiscords')->findOrFail($id);
            $taskGroup = TaskGroup::where('task_id', $id)->pluck('group_id');
            $taskGallery = TaskGallery::where('task_id', $id)->pluck('url_image');
            $booths = TaskEvent::where('task_id', $id)->with('detail')->where('type', 1)->first();
            $sessions = TaskEvent::where('task_id', $id)->with('detail')->where('type', 0)->first();
            $image = [];
            foreach ($taskGallery as $item) {
                $image[]['url'] = $item;
            }
            $urlAnswersFull = route('web.events.show', ['id' => $id, 'check_in' => true]);
            //Shorten url
            $urlAnswers = Url::shortenUrl($urlAnswersFull);
            $task['group_tasks'] = $taskGroup;
            $task['task_galleries'] = $image;
            $task['booths'] = $booths;
            $task['sessions'] = $sessions;
            $task['urlAnswers'] = $urlAnswers;
            return $this->responseApiSuccess($task);
        } catch (\Exception $exception) {
            return $this->responseApiError([], $exception->getMessage());
        }
    }

    public function store(TaskRequest $request)
    {
        try {
//            dd($request->all());
            $task = $this->eventService->store($request);
            return $this->responseApiSuccess($task);
        } catch (\Exception $exception) {
            return $this->responseApiError([], $exception->getMessage());
        }
    }
}
