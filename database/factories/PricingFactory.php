<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

use App\Models\Pricing;
use App\Models\PricingFeature;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pricing>
 */
class PricingFactory extends Factory
{
    public function definition(): array
    {
        return [
            'title' => $this->faker->word,
            'subtitle' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'nbr_sessions' => $this->faker->numberBetween(1, 10),
            'price' => $this->faker->randomFloat(2, 10, 1000),
            'online' => $this->faker->boolean,
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Pricing $pricing) {
            $features = PricingFeature::factory()->count(3)->make();
            $pricing->features()->saveMany($features);
        });
    }
}
