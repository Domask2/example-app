<?php


namespace App\Services;

use App\Models\DataBase;
use App\Models\DataSource;
use App\Models\DataSource as Model;
use App\Models\DataSourceAccess;
use App\Models\DataSourceField;

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
            'data_base_id' => $data['data_base_id'],
            'title' => $data['table_name'],
            'key' => $data['table_name'],
            'type' => $data['table_type'],
            'crud' => $data['table_type'] == 'BASE TABLE' ? 'crud' : 'r',
        ]);
    }

    public function createDsRemote($db, $request)
    {
        $ds = $request->all();
        $ds['data_base_id'] = $db->id;
        $ds['crud'] = $request->type == 'BASE TABLE' ? 'crud' : 'r';
        unset($ds['db_key']);
        $ds = DataSource::updateOrCreate(['key' => $ds['key'], "data_base_id" => $db->id], $ds);
        return $ds;
    }

    public function createDsRemoteAll($request)
    {
        $data_base = DataBase::where('key', $request->db_key)->first();

        if ($data_base) {
            foreach ($request->ds as $item) {
                $ds['data_base_id'] = $data_base->id;
                $ds['title'] = $item['title'];
                $ds['key'] = $item['key'];
                $ds['description'] = $item['description'];
                $ds['type'] = $item['type'];
                $ds['crud'] = $item['type'] == 'BASE TABLE' ? 'crud' : 'r';
                $data_source = DataSource::updateOrCreate(['key' => $ds['key'], "data_base_id" => $data_base->id], $ds);

                if ($data_source) {
                    DataSourceField::where("data_source_id", $data_source->id)->delete();

                    foreach ($item['dataSourceFields'] as $dsf) {
                        $data_source_field["data_source_id"] = $data_source->id;
                        $data_source_field["title"] = $dsf['title'];
                        $data_source_field["key"] = $dsf['key'];
                        $data_source_field["dataIndex"] = $dsf['dataIndex'];
                        $data_source_field["visible"] = $dsf['visible'];
                        $data_source_field["type"] = $dsf['type'];
                        $data_source_field["pk"] = $dsf['pk'];
                        $data_source_field["search"] = $dsf['search'];
                        DataSourceField::updateOrCreate(['key' => $dsf['key'], "data_source_id" => $data_source->id, 'title' => $dsf['title']], $data_source_field);
                    }

                    foreach ($item['dataSourceAccess'] as $dsa) {
                        $data_source_access['data_source_id'] = $data_source->id;
                        $data_source_access['key'] = $dsa['key'];
                        $data_source_access['source_name'] = $dsa['source_name'];
                        $data_source_access['role'] = $dsa['role'];
                        DataSourceAccess::updateOrCreate(['key' => $dsa['key'], "data_source_id" => $data_source->id, "source_name" => $dsa['source_name']], $data_source_access);
                    }
                }
            }
        }
    }
}
