<?php

use Domain\Auth\Controllers\LoginController;
use Domain\Ticket\Controllers\Admin\TicketController;
use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use Domain\Role\Controllers\RoleController;

Route::get('/admin', static function () {
    return Inertia::render('Auth/Login', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Auth::routes(['register' => false]);


Route::prefix('admin')
    ->controller(LoginController::class)
    ->group(function () {
        Route::get('login', 'showLoginForm')->name('admin.login');
        Route::post('login', 'login');
        Route::post('logout', 'logout')->name('admin.logout');
    });

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->prefix('admin')->group(function () {

    Route::get('/dashboard', function () { return Inertia::render('Dashboard'); })->name('dashboard');

    Route::middleware([
        'check-domains',
        'check-permissions',
    ])->group(function () {
        Route::prefix('roles')
            ->name('roles.')
            ->controller(RoleController::class)
            ->group(function () {
                Route::get('/', 'index')->name('index');
                Route::get('/create', 'create')->name('create');
                Route::get('/duplicate', 'duplicate')->name('duplicate');
                Route::post('/store', 'store')->name('store');

                Route::prefix('{role}')
                    ->group(function () {
                        Route::get('/show', 'show')->name('show');
                        Route::post('/update', 'update')->name('update');
                        Route::delete('/destroy', 'destroy')->name('destroy');
                    });
            });

        Route::prefix('tickets')
            ->name('tickets.')
            ->controller(TicketController::class)
            ->group(function () {
                Route::get('/', 'index')->name('index');

                Route::prefix('{ticket}')
                    ->group(function () {
                        Route::get('/show', 'show')->name('show');
                        Route::post('/update', 'update')->name('update');
                    });
            });

    });
});
