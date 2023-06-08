<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event\EventDiscords;
use App\Models\Event\EventSocial;
use App\Models\Event\TaskEvent;
use App\Models\Event\TaskEvent as Event;
use App\Models\Quiz\Quiz;
use App\Models\Task;
use App\Models\TaskGallery;
use App\Models\TaskGroup;
use App\Services\Admin\EventService;
use App\Services\Admin\TaskService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    public function __construct(
        private TaskEvent    $eventModel,
        private EventService $eventService,
        private TaskService  $taskService
    )
    {
    }

    /**
     * Display a listing of the resource.
     *
     */
    public function index(Request $request)
    {
        //$events = Event::orderBy('id','desc')->paginate(5);
        $limit = $request->get('limit') ?? PAGE_SIZE;
        $user = Auth::user();
        if ($user->role == ADMIN_ROLE) {
            $events = $this->taskService->search(['limit' => $limit]);
        } else {
            $events = $this->taskService->search(['limit' => $limit]);
        }

        //tab
        $tab = $request->get('tab') ?? 0;
        $data = [
            'events' => $events,
            'tab' => $tab,
        ];

        return view('cws.event.index', $data);
    }

    /*
     * template
     * */
    public function template(Request $request, $id = '')
    {
        $index = $request->get('index');
        $type = $request->get('type', 1);
        $getInc = $request->get('inc', 1);
        if (empty($id)) {
            $id = $request->get('flag_check');
        }

        $dataView['type'] = $type;
        $dataView['indexImageItem'] = $id;
        $dataView['getInc'] = $getInc + 1;

        if ($type == 1) {
            return response()->json([
                'code' => 200,
                'status' => 200,
                'html' => view('cws.event._template.item_session', $dataView)->render(),
                'message' => 'success',
            ], 200);
        }
        if ($type == 2) {
            return response()->json([
                'code' => 200,
                'status' => 200,
                'html' => view('cws.event._template.item_booth', $dataView)->render(),
                'message' => 'success',
            ], 200);
        }

        if ($type == 3) {
            return response()->json([
                'code' => 200,
                'status' => 200,
                'html' => view('cws.event._template.item_quiz', $dataView)->render(),
                'message' => 'success',
            ], 200);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        /** @var Task $task */
        $task =  new Event();
        $isCopyModel = $request->get('copy', null);
        if ($isCopyModel) {
            $post_id = $request->get('id', 0);
            $modelClone = Task::with('taskSocials', 'taskLocations', 'taskEventSocials', 'taskGenerateLinks', 'taskEventDiscords')->find($post_id);
            //Clone data
            if ($modelClone) {
                $task = $modelClone->replicate();

            }
        }
        $id = $task->id;

        $taskGroup = TaskGroup::where('task_id', $id)->pluck('group_id');
        $taskGallery = TaskGallery::where('task_id', $id)->pluck('url_image');

        $booths = TaskEvent::where('task_id', $id)->with('detail')->where('type', 1)->first();

        $sessions = TaskEvent::where('task_id', $id)->with('detail')->where('type', 0)->first();
        //taskEventDiscords EventDiscords
        /** @var EventDiscords $taskEventDiscords */
        $taskEventDiscords = $task->taskEventDiscords;
        //Check if $taskEventDiscords is null then create new EventDiscords
        if ($taskEventDiscords == null) {

            $taskEventDiscords = new EventDiscords();
            //$taskEventDiscords->task_id = $id;
            //$taskEventDiscords->save();
        }
        //taskEventSocials EventSocial
        /** @var EventSocial $taskEventSocials */
        $taskEventSocials = $task->taskEventSocials;
        //Check if $taskEventSocials is null then create new EventSocial
        if ($taskEventSocials == null) {
            $taskEventSocials = new EventSocial();
            //$taskEventSocials->task_id = $id;
            //$taskEventSocials->save();
        }


        //Check if $sessions is null then create new
        if ($sessions == null) {
            $sessions = new TaskEvent();
            //$sessions->task_id = $id;
            $sessions->type = 0;
            //$sessions->save();
        }


        //Check if $booths is null then create new
        if ($booths == null) {
            $booths = new TaskEvent();
            //$booths->task_id = $id;
            $booths->type = 1;

            //$booths->save();
        }

        $quiz = [];

        /*foreach ($quiz as $value) {
            foreach ($value['detail'] as $key => $value) {
                $value['key'] = $key;
            }
        }*/
        $image = [];
        /*foreach ($taskGallery as $item) {
            $image[]['url'] = $item;
        }*/
        $task['group_tasks'] = $taskGroup;
        $task['task_galleries'] = $image;
        $task['booths'] = $booths;
        $task['sessions'] = $sessions;
        $task['quiz'] = $quiz;
        //dd($task);

        //dd($sessions);
        //dd($sessions);
        $activeTab = $request->get('tab') ?? '0';

        $data = [
            'event' => $task,
            'sessions' => $sessions,
            'booths' => $booths,
            'quiz' => $quiz,
            'taskEventSocials' => $taskEventSocials,
            'taskEventDiscords' => $taskEventDiscords,
            'group_tasks' => $taskGroup,
            'task_galleries' => $image,
            'total_file' => count($image),
            'activeTab' => $activeTab,
            'is_update' => 0,
        ];

        return view('cws.event.edit', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $inputAll = $request->all();
        //dd($inputAll);
        /*
         * "id" => "99583545-472e-4710-8258-24b8b2b33110"
    "task_id" => "c519af43-1349-46bb-ab52-de6b53981d8c"
         * */

        $request->validate([
            'name' => 'required',
            //'email' => 'required',
            //'address' => 'required',
        ]);

        //$company->fill($request->post())->save();
        $this->eventService->store($request);

        return redirect()->route('cws.eventList')->with('success', 'Event has been created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param \App\company $company
     * @return \Illuminate\Http\Response
     */
    public function show(Event $company)
    {
        return view('companies.show', compact('company'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     */
    public function edit(Request $request, $id)
    {
        /** @var Task $task */
        $task = Task::with('taskSocials', 'taskLocations', 'taskEventSocials', 'taskGenerateLinks', 'taskEventDiscords')->find($id);
        $taskGroup = TaskGroup::where('task_id', $id)->pluck('group_id');
        $taskGallery = TaskGallery::where('task_id', $id)->pluck('url_image');

        $booths = TaskEvent::where('task_id', $id)->with('detail')->where('type', 1)->first();

        $sessions = TaskEvent::where('task_id', $id)->with('detail')->where('type', 0)->first();
        //taskEventDiscords EventDiscords
        /** @var EventDiscords $taskEventDiscords */
        $taskEventDiscords = $task->taskEventDiscords;
        //Check if $taskEventDiscords is null then create new EventDiscords
        if ($taskEventDiscords == null) {

            $taskEventDiscords = new EventDiscords();
            $taskEventDiscords->task_id = $id;
            $taskEventDiscords->save();
        }
        //taskEventSocials EventSocial
        /** @var EventSocial $taskEventSocials */
        $taskEventSocials = $task->taskEventSocials;
        //Check if $taskEventSocials is null then create new EventSocial
        if ($taskEventSocials == null) {
            $taskEventSocials = new EventSocial();
            $taskEventSocials->task_id = $id;
            $taskEventSocials->save();
        }


        //Check if $sessions is null then create new
        if ($sessions == null) {
            $sessions = new TaskEvent();
            $sessions->task_id = $id;
            $sessions->type = 0;
            $sessions->save();
        }


        //Check if $booths is null then create new
        if ($booths == null) {
            $booths = new TaskEvent();
            $booths->task_id = $id;
            $booths->type = 1;

            $booths->save();
        }

        $quiz = Quiz::where('task_id', $id)->with('detail')->get();

        foreach ($quiz as $value) {
            foreach ($value['detail'] as $key => $value) {
                $value['key'] = $key;
            }
        }
        $image = [];
        foreach ($taskGallery as $item) {
            $image[]['url'] = $item;
        }
        $task['group_tasks'] = $taskGroup;
        $task['task_galleries'] = $image;
        $task['booths'] = $booths;
        $task['sessions'] = $sessions;
        $task['quiz'] = $quiz;
        //dd($task);

        //dd($sessions);
        //dd($sessions);
        $activeTab = $request->get('tab') ?? '0';

        $data = [
            'event' => $task,
            'sessions' => $sessions,
            'booths' => $booths,
            'quiz' => $quiz,
            'taskEventSocials' => $taskEventSocials,
            'taskEventDiscords' => $taskEventDiscords,
            'group_tasks' => $taskGroup,
            'task_galleries' => $image,
            'total_file' => count($image),
            'activeTab' => $activeTab,
            'is_update' => 1,
        ];
        return view('cws.event.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\company $company
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Event $company)
    {

        $input = $request->all();

        /*
         * "id" => "99583545-472e-4710-8258-24b8b2b33110"
    "task_id" => "c519af43-1349-46bb-ab52-de6b53981d8c"
         * */

        $request->validate([
            'name' => 'required',
            //'email' => 'required',
            //'address' => 'required',
        ]);


        //dd($input);
        //$company->fill($request->post())->save();
        $this->eventService->store($request);

        return redirect()->route('cws.eventList', ['tab' => 0])->with('success', 'Event Has Been updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Event $company
     * @return \Illuminate\Http\Response
     */
    public function destroy(Event $company)
    {
        $company->delete();
        return redirect()->route('cws.eventList')->with('success', 'Event has been deleted successfully');
    }
}
