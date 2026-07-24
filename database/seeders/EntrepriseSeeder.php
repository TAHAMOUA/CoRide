<?php

namespace Database\Seeders;

use App\Models\Entreprise;
use Illuminate\Database\Seeder;

/**
 * Tache: Taha (Epic 2 - Creer les seeders/factories + import CSV)
 * Les 5 entreprises partenaires citees dans le brief.
 */
class EntrepriseSeeder extends Seeder
{
    public function run(): void
    {
        collect(['MobiliTech', 'NextBuild', 'Atlas Digital', 'GreenLogix', 'Kandia Solutions'])
            ->each(fn (string $nom) => Entreprise::firstOrCreate(['nom' => $nom]));
    }
}
