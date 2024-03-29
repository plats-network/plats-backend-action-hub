<?php

namespace App\Http\Controllers\Api\Beta\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Services\Admin\{EventService, TaskService};
use App\Http\Controllers\Admin\UploadController;
use App\Models\{NFT\NFT,
    Task,
    TaskGallery,
    TaskGroup,
    TaskGenerateLinks,
    TravelGame,
    Sponsor,
    SponsorDetail,
    Url,
    UserSponsor,
    User
};
class TaskController extends Controller
{

    public function __construct(
        private EventService   $eventService,
        private UploadController $uploadController
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
}
