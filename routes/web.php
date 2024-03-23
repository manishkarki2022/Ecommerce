<?php

use App\Http\Controllers\admin\ProductController;
use App\Http\Controllers\admin\ProductSubCategoryController;
use App\Http\Controllers\admin\SubCategoryController;
use App\Http\Controllers\admin\TempImagesController;
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


Route::group(['prefix'=>'account'], function () {
    Route::group(['middleware'=>'guest'], function () {
        Route::get('/login', [AuthController::class, 'login'])->name('account.login');
        Route::post('/login', [AuthController::class, 'authenticate'])->name('account.authenticate');
        Route::get('/register', [AuthController::class, 'register'])->name('account.register');
        Route::post('/register', [AuthController::class, 'postRegister'])->name('account.postRegister');


    });
    Route::group(['middleware'=>'auth'], function () {
        Route::get('/profile', [AuthController::class, 'profile'])->name('account.profile');
        Route::get('/logout', [AuthController::class, 'logout'])->name('account.logout');


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
