<?php


namespace App\Repositories;

use App\Models\DataBase as Model;

/**
 * Class DataBaseRepository
 * @package App\Repositories
 */
class DataBaseRepository extends CoreRepository
{
    /**
     * @return string
     */
    protected function getModelClass()
    {
        return Model::class;
    }

    public function find($id)
    {
        return $this->entity()->find($id);
    }

    /**
     * @param $key
     * @return mixed
     */
    public function findByKey($key)
    {
        return $this->entity()->where('key', $key)->first();
    }
}
