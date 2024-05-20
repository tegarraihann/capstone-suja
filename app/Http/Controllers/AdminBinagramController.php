<?php

namespace App\Http\Controllers;

use App\Models\Indikator;
use App\Models\IndikatorPenunjang;
use App\Models\Sasaran;
use App\Models\SubIndikator;
use App\Models\Tujuan;
use Illuminate\Http\Request;

class AdminBinagramController extends Controller
{
    public function store(Request $request, $id, $bidang_id = null)
    {
        $tujuan = Tujuan::findOrFail($id);
        $sasaran = Sasaran::findOrFail($id);
        $indikator = Indikator::findOrFail($id);
        $indikatorPenunjang = IndikatorPenunjang::findOrFail($id);
        $subIndikator = SubIndikator::findOrFail($id);

        request()->validate([
            'tujuan' => ['required'],
            'sasaran' => ['required'],
            'indikator' => ['required'],
            'indikator_penunjang' => ['required'],
            'sub_indikator' => ['required'],
        ]);
    }
}
