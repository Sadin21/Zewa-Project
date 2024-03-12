<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    public function authenticate(Request $request): View | RedirectResponse
    {
        if ($request->getMethod() === 'GET') {
            return view('pages.auth.index');
        }

        $credentials = $request->validate([
            'email' => 'required|string|exists:users,email',
            'password' => 'required',
        ]);


        if (Auth::attempt($credentials)) {
            return redirect()->route('home.index')->with('success', 'Login success');
        } else {
            return redirect()->back()->with('error', 'Login gagal');
        }
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        // $request->session()->regenerateToken();

        return redirect()->route('auth.login')->with('success', 'Logout success');
    }
}
