<?php


use Domain\Dashboard\Controllers\LandingController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;


Route::get('storage-link', static function () {
    return Artisan::call('storage:link');
});

Route::get('cache-clear', static function () {
    return Artisan::call('optimize:clear');
});

Route::get('/', static function () {
    return redirect()->route('front.index');
});

Route::get('/login', static function () {
    return redirect('/admin');
});

Route::name('front.')
    ->group(function () {
        Route::controller(LandingController::class)
            ->group(function () {
                Route::get('/', 'index')->name('index');
            });

    });
