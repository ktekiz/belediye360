<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    
    public function store(LoginRequest $request): RedirectResponse
{
    $request->authenticate();

    $request->session()->regenerate();

    $user = $request->user();

    return redirect()->intended($this->redirectPathFor($user));
}

private function redirectPathFor($user): string
{
    return match ($user->role) {
        \App\Enums\UserRole::ADMIN => route('dashboard', absolute: false),
        \App\Enums\UserRole::MANAGER => route('dashboard', absolute: false),
        \App\Enums\UserRole::CHIEF => route('dashboard', absolute: false),
        \App\Enums\UserRole::STAFF => route('tasks.index', absolute: false),
    };
}
   
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('welcome');
    }
}
