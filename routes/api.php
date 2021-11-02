<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HotelController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\FacilityController;
use App\Http\Controllers\RegencyController;
use App\Http\Controllers\HotelFacilityController;
use App\Http\Controllers\RoomTypeController;

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
Route::resource('facilities', FacilityController::class);

// Route for hotel facility
Route::post('hotel/facility', [HotelFacilityController::class, 'store']);
Route::delete('hotel/facility/{id}', [HotelFacilityController::class, 'destroy']);

// Route for room type
Route::get('hotel/roomtype', [RoomTypeController::class, 'index']);
Route::get('hotel/{idHotel}/roomtype', [RoomTypeController::class, 'index']);
Route::get('hotel/{idHotel}/roomtype/{idRoom}', [RoomTypeController::class, 'show']);
Route::put('hotel/{idHotel}/roomtype/{idRoom}', [RoomTypeController::class, 'update']);
Route::delete('hotel/{idHotel}/roomtype/{idRoom}', [RoomTypeController::class, 'destroy']);
Route::post('hotel/{id}/roomtype', [RoomTypeController::class, 'store']);

// Route for booking hotel
Route::get('booking', [BookingController::class, 'index']);
Route::post('booking', [BookingController::class, 'store']);
