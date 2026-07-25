<?php
require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Employe;
use Illuminate\Support\Facades\Hash;

$user = Employe::where('email', 'admin@techrecrut.test')->first();
if (! $user) {
    echo "NO_USER\n";
    return;
}

echo "USER:" . $user->email . "\n";
echo "PASSWORD_HASH:" . $user->password . "\n";
echo "CHECK_PASSWORD:" . (Hash::check('password', $user->password) ? 'OK' : 'FAIL') . "\n";
