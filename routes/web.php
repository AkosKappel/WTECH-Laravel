<?php

use App\Http\Controllers\Admin\DiscountCodeController;
use App\Http\Controllers\Admin\MaintenanceController;
use App\Http\Controllers\Admin\StatsController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CompareController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\DemoAdminController;
use App\Models\Smartphone;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\SmartphoneController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Auth\PasswordChangeController;
use App\Http\Controllers\Auth\RegisteredUserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

require __DIR__ . '/auth.php';

// Homepage
Route::get('/', [ShopController::class, 'index'])->name('home');

Route::post('/demo-notice/dismiss', [ShopController::class, 'dismissDemoNotice'])->middleware('throttle:shop')->name('demo-notice.dismiss');
Route::post('/locale/{locale}', [ShopController::class, 'switchLocale'])->middleware('throttle:shop')->name('locale.switch');

// Information pages
Route::view('/about', 'layout.pages.about')->name('about');
Route::view('/contact', 'layout.pages.contact')->name('contact');
Route::view('/shipping', 'layout.pages.shipping')->name('shipping');
Route::view('/payment-methods', 'layout.pages.payment-methods')->name('payment-methods');
Route::view('/returns', 'layout.pages.returns')->name('returns');
Route::view('/terms', 'layout.pages.terms')->name('terms');
Route::view('/privacy', 'layout.pages.privacy')->name('privacy');
Route::get('/sitemap.xml', [ShopController::class, 'sitemap'])->name('sitemap');

// User
Route::get('/profile', [UserController::class, 'index'])->middleware(['auth'])->name('profile');
Route::put('/profile', [UserController::class, 'update'])->middleware(['auth', 'throttle:shop']);
Route::get('/finishRegister', [RegisteredUserController::class, 'redirectAfterOrder'])->name('finishRegister');
Route::post('/finishRegister', [RegisteredUserController::class, 'storeAfterOrder'])->middleware('throttle:signup')->name('storeAfterOrder');

Route::get('/orders', [OrderController::class, 'history'])->middleware(['auth'])->name('orders');
Route::get('/orders/{order}', [OrderController::class, 'show'])->middleware(['auth'])->name('orders.show')->whereNumber('order');

Route::get('/passwordChange', [PasswordChangeController::class, 'create'])->middleware(['auth'])->name('passwordChange');
Route::put('/passwordChange', [PasswordChangeController::class, 'update'])->middleware(['auth', 'throttle:login']);
//Route::get('/passwordReset', function () {
//    return view('layout/user/passwordReset');
//});

// Cart
Route::get('/cart', [CartController::class, 'index'])->name('cart');
Route::post('/cart', [CartController::class, 'store'])->middleware('throttle:shop')->name('cart.store');
// before /cart/{product}, which would catch "code"
Route::post('/cart/code', [CartController::class, 'applyCode'])->middleware('throttle:shop')->name('cart.code');
Route::delete('/cart/code', [CartController::class, 'removeCode'])->middleware('throttle:shop')->name('cart.code.remove');
Route::delete('/cart/{product}', [CartController::class, 'destroy'])->middleware('throttle:shop')->name('cart.destroy');
Route::put('/cart/{product}', [CartController::class, 'update'])->middleware('throttle:shop')->name('cart.update');

// Admin: products, for the admin and for demo admins (each action checked by SmartphonePolicy)
Route::middleware(['auth', 'can:adminZone'])->group(function () {
    Route::get('/admin', [SmartphoneController::class, 'adminIndex'])->name('admin');
    Route::get('/smartphones/create', [SmartphoneController::class, 'create'])->name('smartphones.add')->can('create', Smartphone::class);
    Route::post('/smartphones/add', [SmartphoneController::class, 'store'])->name('smartphones.create')->can('create', Smartphone::class)->middleware('throttle:demo-admin-writes');
    Route::get('/smartphones/{smartphone}/edit/', [SmartphoneController::class, 'edit'])->name('smartphones.edit')->can('update', 'smartphone');
    Route::put('/smartphones/{smartphone}', [SmartphoneController::class, 'update'])->name('smartphones.update')->can('update', 'smartphone')->middleware('throttle:demo-admin-writes');
    Route::delete('/smartphones/{smartphone}/', [SmartphoneController::class, 'destroy'])->name('smartphones.delete')->can('delete', 'smartphone');
});

