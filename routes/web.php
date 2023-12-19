<?php

use Inertia\Inertia;
use App\Models\Cinema;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RootAdmin\UserController;
use App\Http\Controllers\RootAdmin\MovieController;
use App\Http\Controllers\RootAdmin\CinemaController;
use App\Http\Controllers\RootAdmin\ReportController;

use App\Http\Controllers\CinemaAdmin\UserController as CinemaUserController;
use App\Http\Controllers\CinemaAdmin\MovieController as CinemaMovieController;
use App\Http\Controllers\CinemaAdmin\CinemaController as CinemaCinemaController;
use App\Http\Controllers\CinemaAdmin\ReportController as CinemaReportController;

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
    ->group(function () {
        Route::resource('/dashboard', ReportController::class)->only(['index', 'show']);

        Route::resource('/usuarios', UserController::class);

        Route::patch('/cinemas/{cinema}/admin', [CinemaController::class, 'alterAdmin']);
        Route::post('/cinemas/{cinema}/novos-usuarios', [CinemaController::class, 'addNewUsers']);
        Route::resource('/cinemas', CinemaController::class);

        Route::resource('/filmes', MovieController::class);
    });





Route::prefix('cinema')
    ->middleware(['auth', 'role:cinema_admin'])
    ->group(function () {
        Route::resource('/dashboard', CinemaReportController::class)->only(['index', 'show']);

        Route::post('/usuarios/find', [CinemaUserController::class, 'findUserBy']);
        Route::resource('/usuarios', CinemaUserController::class);

        Route::get('/perfil', [CinemaCinemaController::class, 'show']);
        Route::put('/perfil', [CinemaCinemaController::class, 'update']);

        Route::resource('/filmes', CinemaMovieController::class)->only(['index', 'show']);
    });




require __DIR__ . '/auth.php';
