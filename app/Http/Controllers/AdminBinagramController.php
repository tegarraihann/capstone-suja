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
    public function view_master_data()
    {
        $iku = Tujuan::where('iku', 0)->with(['sasaran.indikator.indikator_penunjang', 'sasaran.indikator.sub_indikator'])->get();
        $iku_sup = Tujuan::where('iku', 1)->with(['sasaran.indikator.indikator_penunjang', 'sasaran.indikator.sub_indikator'])->get();

        return view('adminbinagram.dashboard', ['iku' => $iku, 'iku_sup' => $iku_sup]);
    }

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
