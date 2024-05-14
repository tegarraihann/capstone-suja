<?php

namespace App\Http\Controllers;

use App\Models\Bidang;
use App\Models\User;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class AdminSistemController extends Controller
{
    public function tambah_akun() {
        return view("adminsistem.tambah-akun");
    }
    public function create_user(Request $request)
    {
        $user = request()->validate([
            "name" => ["required", "max:100"],
            "email" => ["required", "unique:users"],
            "nip" => ["required", "unique:users"],
            "bidang_id" => ["required", "exist:bidang, id"],
            "password" => ["required", Password::min(6)->numbers()],
            "confirm_password" => ["required_with:password", "same:password"],
            "role" => "required"
        ]);

        $user = new User();
        $user->name = strtolower(trim($request->name));
        $user->email = trim($request->email);
        $user->nip = trim($request->nip);
        $user->bidang_id = trim($request->bidang_id);
        $user->password = Hash::make($request->password);
        $user->role = trim($request->role);
        $user->remember_token = \Illuminate\Support\Str::uuid()->toString();
        $user->save();

        return redirect('user-management')->with([
            'success' => [
                "title" => "Register Succesfully",
                "message" => "Akun berhasil didaftarkan"
            ]
        ]);
    }

    public function get_all_user()
    {
        $adminSystemCurrent = Auth::user()->id;
        $users = User::where('id', '!=', $adminSystemCurrent)->get();

        return view('adminsistem.dashboard', ['users' => $users]);
    }

    public function create_bidang(Request $request)
    {
        $bidang = request()->validate([
            "nama_bidang" => ["required", "max:100"]
        ]);

        $bidang = new Bidang();
        $bidang->nama_bidang = strtolower(trim($request->nama_bidang));
        $bidang->save();

        return redirect('bidang-management')->with([
            'success' => [
                "title" => "Created Succesfully",
                "message" => "Bidang berhasil ditambahkan"
            ]
        ]);
    }
}
