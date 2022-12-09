<?php

namespace Database\Factories;

use App\Models\DataSource;
use Illuminate\Database\Eloquent\Factories\Factory;

class DataSourceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = DataSource::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => 'brtaining_effect',
            'data_base_id' => 1,
            'crud' => 'crud',
            'key' => 'brtaining_effect',
            'type' => 'table',
        ];
    }
}
