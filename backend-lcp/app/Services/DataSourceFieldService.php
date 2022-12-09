<?php

namespace App\Services;

use App\Models\DataSource;
use App\Models\DataSourceField;
use App\Models\DataSourceField as Model;
use Illuminate\Support\Facades\DB;

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

    public function createDsfRemote($fields, $ds)
    {
        try {

            DB::beginTransaction();

            $result = [];
            DataSourceField::where("data_source_id", $ds->id)->delete();

            foreach ($fields as $item) {
                $field["data_source_id"] = $ds->id;
                $field["title"] = $item['title'];
                $field["key"] = $item['key'];
                $field["dataIndex"] = $item['dataIndex'];
                $field["visible"] = $item['visible'];
                $field["type"] = $item['type'];
                $field["pk"] = $item['pk'];
                $field["search"] = $item['search'];

                $dsFields = DataSourceField::updateOrCreate(['key' => $item['key'], "data_source_id" => $ds->id, 'title' => $item['title']], $field);
                array_push($result, ...$dsFields->all());
            }

            DB:: commit();
            return $result;
        } catch (\Throwable $e) {
            DB::rollback();
            return response()->json($e, 404);
        }
    }
}
