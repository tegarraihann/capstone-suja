<?php

namespace App\Http\Controllers;

use App\Models\Bidang;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class AdminSistemController extends Controller
{
    public function view_add_user()
    {
        $roleOptions = [
            ['value' => '4', 'label' => 'Pimpinan'],
            ['value' => '3', 'label' => 'Admin Sistem'],
            ['value' => '2', 'label' => 'Admin Binagram'],
            ['value' => '1', 'label' => 'Admin Approval'],
            ['value' => '0', 'label' => 'Operator'],
        ];

        $existingPimpinan = User::where('role', 4)->exists();


        if ($existingPimpinan) {
            $roleOptions = array_filter($roleOptions, function ($option) {
                return $option['value'] !== '4';
            });
        }

        $bidang = Bidang::all();
        if ($existingPimpinan) {
            $bidang = $bidang->reject(function ($b) {
                return $b->nama_bidang === 'Pimpinan';
            });
        }

        return view("adminsistem.tambah-user")->with(compact(['roleOptions', 'bidang']));
    }

    public function view_update_user($id)
    {
        $user = User::findOrFail($id);
        $bidang = Bidang::all();

        $roleOptions = [
            ['value' => '4', 'label' => 'Pimpinan'],
            ['value' => '3', 'label' => 'Admin Sistem'],
            ['value' => '2', 'label' => 'Admin Binagram'],
            ['value' => '1', 'label' => 'Admin Approval'],
            ['value' => '0', 'label' => 'Operator'],
        ];

        $joinBidang = User::join('bidang', 'users.bidang_id', '=', 'bidang.id')
            ->select('users.*', 'bidang.nama_bidang')
            ->findOrFail($id);

        return view("adminsistem.edit-user")->with(compact('joinBidang', 'user', 'bidang', 'roleOptions'));
    }

    public function create_user(Request $request)
    {
        $user = request()->validate([
            "name" => ["required", "max:100"],
            "email" => ["required", "unique:users"],
            "nip" => ["required", "unique:users"],
            "bidang_id" => ["required"],
            "password" => ["required", Password::min(6)->numbers()->letters()],
            "confirm_password" => ["required_with:password", "same:password"],
            "role" => "required"
        ]);

        $user = new User();
        $user->name = ucwords(strtolower(trim($request->name)));
        $user->email = trim($request->email);
        $user->nip = trim($request->nip);
        $user->bidang_id = trim($request->bidang_id);
        $user->password = Hash::make($request->password);
        $user->role = trim($request->role);
        $user->remember_token = \Illuminate\Support\Str::uuid()->toString();
        $user->save();

        return redirect('adminsistem/tambah-user')->with([
            'success' => [
                "title" => "User Register Succesfully",
                "message" => "Akun berhasil didaftarkan"
            ]
        ]);
    }

    public function edit_user(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            "name" => ["required", "max:100"],
            "email" => ["required", "unique:users,email," . $user->id], // Mengecualikan email milik pengguna yang sedang diedit
            "nip" => ["required", "unique:users,nip," . $user->id], // Mengecualikan NIP milik pengguna yang sedang diedit
            "password" => ["required", Password::min(6)->numbers()->letters()],
            "confirm_password" => ["required_with:password", "same:password"],
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->nip = $request->nip;
        $user->password = bcrypt($request->password);
        $user->save();

        return redirect('adminsistem/edit-user/' . $id)->with([
            'success' => [
                "title" => "Update User Succesfully",
                "message" => "Akun berhasil di perbarui"
            ]
        ]);
    }

    public function get_all_user()
    {
        $adminSystemCurrent = Auth::user()->id;
        $users = User::where('users.id', '!=', $adminSystemCurrent)
            ->join('bidang', 'users.bidang_id', '=', 'bidang.id')
            ->select('users.*', 'bidang.nama_bidang')
            ->latest('users.id')
            ->paginate(7);

        $roleOptions = [
            ['value' => '4', 'label' => 'Pimpinan'],
            ['value' => '3', 'label' => 'Admin Sistem'],
            ['value' => '2', 'label' => 'Admin Binagram'],
            ['value' => '1', 'label' => 'Admin Approval'],
            ['value' => '0', 'label' => 'Operator'],
        ];

        return view('adminsistem.dashboard', ['users' => $users, 'roleOptions' => $roleOptions]);
    }

    public function delete_user($id): void
    {
        $user = User::findOrFail($id);
        $user->delete();
    }

    public function create_bidang(Request $request)
    {
        $bidang = request()->validate([
            "nama_bidang" => ["required", "max:100", "unique:bidang"]
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

    public function search_users(Request $request)
    {
        $roleOptions = [
            ['value' => '4', 'label' => 'Pimpinan'],
            ['value' => '3', 'label' => 'Admin Sistem'],
            ['value' => '2', 'label' => 'Admin Binagram'],
            ['value' => '1', 'label' => 'Admin Approval'],
            ['value' => '0', 'label' => 'Operator'],
        ];

        $search = $request->input('search');

        $adminSystemCurrent = Auth::user()->id;
        $users = User::where('users.id', '!=', $adminSystemCurrent)
            ->join('bidang', 'users.bidang_id', '=', 'bidang.id')
            ->select('users.*', 'bidang.nama_bidang')
            ->where(function ($query) use ($search, $roleOptions) {
                $query->where('users.name', 'like', '%' . $search . '%')
                    ->orWhere('users.nip', 'like', '%' . $search . '%')
                    ->orWhere('users.email', 'like', '%' . $search . '%')
                    ->orWhere('bidang.nama_bidang', 'like', '%' . $search . '%');

                foreach ($roleOptions as $role) {
                    $query->orWhere('users.role', 'like', '%' . $role['label'] . '%', 'like', '%' . $search . '%');
                }
            })
            ->latest('users.id')
            ->paginate(7);

        return view('adminsistem.dashboard', ['users' => $users, 'roleOptions' => $roleOptions]);
    }
}
