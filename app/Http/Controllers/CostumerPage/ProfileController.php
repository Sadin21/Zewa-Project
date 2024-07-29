<?php

namespace App\Http\Controllers\CostumerPage;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class ProfileController extends Controller
{
    public function updateProfile(Request $request): View | RedirectResponse
    {
        $user = User::find(Auth::id());

        if (!$user) {
            return redirect()->back()->with('error', 'User not found');
        }

        if ($request->getMethod() === 'GET') {
            return view('pages.customer-page.profile.index', compact('user'));
        }

        try {
            $request->validate([
                'nama' => 'required|string',
                'alamat' => 'nullable|string',
                'email' => 'required|email|unique:user,email,' . $user->id,
                'password' => 'nullable|min:6',
                'foto' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
            ]);

            $input = $request->only(['nama', 'alamat', 'email']);

            if ($request->hasFile('foto')) {
                $foto = $request->file('foto');
                $fotoName = time() . '.' . $foto->getClientOriginalExtension();
                $foto->move(public_path('assets/imgs/user'), $fotoName);
                $user->foto = $fotoName;
            }

            if ($request->filled('password')) {
                $input['password'] = Hash::make($request->password);
            }

            $user->update($input);

            return redirect()->back()->with('success', 'Update profile success');
        } catch (\Throwable $e) {
            Log::error($e->getMessage());
            return redirect()->back()->with('error', 'Update profile failed');
        }
    }
}
