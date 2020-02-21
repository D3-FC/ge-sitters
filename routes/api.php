<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;

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

Route::post('/register', [UserController::class, 'register']);

Route::group(['middleware' => ['auth:api']], function () {

    Route::post('/users/update', [UserController::class, 'update']);

    Route::post('/articles/create', [ArticleController::class, 'create']);
    Route::post('/articles/get-many', [ArticleController::class, 'getMany']);

    Route::post('/messages/create', [MessageController::class, 'create']);
    Route::post('/messages/get-many', [MessageController::class, 'getMany']);

});
