<?php

use App\Http\Controllers\admin\DiscountCodeController;
use App\Http\Controllers\admin\OrderController;
use App\Http\Controllers\admin\PageController;
use App\Http\Controllers\admin\ProductController;
use App\Http\Controllers\admin\ProductSubCategoryController;
use App\Http\Controllers\admin\SettingController;
use App\Http\Controllers\admin\ShippingController;
use App\Http\Controllers\admin\SubCategoryController;
use App\Http\Controllers\admin\TempImagesController;
use App\Http\Controllers\admin\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\ShopController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\AdminLoginController;
use App\Http\Controllers\admin\CategoryController;
use App\Http\Controllers\admin\HomeController;

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

//Route::get('/', function () {
//    return view('welcome');
//});
Route::get('/', [FrontController::class, 'index'])->name('front.home');
Route::get('/shop/{categorySlug?}/{subCategorySlug?}', [ShopController::class, 'index'])->name('front.shop');
Route::get('/product/{slug}', [ShopController::class, 'product'])->name('front.product');
Route::get('/cart', [CartController::class, 'cart'])->name('front.cart');
Route::post('/add-to-cart', [CartController::class, 'addToCart'])->name('front.addToCart');
Route::post('/update-cart', [CartController::class, 'updateCart'])->name('front.updateCart');
Route::delete('/deleteItem-cart', [CartController::class, 'deleteItem'])->name('front.deleteItemCart');
Route::get('/checkout',[CartController::class, 'checkout'])->name('front.checkout');
Route::post('/process-checkout',[CartController::class, 'processCheckout'])->name('front.processCheckout');
Route::get('/thanks/{orderId}', [CartController::class, 'thankYou'])->name('front.thanks');
Route::post('get-order-summary', [CartController::class, 'getOrderSummary'])->name('front.getOrderSummary');


//apply Discount
Route::post('/apply-discount', [CartController::class, 'applyDiscount'])->name('front.applyDiscount');
Route::post('/remove-discount', [CartController::class, 'removeDiscount'])->name('front.removeDiscount');

//Wishlist Route
Route::post('add-to-wishlist/product',[FrontController::class,'addWishlist'])->name('front.addWishlist');

//Front Page Route
Route::get('/page/{slug}', [FrontController::class, 'page'])->name('front.page');

//Contact us Email
Route::post('/send-contact-email', [FrontController::class, 'sendContactEmail'])->name('front.sendContactEmail');

//Forgot Password
Route::get('/forgot-password', [AuthController::class, 'forgotPassword'])->name('front.forgotPassword');
Route::post('/process-forgot-password', [AuthController::class, 'processForgotPassword'])->name('front.processForgotPassword');
Route::get('/reset-password/{token}', [AuthController::class, 'resetPassword'])->name('front.resetPassword');
Route::post('/process-reset-password', [AuthController::class, 'processResetPassword'])->name('front.processResetPassword');

//Product Rating
Route::post('/product-rating/', [ShopController::class, 'productRating'])->name('front.productRating');


Route::group(['prefix'=>'account'], function () {
    Route::group(['middleware'=>'guest'], function () {
        Route::get('/login', [AuthController::class, 'login'])->name('account.login');
        Route::post('/login', [AuthController::class, 'authenticate'])->name('account.authenticate');
        Route::get('/register', [AuthController::class, 'register'])->name('account.register');
        Route::post('/register', [AuthController::class, 'postRegister'])->name('account.postRegister');


    });
    Route::group(['middleware'=>'auth'], function () {
        Route::get('/profile', [AuthController::class, 'profile'])->name('account.profile');
        Route::post('/update-profile', [AuthController::class, 'updateProfile'])->name('account.updateProfile');
        Route::post('/update-address', [AuthController::class, 'updateAddress'])->name('account.updateAddress');
        Route::get('/my-orders', [AuthController::class, 'orders'])->name('account.orders');
        Route::get('/order-detail/{id}', [AuthController::class, 'orderDetail'])->name('account.orderDetail');
        Route::get('/logout', [AuthController::class, 'logout'])->name('account.logout');
        Route::get('/wishlists', [AuthController::class, 'wishlist'])->name('account.wishlist');
        Route::delete('wishlist/remove/{id}', [AuthController::class, 'deleteWishlist'])->name('front.deleteWishlist');
        Route::get('/change-password', [AuthController::class, 'changePassword'])->name('account.changePassword');
        Route::post('/change-password', [AuthController::class, 'updatePassword'])->name('account.updatePassword');


    });


});

