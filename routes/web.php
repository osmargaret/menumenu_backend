<?php

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

require __DIR__.'/settings.php';


Route::get('run-seeder', function () {
    Artisan::call('db:seed', ['--force' => true]);
    return 'Seeder executed successfully!';
});

Route::get('migrate', function () {
    Artisan::call('migrate', ['--force' => true]);
    return 'Migration executed successfully!';
});

Route::get('route-cache', function () {
    Artisan::call('route:cache');
    return 'Route cache cleared successfully!';
});

Route::get('config-clear', function () {
    Artisan::call('config:clear');
    return 'Config cache cleared successfully!';
});

Route::get('config-cache', function () {
    Artisan::call('config:cache');
    return 'Config cached successfully!';
});

