<?php

namespace Database\Seeders;

use App\Models\Employe;
use App\Models\Entreprise;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

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
        $path = database_path('seeders/data/employes.csv');

        if (! is_file($path)) {
            Employe::factory()->count(40)->create();

            return;
        }

        $lignes = array_map('str_getcsv', file($path));
        $entetes = array_shift($lignes);

        foreach ($lignes as $ligne) {
            $ligne = array_combine($entetes, $ligne);

            $entreprise = Entreprise::firstOrCreate(['nom' => trim($ligne['entreprise'])]);

            // On conserve l'id du CSV tel quel : trajets.csv et reservations.csv
            // referencent conducteur_id / passager_id sur la base de ces memes ids.
            Employe::updateOrCreate(
                ['id' => (int) $ligne['id']],
                [
                    'nom' => $ligne['nom'],
                    'email' => trim($ligne['email']),
                    'password' => Hash::make('password'),
                    'entreprise_id' => $entreprise->id,
                    'ville_residence' => $ligne['ville_residence'],
                    'role' => $ligne['role'],
                ]
            );
        }
    }
}
