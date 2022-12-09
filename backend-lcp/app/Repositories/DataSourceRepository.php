<?php


namespace App\Repositories;

use App\Models\DataSource;
use App\Models\DataSource as Model;
use Symfony\Component\VarDumper\Cloner\Data;

/**
 * Class DataBaseRepository
 * @package App\Repositories
 */
class DataSourceRepository extends CoreRepository
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
     * @param $value
     * @return mixed
     */
    public function findBy($key, $value)
    {
        $result = $this->entity()->where($key, $value)->first();
        return $result;
    }
}
