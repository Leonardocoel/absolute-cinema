<?php

use Inertia\Inertia;
use App\Models\Cinema;

use Illuminate\Support\Facades\Route;
// use App\Http\Controllers\RootAdmin\UserController;
use App\Http\Controllers\RootAdmin\MovieController;
use App\Http\Controllers\RootAdmin\CinemaController;
// use App\Http\Controllers\RootAdmin\ReportController;

use App\Http\Controllers\CinemaAdmin\UserController as CinemaUserController;
use App\Http\Controllers\CinemaAdmin\MovieController as CinemaMovieController;
use App\Http\Controllers\CinemaAdmin\CinemaController as CinemaCinemaController;
use App\Http\Controllers\CinemaAdmin\ReportController as CinemaReportController;



Route::get('/', fn () => redirect('login'))->middleware('');

Route::prefix('admin')
    ->name('admin.')
    ->namespace('App\Http\Controllers\RootAdmin')
    ->middleware(['auth', 'role:root_admin'])
    ->group(function () {
        Route::resource('/dashboard', ReportController::class)->only(['index', 'show']);

        Route::resource('/usuarios', UserController::class);
    });









require __DIR__ . '/auth.php';
