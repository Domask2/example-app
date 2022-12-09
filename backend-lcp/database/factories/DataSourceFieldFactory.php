<?php

namespace Database\Factories;

use App\Models\DataSourceField;
use Illuminate\Database\Eloquent\Factories\Factory;

class DataSourceFieldFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = DataSourceField::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => 'id',
            'data_source_id' => 1,
            'dataIndex' => 'id',
            'key' => 'id',
            'visible' => true,
            'type' => 'integer',
        ];
    }
}
