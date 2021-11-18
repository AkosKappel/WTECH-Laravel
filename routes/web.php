<?php

use App\Http\Controllers\SmartphoneController;
use App\Http\Controllers\UserController;
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

//Route::get('/', function () {
//    return view('welcome');
//});

//Route::get('/dashboard', function () {
//    return view('dashboard');
//})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';

// Homepage
Route::get('/', function () {
    return view('layout/app');
})->name('home');


// User
//Route::get('/profile', function () {
//    return view('layout/user/profile');
//})->middleware(['auth'])->name('profile');

Route::get('/profile', [UserController::class, 'index'])->middleware(['auth'])->name('profile');

//Route::get('/login', function () {
//    return view('layout/user/login');
//});
//
//Route::get('/register', function () {
//    return view('layout/user/register');
//});
//
//Route::get('/passwordReset', function () {
//    return view('layout/user/passwordReset');
//});
//
//Route::get('/passwordChange', function () {
//    return view('layout/user/passwordChange');
//});


// Cart
Route::get('/cart', function () {
    return view('layout/cart/cart');
})->name('cart');


// Products
Route::get('/smartphones', function () {
    return view('layout/products/smartphones');
})->name('smartphones');

Route::get('/details', function () {
    return view('layout/products/details');
})->name('details');


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
Route::resource('smartphones', SmartphoneController::class);

Route::resource('user', \App\Http\Controllers\UserController::class);
