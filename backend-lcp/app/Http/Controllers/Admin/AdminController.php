<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\ProjectResource;
use App\Http\Resources\Api\UserResource;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AdminController extends Controller
{
    public function index()
    {
        if (!auth()->user() || auth()->user()->role !== 'admin')
            return redirect(route('home'));

        $users = UserResource::collection(User::orderBy('id')->paginate(10));
        $projects = ProjectResource::collection(Project::orderBy('id')->paginate(10));

        return view('admin.index', compact('users', 'projects'));
    }

    public function remote($srv)
    {

        if (!auth()->user() || auth()->user()->role !== 'admin')
            return redirect(route('home'));

        $apiURL = 'http://' . $srv . '/api/project';
        $response = Http::asForm()->withToken('771|61rMv8jyWRZ2db0hz9jGXMxtvkAlDvhzDgmXNgca')->get($apiURL);
        $remoteProjects = json_decode($response->getBody(), true);

        $projects = Project::orderBy('key')->get();
        return view('admin.remote', compact(['projects', 'remoteProjects', 'srv']));
    }

    public function remote_project($srv)
    {
        if (!auth()->user() || auth()->user()->role !== 'admin')
            return redirect(route('home'));

        $apiURL = 'http://' . $srv . '/api/project';
        $response = Http::asForm()->withToken('771|61rMv8jyWRZ2db0hz9jGXMxtvkAlDvhzDgmXNgca')->get($apiURL);
        $remoteProjects = json_decode($response->getBody(), true);

        $projects = Project::orderBy('key')->get();
        return view('admin.remote', compact(['projects', 'remoteProjects', 'srv']));
    }

}
