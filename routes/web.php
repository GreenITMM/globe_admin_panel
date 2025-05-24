<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\RolesController;
use App\Http\Controllers\Admin\DropzoneController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\XPPen\XPPenSeriesController;
use App\Http\Controllers\Admin\Order\PendingOrderController;
use App\Http\Controllers\Admin\Solar\SolarProductController;
use App\Http\Controllers\Admin\XPPen\XPPenProductController;
use App\Http\Controllers\Admin\Solar\SolarCategoryController;
use App\Http\Controllers\Admin\XPPen\XPPenCategoryController;
use App\Http\Controllers\Admin\Order\CancelledOrderController;
use App\Http\Controllers\Admin\Order\ConfirmedOrderController;
use App\Http\Controllers\Admin\Solar\SolarAttributeController;
use App\Http\Controllers\Admin\Currency\CurrencyRateController;
use App\Http\Controllers\Admin\CareerManagement\CareerController;
use App\Http\Controllers\Admin\DeliveryManagement\CityController;
use App\Http\Controllers\Admin\ProductManagement\BrandController;
use App\Http\Controllers\Admin\Adreamer\AdreamerProductController;
use App\Http\Controllers\Admin\ContentManagement\SliderController;
use App\Http\Controllers\Admin\DeliveryManagement\StateController;
use App\Http\Controllers\Admin\ProductManagement\SeriesController;
use App\Http\Controllers\Admin\Adreamer\AdreamerCategoryController;
use App\Http\Controllers\Admin\CareerManagement\PositionController;
use App\Http\Controllers\Admin\ContentManagement\PartnerController;
use App\Http\Controllers\Admin\ProductManagement\ProductController;
use App\Http\Controllers\Admin\Adreamer\AdreamerAttributeController;
use App\Http\Controllers\Admin\ProductManagement\CategoryController;
use App\Http\Controllers\Admin\CareerManagement\DepartmentController;
use App\Http\Controllers\Admin\ContentManagement\PromotionController;
use App\Http\Controllers\Admin\ProductManagement\AttributeController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
 */
Route::get('/', function () {return redirect()->route('admin.home');});

