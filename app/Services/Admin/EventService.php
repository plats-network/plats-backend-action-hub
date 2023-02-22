<?php

namespace App\Services\Admin;

use App\Models\Event\TaskEvent;
use App\Models\Event\TaskEventDetail;
use App\Models\Event\TaskEventReward;
use App\Models\TaskGallery;
use App\Repositories\EventRepository;
use App\Repositories\TaskRepository;
use App\Services\Concerns\BaseService;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class EventService extends BaseService
{
    protected $repository;

    public function __construct(
        EventRepository $eventRepository,
        TaskRepository $taskRepository
    )
    {
        $this->repository = $eventRepository;
        $this->taskRepository = $taskRepository;
    }

    public function store($request)
    {
        if ($request->has('id') && $request->filled('id')) {
            return $this->update($request,$request->input('id'));
        }

        return $this->create($request);
    }

    public function update($request,$id)
    {
        DB::beginTransaction();

        try {
            $data = Arr::except($request->all(), '__token');
            $data['creator_id'] = Auth::user()->id;
            $dataBaseTask = $this->taskRepository->update($data,$id);
            TaskGallery::where('task_id',$id)->delete();
            if ($data['task_galleries']){
                foreach ($data['task_galleries'] as $uploadedFile){
                    $dataBaseTask->taskGalleries()->create( ['url_image' => empty($uploadedFile['url']) ? $uploadedFile :  $uploadedFile['url']]);
                }
            }
            $idTaskEvent = TaskEvent::where('task_id',$id)->first();
            TaskEventDetail::where('task_event_id',$idTaskEvent->id)->delete();
            TaskEvent::where('task_id',$id)->delete();
            $sessions = Arr::get($data, 'sessions');
            unset($sessions['id']);
            $idTaskEventSessions = $dataBaseTask->taskEvents()->create($sessions);
            if ($sessions['detail']){
                foreach ($sessions['detail'] as $item){
                    unset($item['id']);
                    $idTaskEventSessions->detail()->create($item);
                }
            }
            $booths = Arr::get($data, 'booths');
            unset($booths['id']);
            $idTaskEventBooths = $dataBaseTask->taskEvents()->create($booths);
            if ($booths['detail']){
                foreach ($booths['detail'] as $item1){
                    unset($item1['id']);
                    $idTaskEventBooths->detail()->create($item1);
                }
            }
            DB::commit();
        } catch (RuntimeException $exception) {
            DB::rollBack();
            throw $exception;
        } catch (Exception $exception) {
            DB::rollBack();
            throw new RuntimeException($exception->getMessage(), 500062, $exception->getMessage(), $exception);
        }
    }

    public function create($request)
    {
        DB::beginTransaction();

        try {
            $data = Arr::except($request->all(), '__token');
            $data['creator_id'] = Auth::user()->id;
            $dataBaseTask = $this->taskRepository->create($data);
            if ($data['task_galleries']){
                foreach ($data['task_galleries'] as $uploadedFile){
                    $dataBaseTask->taskGalleries()->create( ['url_image' => empty($uploadedFile['url']) ? $uploadedFile :  $uploadedFile['url']]);
                }
            }
            $sessions = Arr::get($data, 'sessions');
            $idTaskEventSessions = $dataBaseTask->taskEvents()->create($sessions);
            if ($sessions['detail']){
                foreach ($sessions['detail'] as $item){
                    $idTaskEventSessions->detail()->create($item);
                }
            }
            $booths = Arr::get($data, 'booths');
            $idTaskEventBooths = $dataBaseTask->taskEvents()->create($booths);
            if ($booths['detail']){
                foreach ($booths['detail'] as $item){
                    $idTaskEventBooths->detail()->create($item);
                }
            }

            DB::commit();
        } catch (RuntimeException $exception) {
            DB::rollBack();
            throw $exception;
        } catch (Exception $exception) {
            DB::rollBack();
            throw new RuntimeException($exception->getMessage(), 500062, $exception->getMessage(), $exception);
        }
    }
}
