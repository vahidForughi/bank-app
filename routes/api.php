<?php

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//Route::prefix('/user')->group(base_path('routes/groups/admin/user.php'));
//Route::prefix('/accounts')->group(base_path('routes/groups/admin/account.php'));
//Route::prefix('/cards')->group(base_path('routes/groups/admin/user.php'));
//Route::prefix('/transactions')->group(base_path('routes/groups/admin/user.php'));
//Route::prefix('/fees')->group(base_path('routes/groups/admin/user.php'));

Route::middleware(
    \App\Http\Middleware\JsonApiMiddleware::class
)->group(function () {

    Route::prefix('/transactions')->group(
        base_path('routes/groups/transaction.php')
    );

    Route::get('/reports/user-max-transaction', [\App\Http\Controllers\ReportController::class, 'userMaxTransaction']);

});
