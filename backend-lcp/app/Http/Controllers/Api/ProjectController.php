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
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

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

    public function storeRemote(ProjectCreateRequest $request, ProjectService $projectService)
    {
        $project = $projectService->createRemote($request->validated());
        return response()->json($project, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
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
        $project->update($request->validated());

        return response()->json([
            'status' => 200,
            'project' => $project,
            'message' => 'Проект успешно сохранен'
        ]);
    }

    public function projectFormData(Request $request, ProjectService $projectService)
    {
        $validator = $projectService->projectFromDateValidate($request);
        $project = Project::find($request->input('id'));

        if ($validator->fails()) {
            return response()->json([
                'status' => 422,
                'message' => $validator->errors(),
            ], 422);
        } else {
            if ($project) {
                $project = $projectService->saveProjectByFormData($request, $project);
                return response()->json([
                    'status' => 200,
                    'project' => $project,
                    'message' => 'Проект успешно сохранен'
                ]);
            } else {
                return response()->json([
                    'status' => 404,
                    'message' => 'Проект не найден',
                ], 404);
            }
        }
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
