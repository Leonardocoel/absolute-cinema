<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RootAdmin\UserController;
use App\Http\Controllers\RootAdmin\MovieController;
use App\Http\Controllers\RootAdmin\CinemaController;



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

Route::get('/', fn () => redirect('login'));

Route::prefix('admin')
    ->middleware(['auth', 'role:root_admin'])
    ->namespace('App\Http\Controllers\RootAdmin')
    ->group(function () {
        Route::get('/dashboard', fn () => Inertia::render('RootAdmin/Dashboard'))->name('dashboard');

        Route::resource('/usuarios', UserController::class);

        Route::patch('/cinemas/{cinema}/admin', [CinemaController::class, 'alterAdmin']);
        Route::post('/cinemas/{cinema}/novos-usuarios', [CinemaController::class, 'addNewUsers']);
        Route::resource('/cinemas', CinemaController::class);

        Route::resource('/filmes', MovieController::class);
    });




require __DIR__ . '/auth.php';
