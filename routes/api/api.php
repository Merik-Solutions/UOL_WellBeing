<?php

use App\Http\Controllers\Api\v1\ContactController;
use App\Http\Controllers\Api\v1\CountryController;
use App\Http\Controllers\Api\v1\SettingController;
use App\Http\Controllers\Api\v1\Patient\CategoryController;
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

Route::get('countries', CountryController::class);
Route::get('categories', [CategoryController::class, 'index']);
Route::post('contact', ContactController::class);
Route::get('setting/{name}', SettingController::class);
