<?php

use Illuminate\Support\Facades\Route;

// ─── Auth ────────────────────────────────────────────────────────────────────
use App\Http\Controllers\Customers\CustomersAuthenticationController;
use App\Http\Controllers\Kitchen\KitchenAuthenticationController;
use App\Http\Controllers\Admin\AdminAuthenticationController;

// ─── General (public/shared) ──────────────────────────────────────────────────
use App\Http\Controllers\General\OtpController;
use App\Http\Controllers\General\LocationController;
use App\Http\Controllers\General\CategoryController;

// ─── Customer-facing ─────────────────────────────────────────────────────────
use App\Http\Controllers\Customers\KitchenController;
use App\Http\Controllers\Customers\MealController;
use App\Http\Controllers\Customers\OrderController;
use App\Http\Controllers\Customers\MessageController;
use App\Http\Controllers\Customers\ReviewController;
use App\Http\Controllers\Customers\WishlistController;
use App\Http\Controllers\Customers\FollowController;
use App\Http\Controllers\Customers\CouponController;

// ─── Kitchen-facing ───────────────────────────────────────────────────────────
use App\Http\Controllers\Kitchen\KitchenDashboardController;

// ─── Admin ────────────────────────────────────────────────────────────────────
use App\Http\Controllers\Admin\KitchenVerificationController;
use App\Http\Controllers\Admin\RefundController;
use App\Http\Controllers\Admin\PayoutController;
use App\Http\Controllers\Admin\AuditLogController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\RoleController;

/*
|--------------------------------------------------------------------------
| Health Check
|--------------------------------------------------------------------------
*/
Route::get('welcome', fn () => response()->json(['status' => 'ok', 'app' => 'Feast Finder API']));

/*
|--------------------------------------------------------------------------
| Location — Nigerian States & Cities (public)
|--------------------------------------------------------------------------
*/
Route::get('states',[LocationController::class, 'states']);   // list all 37 states
Route::get('states/{state}/cities', [LocationController::class, 'cities']);   // cities for a state

/*
|--------------------------------------------------------------------------
| Categories (public read)
|--------------------------------------------------------------------------
*/
Route::get('categories',            [CategoryController::class, 'index']);
Route::get('categories/{category}', [CategoryController::class, 'show']);

/*
|--------------------------------------------------------------------------
| Kitchens & Meals — public browsing
|--------------------------------------------------------------------------
*/
Route::get('kitchens',                    [KitchenController::class, 'index']);
Route::get('kitchens/{kitchen}',           [KitchenController::class, 'show']);
Route::get('kitchens/{kitchen}/reviews',   [ReviewController::class, 'index']);

Route::get('meals',                      [MealController::class, 'index']);
Route::get('meals/{meal}',               [MealController::class, 'show']);

/*
|--------------------------------------------------------------------------
| Customer Authentication (public)
|--------------------------------------------------------------------------
*/
Route::post('customer-register', [CustomersAuthenticationController::class, 'register']);
Route::post('hi/customer-register', [CustomersAuthenticationController::class, 'register']); // For backward compatibility
Route::post('customer-login',    [CustomersAuthenticationController::class, 'login']);
Route::post('forgot-password',   [CustomersAuthenticationController::class, 'forgotPassword']);
Route::post('verify-otp',        [OtpController::class, 'verify']);
Route::post('resend-otp',        [OtpController::class, 'resend']);

/*
|--------------------------------------------------------------------------
| Kitchen Authentication (public)
|--------------------------------------------------------------------------
*/
Route::post('kitchen-register', [KitchenAuthenticationController::class, 'register']);
Route::post('kitchen-login',    [KitchenAuthenticationController::class, 'login']);

/*
|--------------------------------------------------------------------------
| Admin Authentication (public)
|--------------------------------------------------------------------------
*/
Route::post('admin-login',           [AdminAuthenticationController::class, 'login']);
Route::post('admin-forgot-password', [AdminAuthenticationController::class, 'forgotPassword']);

