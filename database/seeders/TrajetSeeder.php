<?php

namespace Database\Seeders;

use App\Models\Trajet;
use Illuminate\Database\Seeder;

/**
 * Tache: Taha (Epic 2 - Creer les seeders/factories + import CSV)
 *
 * Importe database/seeders/data/trajets.csv (colonnes :
 * id,conducteur_id,ville_depart,ville_arrivee,horaire,places_disponibles,jours_recurrence).
 * jours_recurrence est attendu sous forme "lundi|mercredi|vendredi".
 * Se replie sur la Factory si le fichier est absent.
 */
class TrajetSeeder extends Seeder
{
    public function run(): void
    {
        $path = database_path('seeders/data/trajets.csv');

        if (! is_file($path)) {
            Trajet::factory()->count(25)->create();

            return;
        }

        $lignes = array_map('str_getcsv', file($path));
        $entetes = array_shift($lignes);

        foreach ($lignes as $ligne) {
            $ligne = array_combine($entetes, $ligne);

            Trajet::updateOrCreate(
                ['id' => (int) $ligne['id']],
                [
                    'conducteur_id' => (int) $ligne['conducteur_id'],
                    'ville_depart' => $ligne['ville_depart'],
                    'ville_arrivee' => $ligne['ville_arrivee'],
                    'horaire' => $ligne['horaire'],
                    'places_disponibles' => (int) $ligne['places_disponibles'],
                    'jours_recurrence' => array_filter(explode('|', $ligne['jours_recurrence'] ?? '')),
                ]
            );
        }
    }
}
