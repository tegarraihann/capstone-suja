<?php

namespace Database\Seeders;

use App\Models\Triwulan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TriwulanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $triwulan = [
            [
                'triwulan' => 'Minggu 1',
            ],
            [
                'triwulan' => 'Minggu 2',
            ],
            [
                'triwulan' => 'Minggu 3',
            ],
            [
                'triwulan' => 'Minggu 4',
            ],
        ];

        foreach($triwulan as $trwln){
            Triwulan::create($trwln);
        }
    }
}
