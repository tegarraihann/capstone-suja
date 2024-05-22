<?php

namespace App\Http\Controllers;

use App\Models\Indikator;
use App\Models\IndikatorPenunjang;
use App\Models\Sasaran;
use App\Models\SubIndikator;
use App\Models\Tujuan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminBinagramController extends Controller
{
    public function view_master_data()
    {
        $iku = Tujuan::where('iku', 0)->with(['sasaran.indikator.indikator_penunjang', 'sasaran.indikator.sub_indikator'])->get();
        $iku_sup = Tujuan::where('iku', 1)->with(['sasaran.indikator.indikator_penunjang', 'sasaran.indikator.sub_indikator'])->get();

        return view('adminbinagram.dashboard', ['iku' => $iku, 'iku_sup' => $iku_sup]);
    }

    public function store(Request $request)
    {
        if ($request->has('tujuan') && $request->has('iku')) {
            // Logika untuk menyimpan tujuan
            $request->validate([
                'tujuan' => 'required|min:6',
                'iku' => 'required',
            ]);

            $tujuan = new Tujuan();
            $tujuan->tujuan = $request->tujuan;
            $tujuan->iku = $request->iku;

            if ($tujuan->save()) {
                return response()->json(['message' => 'Data tujuan berhasil dimasukkan'], 200);
            } else {
                return response()->json(['message' => 'Gagal memasukkan data tujuan'], 500);
            }
        } else if ($request->has('sasaran') && $request->has('tujuan_id')) {
            // Logika untuk menyimpan sasaran
            $request->validate([
                'sasaran' => 'required|min:6',
                'tujuan_id' => 'required',
            ]);

            $sasaran = new Sasaran();
            $sasaran->sasaran = $request->sasaran;
            $sasaran->tujuan_id = $request->tujuan_id;

            if ($sasaran->save()) {
                return response()->json(['message' => 'Data sasaran berhasil dimasukkan'], 200);
            } else {
                return response()->json(['message' => 'Gagal memasukkan data sasaran'], 500);
            }
        } else if ($request->has('indikator') && $request->has('sasaran_id')) {
            // Logika untuk menyimpan indikator, indikator penunjang, dan sub indikator
            $request->validate([
                'indikator' => 'required|min:6',
                'sasaran_id' => 'required',
            ]);

            try {
                DB::transaction(function () use ($request) {
                    $indikator = new Indikator();
                    $indikator->indikator = $request->indikator;
                    $indikator->sasaran_id = $request->sasaran_id;
                    $indikator->save();

                    $indikatorPenunjang = null;
                    if ($request->input('indikator_penunjang') !== null) {
                        $indikatorPenunjang = new IndikatorPenunjang();
                        $indikatorPenunjang->indikator_penunjang = $request->indikator_penunjang;
                        $indikatorPenunjang->indikator_id = $indikator->id;
                        $indikatorPenunjang->save();
                    }

                    if ($request->input('sub_indikator') !== null) {
                        $sub_indikator = new SubIndikator();
                        $sub_indikator->sub_indikator = $request->sub_indikator;
                        $sub_indikator->indikator_id = $indikator->id;
                        $sub_indikator->indikator_penunjang_id = $indikatorPenunjang ? $indikatorPenunjang->id : null;
                        $sub_indikator->bidang_id = $request->has('bidang_id') ? $request->bidang_id : null;
                        $sub_indikator->save();
                    }
                });

                return response()->json(['message' => 'Data indikator berhasil dimasukkan'], 200);
            } catch (\Exception $e) {
                return response()->json(['message' => 'Gagal memasukkan data indikator', 'error' => $e->getMessage()], 500);
            }
        } elseif ($request->has('indikator_penunjang') && $request->has('indikator_id')) {
            // Logika untuk menyimpan indikator penunjang dan sub indikator
            $request->validate([
                'indikator_id' => 'required',
            ]);

            try {
                DB::transaction(function () use ($request) {
                    $indikator_penunjang = null;
                    if($request->input('indikator_penunjang') !== null){
                        $indikator_penunjang = new IndikatorPenunjang();
                        $indikator_penunjang->indikator_penunjang = $request->indikator_penunjang;
                        $indikator_penunjang->indikator_id = $request->indikator_id;
                        $indikator_penunjang->save();
                    }

                    $sub_indikator = null;
                    if ($request->input('sub_indikator') !== null) {
                        $sub_indikator = new SubIndikator();
                        $sub_indikator->sub_indikator = $request->sub_indikator;
                        $sub_indikator->indikator_penunjang_id = $indikator_penunjang ? $indikator_penunjang->id : null;
                        $sub_indikator->indikator_id = $request->indikator_id;
                        $sub_indikator->bidang_id = $request->has('bidang_id') ? $request->bidang_id : null;
                        $sub_indikator->save();
                    }
                });

                return response()->json(['message' => 'Data indikator berhasil dimasukkan'], 200);
            } catch (\Exception $e) {
                return response()->json(['message' => 'Gagal memasukkan data indikator', 'error' => $e->getMessage()], 500);
            }
        } else if ($request->has('sub_indikator') && ($request->has('indikator_id') || $request->has('indikator_penunjang_id'))) {
            // Logika untuk menyimpan sub indikator
            $request->validate([
                'sub_indikator' => 'required|min:6',
                'indikator_id' => 'sometimes|nullable',
                'indikator_penunjang_id' => 'sometimes|nullable',
            ]);

            try {
                DB::transaction(function () use ($request) {
                    $sub_indikator = new SubIndikator();
                    $sub_indikator->sub_indikator = $request->sub_indikator;
                    $sub_indikator->indikator_id = $request->has('indikator_id') ? $request->indikator_id : null;
                    $sub_indikator->indikator_penunjang_id = $request->has('indikator_penunjang_id') ? $request->indikator_penunjang_id : null;
                    $sub_indikator->bidang_id = $request->has('bidang_id') ? $request->bidang_id : null;
                    $sub_indikator->save();
                });

                return response()->json(['message' => 'Data sub indikator berhasil dimasukkan'], 200);
            } catch (\Exception $e) {
                return response()->json(['message' => 'Gagal memasukkan data sub indikator', 'error' => $e->getMessage()], 500);
            }
        } else {
            return response()->json(['message' => 'Permintaan tidak valid'], 400);
        }
    }

    public function update(Request $request, $id)
    {
        if ($request->has('tujuan')) {
            $request->validate([
                'tujuan' => 'required|min:6',
            ]);

            $tujuan = Tujuan::findOrFail($id);
            $tujuan->tujuan = $request->tujuan;
            $tujuan->save();

            return response()->json(['message' => 'Data tujuan berhasil diperbarui'], 200);
        } elseif ($request->has('sasaran')) {
            $request->validate([
                'sasaran' => 'required|min:6',
            ]);

            $sasaran = Sasaran::findOrFail($id);
            $sasaran->sasaran = $request->sasaran;
            $sasaran->save();

            return response()->json(['message' => 'Data sasaran berhasil diperbarui'], 200);
        } elseif ($request->has('indikator')) {
            $request->validate([
                'indikator' => 'required|min:6'
            ]);

            $indikator = Indikator::findOrFail($id);
            $indikator->indikator = $request->indikator;
            $indikator->save();

            return response()->json(['message' => 'Data indikator berhasil diperbarui'], 200);
        } elseif ($request->has('indikator_penunjang')) {
            $request->validate([
                'indikator_penunjang' => 'required|min:6'
            ]);

            $indikator_penunjang = IndikatorPenunjang::findOrFail($id);
            $indikator_penunjang->indikator_penunjang = $request->indikator_penunjang;
            $indikator_penunjang->save();

            return response()->json(['message' => 'Data indikator penunjang berhasil diperbarui'], 200);
        } elseif ($request->has('sub_indikator')) {
            $request->validate([
                'sub_indikator' => 'required|min:6'
            ]);

            $sub_indikator = SubIndikator::findOrFail($id);
            $sub_indikator->sub_indikator = $request->sub_indikator;
            $sub_indikator->bidang_id = $request->has('bidang_id') ? $request->bidang_id : null;
            $sub_indikator->save();

            return response()->json(['message' => 'Data indikator penunjang berhasil diperbarui'], 200);
        } else {
            return response()->json(['message' => 'Permintaan tidak valid'], 400);
        }
    }

    public function delete($id)
    {
        try {
            if (request()->has('is_sasaran') && request()->is_sasaran) {
                $sasaran = Sasaran::findOrFail($id);
                $sasaran->delete();

                return response()->json(['message' => 'Data sasaran berhasil dihapus'], 200);
            } elseif (request()->has('is_indikator') && request()->is_indikator) {
                $indikator = Indikator::findOrFail($id);
                $indikator->delete();

                return response()->json(['message' => 'Data indikator berhasil dihapus'], 200);
            } elseif (request()->has('is_indikator_penunjang') && request()->is_indikator_penunjang) {
                $indikator_penunjang = IndikatorPenunjang::findOrFail($id);
                $indikator_penunjang->delete();

                return response()->json(['message' => 'Data indikator penunjang berhasil dihapus'], 200);
            } elseif (request()->has('is_sub_indikator') && request()->is_sub_indikator) {
                $sub_indikator = SubIndikator::findOrFail($id);
                $sub_indikator->delete();

                return response()->json(['message' => 'Data sub indikator berhasil dihapus'], 200);
            } else {
                $tujuan = Tujuan::findOrFail($id);
                $tujuan->delete();

                return response()->json(['message' => 'Data tujuan berhasil dihapus'], 200);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => 'Gagal menghapus data'], 500);
        }
    }
}
