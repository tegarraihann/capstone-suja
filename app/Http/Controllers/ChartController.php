<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ChartController extends Controller
{
    public function getDataForChart()
    {
        // Query data dari database atau buat data untuk chart
        $data = [
            'labels' => ['Januari', 'Februari', 'Maret'],
            'values' => [10, 20, 30]
        ];

        return response()->json($data);
    }
}
