<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Reduction;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Reduction>
 */
class ReductionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'code' => $this->faker->regexify('[A-Z0-9]{8}'),
            'percentage' => $this->faker->numberBetween(1, 100),
            'start_date' => $this->faker->dateTimeBetween('-1 month', '+1 month')->format('Y-m-d H:i:s'),
            'end_date' => $this->faker->dateTimeBetween('+1 month', '+2 months')->format('Y-m-d H:i:s'),
            'online' => $this->faker->boolean(),
        ];        
    }
}
