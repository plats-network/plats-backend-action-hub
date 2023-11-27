<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\Services\Admin\{EventService, TaskService};

class Dashboard extends Controller
{
    public function __construct(
        private TaskService  $taskService,
    )
    {
        // $this->middleware('client_admin');
    }

    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {
        $limit = $request->get('limit') ?? 10;
        $events = $this->taskService->search([
            'limit' => $limit,
            'type' => EVENT
        ]);

        return view('cws.home', [
            'events' => $events
        ]);
    }

    //ping
    public function ping()
    {
        return response()->json([
            'status' => 'success',
            'updated_at' => '27.11.2023',
            'message' => 'pong'
        ]);
    }
}
