<?php

namespace App\Http\Controllers;

use App\Models\DataIku;
use App\Models\Indikator;
use App\Models\IndikatorPenunjang;
use App\Models\SubIndikator;
use App\Models\Tujuan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OperatorController extends Controller
{
    public function view_master_data()
    {
        $iku = Tujuan::where('iku', 0)->with(['sasaran.indikator.indikator_penunjang', 'sasaran.indikator.sub_indikator'])->get();
        $iku_sup = Tujuan::where('iku', 1)->with(['sasaran.indikator.indikator_penunjang', 'sasaran.indikator.sub_indikator'])->get();

        // Ambil semua sub_indikator_id yang ada di data_iku
        $existingDataSubIndikator = DataIku::pluck('sub_indikator_id')->toArray();
        $existingDataIndikatorPenunjang = DataIku::pluck('indikator_penunjang_id')->toArray();
        $existingDataIndikator = DataIku::pluck('indikator_id')->toArray();

        return view('operator.dashboard', [
            'iku' => $iku,
            'iku_sup' => $iku_sup,
            'existingDataSubIndikator' => $existingDataSubIndikator,
            'existingDataIndikatorPenunjang' => $existingDataIndikatorPenunjang,
            'existingDataIndikator' => $existingDataIndikator
        ]);
    }

    public function view_add_master_data($type, $id)
    {
        // Fetch entity based on type and id
        if ($type === 'sub_indikator') {
            $entity = SubIndikator::find($id);
            $entityName = $entity->sub_indikator ?? null;
        } elseif ($type === 'indikator_penunjang') {
            $entity = IndikatorPenunjang::find($id);
            $entityName = $entity->indikator_penunjang ?? null;
        } elseif ($type === 'indikator') {
            $entity = Indikator::find($id);
            $entityName = $entity->indikator ?? null;
        } else {
            $entity = null;
            $entityName = null;
        }

        if (!$entity) {
            return redirect()->back()->with('error', 'Entitas tidak ditemukan');
        }

        return view('operator.tambah-master-data', [
            'entityType' => $type,
            'entityName' => $entityName,
            'entityId' => $id,
        ]);
    }


    public function view_edit_master_data($type, $id)
    {
        // Fetch entity based on type and id
        if ($type === 'sub_indikator') {
            $entity = SubIndikator::find($id);
            $entityName = $entity->sub_indikator ?? null;
        } elseif ($type === 'indikator_penunjang') {
            $entity = IndikatorPenunjang::find($id);
            $entityName = $entity->indikator_penunjang ?? null;
        } elseif ($type === 'indikator') {
            $entity = Indikator::find($id);
            $entityName = $entity->indikator ?? null;
        } else {
            $entity = null;
            $entityName = null;
        }

        if (!$entity) {
            return redirect()->back()->with('error', 'Entitas tidak ditemukan');
        }

        // Fetch DataIku based on entity id
        $dataIku = DataIku::where('sub_indikator_id', $id)
            ->orWhere('indikator_penunjang_id', $id)
            ->orWhere('indikator_id', $id)
            ->first();

        if (!$dataIku) {
            return redirect()->back()->with('error', 'Data IKU tidak ditemukan');
        }

        return view('operator.edit-master-data', [
            'entityType' => $type,
            'entityName' => $entityName,
            'entityId' => $id,
            'dataIku' => $dataIku
        ]);
    }

    public function add_master_data(Request $request)
    {
        // Periksa apakah salah satu dari indikator_id, indikator_penunjang_id, atau sub_indikator_id ada
        if (!$request->has('type') || !$request->has('entity_id')) {
            return response()->json(['message' => 'Permintaan tidak valid. Type dan entity_id harus diketahui.'], 400);
        }

        // Validasi input
        $data = request()->validate([
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
            'sub_indikator_id' => 'nullable|unique:data_iku,sub_indikator_id',
            'indikator_penunjang_id' => 'nullable|unique:data_iku,indikator_penunjang_id',
            'indikator_id' => 'nullable|unique:data_iku,indikator_id'
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

        // Menyimpan id entitas berdasarkan type
        $type = $request->input('type');
        $entity_id = $request->input('entity_id');
        if ($type === 'sub_indikator') {
            $data->sub_indikator_id = $entity_id;
        } elseif ($type === 'indikator_penunjang') {
            $data->indikator_penunjang_id = $entity_id;
        } elseif ($type === 'indikator') {
            $data->indikator_id = $entity_id;
        }

        try {
            // Memasukkan data ke dalam database
            $data->save();

            return redirect()->back()->with([
                'success' => [
                    "title" => "Data Submit Succesfully",
                    "message" => "Data berhasil diisi"
                ]
            ]);
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->errorInfo[1] == 1062) {
                return redirect()->back()->withErrors(['error' => 'Duplikat entri terdeteksi. Data dengan ID yang sama sudah ada.'])->withInput();
            }
            return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan saat menyimpan data.'])->withInput();
        }
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

        // Memeriksa apakah semua input sama dengan nilai sebelumnya
        if (
            $data->perjanjian_kinerja_target_kumulatif == $request->input('perjanjian_kinerja_target_kumulatif') &&
            $data->perjanjian_kinerja_realisasi_kumulatif == $request->input('perjanjian_kinerja_realisasi_kumulatif') &&
            $data->capaian_kinerja_kumulatif == $request->input('capaian_kinerja_kumulatif') &&
            $data->capaian_kinerja_target_setahun == $request->input('capaian_kinerja_target_setahun') &&
            $data->link_bukti_dukung_capaian == $request->input('link_bukti_dukung_capaian') &&
            $data->upaya_yang_dilakukan == $request->input('upaya_yang_dilakukan') &&
            $data->link_bukti_dukung_upaya_yang_dilakukan == $request->input('link_bukti_dukung_upaya_yang_dilakukan') &&
            $data->kendala == $request->input('kendala') &&
            $data->solusi_atas_kendala == $request->input('solusi_atas_kendala') &&
            $data->rencana_tidak_lanjut == $request->input('rencana_tidak_lanjut') &&
            $data->pic_tidak_lanjut == $request->input('pic_tidak_lanjut') &&
            $data->tenggat_tidak_lanjut == $request->input('tenggat_tidak_lanjut')
        ) {
            return redirect()->back()->with([
                'warning' => [
                    "title" => "No Changes Made",
                    "message" => "Tidak ada perubahan yang dilakukan."
                ]
            ]);
        }

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
            'upload_by' => Auth::id()
        ]);

        try {
            // Memasukkan data ke dalam database
            $data->save();

            return redirect()->back()->with([
                'success' => [
                    "title" => "Data Updated Successfully",
                    "message" => "Data berhasil diperbarui."
                ]
            ]);
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->errorInfo[1] == 1062) {
                return redirect()->back()->withErrors(['error' => 'Duplikat entri terdeteksi. Data dengan ID yang sama sudah ada.'])->withInput();
            }
            return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan saat menyimpan data.'])->withInput();
        }
    }


    public function view_uploaded_master_data(Request $request)
    {
        $search = $request->input('search');
        $bidangId = Auth::user()->bidang_id;

        // Inisialisasi query
        $dataIkuQuery = DataIku::where('status', 'pending')
            ->whereHas('sub_indikator', function ($query) use ($bidangId) {
                $query->whereNull('bidang_id')
                    ->orWhere('bidang_id', $bidangId);
            })
            ->with(['sub_indikator', 'indikator_penunjang', 'indikator', 'user']);

        // Tambahkan kondisi pencarian jika ada
        if ($search) {
            $dataIkuQuery->where(function ($query) use ($search) {
                $query->whereHas('sub_indikator', function ($q) use ($search) {
                    $q->where('sub_indikator', 'like', '%' . $search . '%');
                })
                    ->orWhereHas('indikator_penunjang', function ($q) use ($search) {
                        $q->where('indikator_penunjang', 'like', '%' . $search . '%');
                    })
                    ->orWhereHas('indikator', function ($q) use ($search) {
                        $q->where('indikator', 'like', '%' . $search . '%');
                    })
                    ->orWhereHas('user', function ($q) use ($search) {
                        $q->where('name', 'like', '%' . $search . '%');
                    });
            });
        }

        // Paginate the results
        $dataIku = $dataIkuQuery->paginate(3);

        // Return view with the data
        return view('operator.pending-master-data', [
            'dataIku' => $dataIku,
        ]);
    }

}
