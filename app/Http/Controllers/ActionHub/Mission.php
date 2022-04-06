<?php

namespace App\Http\Controllers\ActionHub;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateMissionRequest;
use App\Http\Resources\MissionResource;
use App\Services\MissionService;
use Illuminate\Http\Request;

class Mission extends Controller
{
    /**
     * @var \App\Services\MissionService
     */
    protected $missionService;

    /**
     * @param \App\Services\MissionService $missionService
     */
    public function __construct(MissionService $missionService)
    {
        $this->missionService = $missionService;
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Request $request)
    {
        return MissionResource::collection($this->missionService->search(['creator_id' => $request->user()->id]));
    }

    /**
     * @param string $id
     */
    public function detail($id)
    {
        return new MissionResource($this->missionService->find($id, ['tasks']));
    }

    /**
     * @param \App\Http\Requests\CreateMissionRequest $request
     *
     * @return \App\Http\Resources\MissionResource
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function create(CreateMissionRequest $request)
    {
        return new MissionResource($this->missionService->create($request));
    }
}
