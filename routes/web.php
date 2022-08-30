<?php

use App\Http\Controllers\FixtureController;
use App\Http\Controllers\MyTeamController;
use App\Http\Controllers\TeamController;
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

Route::get('/', [MyTeamController::class, 'index'])->name('home');
Route::get('/teams', [TeamController::class, 'index'])->name('teams');
Route::get('/fixtures', [FixtureController::class, 'index'])->name('fixtures.index');
Route::get('/fixture/{fixture}', [FixtureController::class, 'show'])->name('fixtures.show');
