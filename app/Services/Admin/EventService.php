<?php

namespace App\Services\Admin;

use App\Models\Event\TaskEvent;
use App\Models\Event\TaskEventDetail;
use App\Models\Event\TaskEventReward;
use App\Models\Quiz\Quiz;
use App\Models\Quiz\QuizAnswer;
use App\Models\TaskGallery;
use App\Models\TaskGenerateLinks;
use App\Repositories\EventRepository;
use App\Repositories\TaskRepository;
use App\Services\Concerns\BaseService;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

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
            $data['slug'] = $request->input('name');
            $data['status'] = true;
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
            $quiz = Arr::get($data, 'quiz');
            $idQuizDetail = Quiz::where('task_id',$id)->first();
            if ($idQuizDetail){
                QuizAnswer::where('quiz_id',$idQuizDetail->id)->delete();
            }
            Quiz::where('task_id',$id)->delete();
            if ($quiz){
                foreach ($quiz as $item){
                    unset($item['id']);
                    $idQuiz = $dataBaseTask->quizs()->create($item);
                    if ($item['detail']){
                        foreach ($item['detail'] as $itemDetail){
                            unset($itemDetail['id']);
                            $idQuiz->detail()->create($itemDetail);
                        }
                    }
                }
            }
            TaskGenerateLinks::where('task_id',$id)->delete();
            $generateNumber = $dataBaseTask->taskGenerateLinks()->createMany($this->generateNumber($dataBaseTask->slug));
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
            $data['status'] = true;
            $data['slug'] = $request->input('name');
            $data['max_job'] = 0;
            $dataBaseTask = $this->taskRepository->create($data);
            if ($data['task_galleries']){
                foreach ($data['task_galleries'] as $uploadedFile){
                    $dataBaseTask->taskGalleries()->create( ['url_image' => empty($uploadedFile['url']) ? $uploadedFile :  $uploadedFile['url']]);
                }
            }
            $quiz = Arr::get($data, 'quiz');
            if ($quiz){
                foreach ($quiz as $item){
                    $idQuiz = $dataBaseTask->quizs()->create($item);
                    if ($item['detail']){
                        foreach ($item['detail'] as $itemDetail){
                            $idQuiz->detail()->create($itemDetail);
                        }
                    }
                }
            }
            $sessions = Arr::get($data, 'sessions');
            if ($sessions){
                $idTaskEventSessions = $dataBaseTask->taskEvents()->create($sessions);
                if ($sessions['detail']){
                    foreach ($sessions['detail'] as $item){
                        $idTaskEventSessions->detail()->create($item);
                    }
                }
            }
            $booths = Arr::get($data, 'booths');
            if ($booths){
                $idTaskEventBooths = $dataBaseTask->taskEvents()->create($booths);
                if ($booths['detail']){
                    foreach ($booths['detail'] as $item){
                        $idTaskEventBooths->detail()->create($item);
                    }
                }
            }
            $generateNumber = $dataBaseTask->taskGenerateLinks()->createMany($this->generateNumber($dataBaseTask->slug));
            DB::commit();
        } catch (RuntimeException $exception) {
            DB::rollBack();
            throw $exception;
        } catch (Exception $exception) {
            DB::rollBack();
            throw new RuntimeException($exception->getMessage(), 500062, $exception->getMessage(), $exception);
        }
    }
    public function generateNumber($slug)
    {
        $type = [
            'facebook',
            'twitter',
            'telegram',
            'discord',
            'form',
        ];
        $dataLinkGenerate = [];
        foreach ($type as $key => $item) {
            $dataLinkGenerate[] = [
                'name' => 'Link share '.$item,
                'type' => $key,
                'url' => config('app.link_share').'/events/'.$slug.'?'.$item.'=' . Str::random(32),
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ];
        }

        return $dataLinkGenerate;
    }
}
