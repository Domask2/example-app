<?php


namespace App\Repositories;

use App\Models\Page as Model;

/**
 * Class DataBaseRepository
 * @package App\Repositories
 */
class PageRepository extends CoreRepository
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
     * @param $key
     * @return mixed
     */
    public function getPageByKey($key)
    {
        $result = $this->entity()->where("key", $key);
        return $result;
    }

    /**
     * @param $project_id
     * @return mixed
     */
    public function getPagesByProject($project_id)
    {
        $columns = ["id", "project_id", "title", "key", "description", "components", "datasources", "ls", "fnc",
            "addictions", "fly_inputs_groups"];

        $pages = $this->entity()
            ->with("project")
            ->where("project_id", $project_id);

        $result = $pages->get($columns);

        $filtered = $result->filter(function ($item) {
            $is_published = $item->project->is_published;
            $owner_id = $item->project->user_id;

            $or = false;
            if (auth()->user() !== null)
                $or = $owner_id === auth()->user()->id;

            return $is_published || $or;
        });

        return $filtered;
    }
}
