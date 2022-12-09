<?php


namespace App\Http\Controllers\Api\Free;


use App\Http\Controllers\Controller;
use App\Http\Resources\Api\PageResource;
use App\Http\Resources\Api\ProjectResource;
use App\Repositories\PageRepository;
use App\Repositories\ProjectRepository;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ProjectFreeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index()
    {
        $repository = new ProjectRepository();
        return ProjectResource::collection($repository->getAllProjects());
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
}
