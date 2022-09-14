<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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


//auth route
Route::prefix('v1')->group(function () {
Route::post('/register', [App\Http\Controllers\Api\Auth\AuthController::class, 'UserRegistration']);
Route::post('/login', [App\Http\Controllers\Api\Auth\AuthController::class, 'login']);


});


Route::prefix('v1')
->middleware(['auth:sanctum'])
->group(function () {
    Route::post('/company/store', [App\Http\Controllers\Api\CompanyController::class, 'store']);
    Route::get('/companies', [App\Http\Controllers\Api\CompanyController::class, 'index']);
    Route::post('/company/update', [App\Http\Controllers\Api\CompanyController::class, 'update']);
    Route::delete('/company/delete/{id}', [App\Http\Controllers\Api\CompanyController::class, 'destroy']);

    Route::post('/profile/update', [App\Http\Controllers\Api\UserController::class, 'UpdateUser']);
    Route::post('/logout', [App\Http\Controllers\Api\Auth\AuthController::class, 'logout']);
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
