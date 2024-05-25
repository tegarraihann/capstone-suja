<?php

namespace App\Http\Controllers;

use App\Models\DataIku;
use App\Models\Tujuan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OperatorController extends Controller
{
    public function view_master_data()
    {
        $iku = Tujuan::where('iku', 0)->with(['sasaran.indikator.indikator_penunjang', 'sasaran.indikator.sub_indikator'])->get();
        $iku_sup = Tujuan::where('iku', 1)->with(['sasaran.indikator.indikator_penunjang', 'sasaran.indikator.sub_indikator'])->get();

        return view('operator.dashboard', ['iku' => $iku, 'iku_sup' => $iku_sup]);
    }

    public function view_add_master_data()
    {
        return view("operator.tambah-master-data");
    }

    public function view_edit_master_data($id)
    {
        $dataIku = DataIku::findOrFail($id);

        return view("operator.edit-master-data")->with(compact('dataIku'));
    }

    public function add_master_data(Request $request)
    {
        // Periksa apakah salah satu dari indikator_id, indikator_penunjang_id, atau sub_indikator_id ada
        if (!$request->has('indikator_id') && !$request->has('indikator_penunjang_id') && !$request->has('sub_indikator_id')) {
            return response()->json(['message' => 'Permintaan tidak valid. Salah satu dari indikator_id, indikator_penunjang_id, atau sub_indikator_id harus diketahui.'], 400);
        }

        // Validasi input
        $request->validate([
            'perjanjian_kinerja_target_kumulatif' => 'required|integer',
            'perjanjian_kinerja_realisasi_kumulatif' => 'required|integer',
            'capaian_kinerja_kumulatif' => 'required|numeric',
            'capaian_kinerja_target_setahun' => 'required|numeric',
            'link_bukti_dukung_capaian' => 'required|string',
            'upaya_yang_dilakukan' => 'required|string',
            'link_bukti_dukung_upaya_yang_dilakukan' => 'required|string',
            'kendala' => 'required|string',
            'solusi_atas_kendala' => 'required|string',
            'rencana_tidak_lanjut' => 'required|string',
            'pic_tidak_lanjut' => 'required|string',
            'tenggat_tidak_lanjut' => 'required|date',
        ]);

        // Menentukan triwulan berdasarkan bulan saat ini
        $month = now()->month;
        if ($month >= 1 && $month <= 3) {
            $triwulan = "1";
        } elseif ($month >= 4 && $month <= 6) {
            $triwulan = "2";
        } elseif ($month >= 7 && $month <= 9) {
            $triwulan = "3";
        } else {
            $triwulan = "4";
        }

        // Menyusun data untuk disimpan
        $data = new DataIku();
        $data->perjanjian_kinerja_target_kumulatif = $request->input('perjanjian_kinerja_target_kumulatif');
        $data->perjanjian_kinerja_realisasi_kumulatif = $request->input('perjanjian_kinerja_realisasi_kumulatif');
        $data->capaian_kinerja_kumulatif = $request->input('capaian_kinerja_kumulatif');
        $data->capaian_kinerja_target_setahun = $request->input('capaian_kinerja_target_setahun');
        $data->link_bukti_dukung_capaian = $request->input('link_bukti_dukung_capaian');
        $data->upaya_yang_dilakukan = $request->input('upaya_yang_dilakukan');
        $data->link_bukti_dukung_upaya_yang_dilakukan = $request->input('link_bukti_dukung_upaya_yang_dilakukan');
        $data->kendala = $request->input('kendala');
        $data->solusi_atas_kendala = $request->input('solusi_atas_kendala');
        $data->rencana_tidak_lanjut = $request->input('rencana_tidak_lanjut');
        $data->pic_tidak_lanjut = $request->input('pic_tidak_lanjut');
        $data->tenggat_tidak_lanjut = $request->input('tenggat_tidak_lanjut');
        $data->status = 'pending';
        $data->upload_by = Auth::id();
        $data->approve_by = null;
        $data->reject_by = null;
        $data->reject_comment = null;
        $data->triwulan = $triwulan;

        // Memasukkan indikator_id jika ada
        if ($request->has('indikator_id')) {
            $data->indikator_id = $request->indikator_id;
        }

        // Memasukkan indikator_penunjang_id jika ada
        if ($request->has('indikator_penunjang_id')) {
            $data->indikator_penunjang_id = $request->indikator_penunjang_id;
        }

        // Memasukkan sub_indikator_id jika ada
        if ($request->has('sub_indikator_id')) {
            $data->sub_indikator_id = $request->sub_indikator_id;
        }

        // Memasukkan data ke dalam database
        $data->save();

        return redirect()->back()->with('success', 'Data berhasil ditambahkan');
    }

    public function update_master_data(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'perjanjian_kinerja_target_kumulatif' => 'required|integer',
            'perjanjian_kinerja_realisasi_kumulatif' => 'required|integer',
            'capaian_kinerja_kumulatif' => 'required|numeric',
            'capaian_kinerja_target_setahun' => 'required|numeric',
            'link_bukti_dukung_capaian' => 'required|string',
            'upaya_yang_dilakukan' => 'required|string',
            'link_bukti_dukung_upaya_yang_dilakukan' => 'required|string',
            'kendala' => 'required|string',
            'solusi_atas_kendala' => 'required|string',
            'rencana_tidak_lanjut' => 'required|string',
            'pic_tidak_lanjut' => 'required|string',
            'tenggat_tidak_lanjut' => 'required|date',
        ]);

        // Cari data yang akan diupdate
        $data = DataIku::findOrFail($id);

        // Memperbarui data
        $data->update([
            'perjanjian_kinerja_target_kumulatif' => $request->input('perjanjian_kinerja_target_kumulatif'),
            'perjanjian_kinerja_realisasi_kumulatif' => $request->input('perjanjian_kinerja_realisasi_kumulatif'),
            'capaian_kinerja_kumulatif' => $request->input('capaian_kinerja_kumulatif'),
            'capaian_kinerja_target_setahun' => $request->input('capaian_kinerja_target_setahun'),
            'link_bukti_dukung_capaian' => $request->input('link_bukti_dukung_capaian'),
            'upaya_yang_dilakukan' => $request->input('upaya_yang_dilakukan'),
            'link_bukti_dukung_upaya_yang_dilakukan' => $request->input('link_bukti_dukung_upaya_yang_dilakukan'),
            'kendala' => $request->input('kendala'),
            'solusi_atas_kendala' => $request->input('solusi_atas_kendala'),
            'rencana_tidak_lanjut' => $request->input('rencana_tidak_lanjut'),
            'pic_tidak_lanjut' => $request->input('pic_tidak_lanjut'),
            'tenggat_tidak_lanjut' => $request->input('tenggat_tidak_lanjut'),
        ]);

        return redirect()->back()->with('success', 'Data berhasil diperbarui');
    }

    public function view_uploaded_master_data()
    {
        $userBidangId = Auth::user()->bidang_id;

        $pendingData = DataIku::where('status', 'pending')
            ->where(function ($query) use ($userBidangId) {
                $query->whereHas('sub_indikator', function ($query) use ($userBidangId) {
                    $query->where('bidang_id', $userBidangId)
                        ->orWhereNull('bidang_id');
                });
            })
            ->get();

        $rejectedData = DataIku::where('status', 'rejected')
            ->where(function ($query) use ($userBidangId) {
                $query->whereHas('sub_indikator', function ($query) use ($userBidangId) {
                    $query->where('bidang_id', $userBidangId)
                        ->orWhereNull('bidang_id');
                });
            })
            ->get();

        $approvedData = DataIku::where('status', 'approved')
            ->where(function ($query) use ($userBidangId) {
                $query->whereHas('sub_indikator', function ($query) use ($userBidangId) {
                    $query->where('bidang_id', $userBidangId)
                        ->orWhereNull('bidang_id');
                });
            })
            ->get();

        // Mengembalikan view dengan data yang telah difilter
        return view('operator.uploaded-master-data', [
            'pendingData' => $pendingData,
            'rejectedData' => $rejectedData,
            'approvedData' => $approvedData,
        ]);
    }
}
