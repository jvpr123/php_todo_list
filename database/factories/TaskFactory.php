<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            "title" => $this->faker->text(20),
            "description" => $this->faker->text(50),
            "deadline" => $this->faker->dateTime(),
            "user_id" => User::all()->random(),
            "category_id" => Category::all()->random(),
        ];
    }
}
