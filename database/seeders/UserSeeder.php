<?php

namespace Database\Seeders;

use App\Models\Bidang;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $bidangUmum = Bidang::where('nama_bidang', 'Bagian Umum')->first();
        $bidangStatSosial = Bidang::where('nama_bidang', 'Fungsi Statistik Sosial')->first();
        $bidangStatProduksi = Bidang::where('nama_bidang', 'Fungsi Statistik Produksi')->first();
        $bidangStatDistribusi = Bidang::where('nama_bidang', 'Fungsi Statistik Distribusi')->first();
        $bidangNerwilis = Bidang::where('nama_bidang', 'Fungsi Nerwilis')->first();
        $bidangIPDS = Bidang::where('nama_bidang', 'Fungsi IPDS')->first();
        $pimpinan = Bidang::where('nama_bidang', 'Pimpinan')->first();

        $users = [


            // ADMIN SISTTEM
            [
                "name" => "John Doe",
                "email" => "adminsistem@gmail.com",
                "password" => "bps123",
                "role" => "3",
                "nip" => "132131231231312313124",
                "bidang_id" => $bidangIPDS->id
            ],


            // ADMIN APPROVAL
            [
                "name" => "Jehan Roy",
                "email" => "AdminApproval@gmail.com",
                "password" => "telkom123",
                "role" => "1",
                "nip" => "132131231231312315232",
                "bidang_id" => $bidangUmum->id
            ],

            // OPERATOR
            [
                "name" => "Ronald Roy",
                "email" => "officeBoy@gmail.com",
                "password" => "telkom123",
                "role" => "0",
                "nip" => "132131231231312313126873",
                "bidang_id" => $bidangUmum->id
            ]

        ];

        foreach ($users as $user) {
            User::create([
                "name" => $user['name'],
                "email" => $user['email'],
                "password" => Hash::make($user['password']),
                "remember_token" => Str::random(50),
                "role" => $user['role'],
                "nip" => $user['nip'],
                "bidang_id" => $user['bidang_id']
            ]);
        }
    }
}
