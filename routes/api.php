<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HotelController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\RegencyController;
use App\Http\Controllers\HotelFacilityController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Route for login & register
Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);

Route::resource('hotel', HotelController::class);
Route::resource('banner', BannerController::class);
Route::resource('regency', RegencyController::class);

// Route for hotel facility
Route::post('hotel/facility', [HotelFacilityController::class, 'store']);
Route::delete('hotel/facility/{id}', [HotelFacilityController::class, 'destroy']);
