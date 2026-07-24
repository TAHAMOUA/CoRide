<?php

namespace Database\Seeders;

use App\Models\Reservation;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

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
        $path = database_path('data/reservations.csv');

        if (! is_file($path)) {
            return;
        }

        $handle = fopen($path, 'r');
        if ($handle === false) {
            return;
        }

        $headers = fgetcsv($handle);
        if (! is_array($headers)) {
            fclose($handle);
            return;
        }

        while (($row = fgetcsv($handle)) !== false) {
            if (count($row) === 0) {
                continue;
            }

            $ligne = array_combine($headers, $row);
            if ($ligne === false) {
                continue;
            }

            $id = (int) ($ligne['id'] ?? 0);
            $payload = [
                'trajet_id' => isset($ligne['trajet_id']) ? (int) $ligne['trajet_id'] : null,
                'passager_id' => isset($ligne['passager_id']) ? (int) $ligne['passager_id'] : null,
                'statut' => $ligne['statut'] ?? null,
                'date_reservation' => $ligne['date_reservation'] ?? null,
                'updated_at' => now(),
            ];

            if ($id > 0) {
                $payload['created_at'] = now();
                DB::table('reservations')->updateOrInsert(['id' => $id], $payload);
            } else {
                DB::table('reservations')->insert($payload + ['created_at' => now()]);
            }
        }

        fclose($handle);
    }
}
