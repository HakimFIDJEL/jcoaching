<?php

namespace Database\Seeders;

use App\Models\User;
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

        $user = User::where('email', 'hakimfidjel.spam@gmail.com')->first();

        // Le seed a déjà été exécuté
        if (!$user) {
            
            // Génère un utilisateur admin
            User::factory()->create([
                'role' => 'admin',
                'firstname' => 'Jérôme',
                'lastname' => 'Hache',
                'email' => 'hakimfidjel.spam@gmail.com',
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
       

    }
}
