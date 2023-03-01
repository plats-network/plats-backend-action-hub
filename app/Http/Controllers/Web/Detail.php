<?php

namespace App\Http\Controllers\Web;

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
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class Detail extends Controller
{
    public function __construct(
        EventUserTicketRepository $eventUserTicketRepository,
        UserEventLikeRepository $eventLikeRepository
    )
    {
//        $this->middleware('client_web');
        $this->repository = $eventUserTicketRepository;
        $this->userEventLikeRepository = $eventLikeRepository;
    }

    public function index(Request $request)
    {
        $getIdTask = Task::where('slug',Route::current()->slug)->first();
        return view('web.detail',['id' => $getIdTask->id]);
    }

    public function addTicket(AddTicketRequest $request)
    {
        $data = Arr::except($request->all(), '__token');
        if (empty(Auth::user()->id)){
            $data['user_id'] = null;
            $data['type'] = 1;
        }else{
            $data['user_id'] = Auth::user()->id;
            $data['type'] = 0;
        }
        $dataBaseTask = $this->repository->create($data);
        return $this->respondSuccess($dataBaseTask);

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
}
