<?php

use App\Http\Controllers\PlaceController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\PlaceTypesController;
use App\Http\Controllers\RatingController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post('register_user', [AuthController::class, 'register']);
Route::post('login_user', [AuthController::class, 'login']);
Route::resource('place_types', PlaceTypesController::class);
Route::resource('place', PlaceController::class);




Route::group([
    'middleware' => 'auth:api'
], function () {

    Route::post('/places/{placeId}/rate', [RatingController::class, 'store']);

});