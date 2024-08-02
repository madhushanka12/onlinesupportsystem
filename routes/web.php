<?php


use Domain\Dashboard\Controllers\LandingController;
use Domain\Ticket\Controllers\TicketController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;


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

        Route::prefix('tickets')
            ->name('tickets.')
            ->controller(TicketController::class)
            ->group(function () {
                Route::post('/store', 'store')->name('store');
            });
    });
