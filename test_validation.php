<?php

require __DIR__.'/vendor/autoload.php';

$app = require __DIR__.'/bootstrap/app.php';

$app->boot();

// Test 1: Only state_id (Lagos = 24)
$rules = ['state_id' => 'nullable|exists:states,id', 'city_id' => 'nullable|exists:cities,id'];
$data = ['state_id' => 24];
$validator = Illuminate\Support\Facades\Validator::make($data, $rules);
echo "Test 1 - Only state_id (24): ".(!$validator->fails() ? 'PASS' : 'FAIL').PHP_EOL;
if ($validator->fails()) {
    print_r($validator->errors()->toArray());
}

// Test 2: state_id + valid city_id for Lagos
$lagosCity = App\Models\City::where('state_id', 24)->first();
if ($lagosCity) {
    $data = ['state_id' => 24, 'city_id' => $lagosCity->id];
    $validator = Illuminate\Support\Facades\Validator::make($data, $rules);
    echo "Test 2 - Lagos state + valid city: ".(!$validator->fails() ? 'PASS' : 'FAIL').PHP_EOL;
    if ($validator->fails()) {
        print_r($validator->errors()->toArray());
    }
}

// Test 3: state_id + invalid city_id (from different state)
$differentStateCity = App\Models\City::where('state_id', '!=', 24)->first();
if ($differentStateCity) {
    $data = ['state_id' => 24, 'city_id' => $differentStateCity->id];
    $validator = Illuminate\Support\Facades\Validator::make($data, $rules);
    echo "Test 3 - Lagos state + different state city: ".(!$validator->fails() ? 'PASS' : 'FAIL').PHP_EOL;
    if ($validator->fails()) {
        print_r($validator->errors()->toArray());
    }
}