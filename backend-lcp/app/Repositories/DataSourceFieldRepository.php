<?php


namespace App\Repositories;

use App\Models\DataSourceField as Model;

/**
 * Class DataBaseRepository
 * @package App\Repositories
 */
class DataSourceFieldRepository extends CoreRepository
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
}
