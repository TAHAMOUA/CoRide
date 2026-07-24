<?php

namespace Database\Seeders;

use App\Models\Trajet;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

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
        $path = database_path('data/trajets.csv');

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

            // Accept both '|' or ',' separators and special value 'Tous les jours'
            $rawJours = $ligne['jours_recurrence'] ?? '';
            $jours = [];
            if (is_string($rawJours) && trim($rawJours) !== '') {
                if (stripos($rawJours, 'Tous') !== false) {
                    $jours = ['Tous les jours'];
                } else {
                    $jours = array_filter(array_map('trim', preg_split('/[|,]/', $rawJours)));
                }
            }

            // Normalize horaire: if CSV provides a time like '08:00', prepend today's date
            $rawHoraire = trim((string) ($ligne['horaire'] ?? ''));
            $horaire = null;
            if ($rawHoraire !== '') {
                $clean = preg_replace('/[^0-9:]/', '', $rawHoraire);
                if (preg_match('/^\d{1,2}:\d{2}(:\d{2})?$/', $clean)) {
                    $timePart = (strlen($clean) === 5) ? $clean . ':00' : $clean;
                    $horaire = date('Y-m-d') . ' ' . $timePart;
                } else {
                    $horaire = $rawHoraire;
                }
            }

            $id = (int) ($ligne['id'] ?? 0);
            $payload = [
                'conducteur_id' => isset($ligne['conducteur_id']) ? (int) $ligne['conducteur_id'] : null,
                'ville_depart' => $ligne['ville_depart'] ?? null,
                'ville_arrivee' => $ligne['ville_arrivee'] ?? null,
                'horaire' => $horaire,
                'places_disponibles' => isset($ligne['places_disponibles']) ? (int) $ligne['places_disponibles'] : null,
                'jours_recurrence' => $jours === [] ? null : json_encode(array_values($jours)),
                'updated_at' => now(),
            ];

            if ($id > 0) {
                $payload['created_at'] = now();
                DB::table('trajets')->updateOrInsert(['id' => $id], $payload);
            } else {
                DB::table('trajets')->insert($payload + ['created_at' => now()]);
            }
        }

        fclose($handle);
    }
}