Route::group(['prefix'=>'admin'], function () {
    Route::group(['middleware'=>'admin.guest'], function () {
        Route::get('/login', [AdminLoginController::class, 'index'])->name('admin.login');
        Route::post('/authenticate', [AdminLoginController::class, 'authenticate'])->name('admin.authenticate');
    });

    Route::group(['middleware'=>'admin.auth'], function () {
        Route::get('/dashboard', [HomeController::class, 'index'])->name('admin.dashboard');
        Route::get('/logout', [HomeController::class, 'logout'])->name('admin.logout');

        // Category Route
        Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
        Route::get('/categories/create', [CategoryController::class, 'create'])->name('categories.create');
        Route::post('/categories/store', [CategoryController::class, 'store'])->name('categories.store');
        Route::get('/categories/search', [CategoryController::class, 'search'])->name('categories.search');
        Route::get('/categories/{categories}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
        Route::put('/categories/{categories}', [CategoryController::class, 'update'])->name('categories.update');
        Route::delete('/categories/{categories}', [CategoryController::class, 'destroy'])->name('categories.destroy');


        //SubCategory Route
        Route::get('/sub-categories', [SubCategoryController::class, 'index'])->name('sub-categories.index');
        Route::get('/sub-categories/create', [SubCategoryController::class, 'create'])->name('sub-categories.create');
        Route::post('/sub-/store', [SubCategoryController::class, 'store'])->name('sub-categories.store');
        Route::get('/sub-categories/search', [SubCategoryController::class, 'search'])->name('sub-categories.search');
        Route::get('/sub-categories/{subCategories}/edit', [SubCategoryController::class, 'edit'])->name('sub-categories.edit');
        Route::put('/sub-categories/{subCategory}', [SubCategoryController::class, 'update'])->name('sub-categories.update');
        Route::delete('/sub-categories/{subCategories}', [SubCategoryController::class, 'destroy'])->name('sub-categories.destroy');

        //Product Route
        Route::get('/products', [ProductController::class, 'index'])->name('products.index');
        Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
        Route::post('/products/store', [ProductController::class, 'store'])->name('products.store');
        Route::get('/products/search', [ProductController::class, 'search'])->name('products.search');
        Route::get('/products/{products}/edit', [ProductController::class, 'edit'])->name('products.edit');
        Route::put('/products/{products}', [ProductController::class, 'update'])->name('products.update');
        Route::delete('/delete-image', [ProductController::class, 'deleteImage'])->name('delete-image');
        Route::delete('/sub-products/{products}', [ProductController::class, 'destroy'])->name('products.destroy');
        Route::get('/get-products', [ProductController::class, 'getProducts'])->name('products.getProducts');


        //Product Category get SubCategory Route
        Route::get('/get-sub-categories', [ProductSubCategoryController::class, 'index'])->name('get-sub-categories');

        //Shipping Route
        Route::get('/shipping/create', [ShippingController::class, 'create'])->name('shipping.create');
        Route::post('/shipping/store', [ShippingController::class, 'store'])->name('shipping.store');
        Route::get('/shipping/edit/{id}', [ShippingController::class, 'edit'])->name('shipping.edit');
        Route::put('/shipping/update/{id}', [ShippingController::class, 'update'])->name('shipping.update');
        Route::delete('/shipping/delete/{id}', [ShippingController::class, 'destroy'])->name('shipping.destroy');


        //Coupon Route
        Route::get('coupons',[DiscountCodeController::class,'index'])->name('coupons.index');
        Route::get('/coupons/search', [DiscountCodeController::class, 'search'])->name('coupons.search');
        Route::get('coupons/create',[DiscountCodeController::class,'create'])->name('coupons.create');
        Route::post('coupons/store',[DiscountCodeController::class,'store'])->name('coupons.store');
        Route::get('/coupons/{coupons}/edit', [DiscountCodeController::class, 'edit'])->name('coupons.edit');
        Route::put('/coupons/update/{id}', [DiscountCodeController::class, 'update'])->name('coupons.update');
        Route::delete('/coupons/delete/{id}', [DiscountCodeController::class, 'destroy'])->name('coupons.destroy');


        //Order Route
        Route::get('orders',[OrderController::class,'index'])->name('orders.index');
        Route::get('orders/show/{id}',[OrderController::class,'show'])->name('orders.show');
        Route::get('/orders/search', [OrderController::class, 'search'])->name('orders.search');
        Route::post('/order/change-status/{id}', [OrderController::class, 'changeOrderStatus'])->name('order.changeOrderStatus');
        Route::post('/order/send-email/{id}', [OrderController::class, 'sendInvoiceEmail'])->name('order.sendInvoiceEmail');


        //User Route
        Route::get('users',[UserController::class,'index'])->name('users.index');
        Route::get('/users/search', [UserController::class, 'search'])->name('users.search');
        Route::get('users/create',[UserController::class,'create'])->name('users.create');
        Route::post('users/store',[UserController::class,'store'])->name('users.store');
        Route::get('/users/{users}/edit', [UserController::class, 'edit'])->name('users.edit');
        Route::put('/users/update/{id}', [UserController::class, 'update'])->name('users.update');
        Route::delete('/users/delete/{id}', [UserController::class, 'destroy'])->name('users.destroy');
//        Route::get('users/show/{id}',[UserController::class,'show'])->name('users.show');


        //Pages Route
        Route::get('pages',[PageController::class,'index'])->name('pages.index');
        Route::get('pages/create',[PageController::class,'create'])->name('pages.create');
        Route::get('/pages/search', [PageController::class, 'search'])->name('pages.search');
        Route::post('pages/store',[PageController::class,'store'])->name('pages.store');
        Route::get('/pages/{pages}/edit', [PageController::class, 'edit'])->name('pages.edit');
        Route::put('/pages/update/{id}', [PageController::class, 'update'])->name('pages.update');
        Route::delete('/pages/delete/{id}', [PageController::class, 'destroy'])->name('pages.destroy');

        //Change Password
        Route::get('/change-password', [SettingController::class, 'showChangePasswordForm'])->name('admin.showChangePassword');
        Route::post('/change-password', [SettingController::class, 'updatePassword'])->name('admin.updatePassword');










        //temp-images.create
        Route::post('/upload-temp-image', [TempImagesController::class, 'create'])->name('temp-images.create');

        Route::get('/getSlug', function(Request $request) {
            $slug = '';
            if (!empty($request->title)) {
                $slug = \Illuminate\Support\Str::slug($request->title);
            }
            return response()->json([
                'slug' => $slug
            ]);
        })->name('getSlug');
    });
});
