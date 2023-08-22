<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\Event\{
    EventDiscords, EventSocial,
    TaskEvent, TaskEventDetail,
    TaskEventReward, EventUserTicket
};
use App\Models\Quiz\Quiz;
use App\Models\{Task, TaskGallery, TaskGroup, TaskGenerateLinks, TravelGame, Sponsor, SponsorDetail, UserSponsor};
use App\Services\Admin\{EventService, TaskService};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Log;

class EventController extends Controller
{
    public function __construct(
        private TaskEvent    $eventModel,
        private EventService $eventService,
        private TaskService  $taskService,
        private Task $task,
        private Sponsor $sponsor,
        private SponsorDetail $sponsorDetail,
        private UserSponsor $userSponsor,
        private TravelGame $travelGame,
        private TaskEventDetail $taskEventDetail,
        private EventUserTicket $eventUserTicket,
        private TaskGenerateLinks $eventShare,
    )
    {
        // code
    }

    /**
     * Display a listing of the resource.
     *
     */
    public function index(Request $request)
    {
        $limit = $request->get('limit') ?? PAGE_SIZE;
        $events = $this->taskService->search([
            'limit' => $limit,
            'type' => EVENT
        ]);

        foreach($events as $event) {
            if ($event->code == null || $event->code == '') {
                $event->update(['code' => genCodeTask()]);
            }
        }

        $tab = $request->get('tab') ?? 0;
        $data = [
            'events' => $events,
            'tab' => $tab,
        ];

        return view('cws.event.index', $data);
    }

    public function overview(Request $request, $id)
    {
        try {
            $event = $this->taskService->findEvent($id);
            $session = $this->eventModel
                ->whereType(TASK_SESSION)
                ->whereTaskId($event->id)
                ->first();
            $booth = $this->eventModel
                ->whereType(TASK_BOOTH)
                ->whereTaskId($event->id)
                ->first();
            if ($session && empty($session->code)) {
                $session->update(['code' => Str::random(20)]);
            }

            if ($booth && empty($booth->code)) {
                $booth->update(['code' => Str::random(20)]);
            }

            $shares = $this->eventShare
                ->whereTaskId($event->id)
                ->orderBy('created_at', 'desc')
                ->get();
        } catch (\Exception $e) {
            Log::error('Error');
        }

        return view('cws.event.overview', [
            'event' => $event,
            'session' => $session,
            'booth' => $booth,
            'shares' => $shares,
        ]);
    }

    public function sponsor(Request $request, $id)
    {
        try {
            $sponsor = $this->sponsor
                ->with(['sponsorDetails', 'userSponsors', 'task'])
                ->whereTaskId($id)
                ->first();
            if (!$sponsor) {
                abort(404);
            }

            $userSponsors = $this->userSponsor
                ->with('user', 'sponsor', 'task', 'sponsorDetail')
                ->where('sponsor_id', $sponsor->id)
                ->orderBy('created_at', 'desc')
                ->get();
        } catch (\Exception $e) {
            abort(404);
        }

        return view('cws.event.sponsor', [
            'sponsor' => $sponsor,
            'userSponsors' => $userSponsors
        ]);
    }

    public function genLink(Request $request)
    {
        try {
            $id = $request->input('id');
            $name = $request->input('name');
            $taskId = $request->input('task_id');
            if ($id) {
                $share = $this->eventShare->find($id);
                $share->update(['name' => $name]);

                notify()->success('Update link successfully');
            } else {
                $this->eventShare->create([
                    'task_id' => $taskId,
                    'name' => $name,
                    'type' => 0,
                    'url' => Str::random(10),
                ]);
                notify()->success('Create link successfully');
            }
        } catch (\Exception $e) {
            notify()->error('Error: '. $e->getMessage());

            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }

        return response()->json([
            'message' => 'OK'
        ], 200);
    }

    /*
     * template
     *
     */
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
        $dataView['travelGames'] = $this->travelGame->whereStatus(true)->get();

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

