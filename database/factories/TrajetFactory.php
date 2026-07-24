<?php

namespace Database\Factories;

use App\Models\Employe;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * Tache: Taha (Epic 2 - Creer les seeders/factories)
 */
class TrajetFactory extends Factory
{
    public function definition(): array
    {
        $jours = ['lundi', 'mardi', 'mercredi', 'jeudi', 'vendredi'];

        return [
            'conducteur_id' => Employe::factory(),
            'ville_depart' => fake('fr_FR')->city(),
            'ville_arrivee' => fake('fr_FR')->city(),
            'horaire' => fake()->dateTimeBetween('+1 day', '+2 weeks'),
            'places_disponibles' => fake()->numberBetween(1, 4),
            'jours_recurrence' => fake()->randomElements($jours, fake()->numberBetween(1, 3)),
        ];
    }
}
