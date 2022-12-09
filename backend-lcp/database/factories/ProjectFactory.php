<?php

namespace Database\Factories;

use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProjectFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Project::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            "user_id" => 1,
            "title" => $this->faker->sentence(2),
            "key" => $this->faker->word() . '_' . $this->faker->word(),
            "description" => $this->faker->text(250),
            "type" => "api",
        ];
    }
}
