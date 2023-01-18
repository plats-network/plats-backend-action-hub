<?php

namespace App\Services\Admin;

use App\Models\Event\TaskEventDetail;
use App\Models\Event\TaskEventReward;
use App\Repositories\EventRepository;
use App\Services\Concerns\BaseService;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class EventService extends BaseService
{
    protected $repository;

    public function __construct(
        EventRepository $eventRepository)
    {
        $this->repository = $eventRepository;
    }

    public function store($request)
    {
        if ($request->has('id') && $request->filled('id')) {
            return $this->update($request);
        }

        return $this->create($request);
    }

    public function update($request,$id)
    {
        DB::beginTransaction();

        try {
            $dataInsertEvent = $request->except(['details', 'rewards']);
            if ($request->hasFile('banner_url')) {
                $avatarFile = $request->file('banner_url');
                $path = 'event/banner/' . Carbon::now()->format('Ymd');
                $dataInsertEvent['banner_url'] = Storage::disk('s3')->putFileAs($path, $avatarFile, $avatarFile->hashName());
            }
            $data = $this->repository->update($dataInsertEvent,$id);
            $details = Arr::get($request->all(), 'details');
            $rewards = Arr::get($request->all(), 'rewards');
            if ($details) {
                TaskEventDetail::where('task_event_id',$id)->delete();
                foreach ($details as $item){
                    $data->taskEventDetail()->create($item);
                }
            }
            $taskId = Arr::get($request->all(), 'task_id');
            if ($taskId){
                if ($rewards) {
                    TaskEventReward::where('task_id',$taskId)->delete();
                    $rewards['task_id'] = $taskId;
                    $rewards['created_at'] = date("Y-m-d H:i:s");
                    $rewards['updated_at'] = date("Y-m-d H:i:s");
                    TaskEventReward::insert($rewards);
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
            $dataInsertEvent = $request->except(['details', 'rewards']);
            if ($request->hasFile('banner_url')) {
                $avatarFile = $request->file('banner_url');
                $path = 'event/banner/' . Carbon::now()->format('Ymd');
                $dataInsertEvent['banner_url'] = Storage::disk('s3')->putFileAs($path, $avatarFile, $avatarFile->hashName());
            }
            $data = $this->repository->create($dataInsertEvent);
            $details = Arr::get($request->all(), 'details');
            $rewards = Arr::get($request->all(), 'rewards');
            if ($details) {
                foreach ($details as $item){
                    $data->taskEventDetail()->create($item);
                }
            }
            if ($rewards) {
                $rewards['task_id'] = Arr::get($request->all(), 'task_id');
                $rewards['created_at'] = date("Y-m-d H:i:s");
                $rewards['updated_at'] = date("Y-m-d H:i:s");
                TaskEventReward::insert($rewards);
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
