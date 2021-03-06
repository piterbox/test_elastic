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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('search', [\App\Http\Controllers\ArticleController::class, 'search']);
Route::post('create', [\App\Http\Controllers\ArticleController::class, 'create']);
Route::put('update/{id}', [\App\Http\Controllers\ArticleController::class, 'update']);
Route::delete('delete/{id}', [\App\Http\Controllers\ArticleController::class, 'delete']);
