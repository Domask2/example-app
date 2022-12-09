<?php


namespace App\Services;

use App\Models\Project as Model;
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


    public function delete($key)
    {
        $project = $this->entity()->where('key', $key)->first();
        /** Проверить пользователь владелец проекта или админ  */
        if (auth()->user()->role === 'admin' || auth()->user()->role === 'mage' || $project->user_id = auth()->user()->id) {
            $project->delete();
        }

        return $this;
    }
}
