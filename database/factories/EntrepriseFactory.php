<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * Tache: Taha (Epic 2 - Creer les seeders/factories)
 */
class EntrepriseFactory extends Factory
{
    public function definition(): array
    {
        return [
            'nom' => fake()->unique()->company(),
        ];
    }
}
