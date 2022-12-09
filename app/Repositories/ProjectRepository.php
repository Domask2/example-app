<?php


namespace App\Repositories;

use App\Models\Project as Model;

/**
 * Class DataBaseRepository
 * @package App\Repositories
 */
class ProjectRepository extends CoreRepository
{
    /**
     * @return string
     */
    protected function getModelClass()
    {
        return Model::class;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function find($id)
    {
        return $this->entity()->find($id);
    }

    /**
     * @return mixed
     */
    public function getAllProjects()
    {
        $columns = ['id', 'user_id', 'title', 'key', 'description', 'navigation', 'is_published', 'project_roles',
            'is_open', 'startpage', 'addictions'];

        $projects = $this->entity()->where('is_published', true);
        if (auth()->user()) {
            if (auth()->user() !== null)
                $projects->orWhere('user_id', auth()->user()->id);
        } else {
            $projects = $this->entity()->where('is_open', true);
            if (auth()->user() !== null)
                $projects->orWhere('user_id', auth()->user()->id);
        }

        return $projects->orderBy('key')->get($columns);
    }
}
