<?php

namespace Database\Seeders;

use App\Models\Day;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DaySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $day = [
            [
                'day' => 'Senin',
            ],
            [
                'day' => 'Selasa',
            ],
            [
                'day' => 'Rabu',
            ],
            [
                'day' => 'Kamis',
            ],
            [
                'day' => 'Jumat',
            ],
            [
                'day' => 'Sabtu',
            ],
        ];

        foreach($day as $day){
            day::create($day);
        }
    }
}
