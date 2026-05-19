<?php

require __DIR__.'/vendor/autoload.php';

$app = require __DIR__.'/bootstrap/app.php';

$app->boot();

use Illuminate\Http\Request;
use Illuminate\Contracts\Http\Kernel;

$request = Request::create('/api/customer-register', 'POST', [
    'name' => 'Test User',
    'email' => 'test@example.com',
    'password' => 'password123',
    'password_confirmation' => 'password123',
    'state_id' => 24, // Lagos
]);

$request->headers->set('Content-Type', 'application/json');

/** @var Kernel $kernel */
$kernel = $app->make(Kernel::class);

try {
    $response = $kernel->handle($request);
    echo "Status: ".$response->getStatusCode().PHP_EOL;
    echo "Content: ".$response->getContent().PHP_EOL;
} catch (Exception $e) {
    echo "Error: ".$e->getMessage().PHP_EOL;
    echo "Trace: ".$e->getTraceAsString().PHP_EOL;
}