<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProjectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'topic' => 'Улучшение колледжа',
            'title' => $this->faker->title(),
            'now_description' => $this->faker->realText(),
            'now_video' => $this->faker->image(),
            'now_photo' => $this->faker->image(),
            'need_description' => $this->faker->realText(),
            'need_video' => $this->faker->image(),
            'need_photo' => $this->faker->image(),
            'will_description' => $this->faker->realText(),
            'rating' => $this->faker->numberBetween(1, 100) / 10,
            'discussion_id' => $this->faker->unique()->numberBetween(1, 10),
            'user_id' => $this->faker->numberBetween(1, 10),
        ];
    }
}
