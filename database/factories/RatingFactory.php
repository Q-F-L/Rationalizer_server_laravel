<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class RatingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'project_id' => $this->faker->numberBetween(1, 10),
            'user_id' => $this->faker->unique()->numberBetween(1, 100),
            'rating' => $this->faker->numberBetween(1, 100) / 10,
        ];
    }
}
