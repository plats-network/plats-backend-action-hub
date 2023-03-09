<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event\EventUserTicket;
use App\Services\Admin\EventUserTicketService;
use Illuminate\Http\Request;

class Event extends  Controller
{
    public function __construct(
        private EventUserTicketService $eventUserTicketService
    )
    {
//        $this->middleware('client_admin');
    }

    public function index(Request $request)
    {
        return view(
            'admin.event.index'
        );
    }

    public function userEvent($id)
    {
        return view(
            'admin.event.user_event',['task_id'=>$id]
        );
    }

    public function apiUserEvent(Request $request ,$id)
    {
        $limit = $request->get('limit') ?? PAGE_SIZE;
        $rawData = $this->eventUserTicketService->search(['limit' => $limit,'task_id' => $id]);
        return response()->json($rawData);
    }
}
