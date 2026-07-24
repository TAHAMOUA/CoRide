<?php

require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$emps = \App\Models\Employe::all();
echo "Employes count: " . $emps->count() . "\n";
foreach ($emps as $e) {
    echo "id={$e->id} nom={$e->nom} email={$e->email} entreprise_id={$e->entreprise_id}\n";
}
