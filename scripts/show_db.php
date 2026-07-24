<?php

require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "Entreprises:\n";
foreach (\App\Models\Entreprise::all() as $e) {
    echo "id={$e->id} nom={$e->nom}\n";
}

echo "\nEmployes:\n";
foreach (\App\Models\Employe::all() as $e) {
    echo "id={$e->id} nom={$e->nom} email={$e->email} entreprise_id={$e->entreprise_id}\n";
}

echo "\nTrajets count: " . \App\Models\Trajet::count() . "\n";
foreach (\App\Models\Trajet::limit(10)->get() as $t) {
    echo "id={$t->id} conducteur_id={$t->conducteur_id} depart={$t->ville_depart} arrivee={$t->ville_arrivee}\n";
}

echo "\nReservations count: " . \App\Models\Reservation::count() . "\n";
foreach (\App\Models\Reservation::limit(10)->get() as $r) {
    echo "id={$r->id} trajet_id={$r->trajet_id} passager_id={$r->passager_id} statut={$r->statut}\n";
}
