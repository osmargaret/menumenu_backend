<?php

require __DIR__.'/vendor/autoload.php';

$app = require __DIR__.'/bootstrap/app.php';

$app->boot();

use Illuminate\Http\Request;
use App\Http\Controllers\Customers\CustomersAuthenticationController;

// Test with valid Lagos state + valid Lagos city
$lagosState = App\Models\State::where('name', 'Lagos')->first();
$lagosCity = App\Models\City::where('state_id', $lagosState->id)->first();

if (!$lagosState || !$lagosCity) {
    die("Could not find Lagos state or city".PHP_EOL);
}

$_POST = [
    'name' => 'Test User',
    'email' => 'test@example.com',
    'password' => 'password123',
    'password_confirmation' => 'password123',
    'state_id' => $lagosState->id,
    'city_id' => $lagosCity->id
];

$request = new Request($_POST);

$controller = new CustomersAuthenticationController();

try {
    $response = $controller->register($request);
    echo "Response status: ".$response->getStatusCode().PHP_EOL;
    echo "Response content: ".$response->getContent().PHP_EOL;
} catch (\Exception $e) {
    echo "Exception: ".$e->getMessage().PHP_EOL;
}