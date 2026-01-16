<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function show()
    {
        return view('auth.login');
    }

    public function authenticate(Request $request)
    {
        // 1. Validate input
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // 2. Attempt login using web guard explicitly
        if (Auth::guard('web')->attempt($credentials, $request->boolean('remember'))) {

            // 3. Regenerate session (safe now)
            $request->session()->regenerate();

            // 4. Staff → Filament
            if ($request->user()->can('access system')) {
                return redirect()->intended('/system');
            }

            // 5. Residents → portal (future)
            return redirect()->intended('/portal');
        }

        // 6. Failed login
        return back()
            ->withErrors([
                'email' => 'Invalid login credentials.',
            ])
            ->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
