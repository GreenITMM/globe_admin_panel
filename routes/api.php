<?php

use App\Http\Controllers\Api\V1\User\UserController;
use App\Http\Controllers\Api\V1\User\WhishListController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\Auth\AuthController;
use App\Http\Controllers\Api\V1\Order\OrderController;
use App\Http\Controllers\Api\V1\Solar\SolarController;
use App\Http\Controllers\Api\V1\XPPen\XPPenController;
use App\Http\Controllers\Api\V1\Auth\RegisterController;
use App\Http\Controllers\Api\V1\Career\CareerController;
use App\Http\Controllers\Api\V1\Content\SliderController;
use App\Http\Controllers\Api\V1\Content\PartnerController;
use App\Http\Controllers\Api\V1\Product\ProductController;
use App\Http\Controllers\Api\V1\Adreamer\AdreamerController;
use App\Http\Controllers\Api\V1\Content\PromotionController;
use App\Http\Controllers\Api\V1\Delivery\DeliveryController;
use App\Http\Controllers\Api\V1\Currency\CurrencyRateController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::group(['prefix' => 'v1','middleware' => ['auth:sanctum']], function () {
    // user
    Route::post('/update-profile', [UserController::class, 'updateProfile']);

    // order
    Route::get('/orders/{user_id}', [OrderController::class, 'index']);

    // wishlist
    Route::post('/add-to-wishlist', [WhishListController::class, 'addToWishlist']);
    Route::get('/wishlists/{user_id}', [WhishListController::class, 'getWishlists']);
    Route::delete('/remove-from-wishlist/{product_id}/{product_type}', [WhishListController::class, 'removeFromWishlist']);
});
Route::get('/orders/{user_id}', [OrderController::class, 'index']);


Route::group(['prefix' => 'v1'], function () {

    // auth
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);

    // career
    Route::get('/careers', [CareerController::class, 'index']);
    Route::get('/careers/{career}', [CareerController::class, 'show']);
    Route::post('submit-career/{career}', [CareerController::class, 'submitCareer']);

    // slider
    Route::get('/sliders', [SliderController::class, 'index']);

    // promotion
    Route::get('/promotions', [PromotionController::class, 'index']);

    // products
    Route::get('/category-lists', [ProductController::class, 'getCategories']);
    Route::get('/products/{category_slug}', [ProductController::class, 'getProducts']);
    Route::get('/product-detail/{product_slug}', [ProductController::class, 'getProductDetail']);

    // adreamer
    Route::get('/adreamer-category-lists', [AdreamerController::class, 'getCategories']);
    Route::get('/adreamer/{category_slug}', [AdreamerController::class, 'getProducts']);
    Route::get('/adreamer-product-detail/{product_slug}', [AdreamerController::class, 'getProductDetail']);

    // xp-pen
    Route::get('/xp-pens-category', [XPPenController::class, 'getCategory']);
    Route::get('/xp-pens-series', [XPPenController::class, 'getSeries']);
    Route::get('/xp-pen/{category_slug}', [XPPenController::class, 'getProducts']);
    Route::get('/xp-pen-detail/{product_slug}', [XPPenController::class, 'getProductDetail']);

    // solar
    Route::get('/solar-category-lists', [SolarController::class, 'getCategories']);
    Route::get('/solar/{category_slug}', [SolarController::class, 'getProducts']);
    Route::get('/solar-product-detail/{product_slug}', [SolarController::class, 'getProductDetail']);

    // partner
    Route::get('/partners', [PartnerController::class, 'index']);

    // currency rate
    Route::get('/usd-mmk-rate', [CurrencyRateController::class, 'getUsdMmkRate']);

    // delivery
    Route::get('/delivery-states', [DeliveryController::class, 'getDeliveryStates']);

    // order
    Route::post('/order', [OrderController::class, 'store']);

    // random products
    Route::get('/random-products', [ProductController::class, 'getRandomProducts']);

    // search product
    Route::get('/search-products', [ProductController::class, 'searchProducts']);

    // popular product
    Route::get('/popular-products', [ProductController::class, 'getPopularProducts']);

});