/*
|--------------------------------------------------------------------------
| Authenticated Routes  (customers + kitchens both use auth:sanctum)
|--------------------------------------------------------------------------
*/
Route::middleware('auth:sanctum')->group(function () {

    // ── Customer Profile ──────────────────────────────────────────────────
    Route::get('customer/profile',   [CustomersAuthenticationController::class, 'getProfile']);
    Route::patch('customer/profile', [CustomersAuthenticationController::class, 'updateProfile']);

    // ── Kitchen Profile ────────────────────────────────────────────────────
    Route::post('kitchen/profile', [KitchenAuthenticationController::class, 'profile']);

    // ── Kitchen Dashboard ──────────────────────────────────────────────────
    Route::get('kitchen/dashboard', [KitchenDashboardController::class, 'stats']);
    Route::get('kitchen/orders',    [KitchenDashboardController::class, 'orders']);
    Route::get('kitchen/meals',     [KitchenDashboardController::class, 'meals']);

    // ── Kitchens (write) ───────────────────────────────────────────────────
    Route::post('kitchens',            [KitchenController::class, 'store']);
    Route::put('kitchens/{kitchen}',    [KitchenController::class, 'update']);
    Route::patch('kitchens/{kitchen}',  [KitchenController::class, 'update']);
    Route::delete('kitchens/{kitchen}', [KitchenController::class, 'destroy']);

    // ── Meals (write) ─────────────────────────────────────────────────────
    Route::post('meals',          [MealController::class, 'store']);
    Route::put('meals/{meal}',    [MealController::class, 'update']);
    Route::patch('meals/{meal}',  [MealController::class, 'update']);
    Route::delete('meals/{meal}', [MealController::class, 'destroy']);

    // ── Orders ────────────────────────────────────────────────────────────
    Route::get('orders',              [OrderController::class, 'index']);
    Route::get('orders/{order}',      [OrderController::class, 'show']);
    Route::post('orders',             [OrderController::class, 'store']);
    Route::patch('orders/{order}',    [OrderController::class, 'update']);
    Route::delete('orders/{order}',   [OrderController::class, 'destroy']);

    // ── Reviews ───────────────────────────────────────────────────────────
    Route::post('kitchens/{kitchen}/reviews', [ReviewController::class, 'store']);
    Route::delete('reviews/{review}',       [ReviewController::class, 'destroy']);

    // ── Wishlist ──────────────────────────────────────────────────────────
    Route::get('wishlist',            [WishlistController::class, 'index']);
    Route::post('wishlist',           [WishlistController::class, 'store']);
    Route::delete('wishlist/{meal}',  [WishlistController::class, 'destroy']);

    // ── Follows ───────────────────────────────────────────────────────────
    Route::get('follows',                      [FollowController::class, 'index']);
    Route::post('kitchens/{kitchen}/follow',     [FollowController::class, 'toggle']);

    // ── Coupons ───────────────────────────────────────────────────────────
    Route::post('coupons/validate', [CouponController::class, 'validate']);

    // ── Messages ──────────────────────────────────────────────────────────
    Route::get('messages',                       [MessageController::class, 'index']);
    Route::get('messages/{otherUserId}',         [MessageController::class, 'show']);
    Route::post('messages',                      [MessageController::class, 'store']);
    Route::patch('messages/{otherUserId}/read',  [MessageController::class, 'markAsRead']);
});

/*
|--------------------------------------------------------------------------
| Admin Routes  (admin token + admin.auth middleware)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth:sanctum', 'admin.auth'])->prefix('admin')->group(function () {

    Route::get('profile',  [AdminAuthenticationController::class, 'profile']);
    Route::post('logout',  [AdminAuthenticationController::class, 'logout']);

    // Kitchen verifications
    Route::apiResource('kitchen-verifications', KitchenVerificationController::class);

    // Refunds & Payouts
    Route::apiResource('refunds', RefundController::class);
    Route::apiResource('payouts', PayoutController::class);

    // Audit logs (read-only)
    Route::get('audit-logs',             [AuditLogController::class, 'index']);
    Route::get('audit-logs/{auditLog}',  [AuditLogController::class, 'show']);

    // Settings
    Route::apiResource('settings', SettingController::class);

    // Roles & staff
    Route::apiResource('roles', RoleController::class);
    Route::post('roles/{role}/assign-users', [RoleController::class, 'assignUsers']);

    // Category management (admin-only writes)
    Route::post('categories',             [CategoryController::class, 'store']);
    Route::put('categories/{category}',   [CategoryController::class, 'update']);
    Route::patch('categories/{category}', [CategoryController::class, 'update']);
    Route::delete('categories/{category}',[CategoryController::class, 'destroy']);
});
