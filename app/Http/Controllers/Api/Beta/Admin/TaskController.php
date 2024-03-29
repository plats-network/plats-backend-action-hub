<?php

namespace App\Http\Controllers\Api\Beta\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Beta\TaskRequest;
use App\Http\Resources\Api\Beta\Admin\TaskResource;
use App\Models\Event\TaskEvent;
use App\Models\Quiz\Quiz;
use App\Models\Task;
use App\Models\TaskGallery;
use App\Models\TaskGroup;
use App\Models\Url;
use App\Services\Admin\EventService;
use App\Services\Admin\TaskService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Admin\UploadController;
use App\Models\{NFT\NFT,
    TaskGenerateLinks,
    TravelGame,
    Sponsor,
    SponsorDetail,
    UserSponsor,
    User
};
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class TaskController extends Controller
{

    public function __construct(
        private EventService   $eventService,
        private UploadController $uploadController,
        private TaskService  $taskService,
    )
    {
        // code
    }

    public function update(Request $request,$taskId){

        $data = $request->only(['name','address','lat','lng','start_at','end_at','thumbnail','description','sessions','booths']);
        
        // Define the data to be validated and the validation rules separately
        $dataValidator = $data; // Assuming you want to validate all data fields

        // Set the value of 'id' field based on $taskId
        $dataValidator['id'] = $taskId ?? '';
        
        $requireValidator = [
            'id' => 'required|string|min:1|exists:tasks', // Ensure valid UUID format
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'lat' => 'nullable|string', // Validate as a number (decimal allowed)
            'lng' => 'nullable|string', // Validate as a number (decimal allowed)
            'start_at' => 'required|date_format:Y-m-d H:i', // Ensure valid datetime format, after now
            'end_at' => 'required|date_format:Y-m-d H:i', // Ensure valid datetime format, after start date
            'thumbnail' => 'nullable|array|filled',
            'thumbnail.path' => 'nullable|url', // Validate as a valid URL
            // ... other optional thumbnail fields (name, size, type, order, base_url)
            'description' => 'required|string',
            'sessions' => 'required|array|filled',
            'sessions.id' => 'required|uuid', // Ensure valid UUID format
            'sessions.task_id' => 'required|uuid', // Ensure valid UUID format
            'sessions.name' => 'required|string|max:255',
            'sessions.max_job' => 'required|integer|min:0', // Ensure non-negative integer
            'sessions.description' => 'required|string',
            'sessions.detail' => 'required|array|filled',
            'sessions.detail.*.id' => 'required|uuid', // Ensure valid UUID format
            'sessions.detail.*.is_delete' => 'required|boolean', // Validate as a boolean value
            'sessions.detail.*.travel_game_id' => 'nullable|uuid', // Ensure valid UUID format (if applicable)
            'sessions.detail.*.name' => 'required|string|max:255',
            'sessions.detail.*.description' => 'required|string',
            'sessions.detail.*.is_required' => 'required|boolean', // Validate as a boolean value
            // ... other optional sessions.detail.* fields (question, a1, a2, a3, a4)
            'booths' => 'required|array|filled',
            'booths.id' => 'required|uuid', // Ensure valid UUID format
            'booths.task_id' => 'required|uuid', // Ensure valid UUID format
            'booths.name' => 'required|string|max:255',
            'booths.max_job' => 'required|integer|min:0', // Ensure non-negative integer
            'booths.description' => 'required|string',
            'booths.detail' => 'required|array|filled',
            'booths.detail.*.id' => 'required|uuid', // Ensure valid UUID format
            'booths.detail.*.is_delete' => 'required|boolean', // Validate as a boolean value
            'booths.detail.*.travel_game_id' => 'nullable|uuid', // Ensure valid UUID format (if applicable)
            'booths.detail.*.name' => 'required|string|max:255',
            'booths.detail.*.description' => 'required|string',
            'booths.detail.*.is_question' => 'required|boolean', // Validate as a boolean value
        ];

        $messageValidator = [
            'id.exists'=>'task Id not exits',
            'id.required'=>'task Id required',
            'id.string'=>'task Id is string',
        ];

        $validator = Validator::make($dataValidator, $requireValidator,$messageValidator);

        // validate data
        if ($validator->fails()) {

            $error = $validator->messages()->first();

            return $this->responseApiError($error);
        }
        
        try {

            //cập nhật data vào service
            $this->eventService->update($data,$taskId);

            //trạng thái thành công
            return $this->responseApiSuccess($data);

        } catch (\Exception $e) {

            return $this->responseApiError($e->getMessage());
        }
    }

    public function delete($taskId){
     
        // Set the value of 'id' field based on $taskId
        $dataValidator['id'] = $taskId ?? '';
        
        $requireValidator = [
            'id' => 'required|string|min:1|exists:tasks', // Ensure valid UUID format
        ];
 
        $messageValidator = [
            'id.exists'=>'task Id not exits',
            'id.required'=>'task Id required',
            'id.string'=>'task Id is string',
        ];
 
        $validator = Validator::make($dataValidator, $requireValidator,$messageValidator);
 
        // validate data
        if ($validator->fails()) {
 
             $error = $validator->messages()->first();
 
             return $this->responseApiError($error);
        }
        
        try {

            $task = Task::findOrFail($taskId)->update(['status' => 0]);

            if(!$task){

                return $this->responseApiError('Data table task not exits');
            }

            //trạng thái thành công
            return $this->responseApiSuccess($task);

        } catch (\Exception $e) {

            return $this->responseApiError($e->getMessage());
        }

    }

    public function upload(Request $request){

        $validator = Validator::make($request->all(), [
            '_fileinput_w0' => 'file|mimes:jpeg,jpg,png|max:10240', // Allowed formats: jpeg, jpg, png, max size: 10MB
        ]);
 
        // validate data
        if ($validator->fails()) {
 
             $error = $validator->messages()->first();
 
             return $this->responseApiError($error);
        }

        try {
            
            $uploadSingle = $this->uploadController->uploadSingle($request);

            //trạng thái thành công
            return $this->responseApiSuccess($uploadSingle);

        } catch (\Exception $e) {

            return $this->responseApiError($e->getMessage());
        }

    }
    public function index(Request $request)
    {
        try {
            $limit = !empty($request->get('limit')) ? $request->get('limit') : PAGE_SIZE;
            $tasks = $this->taskService->search(['limit' => $limit, 'type' => EVENT]);
            $datas = TaskResource::collection($tasks);
            $pages = [
                'current_page' => (int)$request->get('page'),
                'last_page' => $tasks->lastPage(),
                'per_page' => (int)$limit,
                'total' => $tasks->total()
            ];
            return $this->responseApiSuccess([
                'list' => $datas,
                'paging' => $pages
            ]);
        } catch (\Exception $exception) {
            return $this->responseApiError([], $exception->getMessage());
        }
    }

    public function show(Request $request)
    {
        try {
            $id = $request->id;
            if (empty($id)) {
                return $this->responseApiError([], 'id is not required');
            }
            $task = Task::with('taskSocials', 'taskLocations', 'taskEventSocials', 'taskGenerateLinks', 'taskEventDiscords')->findOrFail($id);
            $taskGroup = TaskGroup::where('task_id', $id)->pluck('group_id');
            $taskGallery = TaskGallery::where('task_id', $id)->pluck('url_image');
            $booths = TaskEvent::where('task_id', $id)->with('detail')->where('type', 1)->first();
            $sessions = TaskEvent::where('task_id', $id)->with('detail')->where('type', 0)->first();
            $image = [];
            foreach ($taskGallery as $item) {
                $image[]['url'] = $item;
            }
            $urlAnswersFull = route('web.events.show', ['id' => $id, 'check_in' => true]);
            //Shorten url
            $urlAnswers = Url::shortenUrl($urlAnswersFull);
            $task['group_tasks'] = $taskGroup;
            $task['task_galleries'] = $image;
            $task['booths'] = $booths;
            $task['sessions'] = $sessions;
            $task['urlAnswers'] = $urlAnswers;
            return $this->responseApiSuccess($task);
        } catch (\Exception $exception) {
            return $this->responseApiError([], $exception->getMessage());
        }
    }

    public function store(TaskRequest $request)
    {
        try {
            $task = $this->eventService->store($request);
            return $this->responseApiSuccess($task);
        } catch (\Exception $exception) {
            return $this->responseApiError([], $exception->getMessage());
        }
    }
}
