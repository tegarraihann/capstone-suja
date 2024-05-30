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
            [
                "name" => "Joe Gon",
                "email" => "pimpinan@gmail.com",
                "password" => "pimpinan123",
                "role" => "4",
                "nip" => "132131231231312313123",
                "bidang_id" => $pimpinan->id
            ],
            [
                "name" => "John Doe",
                "email" => "adminsistem@gmail.com",
                "password" => "admin123",
                "role" => "3",
                "nip" => "132131231231312313124",
                "bidang_id" => $bidangIPDS->id
            ],
            [
                "name" => "Mils Way",
                "email" => "adminbinagram@gmail.com",
                "password" => "admin123",
                "role" => "2",
                "nip" => "132131231231312313125",
                "bidang_id" => $bidangIPDS->id
            ],
            [
                "name" => "Clerk Emily",
                "email" => "adminapproval@gmail.com",
                "password" => "admin123",
                "role" => "1",
                "nip" => "132131231231312313126",
                "bidang_id" => $bidangStatSosial->id
            ],
            [
                "name" => "Ronald Roy",
                "email" => "operator@gmail.com",
                "password" => "operator123",
                "role" => "0",
                "nip" => "132131231231312313123",
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
