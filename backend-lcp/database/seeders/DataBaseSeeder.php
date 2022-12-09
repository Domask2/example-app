<?php

namespace Database\Seeders;

use App\Models\DataBase;
use App\Models\DataSource;
use App\Models\DataSourceField;
use Illuminate\Database\Seeder;

class DataBaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $database = DataBase::factory()->createOne();
        $datasource = DataSource::factory()->createOne([
            'data_base_id' => $database->id
        ]);
        DataSourceField::factory()->createOne([
            'title' => 'id',
            'data_source_id' => $datasource->id,
            'dataIndex' => 'id',
            'key' => 'id',
            'visible' => true,
            'type' => 'integer',
        ]);
        DataSourceField::factory()->createOne([
            'title' => 'title',
            'data_source_id' => $datasource->id,
            'dataIndex' => 'title',
            'key' => 'title',
            'visible' => true,
            'type' => 'string',
        ]);
        DataSourceField::factory()->createOne([
            'title' => 'description',
            'data_source_id' => $datasource->id,
            'dataIndex' => 'description',
            'key' => 'description',
            'visible' => true,
            'type' => 'string',
        ]);
    }
}
