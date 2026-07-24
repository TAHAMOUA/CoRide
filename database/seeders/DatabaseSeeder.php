<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

/**
 * Tache: Taha (Epic 2 - Creer les seeders/factories + import CSV)
 *
 * Placez les fichiers fournis par MobiliTech dans database/seeders/data/ :
 *   employes.csv, trajets.csv, reservations.csv
 * puis lancez : php artisan migrate:fresh --seed
 */
class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            EntrepriseSeeder::class,
            EmployeSeeder::class,
            TrajetSeeder::class,
            ReservationSeeder::class,
        ]);
    }
}
