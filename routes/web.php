<?php

use App\Http\Controllers\CartController;
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

// User
Route::get('/profile', [UserController::class, 'index'])->middleware(['auth'])->name('profile');
Route::put('/profile', [UserController::class, 'update'])->middleware(['auth', 'throttle:shop']);
Route::get('/finishRegister', [RegisteredUserController::class, 'redirectAfterOrder'])->name('finishRegister');
Route::post('/finishRegister', [RegisteredUserController::class, 'storeAfterOrder'])->middleware('throttle:signup')->name('storeAfterOrder');

Route::get('/passwordChange', [PasswordChangeController::class, 'create'])->middleware(['auth'])->name('passwordChange');
Route::put('/passwordChange', [PasswordChangeController::class, 'update'])->middleware(['auth', 'throttle:login']);
//Route::get('/passwordReset', function () {
//    return view('layout/user/passwordReset');
//});

// Cart
Route::get('/cart', [CartController::class, 'index'])->name('cart');
Route::post('/cart', [CartController::class, 'store'])->middleware('throttle:shop')->name('cart.store');
Route::delete('/cart/{product}', [CartController::class, 'destroy'])->middleware('throttle:shop')->name('cart.destroy');
Route::put('/cart/{product}', [CartController::class, 'update'])->middleware('throttle:shop')->name('cart.update');

// Admin
Route::middleware(['auth', 'can:isAdmin'])->group(function () {
    Route::get('/admin', [SmartphoneController::class, 'adminIndex'])->name('admin');
    Route::get('/smartphones/create', [SmartphoneController::class, 'create'])->name('smartphones.add');
    Route::post('/smartphones/add', [SmartphoneController::class, 'store'])->name('smartphones.create');
    Route::get('/smartphones/{smartphone}/edit/', [SmartphoneController::class, 'edit'])->name('smartphones.edit')->whereNumber('smartphone');
    Route::put('/smartphones/{smartphone}', [SmartphoneController::class, 'update'])->name('smartphones.update')->whereNumber('smartphone');
    Route::delete('/smartphones/{smartphone}/', [SmartphoneController::class, 'destroy'])->name('smartphones.delete')->whereNumber('smartphone');
    Route::get('/admin/error-test', [ShopController::class, 'errorTest'])->name('admin.error-test');
});

// Products
Route::get('/smartphones', [SmartphoneController::class, 'index'])->name('smartphones');
Route::get('/search/suggest', [SmartphoneController::class, 'suggest'])->middleware('throttle:60,1')->name('search.suggest');
Route::get('/smartphones/{smartphone}/', [SmartphoneController::class, 'show'])->name('details')->whereNumber('smartphone');

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