        //quizz
        if ($type == 3) {
            return response()->json([
                'code' => 200,
                'status' => 200,
                'html' => view('cws.event._template.item_quiz', $dataView)->render(),
                'message' => 'success',
            ], 200);
        }

        if ($type == 4) {
            return response()->json([
                'code' => 200,
                'status' => 200,
                'html' => view('cws.event._template.item_sponsor', $dataView)->render(),
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
        $task =  new TaskEvent();
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
        $sponsor = $this->sponsor->whereTaskId($id)->first();

        $taskEventDiscords = $task->taskEventDiscords;

        if ($taskEventDiscords == null) {
            $taskEventDiscords = new EventDiscords();
        }
        $taskEventSocials = $task->taskEventSocials;
        if ($taskEventSocials == null) {
            $taskEventSocials = new EventSocial();
        }
        if ($sessions == null) {
            $sessions = new TaskEvent();
            $sessions->type = 0;
        }
        if ($booths == null) {
            $booths = new TaskEvent();
            $booths->type = 1;
        }

        if (!$sponsor) {
            $sponsor = $this->sponsor;
        }

        $quiz = [];
        $image = [];
        $task['group_tasks'] = $taskGroup;
        $task['task_galleries'] = $image;
        $task['booths'] = $booths;
        $task['sessions'] = $sessions;
        $task['quiz'] = $quiz;
        $task['sponsor'] = $sponsor;

        $activeTab = $request->get('tab') ?? '0';
        //Is preview
        $isPreview = $request->get('preview') ?? '0';
        $travelGames = $this->travelGame->whereStatus(true)->get();

        $data = [
            'event' => $task,
            'sessions' => $sessions,
            'booths' => $booths,
            'quiz' => $quiz,
            'sponsor' => $sponsor,
            'taskEventSocials' => $taskEventSocials,
            'taskEventDiscords' => $taskEventDiscords,
            'group_tasks' => $taskGroup,
            'task_galleries' => $image,
            'total_file' => count($image),
            'activeTab' => $activeTab,
            'is_update' => 0,
            'isPreview' => $isPreview,
            'travelGames' => $travelGames,
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

        try {
            $inputAll = $request->all();
            $inputAll['type'] = 1;
            $request->validate(['name' => 'required']);

            //$company->fill($request->post())->save();
            $this->eventService->store($request);
            notify()->success('Create event successfully');
        } catch (\Exception $e) {
            notify()->error('Create event fail!' . $e->getMessage());
            Log::error('Create event cws: ' . $e->getMessage());
            return redirect()->route('cws.eventCreate');
        }

        return redirect()->route('cws.eventList');
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
        if (Str::contains($request->path(), 'event-preview')) {
            if (!$request->get('preview') == 1) {
                notify()->error('Không thể truy cập');
                return redirect()->route('cws.eventList');
            }
        }

        /** @var Task $task */
        $task = Task::with('taskSocials', 'taskLocations', 'taskEventSocials', 'taskGenerateLinks', 'taskEventDiscords')->find($id);

        $taskGroup = TaskGroup::where('task_id', $id)->pluck('group_id');
        $taskGallery = TaskGallery::where('task_id', $id)->pluck('url_image');
        $booths = TaskEvent::where('task_id', $id)->with('detail')->where('type', 1)->first();
        $sessions = TaskEvent::where('task_id', $id)->with('detail')->where('type', 0)->first();
        $sponsor = $this->sponsor->whereTaskId($id)->first();
        // dd($sponsor);

        $taskEventDiscords = $task->taskEventDiscords;
        if ($taskEventDiscords == null) {
            $taskEventDiscords = new EventDiscords();
            $taskEventDiscords->task_id = $id;
            $taskEventDiscords->save();
        }
        $taskEventSocials = $task->taskEventSocials;
        if ($taskEventSocials == null) {
            $taskEventSocials = new EventSocial();
            $taskEventSocials->task_id = $id;
            $taskEventSocials->save();
        }

        if ($sessions == null) {
            $sessions = new TaskEvent();
            $sessions->task_id = $id;
            $sessions->type = 0;
            $sessions->save();
        }

        if ($booths == null) {
            $booths = new TaskEvent();
            $booths->task_id = $id;
            $booths->type = 1;
            $booths->save();
        }

        if (!$sponsor) {
            $sponsor = new Sponsor();
            $sponsor->task_id = $id;
            $sponsor->save();
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
        $task['sponsor'] = $sponsor;

        $activeTab = $request->get('tab') ?? '0';
        //Is preview
        $isPreview = $request->get('preview') ?? '0';
        $travelGames = $this->travelGame->whereStatus(true)->get();

        $data = [
            'event' => $task,
            'sessions' => $sessions,
            'booths' => $booths,
            'quiz' => $quiz,
            'sponsor' => $sponsor,
            'taskEventSocials' => $taskEventSocials,
            'taskEventDiscords' => $taskEventDiscords,
            'group_tasks' => $taskGroup,
            'task_galleries' => $image,
            'total_file' => count($image),
            'activeTab' => $activeTab,
            'is_update' => 1,
            'isPreview' => $isPreview,
            'travelGames' => $travelGames
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
        try {
            $input = $request->all();
            $request->validate(['name' => 'required']);
            $this->eventService->store($request);
            notify()->success('Update successful!');
        } catch (\Exception $e) {
            notify()->error('Update fail!');
            Log::error('Update Event Cws: '. $e->getMessage());
            return redirect()->route('cws.eventList', ['tab' => 0]);
        }

        return redirect()->route('cws.eventList', ['tab' => 0]);
    }

    //preview
    public function preview(Request $request, $id)
    {
        //Preview Event
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Event $company
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Request $request)
    {
        try {
            $event = Task::findOrFail($id);
            $event->update(['status' => 99]);
            notify()->success('Delete event successfully!');
        } catch (\Exception $e) {
            notify()->error('Delete event fail');
            Log::error('Error delete event cws: ' . $e->getMessage());
            return redirect()->route('cws.eventList');
        }

        return redirect()->route('cws.eventList');
    }

    public function updateStatus(Request $request, $id)
    {
        try {
            $task = $this->task->find($id);
            if ($task) {
                $status = $task->status == true ? false : true;
                $task->update(['status' => $status]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 200);
        }

        return response()->json([
            'message' => 'ok'
        ], 200);
    }

    public function updateJob(Request $request, $id)
    {
        try {
            $taskEventId = $request->get('event_id');
            $detail = $this->taskEventDetail
                ->whereTaskEventId($taskEventId)
                ->whereCode($id)
                ->latest()
                ->first();

            if ($detail) {
                $status = $detail->status == true ? false : true;
                $detail->update(['status' => $status]);
            } else {
                return response()->json([
                    'message' => 'Not Found!'
                ], 404);
            }
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }

        return response()->json([
            'message' => 'OK'
        ], 200);
    }

    public function genCode(Request $request, $id)
    {
        try {
            $type = $request->get('type');
            $userId = $request->get('user_id');
            $info = $this->eventUserTicket
                ->where('task_id', $id)
                ->where('user_id', $userId)
                ->first();

            if($info) {
                $color = '#' . substr(md5(rand()), 0, 6);
                if($type == 'session') {
                    $max = $this->eventUserTicket->max('sesion_code') + 1;
                    $info->update([
                        'sesion_code' => $max,
                        'color_session' => $color
                    ]);
                } elseif ($type == 'booth') {
                    $max = $this->eventUserTicket->max('booth_code') + 1;
                    $info->update([
                        'booth_code' => $max,
                        'color_boot' => $color
                    ]);
                }
            }
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 500);
        }

        return response()->json([
            'message' => 'OK'
        ], 200);
    }
}
