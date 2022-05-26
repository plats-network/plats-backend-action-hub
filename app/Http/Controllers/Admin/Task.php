<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateTaskRequest;
use App\Services\TaskService;
use Illuminate\Http\Request;

class Task extends Controller
{
    /**
     * @var \App\Services\TaskService
     */
    protected $taskService;

    /**
     * @param \App\Services\TaskService $taskService
     */
    public function __construct(TaskService $taskService)
    {
        $this->taskService = $taskService;
    }

    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        return view('admin.task.index', ['tasks' => $this->taskService->search()]);
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

        return view('admin.task.create');
    }

    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function edit($id)
    {
        $task = $this->taskService->find($id);

        // Save detail to session
        if (empty(request()->old()) || old('id') != $id) {
            $this->flashSession($task);
        }

        return view('admin.task.edit', ['task' => $task]);
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
