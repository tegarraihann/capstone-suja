<?php

namespace Database\Seeders;

use App\Models\Bidang;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BidangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $bidangs = [
            "Pimpinan"
        ];

        foreach ($bidangs as $nama_bidang) {
            Bidang::create(['nama_bidang' => $nama_bidang]);
        }
    }
}