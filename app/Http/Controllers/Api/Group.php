<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use App\Http\Resources\GroupResource;
use App\Models\Group as GroupModel;

class Group extends ApiController
{
    /**
     * @param $taskService
     */
    public function __construct(
        private GroupModel $group
    ) {}

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            $limit = $request->get('limit') ?? PAGE_SIZE;

            $groups = $this->group
                ->whereStatus(true)
                ->orderBy('created_at', 'desc')
                ->paginate($limit);

            $datas = GroupResource::collection($groups);
            $pages = [
                'current_page' => (int)$request->get('page'),
                'last_page' => $groups->lastPage(),
                'per_page'  => (int)$limit,
                'total' => $groups->lastPage()
            ];
        } catch (\Exception $e) {
            return $this->respondNotFound();
        }


        return $this->respondWithIndex($datas, $pages);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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
