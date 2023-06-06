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
            $dataBaseTask = $this->taskRepository->update($data,$id);
            TaskGallery::where('task_id',$id)->delete();
            if (isset($data['task_galleries'])){
                foreach ($data['task_galleries'] as $uploadedFile){
                    $dataBaseTask->taskGalleries()->create( ['url_image' => empty($uploadedFile['url']) ? $uploadedFile :  $uploadedFile['url']]);
                }
            }

            $sessions = Arr::get($data, 'sessions');
            if ($sessions){
                if (empty($sessions['id'])){
                    $sessions['code'] = Str::random(35);
                    $idTaskEventSessions = $dataBaseTask->taskEvents()->create($sessions);
                    if (isset($sessions['detail'])){
                        foreach ($sessions['detail'] as $key => $item){
                            $item['code'] = $this->generateBarcodeNumber().$key;
                            $idTaskEventSessions->detail()->create($item);
                        }
                    }
                }else{
                    $sessionsUn = Arr::get($data, 'sessions');
                    unset($sessionsUn['detail']);
                    unset($sessionsUn['id']);
                    TaskEvent::where('id',$sessions['id'])->update($sessionsUn);
                    if (isset($sessions['detail'])){
                        foreach ($sessions['detail'] as $key => $item){
                            if (empty($item['id'])){
                                $item['code'] = $this->generateBarcodeNumber().$key;
                                $item['task_event_id'] = $sessions['id'];
                                TaskEventDetail::create($item);
                            }else{
                                $itemUn = $item;
                                unset($itemUn['id']);
                                TaskEventDetail::where('id',$item['id'])->update($itemUn);
                            }
                        }
                    }
                }
            }
            $booths = Arr::get($data, 'booths');
            if ($booths){
                if (empty($booths['id'])){
                    $booths['code'] = Str::random(35);
                    $idTaskEventBooths = $dataBaseTask->taskEvents()->create($booths);
                    if (isset($booths['detail'])){
                        foreach ($booths['detail'] as $key => $item){
                            $item['code'] = $this->generateBarcodeNumber().$key;
                            $idTaskEventBooths->detail()->create($item);
                        }
                    }
                }else{
                    $boothsUn = Arr::get($data, 'booths');
                    unset($boothsUn['detail']);
                    unset($boothsUn['id']);
                    TaskEvent::where('id',$booths['id'])->update($boothsUn);
                    if (isset($booths['detail'])){
                        foreach ($booths['detail'] as $key => $item){
                            if (empty($item['id'])){
                                $item['code'] = $this->generateBarcodeNumber().$key;
                                $item['task_event_id'] = $booths['id'];
                                TaskEventDetail::create($item);
                            }else{
                                $itemUn = $item;
                                unset($itemUn['id']);
                                TaskEventDetail::where('id',$item['id'])->update($itemUn);
                            }
                        }
                    }
                }
            }
            $quiz = Arr::get($data, 'quiz');
            if ($quiz){
                foreach ($quiz as &$item){
                    $quizUn = $item;
                    unset($quizUn['detail']);
                    if (empty($item['id'])){
                        $item['task_id'] = $id;
                        $idQ = Quiz::create($item);
                        if ($item['detail']){
                            foreach ($item['detail'] as $itemDetail){
                                unset($itemDetail['key']);
                                if (empty($itemDetail['id'])){
                                    $itemDetail['quiz_id'] =$idQ->id ;
                                    QuizAnswer::create($itemDetail);
                                }else{
                                    $itemAUn = $itemDetail;
                                    unset($itemAUn['id']);
                                    QuizAnswer::where('id',$itemDetail['id'])->update($itemAUn);
                                }
                            }
                        }
                    }else{
                        unset($quizUn['id']);
                        Quiz::where('id',$item['id'])->update($quizUn);
                        if ($item['detail']){
                            foreach ($item['detail'] as $itemDetail){
                                unset($itemDetail['key']);
                                if (empty($itemDetail['id'])){
                                    $itemDetail['quiz_id'] =$item['id'] ;
                                    QuizAnswer::create($itemDetail);
                                }else{
                                    $itemAUn = $itemDetail;
                                    unset($itemAUn['id']);
                                    QuizAnswer::where('id',$itemDetail['id'])->update($itemAUn);
                                }
                            }
                        }
                    }
                }
            }
            $social = Arr::get($data, 'task_event_socials');
            if ($social){
                if (empty($social['id'])){
                    $dataBaseTask->taskEventSocials()->create($social);
                }else{
                    $socialUn = Arr::get($data, 'task_event_socials');
                    unset($socialUn['id']);
                    $dataBaseTask->taskEventSocials()->update($socialUn,$social['id']);
                }
            }
            $discords = Arr::get($data, 'task_event_discords');
            if ($discords){
                if (empty($discords['id'])){
                    $dataBaseTask->taskEventDiscords()->create($discords);

                }else{
                    $discordsUn = Arr::get($data, 'task_event_discords');
                    unset($discordsUn['id']);
                    $dataBaseTask->taskEventDiscords()->update($discordsUn,$discords['id']);
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
            // $data['code'] = Str::random(35);
            $dataBaseTask = $this->taskRepository->create($data);
            if (isset($data['task_galleries'])){
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
                $sessions['code'] = Str::random(35);
                $idTaskEventSessions = $dataBaseTask->taskEvents()->create($sessions);
                if ($sessions['detail']){
                    foreach ($sessions['detail'] as $key => $item){
                        $item['code'] = $this->generateBarcodeNumber().$key;
                        $idTaskEventSessions->detail()->create($item);
                    }
                }
            }
            $booths = Arr::get($data, 'booths');
            if ($booths){
                $booths['code'] = Str::random(35);
                $idTaskEventBooths = $dataBaseTask->taskEvents()->create($booths);
                if ($booths['detail']){
                    foreach ($booths['detail'] as $key => $item){
                        $item['code'] = $this->generateBarcodeNumber().$key;
                        $idTaskEventBooths->detail()->create($item);
                    }
                }
            }
            $social = Arr::get($data, 'task_event_socials');
            if ($social){
                $dataBaseTask->taskEventSocials()->create($social);
            }
            $discords = Arr::get($data, 'task_event_discords');
            if ($discords){
                $dataBaseTask->taskEventDiscords()->create($discords);

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

    public function generateBarcodeNumber() {
        $number = mt_rand(10000000, 99999999);
        return $number;
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
                'url' => config('app.link_event').'/events/' . $slug . '?' . $item . '=' . Str::random(32),
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ];
        }

        return $dataLinkGenerate;
    }

    public function changeStatus($status,$id)
    {
        $data = [
            'status' => $status
        ];
        try {
            $dataBaseTask = $this->taskRepository->update($data,$id);
        } catch (RuntimeException $exception) {
            DB::rollBack();
            throw $exception;
        } catch (Exception $exception) {
            DB::rollBack();
            throw new RuntimeException($exception->getMessage(), 500062, $exception->getMessage(), $exception);
        }
    }
}
