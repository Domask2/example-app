<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProjectCreateRequest;
use App\Http\Requests\ProjectUpdateRequest;
use App\Http\Resources\Api\PageResource;
use App\Http\Resources\Api\ProjectResource;
use App\Models\Project;
use App\Repositories\PageRepository;
use App\Repositories\ProjectRepository;
use App\Services\Magic\MagicService;
use App\Services\ProjectService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ProjectController extends Controller
{
    private $repository;

    public function __construct(MagicService $service, ProjectRepository $repository)
    {
        parent::__construct($service);
        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index()
    {
        return ProjectResource::collection($this->repository->getAllProjects());
    }

    /**
     * @param ProjectCreateRequest $request
     * @param ProjectService $projectService
     * @return ProjectResource
     */
    public function store(ProjectCreateRequest $request, ProjectService $projectService)
    {
        $project = $projectService->create($request->validated());
        return new ProjectResource($project);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return ProjectResource
     */
    public function show($id)
    {
        return new ProjectResource($this->repository->find($id));
    }

    /**
     * Display the specified resource.
     *
     * @param PageRepository $pageRepository
     * @param int $id
     * @return AnonymousResourceCollection
     */
    public function getPages(PageRepository $pageRepository, $id)
    {
        $pages = $pageRepository->getPagesByProject($id);
        return PageResource::collection($pages);
    }

    /**
     * @param ProjectUpdateRequest $request
     * @param $id
     * @return JsonResponse
     */
    public function update(ProjectUpdateRequest $request, $id)
    {
        $project = Project::find($id);
        $ret = $project->update($request->validated());

        return response()->json($ret, 200, [], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    }

    /**
     * @param $key
     * @param ProjectService $projectService
     * @return JsonResponse
     */
    public function destroy($key, ProjectService $projectService)
    {
        $projectService->delete($key);
        return response()->json('Deletion was successful', 200);
    }
}
