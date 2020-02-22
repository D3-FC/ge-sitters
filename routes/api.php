<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\PriceController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WorkerController;
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

    Route::post('/workers/create', [WorkerController::class, 'create']);
    Route::post('/workers/update', [WorkerController::class, 'update']);
    Route::post('/workers/get', [WorkerController::class, 'get']);
    Route::post('/workers/get-many', [WorkerController::class, 'getMany']);

    Route::post('/prices/create', [PriceController::class, 'create']);
    Route::post('/prices/delete', [PriceController::class, 'delete']);

});
