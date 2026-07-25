<?php
require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Employe;

$users = Employe::all();
echo 'COUNT:' . $users->count() . PHP_EOL;
foreach ($users as $user) {
    echo $user->id . '|' . $user->email . '|' . $user->password . PHP_EOL;
}
