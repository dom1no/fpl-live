<?php

use App\Http\Controllers\FixtureController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ManagerController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes([
    'register' => false,
    'reset' => false,
]);

Route::prefix('fixtures')->name('fixtures.')->group(function () {
    Route::get('/', [FixtureController::class, 'index'])->name('index');
    Route::get('/{fixture}/show', [FixtureController::class, 'show'])->name('show');
});

Route::middleware('auth')->group(function () {
    Route::get('/', HomeController::class)->name('home');

    Route::prefix('managers')->name('managers.')->group(function () {
        Route::get('/', [ManagerController::class, 'index'])->name('index');
        Route::get('/{manager}/show', [ManagerController::class, 'show'])->name('show');
        Route::get('/detail-list', [ManagerController::class, 'detailList'])->name('detail-list');
        Route::get('/transfers', [ManagerController::class, 'transfers'])->name('transfers');
    });
});
