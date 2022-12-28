<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\GroupRequest;
use App\Http\Resources\Admin\GroupResource;
use App\Models\Group as GroupModel;

class Group extends ApiController
{
    /**
    * @param $groupModel
    */
    public function __construct(
        private GroupModel $groupModel
    ) {}

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            $limit = $request->input('limit') ?? PAGE_SIZE;

            $groups = $this->groupModel
                ->orderBy('created_at', 'desc')
                ->orderBy('status', 'desc')
                ->paginate($limit);

            $datas = GroupResource::collection($groups);
            $pages = [
                'current_page' => (int)$request->get('page'),
                'last_page' => $groups->lastPage(),
                'per_page'  => (int)$limit,
                'total' => $groups->lastPage()
            ];
        } catch (\Exception $e) {
            return $this->respondError($e->getMessage());
        }

        return $this->respondWithIndex($datas, $pages);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(GroupRequest $request)
    {
        // dd($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, Request $request)
    {
        try {
            $group = $this->groupModel->findOrFail($id);
        } catch (\Exception $e) {
            return $this->respondError($e->getMessage());
        }

        return $this->respondWithResource(new GroupResource($group));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
