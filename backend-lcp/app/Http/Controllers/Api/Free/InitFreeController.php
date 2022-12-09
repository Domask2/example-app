<?php


namespace App\Http\Controllers\Api\Free;


use App\Http\Controllers\Controller;
use App\Http\Resources\Api\InitResource;
use App\Models\Component;
use App\Models\Page;
use App\Models\Setting;
use App\Repositories\ProjectRepository;

class InitFreeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return InitResource
     */
    public function index()
    {
        $projectRepository = new ProjectRepository();

        $components = Component::all();
        $projects = $projectRepository->getAllProjects();
        $setting = Setting::all();

        $return = [
            'components' => $components,
            'projects' => $projects,
            'setting' => $setting,
            'db' => [],
            'ds' => [],
        ];

        return new InitResource($return);
    }
}
