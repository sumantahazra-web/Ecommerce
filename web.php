<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\RecommendationController;
use App\Http\Controllers\AIController;

Route::get('/', function () {
    return view('welcome');
});



// REGISTER


Route::get('/register', [AuthController::class, 'register']);

Route::post('/register', [AuthController::class, 'registerSubmit']);



// LOGIN


Route::get('/login', [AuthController::class, 'login']);

Route::post('/login', [AuthController::class, 'loginSubmit']);



// PROTECTED ROUTES


Route::middleware('auth')->group(function () {

    // User Dashboard
    Route::middleware('auth')->group(function () {

    Route::get('/dashboard', [AuthController::class, 'userDashboard'])
        ->middleware('user');

    Route::get('/products/{id}', [ProductController::class, 'show'])
        ->middleware('user');

    Route::get('/recommendations', [RecommendationController::class, 'index'])
        ->middleware('user');

    Route::post('/logout', [AuthController::class, 'logout']);

});

    // Admin Dashboard

    Route::get('/admin/dashboard', [AuthController::class, 'adminDashboard'])
        ->middleware('admin');

    // Admin Panel

Route::get('/admin', [AuthController::class, 'admin'])
    ->middleware('admin');

    Route::middleware(['auth', 'admin'])->group(function () {

    Route::get('/admin/products',[ProductController::class, 'index'])
        ->name('admin.products.index');

    Route::get('/admin/products/create',[ProductController::class, 'create'])
        ->name('admin.products.create');

    Route::post('/admin/products',[ProductController::class, 'store'])
        ->name('admin.products.store');

     // Edit product
    Route::get('/admin/products/{id}/edit', [ProductController::class, 'edit']);

    // Update product
    Route::put('/admin/products/{id}', [ProductController::class, 'update']);
    
    // Delete product
    Route::delete('/admin/products/{id}', [ProductController::class, 'destroy']);

    // Categories
    Route::get('/admin/categories', [CategoryController::class, 'index']);

    Route::get('/admin/categories/create', [CategoryController::class, 'create']);

    Route::post('/admin/categories', [CategoryController::class, 'store']);

    Route::get('/admin/categories/{id}/edit',[CategoryController::class, 'edit']);

    Route::put('/admin/categories/{id}',[CategoryController::class, 'update']);

    Route::delete('/admin/categories/{id}',[CategoryController::class, 'destroy']);

    // Users
    Route::get('/admin/users',[UserController::class, 'index']);

    Route::get('/admin/users/{id}',[UserController::class, 'show']);

    Route::get('/admin/users/{id}/edit',[UserController::class, 'edit']);

    Route::put('/admin/users/{id}',[UserController::class, 'update']);

    Route::delete('/admin/users/{id}',[UserController::class, 'destroy']);


    // ORDERS

    Route::get('/admin/orders', [OrderController::class, 'index']);

    Route::get('/admin/orders/{id}', [OrderController::class, 'showAdmin']);

    Route::put('/admin/orders/{id}/status', [OrderController::class, 'updateStatus']);

});

    // Logout
    Route::post('/logout', [AuthController::class, 'logout']);
});


// CART ROUTES


Route::post('/cart/add/{id}', [CartController::class, 'add'])
    ->middleware(['auth', 'user']);

Route::get('/cart', [CartController::class, 'index'])
    ->middleware(['auth', 'user']);

Route::post('/cart/update/{id}', [CartController::class, 'update'])
    ->middleware('user');

Route::post('/cart/remove/{id}', [CartController::class, 'remove'])
    ->middleware('user');

Route::post('/cart/clear', [CartController::class, 'clear'])
    ->middleware('user');


// CHECKOUT

Route::get('/checkout', [OrderController::class, 'checkout'])
    ->middleware('user');

Route::post('/checkout', [OrderController::class, 'placeOrder'])
    ->middleware('user');

// MY ORDERS
Route::get('/my-orders', [OrderController::class, 'myOrders'])
    ->middleware('user');

Route::get('/my-orders/{id}', [OrderController::class, 'show'])
    ->middleware('user');

Route::post('/my-orders/{id}/cancel', [OrderController::class, 'cancel'])
    ->middleware('user');


// WISHLIST ROUTES


Route::get('/wishlist', [WishlistController::class, 'index'])
    ->middleware('user');

Route::post('/wishlist/add/{productId}', [WishlistController::class, 'add'])
    ->middleware('user');

Route::post('/wishlist/remove/{id}', [WishlistController::class, 'remove'])
    ->middleware('user');


// AI

Route::get('/ai', function () {return view('ai');})
    ->middleware(['auth', 'user']);
    
Route::post('/ai/ask', [AIController::class, 'askAI'])
    ->middleware(['auth', 'user']);


