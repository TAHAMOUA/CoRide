<?php

namespace Database\Seeders;

use App\Models\Reservation;
use Illuminate\Database\Seeder;

/**
 * Tache: Taha (Epic 2 - Creer les seeders/factories + import CSV)
 *
 * Importe database/seeders/data/reservations.csv (colonnes :
 * id,trajet_id,passager_id,statut,date_reservation).
 * Ce jeu de donnees contient volontairement des cas limites (trajets deja
 * complets, statuts varies) utilises par Soukaina pour les tests finaux (Epic 5).
 */
class ReservationSeeder extends Seeder
{
    public function run(): void
    {
        $path = database_path('seeders/data/reservations.csv');

        if (! is_file($path)) {
            Reservation::factory()->count(35)->create();

            return;
        }

        $lignes = array_map('str_getcsv', file($path));
        $entetes = array_shift($lignes);

        foreach ($lignes as $ligne) {
            $ligne = array_combine($entetes, $ligne);

            Reservation::updateOrCreate(
                ['id' => (int) $ligne['id']],
                [
                    'trajet_id' => (int) $ligne['trajet_id'],
                    'passager_id' => (int) $ligne['passager_id'],
                    'statut' => $ligne['statut'],
                    'date_reservation' => $ligne['date_reservation'],
                ]
            );
        }
    }
}
