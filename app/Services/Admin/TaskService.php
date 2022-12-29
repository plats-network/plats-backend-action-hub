<?php

namespace App\Services\Admin;

use App\Repositories\TaskLocationRepository;
use App\Repositories\TaskRepository;
use App\Repositories\TaskRewardsRepository;
use App\Services\Concerns\BaseService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class TaskService extends BaseService
{
    protected $repository;

    public function __construct(
        TaskRepository $taskRepository,
    )
    {
        $this->repository = $taskRepository;
    }

    public function search($conditions = [])
    {
        $this->makeBuilder($conditions);

        if ($this->filter->has('status')) {
            $this->builder->where(function ($q) {
                $q->where('status',$this->filter->get('status'));
            });
            // Remove condition after apply query builder
            $this->cleanFilterBuilder('status');
        }
        if ($this->filter->has('type')) {
            $this->builder->where(function ($q) {
                $q->where('type',$this->filter->get('type'));
            });
            // Remove condition after apply query builder
            $this->cleanFilterBuilder('type');
        }
        if ($this->filter->has('creator_id')) {
            $this->builder->where(function ($q) {
                $q->where('creator_id',$this->filter->get('creator_id'));
            });
            // Remove condition after apply query builder
            $this->cleanFilterBuilder('creator_id');
        }
        if ($this->filter->has('name')) {
            $this->builder->where(function ($q) {
                $q->where('name', 'LIKE', '%' . $this->filter->get('name') . '%');
            });

            // Remove condition after apply query builder
            $this->cleanFilterBuilder('name');
        }
        $this->builder->with('taskRewards','taskLocation','taskSocial','taskGalleries');
        return $this->endFilter();
    }

    public function store($request)
    {
        if (!$request->filled('id')) {
            return $this->create($request);
        }

        return $this->update($request);
    }

    public function update(Request $request)
    {

    }

    public function create(Request $request)
    {
        $data = Arr::except($request->all(), '__token');
        $baseTask = Arr::get($data, 'base');
        DB::beginTransaction();
        try {
            if ($request->hasFile('image')) {
                $uploadedFile = $request->file('image');
                $path = 'task/image/banner' . Carbon::now()->format('Ymd');
                $baseTask['image'] = Storage::disk('s3')->putFileAs($path, $uploadedFile, $uploadedFile->hashName());
            }
            $baseTask['creator_id'] = Auth::user()->id;
            $dataBaseTask = $this->repository->create($baseTask);
            if ($request->hasFile('slider')) {
                $uploadedFiles = $request->file('slider');
                $path = 'task/image/banner' . Carbon::now()->format('Ymd');
                foreach ($uploadedFiles as $uploadedFile){
                    $imageGuides['url'] = Storage::disk('s3')->putFileAs($path, $uploadedFile, $uploadedFile->hashName());
                    $dataBaseTask->taskGalleries()->create($imageGuides);
                }
            }
//            $reward = Arr::get($data, 'reward');
//            if ($reward){
//                $dataBaseTask->taskRewards()->create($reward);
//            }
            $locations = Arr::get($data, 'locations');
            if ($locations){
                $dataBaseTask->taskLocation()->createMany($locations);
            }
            $socials = Arr::get($data, 'social');
            if ($socials){
                $dataBaseTask->taskSocial()->createMany($socials);
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
