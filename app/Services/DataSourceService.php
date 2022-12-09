<?php


namespace App\Services;

use App\Models\DataBase;
use App\Models\DataSource;
use App\Models\DataSource as Model;

/**
 * Class DataSourceFieldService
 * @package App\Services
 */
class DataSourceService extends CoreService
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
     *
     * Создадим в репозитории источник данных (table | view)
     */
    public function create($data)
    {
        return $this->entity()->create([
            'data_base_id'  => $data['data_base_id'],
            'title' => $data['table_name'],
            'key' => $data['table_name'],
            'type' => $data['table_type'],
            'crud' => $data['table_type'] == 'BASE TABLE' ? 'crud' : 'r',
        ]);
    }
}
