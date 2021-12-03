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


// User
Route::get('/profile', [UserController::class, 'index'])->middleware(['auth'])->name('profile');
Route::put('/profile', [UserController::class, 'update'])->middleware(['auth']);
Route::get('/finishRegister', [RegisteredUserController::class, 'redirectAfterOrder'])->name('finishRegister');
Route::post('/finishRegister', [RegisteredUserController::class, 'storeAfterOrder'])->name('storeAfterOrder');

Route::get('/passwordChange', [PasswordChangeController::class, 'create'])->middleware(['auth'])->name('passwordChange');
Route::put('/passwordChange', [PasswordChangeController::class, 'update'])->middleware(['auth']);

//Route::get('/passwordReset', function () {
//    return view('layout/user/passwordReset');
//});


// Cart
Route::get('/cart', [CartController::class, 'index'])->name('cart');
Route::post('/cart/', [CartController::class, 'store'])->name('cart.store');
Route::delete('/cart/{product}', [CartController::class, 'destroy'])->name('cart.destroy');
Route::put('/cart/{product}', [CartController::class, 'update'])->name('cart.update');


// Products
Route::get('/smartphones', [SmartphoneController::class, 'index'])->name('smartphones');
Route::get('/smartphones/create', [SmartphoneController::class, 'create'])->name('smartphones.add');
Route::post('/smartphones/add', [SmartphoneController::class, 'store'])->name('smartphones.create');
Route::get('/smartphones/{smartphone}/', [SmartphoneController::class, 'show'])->name('details');
Route::get('/smartphones/{smartphone}/edit/', [SmartphoneController::class, 'edit'])->name('smartphones.edit');
Route::put('/smartphones/{smartphone}', [SmartphoneController::class, 'update']);
Route::delete('/smartphones/{smartphone}/', [SmartphoneController::class, 'destroy'])->name('smartphones.delete');


// Order
Route::get('/address', [OrderController::class, 'addressIndex'])->name('address');
Route::put('/address', [OrderController::class, 'addressStore'])->name('address.store');
Route::get('/delivery', [OrderController::class, 'deliveryIndex'])->name('delivery');
Route::post('/delivery', [OrderController::class, 'deliveryStore'])->name('delivery.store');
Route::get('/payment', [OrderController::class, 'paymentIndex'])->name('payment');
Route::post('/payment', [OrderController::class, 'paymentStore'])->name('payment.store');


// Admin
Route::get('/admin', [SmartphoneController::class, 'adminIndex'])->middleware(['auth', 'can:isAdmin'])->name('admin');

