<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

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
        // vider les tables en respectant les contraintes FK
        Schema::disableForeignKeyConstraints();
        DB::table('reservations')->truncate();
        DB::table('trajets')->truncate();
        DB::table('employes')->truncate();
        DB::table('entreprises')->truncate();
        Schema::enableForeignKeyConstraints();

        $this->call([
            EntrepriseSeeder::class,
            EmployeSeeder::class,
            TrajetSeeder::class,
            ReservationSeeder::class,
        ]);
    }
}
