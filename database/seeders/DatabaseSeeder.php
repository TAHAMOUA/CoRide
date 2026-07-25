<?php

namespace Database\Seeders;

use App\Models\Employe;
use App\Models\Entreprise;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
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

        $adminEntreprise = Entreprise::firstOrCreate(
            ['nom' => 'Mobilitech'],
            ['created_at' => now(), 'updated_at' => now()]
        );

        Employe::updateOrCreate(
            ['email' => 'admin@techrecrut.test'],
            [
                'nom' => 'Admin CoRide',
                'password' => Hash::make('password'),
                'entreprise_id' => $adminEntreprise->id,
                'ville_residence' => 'Casablanca',
                'role' => 'les_deux',
                'remember_token' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );
    }
}
