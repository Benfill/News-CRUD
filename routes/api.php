<?php

use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\NewsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::group(['namespace' => 'Api', 'prefix' => 'v1'], function () {
    Route::post('login', [AuthenticationController::class, 'login'])->name('login');
    Route::post('register', [AuthenticationController::class, 'store']);

    Route::group(['middleware' => 'auth:api'], function () {

        Route::prefix('news')->group(function () {
            Route::get('/', [NewsController::class, 'index']);
            Route::get('/{slug}', [NewsController::class, 'show']);
            Route::post('/', [NewsController::class, 'store']);
            Route::put('/{id}', [NewsController::class, 'update']);
            Route::delete('/{id}', [NewsController::class, 'destroy']);

            Route::get('/category/{categoryName}', [CategoryController::class, 'searchForArticlesByCategory']);

        });

        Route::post('logout', [AuthenticationController::class, 'destroy']);
    });
});
