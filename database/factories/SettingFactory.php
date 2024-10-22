<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Setting>
 */
class SettingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'company_name' => 'JCOACHING',
            'company_address' => '5 allée des crocus, appartement 4 / 59650 Villeneuve d\'ascq',
            'company_phone' => '+33 7 82 19 98 30',
            'company_email' => 'jerome.hache333@yahoo.fr',
            'company_siret' => '948226048 00023 (SIRET)',
            'company_tva' => 'Aucune pour le moment',
            
        ];
    }
}
