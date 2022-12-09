<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\InitResource;
use App\Models\Component;
use App\Models\DataBase;
use App\Models\DataSource;
use App\Models\Setting;
use App\Repositories\ProjectRepository;

class InitController extends Controller
{
    public function index()
    {
        $projectRepository = new ProjectRepository();


        $components = Component::all();
        $projects = $projectRepository->getAllProjects();
        $setting = Setting::all();
        $db = DataBase::with('dataSources')->get();

        $return = [
            'components' => $components,
            'projects' => $projects,
            'setting' => $setting,
            'db' => $db,
        ];

        return new InitResource($return);
    }
}