// Admin: orders and diagnostics, for the real admin only (demo admins never see customer data)
Route::middleware(['auth', 'can:isAdmin'])->group(function () {
    Route::get('/admin/orders', [OrderController::class, 'adminIndex'])->name('admin.orders');
    Route::patch('/admin/orders/{order}/status', [OrderController::class, 'updateStatus'])->name('admin.orders.status')->whereNumber('order');
    Route::get('/admin/error-test', [ShopController::class, 'errorTest'])->name('admin.error-test');
    Route::get('/admin/stats', [StatsController::class, 'index'])->name('admin.stats');
    Route::get('/admin/maintenance', [MaintenanceController::class, 'index'])->name('admin.maintenance');
    Route::put('/admin/maintenance', [MaintenanceController::class, 'update'])->name('admin.maintenance.update');
    Route::delete('/admin/maintenance', [MaintenanceController::class, 'destroy'])->name('admin.maintenance.destroy');
    Route::get('/admin/codes', [DiscountCodeController::class, 'index'])->name('admin.codes');
    Route::post('/admin/codes', [DiscountCodeController::class, 'store'])->name('admin.codes.store');
    Route::get('/admin/codes/{code}/edit', [DiscountCodeController::class, 'edit'])->name('admin.codes.edit')->whereNumber('code');
    Route::put('/admin/codes/{code}', [DiscountCodeController::class, 'update'])->name('admin.codes.update')->whereNumber('code');
    Route::delete('/admin/codes/{code}', [DiscountCodeController::class, 'destroy'])->name('admin.codes.destroy')->whereNumber('code');
});

// Demo admin account, one click from the login page
Route::post('/demo-admin', [DemoAdminController::class, 'store'])->middleware(['guest', 'throttle:demo-admin'])->name('demo-admin');

// Products
Route::get('/smartphones', [SmartphoneController::class, 'index'])->name('smartphones');
Route::get('/search/suggest', [SmartphoneController::class, 'suggest'])->middleware('throttle:60,1')->name('search.suggest');
Route::get('/smartphones/{smartphone}/', [SmartphoneController::class, 'show'])->name('details');

// Reviews, wishlist and comparison
Route::post('/smartphones/{smartphone}/reviews', [ReviewController::class, 'store'])->middleware(['auth', 'throttle:shop'])->name('reviews.store');
Route::delete('/reviews/{review}', [ReviewController::class, 'destroy'])->middleware(['auth', 'throttle:shop'])->name('reviews.destroy')->whereNumber('review');
Route::get('/wishlist', [WishlistController::class, 'index'])->middleware('auth')->name('wishlist');
Route::post('/wishlist/{smartphone}', [WishlistController::class, 'toggle'])->middleware(['auth', 'throttle:shop'])->name('wishlist.toggle');
Route::get('/compare', [CompareController::class, 'index'])->name('compare');
Route::post('/compare/{smartphone}', [CompareController::class, 'toggle'])->middleware('throttle:shop')->name('compare.toggle');
Route::delete('/compare', [CompareController::class, 'clear'])->middleware('throttle:shop')->name('compare.clear');

// Order
Route::get('/address', [OrderController::class, 'addressIndex'])->name('address');
Route::put('/address', [OrderController::class, 'addressStore'])->middleware('throttle:shop')->name('address.store');
Route::get('/delivery', [OrderController::class, 'deliveryIndex'])->name('delivery');
Route::post('/delivery', [OrderController::class, 'deliveryStore'])->middleware('throttle:shop')->name('delivery.store');
Route::get('/payment', [OrderController::class, 'paymentIndex'])->name('payment');
Route::post('/payment', [OrderController::class, 'paymentStore'])->middleware('throttle:shop')->name('payment.store');
Route::get('/order/complete', [OrderController::class, 'complete'])->name('order.complete');

// Unknown URLs: the shop's 404 page, with the session, so it's translated and knows the visitor
Route::fallback([ShopController::class, 'notFound']);
