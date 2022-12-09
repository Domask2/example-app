<?php


namespace App\Services;

use App\Models\DataSourceAccess;
use App\Models\DataSourceAccess as Model;


/**
 * Class DataSourceFieldService
 * @package App\Services
 */
class DataSourceAccessService extends CoreService
{
    /**
     * @return mixed|string
     */
    protected function getModelClass()
    {
        return Model::class;
    }

    public function create($request, $ds)
    {
        foreach ($request->dsa as $item) {
            $dsaDate['data_source_id'] = $ds->id;
            $dsaDate['key'] = $item['key'];
            $dsaDate['source_name'] = $item['source_name'];
            $dsaDate['role'] = $item['role'];
            DataSourceAccess::updateOrCreate(['key' => $item['key'], "data_source_id" => $ds->id, "source_name" => $item['source_name']], $dsaDate);
        }
    }


}
