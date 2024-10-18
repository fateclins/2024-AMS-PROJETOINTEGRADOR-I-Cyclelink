<?php

use App\Infra\Http\Api\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'signIn']);
Route::post('password/email', [AuthController::class, 'sendEmail']);
Route::post('password/reset', [AuthController::class, 'resetPassword']);


Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);
