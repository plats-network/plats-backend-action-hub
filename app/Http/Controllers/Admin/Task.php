<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateTaskRequest;
use App\Services\{GuildService, TaskService};
use App\Repositories\TaskRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Auth, Str, Log;

class Task extends Controller
{
    /**
     * @param \App\Services\TaskService $taskService
     * @param \App\Services\GuildService $guildService
     */
    public function __construct(
        private TaskService $taskService,
        private GuildService $guildService,
        private TaskRepository $taskRepository
    ) {
        $this->middleware('client_admin');
    }

    /**
     * @return \Illuminate\Contracts\View\View\
     */
    public function index(Request $request)
    {
        if (Auth::user()->role == CLIENT_ROLE) {
            $tasks = $this->taskRepository->getTasks(Auth::user()->id);
        } else {
            $tasks = $this->taskRepository->getTasks();
        }

        $tasks = $tasks
            ->orderBy('status', 'DESC')
            ->orderBy('created_at', 'DESC')
            ->get();

        return view(
            'admin.task.index', [
                'tasks' => $tasks
            ]
        );
    }

    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        // Remove flash session fields before from visited
        if (!empty(request()->old())) {
            $this->flashReset();
        }

        $assign = [];
        $assign['guilds'] = $this->guildService->mockGuilds();

        return view('admin.task.create', $assign);
    }

    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function edit($id)
    {
        $assign = [];
        $assign['guilds'] = $this->guildService->mockGuilds();
        $assign['task'] = $this->taskService->find($id);

        // Save detail to session
        if (empty(request()->old()) || old('id') != $id) {
            $this->flashSession($assign['task']);
        }

        return view('admin.task.edit', $assign);
    }

    /**
     * @param \App\Http\Requests\CreateTaskRequest $request
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Prettus\Validator\Exceptions\ValidatorException|\Prettus\Repository\Exceptions\RepositoryException
     */
    public function store(CreateTaskRequest $request)
    {
        $task = $this->taskService->store($request);

        if (!$request->filled('id')) {
            // Push notices by services
            $token = Auth::user()->token;
            $icon = $task->cover_url;
            $res = $this->pushNotices(
                $token,
                Str::limit($task->name, 50),
                Str::limit($task->description, 30),
                $task->id,
                $icon
            );

            Log::info('Response push notices', [
                'response' => $res
            ]);

            return redirect()->route(TASK_DEPOSIT_ADMIN_ROUTER, $task->id);
        }
        return redirect()->route(TASK_LIST_ADMIN_ROUTER);
    }

    /**
     * Client deposit
     *
     * @param $id
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function deposit($id)
    {
        $task = $this->taskService->find($id);

        return view('admin.task.deposit', ['task' => $task]);
    }

    private function pushNotices($token, $title, $desc, $taskId, $icon = null)
    {
        $res = Http::withToken($token)
            ->post(config('app.api_url_notice') . "/api/push_tasks", [
                "title" => $title ?? '🙂🙂🙂 Có tin mới!',
                "desc" => $desc ?? '🙂🙂🙂 Bạn có tin nhắn từ Plats',
                "type" => "new_task",
                "type_id" => $taskId,
                "icon"  => $icon
            ]);

        return json_decode($res->getBody()->getContents());
    }
}
