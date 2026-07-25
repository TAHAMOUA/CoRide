<?php
require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Http\Controllers\Auth\ApiAuthenticatedSessionController;
use Illuminate\Http\Request;

$request = Request::create('/api/login', 'POST', [], [], [], [], json_encode([
    'email' => 'admin@techrecrut.test',
    'password' => 'password',
]));
$request->headers->set('Content-Type', 'application/json');

$controller = new ApiAuthenticatedSessionController();
$response = $controller->store($request);

if (method_exists($response, 'getContent')) {
    echo $response->getStatusCode() . '\n';
    echo $response->getContent() . '\n';
} else {
    var_dump($response);
}
