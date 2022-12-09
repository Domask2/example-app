<?php

namespace Database\Factories;

use App\Models\DataBase;
use Illuminate\Database\Eloquent\Factories\Factory;

class DataBaseFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = DataBase::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            "user_id" => 1,
            "title" => "btraining",
            "key" => "btraining",
            "driver" => "pgsql",
            "host" => "localhost",
            "port" => "5432",
            "database" => "btraining",
            "username" => "btraining_user",
            "password" => "okin24081952",
            "charset" => "utf8",
            "prefix" => "",
            "prefix_indexes" => true,
            "schema" => "public",
            "sslmode" => "prefer",
            "url" => ""
        ];
    }
}
