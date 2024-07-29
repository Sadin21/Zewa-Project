<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    public function authenticate(Request $request): View | RedirectResponse
    {
        if ($request->getMethod() === 'GET') {
            return view('pages.auth.signin');
        }

        $credentials = $request->validate([
            'email' => 'required|string|exists:user,email',
            'password' => 'required',
        ]);


        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = $user->createToken('authToken')->plainTextToken;

            return redirect()->route('home.index')->with('success', 'Login success');
        } else {
            return redirect()->back()->with('error', 'Login gagal');
        }
    }

    public function signup(Request $request): View | RedirectResponse
    {
        if ($request->getMethod() === 'GET') {
            return view('pages.auth.signup');
        }

        try {
            $input = $request->validate([
                'nama' => 'required|string',
                'email' => 'required|email|unique:user,email',
                'password' => 'required',
            ]);

            // dd($input);

            $user = new User();
            $user->nama = $request->input('nama');
            $user->email = $request->input('email');
            $user->role_id = '3';
            $user->password = Hash::make($request->input('password'));
            // dd($user);
            $user->save();

            return redirect()->route('auth.login')->with('success', 'Register success');
        } catch (\Throwable $e) {
            Log::error($e->getMessage());
            return redirect()->back()->with('error', 'Register gagal');
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
