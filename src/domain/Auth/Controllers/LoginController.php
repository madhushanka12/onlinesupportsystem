<?php

namespace Domain\Auth\Controllers;

use App\Http\Controllers\Controller;
use Domain\Auth\Requests\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response as InertiaResponse;

class LoginController extends Controller
{
    public function showLoginForm(): InertiaResponse
    {
        return Inertia::render('Auth/Login');
    }

    public function login(
        LoginRequest $loginRequest
    ): RedirectResponse
    {
        $credentials = $loginRequest->only('email', 'password');

        if (Auth::guard('web')->attempt($credentials)) {
            return redirect()->route('dashboard');
        }

        return redirect(route('admin.login'))->withFlash([
            'type' => 'error',
            'title' => 'Invalid credentials',
            'message' => __('Invalid credentials'),
        ]);
    }

    public function logout(): RedirectResponse
    {
        Auth::guard('web')->logout();
        return redirect()->route('admin.login');
    }
}
