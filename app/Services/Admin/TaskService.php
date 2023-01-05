<?php

namespace App\Services\Admin;

use App\Models\Task;
use App\Models\TaskGallery;
use App\Models\TaskGroup;
use App\Models\TaskLocation;
use App\Models\TaskLocationJob;
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
        $this->builder->with('taskLocations','taskSocials','taskGalleries');
        return $this->endFilter();
    }

    public function store($request)
    {
        if (!$request->filled('id')) {
            return $this->create($request);
        }

        return $this->update($request,$request->input('id'));
    }

    public function update(Request $request, $id)
    {
        $data = Arr::except($request->all(), '__token');
        $baseTask = Arr::get($data, 'base');
        DB::beginTransaction();
        try {
            if ($request->hasFile('image')) {
                $uploadedFile = $request->file('image');
                $path = 'task/image/banner' . Carbon::now()->format('Ymd');
                $baseTask['banner_url'] = Storage::disk('s3')->putFileAs($path, $uploadedFile, $uploadedFile->hashName());
            }
            $baseTask['creator_id'] = Auth::user()->id;
            $dataBaseTask = $this->repository->update($baseTask,$id);
            if ($request->hasFile('slider')) {
                TaskGallery::where('task_id',$id)->delete();
                $uploadedFiles = $request->file('slider');
                $path = 'task/image/banner' . Carbon::now()->format('Ymd');
                foreach ($uploadedFiles as $uploadedFile){
                    $imageGuides['url_image'] = Storage::disk('s3')->putFileAs($path, $uploadedFile, $uploadedFile->hashName());
                    $dataBaseTask->taskGalleries()->create($imageGuides);
                }
            }
            if ($baseTask['group_id']){
                TaskGroup::where('task_id',$id)->delete();
                $dataBaseTask->groupTasks()->attach($baseTask['group_id']);
            }
            $locations = Arr::get($data, 'locations');
            if ($locations){
                TaskLocation::where('task_id',$id)->delete();
                foreach ($locations as $location){
                    $idTaskLocation = $dataBaseTask->taskLocations()->create($location);
                    if ($location['detail']){
                        foreach ($location['detail'] as $item){
                            $idTaskLocation->taskLocationJob()->create($item);
                        }
                    }
                }
            }
            $socials = Arr::get($data, 'social');
            if ($socials){
                $dataBaseTask->taskSocials()->delete();
                $dataBaseTask->taskSocials()->createMany($socials);
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

    public function create(Request $request)
    {
        $data = Arr::except($request->all(), '__token');
        $baseTask = Arr::get($data, 'base');
        DB::beginTransaction();
        try {
            if ($request->hasFile('image')) {
                $uploadedFile = $request->file('image');
                $path = 'task/image/banner' . Carbon::now()->format('Ymd');
                $baseTask['banner_url'] = Storage::disk('s3')->putFileAs($path, $uploadedFile, $uploadedFile->hashName());
            }
            $baseTask['creator_id'] = Auth::user()->id;
            $dataBaseTask = $this->repository->create($baseTask);
            if ($request->hasFile('slider')) {
                $uploadedFiles = $request->file('slider');
                $path = 'task/image/banner' . Carbon::now()->format('Ymd');
                foreach ($uploadedFiles as $uploadedFile){
                    $imageGuides['url_image'] = Storage::disk('s3')->putFileAs($path, $uploadedFile, $uploadedFile->hashName());
                    $dataBaseTask->taskGalleries()->create($imageGuides);
                }
            }
            if ($baseTask['group_id']){
                $dataBaseTask->groupTasks()->attach($baseTask['group_id']);
            }
            $locations = Arr::get($data, 'locations');
            if ($locations){
                foreach ($locations as $location){
                    $idTaskLocation = $dataBaseTask->taskLocations()->create($location);
                    if ($location['detail']){
                        foreach ($location['detail'] as $item){
                            $idTaskLocation->taskLocationJob()->create($item);
                        }
                    }
                }
            }
            $socials = Arr::get($data, 'social');
            if ($socials){
                $dataBaseTask->taskSocials()->createMany($socials);
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
