<?php

namespace Database\Factories;

use App\Enums\RoleEmploye;
use App\Models\Entreprise;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

/**
 * Tache: Taha (Epic 2 - Creer les seeders/factories + import CSV)
 */
class EmployeFactory extends Factory
{
    public function definition(): array
    {
        return [
            'nom' => fake('fr_FR')->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'entreprise_id' => Entreprise::factory(),
            'ville_residence' => fake('fr_FR')->city(),
            'role' => fake()->randomElement(RoleEmploye::cases())->value,
        ];
    }
}
