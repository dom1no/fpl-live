<?php

use App\Http\Controllers\FixtureController;
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

Route::get('/', [ManagerController::class, 'my'])->name('home');
Route::get('/teams', [ManagerController::class, 'index'])->name('managers.index');

Route::prefix('fixtures')->name('fixtures.')->group(function () {
    Route::get('/', [FixtureController::class, 'index'])->name('index');
    Route::get('/sync', [FixtureController::class, 'sync'])->name('sync');
    Route::get('/{fixture}/show', [FixtureController::class, 'show'])->name('show');
});
