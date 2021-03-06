<?php

use App\Http\Controllers\AdvertisementController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ContractController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\OfferController;
use App\Http\Controllers\PriceController;
use App\Http\Controllers\PublishedWorkerController;
use App\Http\Controllers\RefusalController;
use App\Http\Controllers\ScheduleController;
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

Route::group(['middleware' => ['auth:api']], function () { // TODO: move auth:api to controllers directly

    Route::post('/me', [UserController::class, 'me']);

    Route::post('/users/update', [UserController::class, 'update']);

    Route::post('/articles/create', [ArticleController::class, 'create']);
    Route::post('/articles/get-many', [ArticleController::class, 'getMany']);

    Route::post('/messages/create', [MessageController::class, 'create']);
    Route::post('/messages/get-many', [MessageController::class, 'getMany']);

    Route::post('/workers/create', [WorkerController::class, 'create']);
    Route::post('/workers/update', [WorkerController::class, 'update']);
    Route::post('/workers/get', [WorkerController::class, 'get']);
    Route::post('/workers/get-many', [WorkerController::class, 'getMany']);

    Route::post('/clients/create', [ClientController::class, 'create']);

    Route::post('/prices/create', [PriceController::class, 'create']);
    Route::post('/prices/delete', [PriceController::class, 'delete']);

    Route::post('/schedules/create', [ScheduleController::class, 'create']);
    Route::post('/schedules/delete', [ScheduleController::class, 'delete']);

    Route::post('/published-workers/create', [PublishedWorkerController::class, 'create']);
    Route::post('/published-workers/delete', [PublishedWorkerController::class, 'delete']);

    Route::post('/advertisements/create', [AdvertisementController::class, 'create']);

    Route::post('/offers/create', [OfferController::class, 'create']);
    Route::post('/offers/get-many', [OfferController::class, 'getMany']);

    Route::post('/contracts/create', [ContractController::class, 'create']);

    Route::post('/refuses/create', [RefusalController::class, 'create']);

});


Route::post('/published-workers/get', [PublishedWorkerController::class, 'get']);
Route::post('/published-workers/get-many', [PublishedWorkerController::class, 'getMany']);
