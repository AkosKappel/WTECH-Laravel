<?php

use App\Http\Controllers\SmartphoneController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Auth\PasswordChangeController;
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

require __DIR__.'/auth.php';


// Homepage
Route::get('/', function () {
    return view('layout/app');
})->name('home');


// User
Route::get('/profile', [UserController::class, 'index'])->middleware(['auth'])->name('profile');
Route::put('/profile', [UserController::class, 'update'])->middleware(['auth']);

Route::get('/passwordChange', [PasswordChangeController::class, 'create'])->middleware(['auth'])->name('passwordChange');
Route::put('/passwordChange', [PasswordChangeController::class, 'update'])->middleware(['auth']);

//Route::get('/passwordReset', function () {
//    return view('layout/user/passwordReset');
//});


// Cart
Route::get('/cart', function () {
    return view('layout/cart/cart');
})->name('cart');


// Products
//Route::get('/smartphones', [SmartphoneController::class, 'index'])->name('smartphones');
//Route::get('/smartphones/{smartphone_id}', [SmartphoneController::class, 'show']);
Route::get('/smartphones', [SmartphoneController::class, 'index'])->name('smartphones');
//Route::get('/smartphones/{sort?}', [SmartphoneController::class, 'index'])->name('smartphones');
Route::get('/smartphones/create', [SmartphoneController::class, 'create']);
Route::post('/smartphones/', [SmartphoneController::class, 'store']);
Route::get('/smartphones/{smartphone}/', [SmartphoneController::class, 'show'])->name('details');
Route::get('/smartphones/{smartphone}/edit/', [SmartphoneController::class, 'edit']);
Route::put('/smartphones/{smartphone}', [SmartphoneController::class, 'update']);
Route::delete('/smartphones/{smartphone}/', [SmartphoneController::class, 'destroy']);


// Order
Route::get('/address', function () {
    return view('layout/order/address');
})->name('address');

Route::get('/delivery', function () {
    return view('layout/order/delivery');
})->name('delivery');

Route::get('/payment', function () {
    return view('layout/order/payment');
})->name('payment');


// Resources
//Route::resource('smartphones', SmartphoneController::class);

//Route::resource('user', UserController::class);
