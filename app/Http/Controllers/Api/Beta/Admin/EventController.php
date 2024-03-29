<?php

namespace App\Http\Controllers\Api\Beta\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event\TaskEventDetail;
use App\Models\Url;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EventController extends Controller
{
    public function __construct(
        private TaskEventDetail $taskEventDetail
    )
    {
    }

    public function updateJob(Request $request, $code)
    {
        if (empty($code)) {
            return $this->responseApiError([], 'Code not found.');
        }
        $params = $request->all();
        $validator = Validator::make($params, [
            "task_event_id" => "required",
            "type" => "required",
        ]);
        if ($validator->fails()) {
            return $this->responseApiError([], $validator->errors()->first());
        }
        try {
            $taskEventId = $params['task_event_id'];
            $detail = $this->taskEventDetail
                ->whereTaskEventId($taskEventId)
                ->whereCode($code)
                ->latest()
                ->first();
            if (empty($detail)) {
                return $this->responseApiError([], 'Not Found!');
            }
            if ($params['type'] == 'normal') {
                $status = $detail->status == true ? false : true;
                $detail->update(['status' => $status]);
            } else {
                $is_required = $detail->is_required == true ? false : true;
                $detail->update(['is_required' => $is_required]);
            }
            return $this->responseApiSuccess($detail);
        } catch (\Exception $exception) {
            return $this->responseApiError([], $exception->getMessage());
        }
    }

    public function updateJobSort(Request $request, $id)
    {
        if (empty($id)) {
            return $this->responseApiError([], 'Id not found.');
        }
        $params = $request->all();
        $validator = Validator::make($params, [
            "sort" => "required",
        ]);
        if ($validator->fails()) {
            return $this->responseApiError([], $validator->errors()->first());
        }
        try {
            $detail = $this->taskEventDetail->find($id);
            if (empty($detail)) {
                return $this->responseApiError([], 'Not Found!');
            }
            $detail->update(['sort' => $params['sort']]);
            return $this->responseApiSuccess($detail);

        } catch (\Exception $exception) {
            return $this->responseApiError([], $exception->getMessage());

        }
    }

    public function updateBoothDetail(Request $request)
    {
        $params = $request->all();
        $validator = Validator::make($params, [
            "id" => "required",
            "name" => "required",
        ]);
        if ($validator->fails()) {
            return $this->responseApiError([], $validator->errors()->first());
        }
        try {
            $id = $params['id'];
            $detail = $this->taskEventDetail->find($id);
            if (empty($detail)) {
                return $this->responseApiError([], 'Not Found!');
            }
            $detail->update([
                'name' => $params['name'],
                'description' => $params['description'] ?? '',
            ]);
            return $this->responseApiSuccess($detail);
        } catch (\Exception $e) {
            return $this->responseApiError([], $e->getMessage());
        }
    }

    public function createShortLink($code)
    {
        if (empty($code)) {
            return $this->responseApiError([], 'Code not found.');
        }
        try {
            $url = 'https://' . config('plats.event') . '/events/code?type=event&id=' . $code;
            $shortenUrl = Url::shortenUrl($url, 1);
            return $this->responseApiSuccess($shortenUrl);

        } catch (\Exception $e) {
            return $this->responseApiError([], $e->getMessage());
        }
    }

}
