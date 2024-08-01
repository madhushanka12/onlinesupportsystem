<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    protected $rootView = 'app';

    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    public function share(Request $request): array
    {
        return array_merge(parent::share($request), [
            'logo' => asset('images/logo.png'),
            'logoIcon' => asset('images/logo-icon.png'),
            'menus' => menus(),
            'user' => auth()->check() ? auth()->user() : null,
            'role' => auth()->check() ? auth()->user()->roles[0] : null,
        ]);
    }
}
