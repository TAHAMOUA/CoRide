<?php

namespace Database\Factories;

use App\Enums\StatutReservation;
use App\Models\Employe;
use App\Models\Trajet;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * Tache: Taha (Epic 2 - Creer les seeders/factories)
 */
class ReservationFactory extends Factory
{
    public function definition(): array
    {
        return [
            'trajet_id' => Trajet::factory(),
            'passager_id' => Employe::factory(),
            'statut' => fake()->randomElement(StatutReservation::cases())->value,
            'date_reservation' => fake()->dateTimeBetween('-1 month', 'now'),
        ];
    }
}
