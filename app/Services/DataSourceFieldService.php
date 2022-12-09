<?php


namespace App\Services;


use App\Models\DataSource;
use App\Models\DataSourceField as Model;

/**
 * Class DataSourceFieldService
 * @package App\Services
 */
class DataSourceFieldService extends CoreService
{
    /**
     * @return mixed|string
     */
    protected function getModelClass()
    {
        return Model::class;
    }

    public function create(DataSource $dataSource, $data)
    {
        if ($data['key'] === '-all-') {
            $fields = $this->magicService->getFields($dataSource);

            foreach ($fields as $item) {
                $arr = [
                    "data_source_id" => $data['data_source_id'],
                    "title" => $item->column_name,
                    "key" => $item->column_name,
                    "dataIndex" => $item->column_name,
                    "visible" => 0,
                    "type" => $item->data_type
                ];
                $this->entity()->firstOrCreate(
                    [
                        "title" => $item->column_name,
                        "data_source_id" => $data['data_source_id']
                    ],
                    $arr
                );
            }
        } else {
            $this->entity()->create($data);
        }
    }
}
