<?php


namespace App\Services;

use App\Models\Project;
use App\Models\Project as Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ProjectService extends CoreService
{
    /**
     * @return mixed|string
     */
    protected function getModelClass()
    {
        return Model::class;
    }

    /**
     * @param $data
     * @return mixed
     */
    public function create($data)
    {
        $data = array_merge($data, ['user_id' => auth()->user()->id]);
        $data['title'] = empty($data['title']) ? 'Новый проект' : $data['title'];
        $data['key'] = empty($data['key']) ?
            Str::random(3) . "_" . Str::random(3) : $data['key'];
        $data['navigation'] = json_encode([]);

        return $this->entity()->create($data);
    }

    public function createRemote($request)
    {
        $data = $request;
        $data['user_id'] = auth()->user()->id;
        $data['addictions'] = json_encode($request['addictions']);
        $data['navigation'] = json_encode($request['navigation']);
        $data['project_roles'] = json_encode($request['project_roles']);
        $project = Project::create($data);

        return $project;
    }

    public function delete($key)
    {
        $project = $this->entity()->where('key', $key)->first();
        /** Проверить пользователь владелец проекта или админ  */
        if (auth()->user()->role === 'admin' || auth()->user()->role === 'mage' || $project->user_id = auth()->user()->id) {
            $project->delete();
        }

        return $this;
    }

    /**
     * @param $request
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function projectFromDateValidate($request)
    {
        return Validator::make($request->all(), [
            'title' => 'max:50',
            'key' => 'max:50',
            'description' => 'max:255',
            'is_published' => '',
            'navigation' => '',
            'project_roles' => '',
            'is_open' => '',
            'startpage' => '',
            'addictions' => '',
        ]);
    }

    /**
     * @param Request $request
     * @param Model $project
     * @return Model
     */
    public function saveProjectByFormData(Request $request, Project $project)
    {
        $project['id'] = $request->input('id');
        $project['user_id'] = json_decode($request->input('user_id'));
        $project['title'] = json_decode($request->input('title'));
        $project['key'] = json_decode($request->input('key'));
        $project['description'] = json_decode($request->input('description'));
        $project['is_published'] = json_decode($request->input('is_published'));
        $project['navigation'] = $request->input('navigation');
        $project['project_roles'] = $request->input('project_roles');
        $project['is_open'] = json_decode($request->input('is_open'));
        $project['startpage'] = json_decode($request->input('startpage'));
        $project['addictions'] = $request->input('addictions');
        $project['banner'] = json_decode($request->input('banner'));

        if ($request->file('logo')) {
            if ($project->logo) {
                $str = $project->logo;
                $str = str_replace('storage/', '', $str);
                Storage::delete($str);
            }

            $image = $request->file('logo')->storePublicly('udb8/logo');
            $project['logo'] = 'storage/' . $image;
        }

        if ($request->input('logo') === 'delete') {
            $str = $project->logo;
            $str = str_replace('storage/', '', $str);
            Storage::delete($str);
            $project['logo'] = null;
        }

        $project->save();
        $project['navigation'] = json_decode($project->navigation);
        $project['project_roles'] = json_decode($project->project_roles);
        $project['addictions'] = json_decode($project->addictions);

        return $project;
    }

}
