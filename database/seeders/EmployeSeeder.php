<?php

namespace Database\Seeders;

use App\Models\Employe;
use App\Models\Entreprise;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

/**
 * Tache: Taha (Epic 2 - Creer les seeders/factories + import CSV)
 *
 * Importe database/seeders/data/employes.csv (colonnes :
 * id,nom,email,entreprise,ville_residence,role).
 * Si le fichier est absent, se replie sur la Factory (40 employes generes).
 */
class EmployeSeeder extends Seeder
{
    public function run(): void
    {
        $path = database_path('data/employes.csv');

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

            $entrepriseId = null;
            if (! empty($ligne['entreprise'])) {
                $entreprise = Entreprise::firstOrCreate(['nom' => trim($ligne['entreprise'])]);
                $entrepriseId = $entreprise->id;
            } elseif (! empty($ligne['entreprise_id'])) {
                $entrepriseId = (int) $ligne['entreprise_id'];
            }

            // Conserver l'id tel quel pour correspondre aux autres CSV
            $id = (int) ($ligne['id'] ?? 0);
            $payload = [
                'nom' => $ligne['nom'] ?? null,
                'email' => isset($ligne['email']) ? trim($ligne['email']) : null,
                'password' => Hash::make('password'),
                'entreprise_id' => $entrepriseId,
                'ville_residence' => $ligne['ville_residence'] ?? null,
                'role' => $ligne['role'] ?? null,
                'updated_at' => now(),
            ];

            if ($id > 0) {
                $payload['created_at'] = now();
                DB::table('employes')->updateOrInsert(['id' => $id], $payload);
            } else {
                // fallback: insert without forcing id
                DB::table('employes')->insert($payload + ['created_at' => now()]);
            }
        }

        fclose($handle);
    }
}
