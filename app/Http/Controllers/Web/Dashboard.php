<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Event\TaskEvent;
use App\Services\Admin\EventService;
use App\Services\Admin\TaskService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Dashboard extends Controller
{
    public function __construct(
        private TaskEvent   $eventModel,
        private EventService $eventService,
        private TaskService $taskService
    )
    {
    }

    public function index(Request $request)
    {
        if (empty(Auth::user()->id)){
            $active = 0;
        }else{
            $active = 1;
        }
        return view('web.home',['active' => $active]);
    }
}
