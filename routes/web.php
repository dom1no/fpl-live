<?php

use App\Http\Controllers\FixtureController;
use App\Http\Controllers\ManagerController;
use App\Models\Manager;
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

Route::get('/', function () {
    return redirect()->route('managers.teams.show', [
        Manager::where('fpl_id', 3503081)->firstOrFail(),
    ]);
})->name('home');

Route::prefix('managers')->name('managers.')->group(function () {
    Route::get('/', [ManagerController::class, 'index'])->name('index');
    Route::get('/teams', [ManagerController::class, 'teams'])->name('teams');
    Route::get('/teams/{manager}', [ManagerController::class, 'managerTeam'])->name('teams.show');
});

Route::prefix('fixtures')->name('fixtures.')->group(function () {
    Route::get('/', [FixtureController::class, 'index'])->name('index');
    Route::get('/sync', [FixtureController::class, 'sync'])->name('sync');
    Route::get('/{fixture}/show', [FixtureController::class, 'show'])->name('show');
});
