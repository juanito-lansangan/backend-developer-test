<?php

use App\Http\Controllers\InventoryController;
use App\Http\Controllers\MartianController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TradeController;
use App\Http\Middleware\CanTrade;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::get('test', function() {
    return 'test route';
});

Route::prefix('martians')->group(function() {
    // martian routes
    Route::get('', [MartianController::class, 'index']);
    Route::get('{martianId}', [MartianController::class, 'show']);
    Route::put('{martianId}', [MartianController::class, 'update']);
    Route::post('', [MartianController::class, 'store']);

    Route::middleware([CanTrade::class])->group(function(){
        // inventory routes
        Route::get('{martianId}/inventories', [InventoryController::class, 'index'])->withoutMiddleware([CanTrade::class]);
        Route::get('{martianId}/inventories/{inventoryId}', [InventoryController::class, 'show'])->withoutMiddleware([CanTrade::class]);
        Route::post('inventories', [InventoryController::class, 'store']);
        Route::put('inventories/{inventoryId}', [InventoryController::class, 'update']);

        // trading routes
        Route::post('trade', [TradeController::class, 'store']);
    });
});

Route::get('products', [ProductController::class,'index']);
Route::get('products/{id}', [ProductController::class,'show']);
Route::put('products/{id}', [ProductController::class,'update']);
Route::post('products', [ProductController::class,'store']);