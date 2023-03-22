<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event\EventUserTicket;
use App\Models\Event\TaskEvent;
use App\Models\Event\UserJoinEvent;
use App\Services\Admin\EventUserTicketService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        //update user_id
        $count = 0;
        foreach ($rawData as &$item){
            if ($item->user_id == null){
                $checkUser = \App\Models\User::where('email',$item->email)->first();
                if ($checkUser){
                    EventUserTicket::where('email',$item->email)->where('task_id',$item->task_id)->update(['user_id' => $checkUser->id,'type' => 0]);
                }
            }
        }
        $rawDataNew = $this->eventUserTicketService->search(['limit' => $limit,'task_id' => $id]);
        foreach ($rawDataNew as &$item){
            if ($item->user_id != null){
                $item['join'] = UserJoinEvent::where('user_id',$item->user_id)->where('task_id',$item->task_id)->select('task_event_id', DB::raw('count(*) as count'))
                    ->groupBy('task_event_id')
                    ->get();
                foreach ($item['join'] as $key =>  &$item){
                    $taskEvent = TaskEvent::where('id',$item->task_event_id)->first();
                    $item['type'] = $taskEvent->type;
                    if ($item->count >= $taskEvent->max_job){
                        $item['check'] = true;
                        $item['stt'] += $count + $key + 1;
                    }else{
                        $item['check'] = false;
                    }
                }
            }
        }
        return response()->json($rawDataNew);
    }
}
