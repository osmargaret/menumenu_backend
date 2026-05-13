<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Customers\CustomersAuthenticationController;
use App\Http\Controllers\Api\Admin\VendorVerificationController;
use App\Http\Controllers\Api\Admin\RefundController;
use App\Http\Controllers\Api\Admin\PayoutController;
use App\Http\Controllers\Api\Admin\AuditLogController;
use App\Http\Controllers\Api\Admin\SettingController;
use App\Http\Controllers\Api\Admin\RoleController;
use App\Http\Controllers\Api\VendorController;
use App\Http\Controllers\Api\MealController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Admin\AdminAuthenticationController;

use App\Http\Controllers\Vendor\VendorAuthenticationController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('welcome', function(){
    return 'Hello World';
});

Route::get('debug-states', function() {
    return response()->json([
        'count' => \App\Models\State::count(),
        'first_five' => \App\Models\State::limit(5)->get(),
        'db_connection' => config('database.default'),
        'db_database' => config('database.connections.' . config('database.default') . '.database'),
    ]);
});

Route::post('customer-login', [CustomersAuthenticationController::class,'login']);
Route::post('customer-register', [CustomersAuthenticationController::class,'register']);
Route::post('forgot-password', [CustomersAuthenticationController::class,'forgotPassword']);
Route::post('admin-login', [AdminAuthenticationController::class, 'login']);
Route::post('admin-forgot-password', [AdminAuthenticationController::class, 'forgotPassword']);
Route::post('vendor-login', [VendorAuthenticationController::class, 'login']);
Route::post('vendor-register', [VendorAuthenticationController::class, 'register']);

Route::middleware(['auth:sanctum', 'admin.auth'])->prefix('admin')->group(function () {
    Route::get('profile', [AdminAuthenticationController::class, 'profile']);
    Route::post('logout', [AdminAuthenticationController::class, 'logout']);
    
    Route::apiResource('vendor-verifications', VendorVerificationController::class);
    Route::apiResource('refunds', RefundController::class);
    Route::apiResource('payouts', PayoutController::class);
    Route::get('audit-logs', [AuditLogController::class, 'index']);
    Route::get('audit-logs/{auditLog}', [AuditLogController::class, 'show']);
    Route::apiResource('settings', SettingController::class);
    Route::apiResource('roles', RoleController::class);
    Route::post('roles/{role}/assign-users', [RoleController::class, 'assignUsers']);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::post('vendor/profile', [VendorAuthenticationController::class, 'profile']);
    Route::apiResource('vendors', VendorController::class);
    Route::apiResource('meals', MealController::class);
    Route::apiResource('orders', OrderController::class);
    Route::get('messages', [\App\Http\Controllers\Api\MessageController::class, 'index']);
    Route::get('messages/{otherUserId}', [\App\Http\Controllers\Api\MessageController::class, 'show']);
    Route::post('messages', [\App\Http\Controllers\Api\MessageController::class, 'store']);
    Route::patch('messages/{otherUserId}/read', [\App\Http\Controllers\Api\MessageController::class, 'markAsRead']);
});

// Public listings
Route::get('vendors', [VendorController::class, 'index']);
Route::get('vendors/{vendor}', [VendorController::class, 'show']);
Route::get('meals', [MealController::class, 'index']);
Route::get('meals/{meal}', [MealController::class, 'show']);