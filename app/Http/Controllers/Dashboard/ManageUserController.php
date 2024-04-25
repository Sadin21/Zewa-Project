<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Models\Roles;
use App\Models\User;
use Nette\Utils\Random;

class ManageUserController extends Controller
{
    public function index(): View
    {
        return view('pages.dashboard.manage-user.index');
    }

    public function getAllData(Request $request): JsonResponse
    {
        $data = DB::table('users')
                    ->join('roles', 'users.role_id', '=', 'roles.id')
                    ->select('users.*', 'roles.name as role')
                    ->get();

        return response()->json([
            'total' => $data->count(),
            'data' => $data,
            'message' => 'Success get all data users'
        ], 200);
    }

    public function create(Request $request): mixed
    {
        $mode = 'create';
        $roles = Roles::get();

        if ($request->getMethod() === 'GET') {
            return view('pages.dashboard.manage-user.create', compact('mode', 'roles'));
        }

        $input = $this->validate($request, [
            'role_id' => 'required|numeric',
            'nama' => 'required|string',
            'alamat' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string',
            'foto' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'foto_ktp' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'foto_hp' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ], [
            'role_id.required' => 'Role wajib diisi',
            'role_id.numeric' => 'Role harus berupa angka',
            'nama.required' => 'Nama wajib diisi',
            'nama.string' => 'Nama harus berupa text',
            'alamat.required' => 'Alamat wajib diisi',
            'alamat.string' => 'Alamat harus berupa text',
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Email harus berupa email',
            'email.unique' => 'Email sudah terdaftar',
            'password.required' => 'Password wajib diisi',
            'password.string' => 'Password harus berupa text',
            'foto.image' => 'Foto harus berupa gambar',
            'foto.mimes' => 'Foto harus berupa gambar dengan format jpeg, png, jpg, gif, atau svg',
            'foto.max' => 'Foto maksimal berukuran 2048 KB',
            'foto_ktp.image' => 'Foto KTP harus berupa gambar',
            'foto_ktp.mimes' => 'Foto KTP harus berupa gambar dengan format jpeg, png, jpg, gif, atau svg',
            'foto_ktp.max' => 'Foto KTP maksimal berukuran 2048 KB',
            'foto_hp.image' => 'Foto HP harus berupa gambar',
            'foto_hp.mimes' => 'Foto HP harus berupa gambar dengan format jpeg, png, jpg, gif, atau svg',
            'foto_hp.max' => 'Foto HP maksimal berukuran 2048 KB',
        ]);

        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $filename = Random::generate(10) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('assets/imgs/user'), $filename);
            $input['foto'] = $filename;
        }

        try{
            User::create($input);
            return redirect()->route('dashboard.manage-user.index')->with('success', 'Akun berhasil dibuat');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->with('error', 'Akun gagal dibuat');
        }
    }

    public function update(Request $request, string $id): mixed
    {
        $mode = 'update';
        $roles = Roles::get();
        $user = User::find($id);

        if (!$user) return redirect()->route('dashboard.manage-user.index')->with('error', 'Akun tidak ditemukan');

        if ($request->getMethod() === 'GET') {
            return view('pages.dashboard.manage-user.create', compact('mode', 'roles', 'user'));
        }

        $input = $this->validate($request, [
            'role_id' => 'required|numeric',
            'nama' => 'required|string',
            'alamat' => 'required|string',
            'email' => 'required|email|unique:users,email, ' . $id,
            'password' => 'required|string',
            'foto' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'foto_ktp' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'foto_hp' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ], [
            'role_id.required' => 'Role wajib diisi',
            'role_id.numeric' => 'Role harus berupa angka',
            'nama.required' => 'Nama wajib diisi',
            'nama.string' => 'Nama harus berupa text',
            'alamat.required' => 'Alamat wajib diisi',
            'alamat.string' => 'Alamat harus berupa text',
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Email harus berupa email',
            'email.unique' => 'Email sudah terdaftar',
            'password.required' => 'Password wajib diisi',
            'password.string' => 'Password harus berupa text',
            'foto.image' => 'Foto harus berupa gambar',
            'foto.mimes' => 'Foto harus berupa gambar dengan format jpeg, png, jpg, gif, atau svg',
            'foto.max' => 'Foto maksimal berukuran 2048 KB',
            'foto_ktp.image' => 'Foto KTP harus berupa gambar',
            'foto_ktp.mimes' => 'Foto KTP harus berupa gambar dengan format jpeg, png, jpg, gif, atau svg',
            'foto_ktp.max' => 'Foto KTP maksimal berukuran 2048 KB',
            'foto_hp.image' => 'Foto HP harus berupa gambar',
            'foto_hp.mimes' => 'Foto HP harus berupa gambar dengan format jpeg, png, jpg, gif, atau svg',
            'foto_hp.max' => 'Foto HP maksimal berukuran 2048 KB',
        ]);

        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $filename = Random::generate(10) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('assets/imgs/user'), $filename);
            $input['foto'] = $filename;
        }

        try{
            $user->fill($input)->save();
            if ($mode === 'update') return redirect()->route('dashboard.manage-user.index')->with('success', 'Akun berhasil diubah');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->with('error', 'Akun gagal diubah');
        }
    }

    public function destroy(Request $request, $id): JsonResponse
    {
        $user = User::find($id);
        if (!$user) return response()->json(['message' => 'Akun tidak ditemukan'], 404);

        try{
            $user->delete();
            return response()->json(['message' => 'Akun berhasil dihapus'], 200);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['message' => 'Akun gagal dihapus'], 500);
        }
    }
}
