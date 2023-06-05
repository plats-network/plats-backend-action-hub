<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
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
        private TaskEvent   $eventModel,
        private EventService $eventService,
        private TaskService $taskService
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
        $data = [
            'events' => $events,
        ];

        return view('cws.event.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('companies.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'address' => 'required',
        ]);

        Event::create($request->post());

        return redirect()->route('companies.index')->with('success','Event has been created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\company  $company
     * @return \Illuminate\Http\Response
     */
    public function show(Event $company)
    {
        return view('companies.show',compact('company'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     */
    public function edit(Request $request, $id)
    {
        $task = Task::with( 'taskSocials', 'taskLocations','taskEventSocials','taskGenerateLinks','taskEventDiscords')->find($id);
        $taskGroup = TaskGroup::where('task_id',$id)->pluck('group_id');
        $taskGallery = TaskGallery::where('task_id',$id)->pluck('url_image');
        $booths = TaskEvent::where('task_id',$id)->with('detail')->where('type',1)->first();
        $sessions = TaskEvent::where('task_id',$id)->with('detail')->where('type',0)->first();
        $quiz = Quiz::where('task_id',$id)->with('detail')->get();
        foreach ($quiz as  $value){
            foreach ($value['detail'] as $key => $value){
                $value['key'] = $key;
            }
        }
        $image = [];
        foreach ($taskGallery as $item){
            $image[]['url'] = $item;
        }
        $task['group_tasks'] = $taskGroup;
        $task['task_galleries'] = $image;
        $task['booths'] = $booths;
        $task['sessions'] = $sessions;
        $task['quiz'] = $quiz;
        //dd($task);

        $activeTab = $request->get('tab') ?? '0';

        $data = [
            'event' => $task,
            'activeTab' => $activeTab,
        ];
        return view('cws.event.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\company  $company
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Event $company)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'address' => 'required',
        ]);

        $company->fill($request->post())->save();

        return redirect()->route('companies.index')->with('success','Event Has Been updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Event  $company
     * @return \Illuminate\Http\Response
     */
    public function destroy(Event $company)
    {
        $company->delete();
        return redirect()->route('companies.index')->with('success','Event has been deleted successfully');
    }
}
