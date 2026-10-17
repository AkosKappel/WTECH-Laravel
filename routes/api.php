<?php

use App\Http\Controllers\Api\SmartphoneController;
use Illuminate\Support\Facades\Route;

/*
| Public, read-only catalog API under /api, rate-limited per visitor ("api" limiter).
| No session or cookies; errors are always JSON.
*/

Route::get('/smartphones', [SmartphoneController::class, 'index'])->name('api.smartphones');
Route::get('/smartphones/{smartphone}', [SmartphoneController::class, 'show'])->name('api.smartphones.show');
