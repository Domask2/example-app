<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\PageStoreRequest;
use App\Http\Requests\PageUpdateRequest;
use App\Http\Resources\Api\PageResource;
use App\Models\Page;
use App\Repositories\PageRepository;
use App\Services\Magic\MagicService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PageController extends Controller
{
    private $repository;

    public function __construct(MagicService $service, PageRepository $repository)
    {
        parent::__construct($service);
        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param PageStoreRequest $request
     * @return PageResource
     */
    public function store(PageStoreRequest $request)
    {
        $data = $request->validated();
        $data['components'] = json_encode($data['components']);
        $data['datasources'] = json_encode($data['datasources']);
        $data['ls'] = empty($data['ld']) ? null : json_encode($data['ls']);
        $data['fnc'] = empty($data['fnc']) ? null : json_encode($data['fnc']);
        $data['fly_inputs_groups'] = empty($data['fly_inputs_groups']) ? null : json_encode($data['fly_inputs_groups']);
        $page = Page::create($data);
        return new PageResource($page);
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
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param $id
     * @return void
     */
    public function update(PageUpdateRequest $request, $id)
    {
        $page = $this->repository->find($id);
        $page->update($request->validated());
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
