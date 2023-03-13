<?php

namespace App\Http\Controllers\Web;

use App\Exports\Ticket;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AddTicketRequest;
use App\Models\Event\EventUserTicket;
use App\Models\Event\TaskEvent;
use App\Models\Event\UserEventLike;
use App\Models\Task;
use App\Models\TaskGallery;
use App\Models\TaskGroup;
use App\Repositories\EventUserTicketRepository;
use App\Repositories\UserEventLikeRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\{Route, Mail, Auth};
use App\Jobs\SendTicket;
use App\Mail\SendTicket as EmailSendTicket;

class Detail extends Controller
{
    public function __construct(
        EventUserTicketRepository $eventUserTicketRepository,
        UserEventLikeRepository $eventLikeRepository
    )
    {
        $this->repository = $eventUserTicketRepository;
        $this->userEventLikeRepository = $eventLikeRepository;
    }

    public function index(Request $request)
    {
        $keyLocal = '';
        if ($request->input('facebook') || $request->input('twitter') || $request->input('telegram') || $request->input('discord') || $request->input('form'))
        {
            foreach ($request->all() as $key => $part) {
                $keyLocal= $key;
            }
        }
        $getIdTask = Task::where('slug',Route::current()->slug)->first();
        return view('web.detail',['id' => $getIdTask->id,'key'=>$keyLocal]);
    }

    public function addTicket(AddTicketRequest $request)
    {
        try {
            $user = Auth::user();
            $data = Arr::except($request->all(), '__token');
            if ($data['phone'] == null){
                $data['phone'] = 0;
            }
            $task = Task::findOrFail($data['task_id']);
            $data['type'] = $user ? 0 : 1;
            $data['user_id'] = $user ?  $user->id : null;
            $checkSendMail = $this->repository
                ->whereEmail($data['email'])
                ->whereTaskId($data['task_id'])
                ->first();

//            if ($checkSendMail) {
//                Mail::to($data['email'])->send(new EmailSendTicket($task));
//            } else {
                $this->repository->create($data);
//                Mail::to($data['email'])->send(new EmailSendTicket($task));
//            }

            return $this->respondSuccess('Success');
        } catch (\Exception $e) {
            return $this->respondError('Errors save data', 422);
        }
    }
    public function edit($id)
    {
        $task = Task::find($id);
        $booths = TaskEvent::where('task_id',$id)->with('detail')->where('type',1)->first();
        $sessions = TaskEvent::where('task_id',$id)->with('detail')->where('type',0)->first();
        $task['booths'] = $booths;
        $task['sessions'] = $sessions;

        return $this->respondSuccess($task);
    }

    public function like(Request $request)
    {
        $data = Arr::except($request->all(), '__token');
        $check = $this->userEventLikeRepository->where('user_id',Auth::user()->id)->where('task_id',$data['task_id'])->first();
        if ($check){
            $dataBaseTask = $this->userEventLikeRepository->where('user_id',Auth::user()->id)->where('task_id',$data['task_id'])->delete();
            return $this->respondSuccess($dataBaseTask);
        }
        $data['user_id'] = Auth::user()->id;
        $dataBaseTask = $this->userEventLikeRepository->create($data);
        return $this->respondSuccess($dataBaseTask);
    }

    public function listLike(Request $request)
    {
        $input= Arr::except($request->all(), '__token');
        $data = $this->userEventLikeRepository->where('user_id',Auth::user()->id)
            ->join('tasks', 'tasks.id', '=', 'user_event_likes.task_id')
            ->orderBy('user_event_likes.created_at', 'desc')->paginate(20);
        return response()->json($data);

    }

    public function downloadTicket($id)
    {
        $task = Task::find($id);
//        return view('mails.send_ticket',['ticket'=> $task]);
        return (new Ticket($task))->downloadPdf();
    }
}
