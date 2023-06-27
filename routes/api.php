<?php

use App\Http\Controllers\{
    TenantController,
    UserController
};
use App\Http\Controllers\Auth\AuthController;
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

Route::post('/register', [UserController::class, 'store']);
Route::post('/login', [AuthController::class, 'login'])->name('login');

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/tenant', [TenantController::class, 'store']);

    Route::middleware('tenant')->group(function () {
        //TEST ROUTE
        Route::get('/', function () {
            return response()->json([
                'message' => 'This is your api route.'
            ]);
        });

        Route::group([
            'prefix' => 'tenant',
            'controller' => TenantController::class,
            'id' => '^[0-9]+$'
        ], function () {
            Route::get('/', 'index');
            Route::get('/{id}', 'show');
            Route::put('/{id}', 'update');
            Route::delete('/{id}', 'destroy');
        });
    });
});
