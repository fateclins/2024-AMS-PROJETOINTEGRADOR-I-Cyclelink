<?php

use App\Infra\Http\Api\RentController;
use App\Infra\Http\Api\AuthController;
use App\Infra\Http\Api\BikeController;
use App\Infra\Http\Api\BrandController;
use App\Infra\Http\Api\TypeBikeController;
use App\Infra\Http\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'signIn']);
Route::post('password/email', [AuthController::class, 'sendEmail']);
Route::post('password/reset', [AuthController::class, 'resetPassword']);
Route::post('auth', [AuthController::class, 'isAuth']);


Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);


Route::get('bikes', [BikeController::class, 'index']);
Route::get('rents/{id}', [BikeController::class, 'show']);
Route::get('/rents', [RentController::class, 'index']); 
Route::get('/brands', [BrandController::class, 'index']); 
Route::get('/types', [TypeBikeController::class, 'index']); 



Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', [UserController::class, 'show']); 
    Route::put('/user', [UserController::class, 'update']);
    Route::apiResource('/rents', RentController::class)->except('index', 'show'); 
});