Route::group(['middleware' => ['auth', 'prevent-back-history'], 'prefix' => 'admin', 'as' => 'admin.'], function () {
    Route::get('/', [ProfileController::class, 'dashboard'])->name('home');

    //permission
    Route::get('/permission-datatable', [PermissionController::class, 'dataTable']);
    Route::resource('permissions', PermissionController::class);

    //roles
    Route::get('/roles-datatable', [RolesController::class, 'dataTable']);
    Route::resource('roles', RolesController::class);

    //users
    Route::get('/users-datatable', [UserController::class, 'dataTable']);
    Route::resource('users', UserController::class);

    Route::get('currency-rates', [CurrencyRateController::class, 'index'])->name('currency-rates.index');
    Route::post('currency-rates', [CurrencyRateController::class, 'changeRate'])->name('currency-rates.changeRate');

    Route::group(['prefix' => 'product-management'], function () {
        //brand
        Route::get('/brands/get-series-by-brands', [BrandController::class, 'getSeriesByBrands']);
        Route::get('brands-list', [BrandController::class, 'brandLists']);
        Route::post('update-brand/{brand}', [BrandController::class, 'updateBrand']);
        Route::resource('brands', BrandController::class);

        // series
        Route::get('series-list', [SeriesController::class, 'seriesLists']);
        Route::post('update-series/{series}', [SeriesController::class, 'updateSeries']);
        Route::resource('series', SeriesController::class);

        //category
        Route::get('category-list', [CategoryController::class, 'categoryLists']);
        Route::post('update-category/{category}', [CategoryController::class, 'updateCategory']);
        Route::resource('categories', CategoryController::class);

        // attributes
        Route::get('attribute-list', [AttributeController::class, 'attributeLists']);
        Route::post('update-attribute/{attribute}', [AttributeController::class, 'updateAttribute']);
        Route::resource('attributes', AttributeController::class);

        //product
        Route::get('product-list', [ProductController::class, 'productLists']);
        Route::post('/products/storeMedia', [ProductController::class, 'storeMedia'])->name('products.storeMedia');
        Route::post('/products/deleteMedia', [ProductController::class, 'deleteMedia'])->name('products.deleteMedia');
        Route::post('update-product/{product}', [ProductController::class, 'updateProduct']);
        Route::resource('products', ProductController::class);
    });

    Route::group(['prefix' => 'career-management'], function () {
        // department
        Route::get('department-list', [DepartmentController::class, 'departmentLists']);
        Route::post('update-department/{department}', [DepartmentController::class, 'updateDepartment']);
        Route::resource('departments', DepartmentController::class);

        // position
        Route::get('position-list', [PositionController::class, 'positionLists']);
        Route::post('update-position/{position}', [PositionController::class, 'updatePosition']);
        Route::resource('positions', PositionController::class);

        // career
        Route::get('career-list', [CareerController::class, 'careerLists']);
        Route::post('update-career/{career}', [CareerController::class, 'updateCareer']);
        Route::resource('careers', CareerController::class);
    });

    Route::group(['prefix' => 'content-management'], function() {
        // slider
        Route::get('slider-list', [SliderController::class, 'sliderLists']);
        Route::post('update-slider/{slider}', [SliderController::class, 'updateSlider']);
        Route::resource('slider', SliderController::class);

        // promotion
        Route::get('promotions-list', [PromotionController::class, 'promotionLists']);
        Route::post('update-promotions/{promotion}', [PromotionController::class, 'updatePromotion']);
        Route::get('toggle-promotion/{promotion}', [PromotionController::class, 'togglePromotion']);
        Route::resource('promotions', PromotionController::class);

        // our partenr
        Route::get('partners-list', [PartnerController::class, 'partnerLists']);
        Route::post('update-partner/{partner}', [PartnerController::class, 'updatePartner']);
        Route::resource('partners', PartnerController::class);
    });

    Route::group(['prefix' => 'xppen'], function() {
        // Cateogry
        Route::get('xppen-category-list', [XPPenCategoryController::class, 'categoryLists']);
        Route::post('update-xppen-category/{xppen_category}', [XPPenCategoryController::class, 'updateCategory']);
        Route::resource('xppen-categories', XPPenCategoryController::class);

        // series
        Route::get('xppen-series-list', [XPPenSeriesController::class, 'seriesLists']);
        Route::post('update-xppen-series/{xppen_series}', [XPPenSeriesController::class, 'updateSeries']);
        Route::resource('xppen-series', XPPenSeriesController::class);

        // products
        Route::get('xppen-product-list', [XPPenProductController::class, 'productLists']);
        Route::post('update-xppen-product/{xppen_product}', [XPPenProductController::class, 'updateProduct']);
        Route::resource('xppen-products', XPPenProductController::class);
    });

    Route::group(['prefix' => 'adreamer'], function() {
        // category
        Route::get('adreamer-category-list', [AdreamerCategoryController::class, 'categoryLists']);
        Route::post('update-adreamer-category/{adreamer_category}', [AdreamerCategoryController::class, 'updateCategory']);
        Route::resource('adreamer-categories', AdreamerCategoryController::class);

        // attribute
        Route::get('adreamer-attribute-list', [AdreamerAttributeController::class, 'attributeLists']);
        Route::post('update-adreamer-attribute/{adreamer_attribute}', [AdreamerAttributeController::class, 'updateAttribute']);
        Route::resource('adreamer-attributes', AdreamerAttributeController::class);

        // product
        Route::get('adreamer-product-list', [AdreamerProductController::class, 'productLists']);
        Route::post('update-adreamer-product/{adreamer_product}', [AdreamerProductController::class, 'updateProduct']);
        Route::resource('adreamer-products', AdreamerProductController::class);
    });

    Route::group(['prefix' => 'solar'], function() {
        // category
        Route::get('solar-category-list', [SolarCategoryController::class, 'categoryLists']);
        Route::post('update-solar-category/{solar_category}', [SolarCategoryController::class, 'updateCategory']);
        Route::get('get-child-category/{solar_category}', [SolarCategoryController::class, 'getChildCategory']);
        Route::resource('solar-categories', SolarCategoryController::class);

         // attribute
         Route::get('solar-attribute-list', [SolarAttributeController::class, 'attributeLists']);
         Route::post('update-solar-attribute/{solar_attribute}', [SolarAttributeController::class, 'updateAttribute']);
         Route::resource('solar-attributes', SolarAttributeController::class);

         // product
        Route::get('solar-product-list', [SolarProductController::class, 'productLists']);
        Route::post('update-solar-product/{solar_product}', [SolarProductController::class, 'updateProduct']);
        Route::resource('solar-products', SolarProductController::class);
    });

    Route::group(['prefix' => 'delivery-management'], function() {
        // state
        Route::get('state-list', [StateController::class, 'stateLists']);
        Route::post('update-state/{state}', [StateController::class, 'updateState']);
        Route::resource('states', StateController::class);

        // city
        Route::get('city-list', [CityController::class, 'cityLists']);
        Route::post('update-city/{city}', [CityController::class, 'updateCity']);
        Route::resource('cities', CityController::class);
    });

    Route::group(['prefix' => 'order-management'], function() {
        // pending order
        Route::get('pending-order-list', [PendingOrderController::class, 'pendingOrderLists']);
        Route::get('confirm-order/{order_id}', [PendingOrderController::class, 'confirmOrder']);
        Route::get('cancel-order/{order_id}', [PendingOrderController::class, 'cancelOrder']);
        Route::resource('pending-orders', PendingOrderController::class);

        // confirmed order
        Route::get('confirmed-order-list', [ConfirmedOrderController::class, 'confirmedOrderLists']);
        Route::resource('confirmed-orders', ConfirmedOrderController::class);

        // cancelled order
        Route::get('cancelled-order-list', [CancelledOrderController::class, 'cancelledOrderLists']);
        Route::resource('cancelled-orders', CancelledOrderController::class);
    });


    Route::post('/dropzone/storeMedia', [DropzoneController::class, 'storeMedia'])->name('dropzone.storeMedia');
    Route::post('/dropzone/deleteMedia', [DropzoneController::class, 'deleteMedia'])->name('dropzone.deleteMedia');
});

require __DIR__ . '/auth.php';
