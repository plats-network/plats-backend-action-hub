<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateTaskRequest;
use App\Services\GuildService;
use App\Services\TaskService;
use Illuminate\Http\Request;

class Task extends Controller
{
    /**
     * @var \App\Services\TaskService
     */
    protected $taskService;

    /**
     * @var \App\Services\GuildService
     */
    protected $guildService;

    /**
     * @param \App\Services\TaskService $taskService
     * @param \App\Services\GuildService $guildService
     */
    public function __construct(TaskService $taskService, GuildService $guildService)
    {
        $this->taskService = $taskService;
        $this->guildService = $guildService;
    }

    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        return view(
            'admin.task.index',
            ['tasks' => $this->taskService->search(['withCount' => ['participants', 'locations']])]
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
}
