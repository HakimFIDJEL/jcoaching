<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Setting;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $admin = User::where('email', 'hakimfidjel.pro@gmail.com')->first();

        // Le seed a déjà été exécuté
        if (!$admin) {
            
            // Génère un utilisateur admin
            User::factory()->create([
                'role' => 'admin',
                'firstname' => 'Hakim',
                'lastname' => 'Fidjel',
                'email' => 'hakimfidjel.pro@gmail.com',
                'password' => Hash::make('password'),    
                'password_expires_at' => now()->addYear(),
                'phone' => '0606060606',
                'address' => '1 rue de la paix',
                'city' => 'Paris',
                'postal_code' => '75000',
                'country' => 'France',
                'address_complement' => null,
                'pfp_path' => null,
                'first_session' => true,
                'email_verified_at' => now(),
                'user_token' => null,
                'user_token_expires_at' => null,
                'email_token' => null,
                'email_token_expires_at' => null,
                'password_token' => null,
                'password_token_expires_at' => null,    
            ]);

            // Génère 10 utilisateurs membre avec des données aléatoires
            // User::factory(10)->create();
        }

        $member = User::where('email', 'hakim.fidjel@gmail.com')->first();

        // Le seed a déjà été exécuté
        if (!$member) {
            
            // Génère un utilisateur membre
            User::factory()->create([
                'role' => 'member',
                'firstname' => 'Hakim',
                'lastname' => 'Fidjel',
                'email' => 'hakim.fidjel@gmail.com',
                'password' => Hash::make('password'),
                'password_expires_at' => now()->addYear(),
                'phone' => '0606060606',
                'address' => '1 rue de la paix',
                'city' => 'Paris',
                'postal_code' => '75000',
                'country' => 'France',
                'address_complement' => null,
                'pfp_path' => null,
                'first_session' => true,
                'email_verified_at' => now(),
                'user_token' => null,
                'user_token_expires_at' => null,
                'email_token' => null,
                'email_token_expires_at' => null,
                'password_token' => null,
                'password_token_expires_at' => null,
            ]);
        }


        $setting = Setting::first();

        if(!$setting) {
            Setting::create([
                'company_name' => 'JCOACHING',
                'company_address' => '5 allée des crocus, appartement 4 / 59650 Villeneuve d\'ascq',
                'company_phone' => '+33 7 82 19 98 30',
                'company_email' => 'jerome.hache333@yahoo.fr',
                'company_siret' => '948226048 00023 (SIRET)',
                'company_tva' => 'Aucune pour le moment',
            ]);
        }

    }
}
