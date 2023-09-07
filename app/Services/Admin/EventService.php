<?php

namespace App\Services\Admin;

use App\Models\Event\{TaskEvent, TaskEventDetail, TaskEventReward};
use App\Models\Quiz\{QuizAnswer, Quiz};
use App\Models\{TaskGallery, TaskGenerateLinks, Sponsor, SponsorDetail};
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
            return $this->update($request, $request->input('id'));
        }

        return $this->create($request);
    }

    public function update($request, $id)
    {
        DB::beginTransaction();

        try {
            $data = Arr::except($request->all(), '_token');

            $sessions = Arr::get($data, 'sessions');
            $booths = Arr::get($data, 'booths');
            $quiz = Arr::get($data, 'quiz');
            $social = Arr::get($data, 'task_event_socials');
            $discords = Arr::get($data, 'task_event_discords');
            $sponsors = Arr::get($data, 'sponsor');
            $data['banner_url'] = isset($data['thumbnail']) ? $data['thumbnail']['path'] : '';
            $dataBaseTask = $this->taskRepository->update($data, $id);

            // Update Session
            if ($sessions && !empty($sessions['name'])) {
                $this->saveSession($dataBaseTask, $sessions);
            }

            // Booth
            if ($booths && !empty($booths['name'])){
                $this->saveBooth($dataBaseTask, $booths);
            }
            
            // Update Quiz
            if ($quiz){
                $this->saveQuiz($dataBaseTask, $quiz);
            }

            // Save Sponsor
            if ($sponsors) {
                $this->saveSponsor($dataBaseTask, $sponsors);
            }
            
            // Update Social
            if ($social){
                if (empty($social['id'])){
                    $dataBaseTask->taskEventSocials()->create($social);
                } else {
                    $socialUn = Arr::get($data, 'task_event_socials');
                    unset($socialUn['id']);
                    $dataBaseTask->taskEventSocials()->update($socialUn,$social['id']);
                }
            }
            
            // Update discords
            if ($discords){
                if (empty($discords['id'])){
                    $dataBaseTask->taskEventDiscords()->create($discords);

                }else{
                    $discordsUn = Arr::get($data, 'task_event_discords');
                    unset($discordsUn['id']);
                    $dataBaseTask->taskEventDiscords()->update($discordsUn, $discords['id']);
                }
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
        }
    }

    public function create($request)
    {
        DB::beginTransaction();

        try {
            $data = Arr::except($request->all(), '__token');
            $sessions = Arr::get($data, 'sessions');
            $quiz = Arr::get($data, 'quiz');
            $booths = Arr::get($data, 'booths');
            $social = Arr::get($data, 'task_event_socials');
            $discords = Arr::get($data, 'task_event_discords');
            $sponsors = Arr::get($data, 'sponsor');

            $data['banner_url'] =  isset($data['thumbnail']) ? $data['thumbnail']['path'] : '';
            $data['creator_id'] = Auth::user()->id;
            $data['status'] = 0;
            $data['slug'] = $request->input('name');
            $data['max_job'] = 0;
            $data['type'] = EVENT;
            $data['code'] = genCodeTask();
            $data['order'] = $data['order'] ?? 1;
            $data['reward'] = $data['reward'] ?? 0;
            $dataBaseTask = $this->taskRepository->create($data);

            // Save session
            if ($sessions && !empty($sessions['name'])){
                unset($sessions['id']);
                $this->saveSession($dataBaseTask, $sessions);
            }
            
            // Save booth
            if ($booths && !empty($booths['name'])){
                unset($booths['id']);
                $this->saveBooth($dataBaseTask, $booths);
            }
            
            // Save social
            if ($social) {
                unset($social['id']);
                $dataBaseTask->taskEventSocials()->create($social);
            }

            // Save discord
            if ($discords){
                unset($discords['id']);
                $dataBaseTask->taskEventDiscords()->create($discords);
            }

            // Save Quiz
            if ($quiz) {
                unset($quiz['id']);
                $this->saveQuiz($dataBaseTask, $quiz);
            }

            // Save Sponsor
            if ($sponsors) {
                unset($sponsors['id']);
                $this->saveSponsor($dataBaseTask, $sponsors);
            }

            DB::commit();
        } catch (\Exception $e) {
            dd($e->getMessage());
            DB::rollBack();
        }
    }

    private function saveSponsor($task, $sponsors)
    {
        if (isset($sponsors['id']) && $sponsors['id']) {
            $sponsor = Sponsor::find($sponsors['id']);

            if (!$sponsor) { return true; }
            if ($sponsors && empty($sponsors['name'])) { return true; }

            $sponsor->update([
                'name' => $sponsors['name'],
                'price_type' => (int)$sponsors['price_type'],
                'price' => (int)$sponsors['price'],
                'description' => $sponsors['description'],
                'end_at' => isset($sponsors['end_at']) ? $sponsors['end_at'] : null,
            ]);

            foreach($sponsors['detail'] as $item) {
                if (isset($item['id']) && $item['id']) {
                    if (isset($item['is_delete']) && $item['is_delete']) {
                        SponsorDetail::where('id', $item['id'])->delete();
                    } else {
                        if (empty($item['name'])) {
                            SponsorDetail::where('id', $item['id'])->delete();
                        } else {
                            SponsorDetail::where('id', $item['id'])->update([
                                'name' => $item['name'],
                                'price' => (int)$item['price'],
                                'description' => $item['description']
                            ]);
                        }
                    }
                } else {
                    if (empty($item['name'])) {
                        continue;
                    } else {
                        SponsorDetail::create([
                            'sponsor_id' => $sponsors['id'],
                            'name' => $item['name'],
                            'price' => (int)$item['price'],
                            'description' => $item['description']
                        ]);
                    }
                }
            }
        } else {
            if (!empty($sponsors['name'])) {
                $sponsor = Sponsor::create([
                    'task_id' => $task->id,
                    'name' => $sponsors['name'],
                    'price_type' => (int)$sponsors['price_type'],
                    'price' => (int)$sponsors['price'],
                    'description' => $sponsors['description'],
                    'end_at' => isset($sponsors['end_at']) ? $sponsors['end_at'] : null,
                ]);

                foreach($sponsors['detail'] as $item) {
                    if (empty($item['name'])) {
                        continue;
                    } else {
                        SponsorDetail::create([
                            'sponsor_id' => $sponsor->id,
                            'name' => $item['name'],
                            'price' => (int)$item['price'],
                            'description' => $item['description']
                        ]);
                    }

                }
            }

        }
    }

    private function saveSession($task, $sessions) {
        if (isset($sessions['id']) && $sessions['id']) {
            $event = TaskEvent::where('id', $sessions['id'])->first();
            if (!$event) {
                return true;
            }

            $event->update([
                'name' => $sessions['name'],
                'max_job' => $sessions['max_job'] ?? 1,
                'description' => $sessions['description']
            ]);

            foreach($sessions['detail'] as $item) {
                if (isset($item['id']) &&
                    $item['id'] &&
                    isset($item['is_delete']) &&
                    $item['is_delete'] == 1)
                {
                    TaskEventDetail::where('id', $item['id'])->delete();
                } else {
                    $is_question = isset($item['is_question']) && $item['is_question'] == '1' ? true : false;
                    $question = isset($item['question']) ? $item['question'] : null;
                    $a1 = isset($item['a1']) && $item['a1'] != null ? $item['a1'] : null;
                    $a2 = isset($item['a2']) && $item['a2'] != null ? $item['a2'] : null;
                    $a3 = isset($item['a3']) && $item['a3'] != null ? $item['a3'] : null;
                    $a4 = isset($item['a4']) && $item['a4'] != null ? $item['a4'] : null;
                    $is_a1 = isset($item['is_a1']) && $item['is_a1'] == '1' ? true : false;
                    $is_a2 = isset($item['is_a2']) && $item['is_a2'] == '1' ? true : false;
                    $is_a3 = isset($item['is_a3']) && $item['is_a3'] == '1' ? true : false;
                    $is_a4 = isset($item['is_a4']) && $item['is_a4'] == '1' ? true : false;

                    if (empty($item['name'])) {
                        continue;
                    } elseif(isset($item['id']) && $item['id']) {
                        TaskEventDetail::where('id', $item['id'])->update([
                            'name' => $item['name'],
                            'description' => $item['description'],
                            'travel_game_id' => $item['travel_game_id'],
                            'is_required' => false,
                            'is_question' => $is_question,
                            'question' => $question,
                            'a1' => $a1,
                            'a2' => $a2,
                            'a3' => $a3,
                            'a4' => $a4,
                            'is_a1' => $is_a1,
                            'is_a2' => $is_a2,
                            'is_a3' => $is_a3,
                            'is_a4' => $is_a4
                        ]);
                    } else {
                        TaskEventDetail::create([
                            'task_event_id' => $event->id,
                            'name' => $item['name'],
                            'description' => $item['description'],
                            'code' => Str::random(35),
                            'travel_game_id' => $item['travel_game_id'],
                            'is_required' => false,
                            'is_question' => $is_question,
                            'question' => $question,
                            'a1' => $a1,
                            'a2' => $a2,
                            'a3' => $a3,
                            'a4' => $a4,
                            'is_a1' => $is_a1,
                            'is_a2' => $is_a2,
                            'is_a3' => $is_a3,
                            'is_a4' => $is_a4
                        ]);
                    }
                }
            }
        } else {
            $event = TaskEvent::create([
                'task_id' => $task->id,
                'name' => $sessions['name'],
                'max_job' => $sessions['max_job'] ?? 1,
                'description' => $sessions['description'],
                'type' => 0,
                'code' => Str::random(35)
            ]);

            foreach($sessions['detail'] as $item) {
                if (isset($item['is_delete']) && $item['is_delete'] == 1) {
                    continue;
                } else {
                    if (empty($item['name'])) {
                        continue;
                    } else {
                        TaskEventDetail::create([
                            'task_event_id' => $event->id,
                            'name' => $item['name'],
                            'description' => $item['description'],
                            'code' => Str::random(35),
                            'travel_game_id' => isset($item['travel_game_id']) ? $item['travel_game_id'] : null,
                            'is_required' => false,
                            'is_question' => isset($item['is_question']) && $item['is_question'] == '1' ? true : false,
                            'question' => isset($item['question']) ? $item['question'] : null,
                            'a1' => isset($item['a1']) ? $item['a1'] : null,
                            'a2' => isset($item['a2']) ? $item['a2'] : null,
                            'a3' => isset($item['a3']) ? $item['a3'] : null,
                            'a4' => isset($item['a4']) ? $item['a4'] : null,
                            'is_a1' => isset($item['is_a1']) && $item['is_a1'] == '1' ? true : false,
                            'is_a2' => isset($item['is_a2']) && $item['is_a2'] == '1' ? true : false,
                            'is_a3' => isset($item['is_a3']) && $item['is_a3'] == '1' ? true : false,
                            'is_a4' => isset($item['is_a4']) && $item['is_a4'] == '1' ? true : false
                        ]);
                    }
                }
            }
        }
    }

    private function saveBooth($task, $booths)
    {
        // dd($booths);
        // https://use.tekuno.app/claim/d5b24e31-0a08-4314-9a1c-6dcaf394f42f
        // https://use.tekuno.app/claim/a057e74e-5d5a-4d2b-81b2-c22c28e043d8
        // https://use.tekuno.app/claim/9e186e9e-49cb-4885-971d-933f1da16540
        if (isset($booths['id']) && $booths['id']) {
            $event = TaskEvent::where('id', $booths['id'])->first();

            if (!$event) { return; }

            $event->update([
                'name' => $booths['name'],
                'max_job' => $booths['max_job'] ?? 1,
                'description' => $booths['description']
            ]);

            foreach($booths['detail'] as $item) {
                if (isset($item['id']) &&
                    $item['id'] &&
                    isset($item['is_delete']) &&
                    $item['is_delete'] == 1)
                {
                    TaskEventDetail::where('id', $item['id'])->delete();
                } else {
                    if (empty($item['name'])) {
                        continue;
                    } elseif(isset($item['id']) && $item['id']) {
                        TaskEventDetail::where('id', $item['id'])->update([
                            'name' => $item['name'],
                            'description' => $item['description'],
                            'nft_link' => $item['nft_link'] ?? null,
                            'travel_game_id' => isset($item['travel_game_id']) ? $item['travel_game_id'] : null,
                            'is_question' => false,
                            'is_required' => isset($item['is_required']) && $item['is_required'] == '1' ? true : false
                        ]);
                    } else {
                        TaskEventDetail::create([
                            'task_event_id' => $event->id,
                            'name' => $item['name'],
                            'description' => $item['description'],
                            'nft_link' => $item['nft_link'] ?? null,
                            'code' => Str::random(35),
                            'travel_game_id' => isset($item['travel_game_id']) ? $item['travel_game_id'] : null,
                            'is_question' => false,
                            'is_required' => isset($item['is_required']) && $item['is_required'] == '1' ? true : false
                        ]);
                    }
                }
            }
        } else {
            $event = TaskEvent::create([
                'task_id' => $task->id,
                'name' => $booths['name'],
                'max_job' => $booths['max_job'] ?? 1,
                'description' => $booths['description'],
                'type' => 1,
                'code' => Str::random(35)
            ]);

            foreach($booths['detail'] as $item) {
                if (isset($item['is_delete']) && $item['is_delete'] == 1) {
                    continue;
                } else {
                    if (empty($item['name'])) {
                        continue;
                    } else {
                        TaskEventDetail::create([
                            'task_event_id' => $event->id,
                            'name' => $item['name'],
                            'nft_link' => $item['nft_link'] ?? null,
                            'description' => $item['description'],
                            'code' => Str::random(35),
                            'travel_game_id' => isset($item['travel_game_id']) ? $item['travel_game_id'] : null,
                            'is_question' => false,
                            'is_required' => isset($item['is_required']) && $item['is_required'] == '1' ? true : false
                        ]);
                    }
                }
            }
        }
    }

    private function saveQuiz($task, $quiz)
    {
        foreach($quiz as $item) {
            if (!empty($item['name'])) {
                if(isset($item['id']) && $item['id']) {
                    $quiz = Quiz::where('id', $item['id'])->first();

                    if (!$quiz) {
                        continue;
                    }

                    if (isset($item['is_delete']) && $item['is_delete'] == 1) {
                        QuizAnswer::where('quiz_id', $quiz->id)->delete();
                        $quiz->delete();
                    } else {
                        $quiz->update([
                            'name' => $item['name'],
                            'time_quiz' => $item['time_quiz'] ?? 5,
                            'order' => $item['order'] ?? 1,
                            'status' => $item['status'] == 'on' ? true : false,
                        ]);

                        foreach($item['detail'] as $aws) {
                            $status = isset($aws['status']) && $aws['status'] == 1 ? true : false;
                            QuizAnswer::where('id', $aws['id'])->update([
                                'name' => $aws['name'],
                                'status' => $status
                            ]);
                        }
                    }
                } else {
                    if (isset($item['is_delete']) && $item['is_delete'] == 1) {
                        continue;
                    } else {
                        $quiz = Quiz::create([
                            'task_id' => $task->id,
                            'name' => $item['name'],
                            'time_quiz' => $item['time_quiz'],
                            'order' => $item['order'],
                            'status' => empty($item['status']) ? 0 : 1
                        ]);

                        foreach($item['detail'] as $aws) {
                            $status = isset($aws['status']) && $aws['status'] == 1 ? true : false;
                            QuizAnswer::create([
                                'quiz_id' => $quiz->id,
                                'name' => $aws['name'],
                                'status' => $status
                            ]);
                        }
                    }
                }
            }
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

    public function changeStatus($status, $id)
    {
        try {
            $dataBaseTask = $this->taskRepository->update(['status' => $status], $id);
        } catch (RuntimeException $exception) {
            DB::rollBack();
            throw $exception;
        } catch (Exception $exception) {
            DB::rollBack();
            throw new RuntimeException($exception->getMessage(), 500062, $exception->getMessage(), $exception);
        }
    }
}
