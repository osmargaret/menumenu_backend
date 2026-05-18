<?php

use Illuminate\Support\Facades\Route;

// ─── Auth ────────────────────────────────────────────────────────────────────
use App\Http\Controllers\Customers\CustomersAuthenticationController;
use App\Http\Controllers\Vendor\VendorAuthenticationController;
use App\Http\Controllers\Admin\AdminAuthenticationController;

// ─── General (public/shared) ──────────────────────────────────────────────────
use App\Http\Controllers\General\OtpController;
use App\Http\Controllers\General\LocationController;
use App\Http\Controllers\General\CategoryController;

// ─── Customer-facing ─────────────────────────────────────────────────────────
use App\Http\Controllers\Customers\VendorController;
use App\Http\Controllers\Customers\MealController;
use App\Http\Controllers\Customers\OrderController;
use App\Http\Controllers\Customers\MessageController;
use App\Http\Controllers\Customers\ReviewController;
use App\Http\Controllers\Customers\WishlistController;
use App\Http\Controllers\Customers\FollowController;
use App\Http\Controllers\Customers\CouponController;

// ─── Vendor-facing ───────────────────────────────────────────────────────────
use App\Http\Controllers\Vendor\VendorDashboardController;

// ─── Admin ────────────────────────────────────────────────────────────────────
use App\Http\Controllers\Admin\VendorVerificationController;
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
| Vendors & Meals — public browsing
|--------------------------------------------------------------------------
*/
Route::get('vendors',                    [VendorController::class, 'index']);
Route::get('vendors/{vendor}',           [VendorController::class, 'show']);
Route::get('vendors/{vendor}/reviews',   [ReviewController::class, 'index']);

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
| Vendor Authentication (public)
|--------------------------------------------------------------------------
*/
Route::post('vendor-register', [VendorAuthenticationController::class, 'register']);
Route::post('vendor-login',    [VendorAuthenticationController::class, 'login']);

/*
|--------------------------------------------------------------------------
| Admin Authentication (public)
|--------------------------------------------------------------------------
*/
Route::post('admin-login',           [AdminAuthenticationController::class, 'login']);
Route::post('admin-forgot-password', [AdminAuthenticationController::class, 'forgotPassword']);

/*
|--------------------------------------------------------------------------
| Authenticated Routes  (customers + vendors both use auth:sanctum)
|--------------------------------------------------------------------------
*/
Route::middleware('auth:sanctum')->group(function () {

    // ── Customer Profile ──────────────────────────────────────────────────
    Route::get('customer/profile',   [CustomersAuthenticationController::class, 'getProfile']);
    Route::patch('customer/profile', [CustomersAuthenticationController::class, 'updateProfile']);

    // ── Vendor Profile ────────────────────────────────────────────────────
    Route::post('vendor/profile', [VendorAuthenticationController::class, 'profile']);

    // ── Vendor Dashboard ──────────────────────────────────────────────────
    Route::get('vendor/dashboard', [VendorDashboardController::class, 'stats']);
    Route::get('vendor/orders',    [VendorDashboardController::class, 'orders']);
    Route::get('vendor/meals',     [VendorDashboardController::class, 'meals']);

    // ── Vendors (write) ───────────────────────────────────────────────────
    Route::post('vendors',            [VendorController::class, 'store']);
    Route::put('vendors/{vendor}',    [VendorController::class, 'update']);
    Route::patch('vendors/{vendor}',  [VendorController::class, 'update']);
    Route::delete('vendors/{vendor}', [VendorController::class, 'destroy']);

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
    Route::post('vendors/{vendor}/reviews', [ReviewController::class, 'store']);
    Route::delete('reviews/{review}',       [ReviewController::class, 'destroy']);

    // ── Wishlist ──────────────────────────────────────────────────────────
    Route::get('wishlist',            [WishlistController::class, 'index']);
    Route::post('wishlist',           [WishlistController::class, 'store']);
    Route::delete('wishlist/{meal}',  [WishlistController::class, 'destroy']);

    // ── Follows ───────────────────────────────────────────────────────────
    Route::get('follows',                      [FollowController::class, 'index']);
    Route::post('vendors/{vendor}/follow',     [FollowController::class, 'toggle']);

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

    // Vendor verifications
    Route::apiResource('vendor-verifications', VendorVerificationController::class);

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
