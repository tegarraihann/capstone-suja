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
    private function getRoleOptions()
    {
        return [
            ['value' => '4', 'label' => 'Pimpinan'],
            ['value' => '3', 'label' => 'Admin Sistem'],
            ['value' => '2', 'label' => 'Admin Binagram'],
            ['value' => '1', 'label' => 'Admin Approval'],
            ['value' => '0', 'label' => 'Operator'],
        ];
    }

    private function customValidationMessages()
    {
        return [
            "name.required" => "Nama harus diisi.",
            "name.max" => "Nama tidak boleh lebih dari 100 karakter.",
            "email.required" => "Email harus diisi.",
            "email.unique" => "Email sudah digunakan.",
            "nip.required" => "NIP harus diisi.",
            "nip.unique" => "NIP sudah digunakan.",
            "bidang_id.required" => "Bidang harus dipilih.",
            "password.required" => "Password harus diisi.",
            "password.min" => "Password harus terdiri minimal 6 karakter.",
            "password.numbers" => "Password harus mengandung angka.",
            "password.letters" => "Password harus mengandung huruf.",
            "confirm_password.required_with" => "Konfirmasi password harus diisi.",
            "confirm_password.same" => "Konfirmasi password tidak cocok dengan password.",
            "role.required" => "Role harus dipilih."
        ];
    }

    public function view_add_user()
    {
        $roleOptions = $this->getRoleOptions();

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

        $roleOptions = $this->getRoleOptions();

        $joinBidang = User::join('bidang', 'users.bidang_id', '=', 'bidang.id')
            ->select('users.*', 'bidang.nama_bidang')
            ->findOrFail($id);

        return view("adminsistem.edit-user")->with(compact('joinBidang', 'user', 'bidang', 'roleOptions'));
    }

    public function create_user(Request $request)
    {
        $user = request()->validate(
            [
                "name" => ["required", "max:100"],
                "email" => ["required", "unique:users"],
                "nip" => ["required", "unique:users"],
                "bidang_id" => ["required"],
                "password" => ["required", Password::min(6)->numbers()->letters()],
                "confirm_password" => ["required_with:password", "same:password"],
                "role" => "required"
            ],
            $this->customValidationMessages()
        );

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

        $request->validate(
            [
                "name" => ["required", "max:100"],
                "email" => ["required", "unique:users,email," . $user->id],
                "nip" => ["required", "unique:users,nip," . $user->id],
                "password" => ["nullable", Password::min(6)->numbers()->letters()],
                "confirm_password" => ["nullable", "required_with:password", "same:password"],
            ],
            $this->customValidationMessages()
        );

        $user->name = ucwords(strtolower(trim($request->name)));
        $user->email = $request->email;
        $user->nip = $request->nip;

        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
        }

        $user->save();

        return redirect('adminsistem/edit-user/' . $id)->with([
            'success' => [
                "title" => "Update User Succesfully",
                "message" => "Akun berhasil di perbarui"
            ]
        ]);
    }

    public function get_all_user($order = 'desc')
    {
        $adminSystemCurrent = Auth::user()->id;
        $usersQuery = User::where('users.id', '!=', $adminSystemCurrent)
            ->join('bidang', 'users.bidang_id', '=', 'bidang.id')
            ->select('users.*', 'bidang.nama_bidang');

        $orderBy = request()->input('order_by');

        // Menentukan urutan berdasarkan parameter
        if ($orderBy) {
            if ($orderBy === 'nip' || $orderBy === 'nama' || $orderBy === 'email' || $orderBy === 'role' || $orderBy === 'nama_bidang') {
                $usersQuery->orderBy($orderBy, $order);
            }
        } else {
            $usersQuery->latest('users.id'); // Urutkan berdasarkan id secara default
        }

        $users = $usersQuery->paginate(7);
        $roleOptions = $this->getRoleOptions();

        return view('adminsistem.dashboard', ['users' => $users, 'roleOptions' => $roleOptions]);
    }

    public function delete_user($id): void
    {
        $user = User::findOrFail($id);
        $user->delete();
    }

    public function search_users(Request $request)
    {
        $roleOptions = $this->getRoleOptions();

        $search = $request->input('search');

        $adminSystemCurrent = Auth::user()->id;
        $users = User::where('users.id', '!=', $adminSystemCurrent)
            ->join('bidang', 'users.bidang_id', '=', 'bidang.id')
            ->select('users.*', 'bidang.nama_bidang')
            ->where(function ($query) use ($search, $roleOptions) {
                $query->where('users.name', 'like', '%' . $search . '%')
                    ->orWhere('users.nip', 'like', '%' . $search . '%')
                    ->orWhere('users.email', 'like', '%' . $search . '%')
                    ->orWhere('bidang.nama_bidang', 'like', '%' . $search . '%')
                    ->orWhere('users.role', 'like', '%' . $search . '%');
            })
            ->latest('users.id')
            ->paginate(7);

        return view('adminsistem.dashboard', ['users' => $users, 'roleOptions' => $roleOptions]);
    }
}
