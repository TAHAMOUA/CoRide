<?php

require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$files = [
    'database/data/employes.csv' => 'employes',
    'database/data/trajets.csv' => 'trajets',
    'database/data/reservations.csv' => 'reservations',
];

$csvCounts = [];
foreach ($files as $path => $label) {
    $count = 0;
    if (is_file($path) && is_readable($path)) {
        if (($h = fopen($path, 'r')) !== false) {
            // read header
            $hdr = fgetcsv($h);
            while (($row = fgetcsv($h)) !== false) {
                // skip entirely empty rows
                $allEmpty = true;
                foreach ($row as $cell) {
                    if (trim((string) $cell) !== '') {
                        $allEmpty = false;
                        break;
                    }
                }
                if (! $allEmpty) {
                    $count++;
                }
            }
            fclose($h);
        }
    }
    $csvCounts[$label] = $count;
}

$dbCounts = [];
$dbCounts['entreprises'] = \App\Models\Entreprise::count();
$dbCounts['employes'] = \App\Models\Employe::count();
$dbCounts['trajets'] = \App\Models\Trajet::count();
$dbCounts['reservations'] = \App\Models\Reservation::count();

echo "CSV counts (hors en-tete):\n";
foreach ($csvCounts as $k => $v) {
    echo "- $k: $v\n";
}

echo "\nDB counts:\n";
foreach ($dbCounts as $k => $v) {
    echo "- $k: $v\n";
}

// Simple consistency checks
echo "\nConsistency checks:\n";
$checks = [];
$checks[] = ['label'=>'employes','csv'=> $csvCounts['employes'] ?? 0, 'db'=> $dbCounts['employes']];
$checks[] = ['label'=>'trajets','csv'=> $csvCounts['trajets'] ?? 0, 'db'=> $dbCounts['trajets']];
$checks[] = ['label'=>'reservations','csv'=> $csvCounts['reservations'] ?? 0, 'db'=> $dbCounts['reservations']];

foreach ($checks as $c) {
    $status = ($c['csv'] === $c['db']) ? 'OK' : 'MISMATCH';
    echo "- {$c['label']}: csv={$c['csv']} db={$c['db']} => {$status}\n";
}

// Relation integrity checks
echo "\nRelation checks:\n";
$missingEntreprise = \App\Models\Employe::whereNotIn('entreprise_id', \App\Models\Entreprise::pluck('id')->toArray())->count();
$missingConducteur = \App\Models\Trajet::whereNotIn('conducteur_id', \App\Models\Employe::pluck('id')->toArray())->count();
$missingTrajetInReservation = \App\Models\Reservation::whereNotIn('trajet_id', \App\Models\Trajet::pluck('id')->toArray())->count();
$missingPassagerInReservation = \App\Models\Reservation::whereNotIn('passager_id', \App\Models\Employe::pluck('id')->toArray())->count();

echo "- employes with missing entreprise: $missingEntreprise\n";
echo "- trajets with missing conducteur: $missingConducteur\n";
echo "- reservations with missing trajet: $missingTrajetInReservation\n";
echo "- reservations with missing passager: $missingPassagerInReservation\n";

exit(0);
