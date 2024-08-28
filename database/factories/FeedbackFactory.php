<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

use App\Models\Feedback;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Feedback>
 */
class FeedbackFactory extends Factory
{
    protected $model = Feedback::class;

    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'job' => $this->faker->jobTitle(),
            'message' => $this->faker->sentence(),
            'online' => $this->faker->boolean(),
        ];
    }
}
