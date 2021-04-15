<?php

use App\Http\Controllers\Web\Dashboard\DashboardController;
use App\Http\Controllers\Web\Dashboard\TransactionController;
use App\Http\Controllers\Web\Users\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web1 Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::group(['prefix' => 'transaction'], function () {
    Route::post('send', [TransactionController::class, 'send'])->name('transaction.send');
});

Route::get('/', [DashboardController::class, 'index'])
    ->name('dashboard');

Route::group(['prefix' => 'users'], function () {
    Route::get('{id}', [UserController::class, 'show'])
        ->where('id', '^[0-9]+$')
        ->name('users.show');
});
