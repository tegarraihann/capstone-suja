<?php

namespace App\Http\Controllers;

use App\Models\DataIku;
use App\Models\Indikator;
use App\Models\IndikatorPenunjang;
use App\Models\SubIndikator;
use App\Models\Triwulan;
use App\Models\Tujuan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;

class OperatorController extends Controller
{
    public function view_master_data(Request $request)
    {
        $iku = Tujuan::where('iku', 0)->with(['sasaran.indikator.indikator_penunjang', 'sasaran.indikator.sub_indikator'])->get();
        $iku_sup = Tujuan::where('iku', 1)->with(['sasaran.indikator.indikator_penunjang', 'sasaran.indikator.sub_indikator'])->get();
        $triwulan = Triwulan::all();

        // Mendapatkan nomor triwulan dari query parameter
        $selectedTriwulan = $request->query('triwulan', null);

        // Mengambil status triwulan dari database
        $triwulanStatus = Triwulan::find($selectedTriwulan)->status ?? null;

        // Memeriksa apakah triwulan memiliki status 'close'
        if ($triwulanStatus === 'close') {
            // Jika triwulan memiliki status 'close', lakukan redirect atau tampilkan pesan kesalahan
            return redirect()->back()->with('error', 'Data untuk triwulan ' . $selectedTriwulan . ' tidak tersedia.');
        }

        // Filter DataIku based on selected triwulan
        $existingDataSubIndikator = DataIku::when($selectedTriwulan, function ($query, $selectedTriwulan) {
            return $query->where('triwulan_id', $selectedTriwulan);
        })->pluck('sub_indikator_id')->toArray();

        $existingDataIndikatorPenunjang = DataIku::when($selectedTriwulan, function ($query, $selectedTriwulan) {
            return $query->where('triwulan_id', $selectedTriwulan);
        })->pluck('indikator_penunjang_id')->toArray();

        $existingDataIndikator = DataIku::when($selectedTriwulan, function ($query, $selectedTriwulan) {
            return $query->where('triwulan_id', $selectedTriwulan);
        })->pluck('indikator_id')->toArray();

        $existingDataSubIndikatorApproved = DataIku::when($selectedTriwulan, function ($query, $selectedTriwulan) {
            return $query->where('triwulan_id', $selectedTriwulan)
                         ->Where('status', 'approved_by_ab');
        })->pluck('sub_indikator_id')->toArray();

        $existingDataIndikatorPenunjangApproved = DataIku::when($selectedTriwulan, function ($query, $selectedTriwulan) {
            return $query->where('triwulan_id', $selectedTriwulan)
                         ->Where('status', 'approved_by_ab');
        })->pluck('indikator_penunjang_id')->toArray();

        $existingDataIndikatorApproved = DataIku::when($selectedTriwulan, function ($query, $selectedTriwulan) {
            return $query->where('triwulan_id', $selectedTriwulan)
                         ->Where('status', 'approved_by_ab');
        })->pluck('indikator_id')->toArray();

        return view('operator.dashboard', [
            'iku' => $iku,
            'iku_sup' => $iku_sup,
            'triwulan' => $triwulan,
            'triwulanStatus' => $triwulanStatus,
            'existingDataSubIndikator' => $existingDataSubIndikator,
            'existingDataIndikatorPenunjang' => $existingDataIndikatorPenunjang,
            'existingDataIndikator' => $existingDataIndikator,
            'selectedTriwulan' => $selectedTriwulan,
            'existingDataSubIndikatorApproved' => $existingDataSubIndikatorApproved,
            'existingDataIndikatorPenunjangApproved' => $existingDataIndikatorPenunjangApproved,
            'existingDataIndikatorApproved' => $existingDataIndikatorApproved
        ]);
    }

    public function storeDataIku(Request $request)
    {
        // Validasi input
        $request->validate([
            'kriteria_kebersihan' => 'required|string',
            'tanggal' => 'required|date',
            'waktu' => 'required|date_format:H:i',
            'foto_before' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'foto_after' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'triwulan_id' => 'required|exists:triwulan,id',
        ]);

        // Simpan foto
        $fotoBeforePath = $request->file('foto_before')->store('public/foto_before');
        $fotoAfterPath = $request->file('foto_after')->store('public/foto_after');

        // Konversi kriteria kebersihan ke bentuk numerik jika diperlukan
        $kriteriaKebersihan = match ($request->input('kriteria_kebersihan')) {
            'harum' => 3,
            'wangi' => 2,
            'bau' => 1,
            default => 0,
        };

        // Buat data IKU baru
        $dataIku = new DataIku();
        $dataIku->perjanjian_kinerja_target_kumulatif = $kriteriaKebersihan;
        $dataIku->perjanjian_kinerja_realisasi_kumulatif = 0;
        $dataIku->capaian_kinerja_kumulatif = 0.0;
        $dataIku->capaian_kinerja_target_setahun = 0.0;
        $dataIku->link_bukti_dukung_capaian = null;
        $dataIku->upaya_yang_dilakukan = 'N/A';
        $dataIku->link_bukti_dukung_upaya_yang_dilakukan = null;
        $dataIku->kendala = 'N/A';
        $dataIku->solusi_atas_kendala = 'N/A';
        $dataIku->rencana_tidak_lanjut = 'N/A';
        $dataIku->pic_tidak_lanjut = 'N/A';
        $dataIku->tenggat_tidak_lanjut = now();

        $dataIku->status = 'pending';
        $dataIku->upload_by = Auth::id();
        $dataIku->approve_by = null;
        $dataIku->reject_by = null;
        $dataIku->triwulan_id = $request->input('triwulan_id');
        $dataIku->reject_comment = null;

        // Assign file paths to custom attributes for foto
        $dataIku->foto_before = Storage::url($fotoBeforePath);
        $dataIku->foto_after = Storage::url($fotoAfterPath);

        // Simpan ke database
        $dataIku->save();

        // Redirect kembali ke halaman dengan pesan sukses
        return redirect()->back()->with('success', 'Data berhasil disimpan');
    }

    public function view_add_master_data(Request $request, $type, $id)
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

        $triwulan = Triwulan::all();
        $selectedTriwulan = $request->query('triwulan', null);
        $triwulanStatus = Triwulan::find($selectedTriwulan)->status ?? null;

        // Memeriksa apakah triwulan memiliki status 'close'
        if ($triwulanStatus === 'close') {
            // Jika triwulan memiliki status 'close', lakukan redirect atau tampilkan pesan kesalahan
            return redirect()->back()->with('error', 'Data untuk triwulan ' . $selectedTriwulan . ' tidak tersedia.');
        }

        return view('operator.tambah-master-data', [
            'entityType' => $type,
            'entityName' => $entityName,
            'entityId' => $id,
            'triwulan' => $triwulan,
            'selectedTriwulan' => $selectedTriwulan,
            'triwulanStatus' => $triwulanStatus,
        ]);
    }



    public function view_edit_master_data(Request $request, $type, $id)
    {

        // Ambil data berdasarkan ID
        $dataIku = DataIku::findOrFail($id);

        // Jika data tidak ditemukan, kembalikan error
        if (!$dataIku) {
            return redirect()->back()->with('error', 'Data IKU tidak ditemukan');
        }

        // Redirect ke halaman edit dengan data yang diperlukan
        return view('operator.edit-master-data', [
            'dataIku' => $dataIku,
        ]);
    }


    public function add_master_data(Request $request)
    {
        // Periksa apakah salah satu dari indikator_id, indikator_penunjang_id, atau sub_indikator_id ada
        if (!$request->has('type') || !$request->has('entity_id')) {
            return response()->json(['message' => 'Permintaan tidak valid. Type dan entity_id harus diketahui.'], 400);
        }

        // Periksa apakah ada query parameter 'triwulan' dan ambil nilainya
        $triwulan_id = $request->input('triwulan');

        // Validasi input
        $data = $request->validate([
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
            'sub_indikator_id' => 'nullable|integer',
            'indikator_penunjang_id' => 'nullable|integer',
            'indikator_id' => 'nullable|integer',
        ]);

        // Menyusun data untuk disimpan
        $dataIku = new DataIku();
        $dataIku->perjanjian_kinerja_target_kumulatif = $request->input('perjanjian_kinerja_target_kumulatif');
        $dataIku->perjanjian_kinerja_realisasi_kumulatif = $request->input('perjanjian_kinerja_realisasi_kumulatif');
        $dataIku->capaian_kinerja_kumulatif = $request->input('capaian_kinerja_kumulatif');
        $dataIku->capaian_kinerja_target_setahun = $request->input('capaian_kinerja_target_setahun');
        $dataIku->link_bukti_dukung_capaian = $request->input('link_bukti_dukung_capaian');
        $dataIku->upaya_yang_dilakukan = $request->input('upaya_yang_dilakukan');
        $dataIku->link_bukti_dukung_upaya_yang_dilakukan = $request->input('link_bukti_dukung_upaya_yang_dilakukan');
        $dataIku->kendala = $request->input('kendala');
        $dataIku->solusi_atas_kendala = $request->input('solusi_atas_kendala');
        $dataIku->rencana_tidak_lanjut = $request->input('rencana_tidak_lanjut');
        $dataIku->pic_tidak_lanjut = $request->input('pic_tidak_lanjut');
        $dataIku->tenggat_tidak_lanjut = $request->input('tenggat_tidak_lanjut');
        $dataIku->status = 'pending';
        $dataIku->upload_by = Auth::id();
        $dataIku->approve_by = null;
        $dataIku->reject_by = null;
        $dataIku->reject_comment = null;

        // Set nilai triwulan_id dari query parameter 'triwulan'
        $dataIku->triwulan_id = $triwulan_id;

        // Menyimpan id entitas berdasarkan type
        $type = $request->input('type');
        $entity_id = $request->input('entity_id');
        if ($type === 'sub_indikator') {
            $dataIku->sub_indikator_id = $entity_id;
        } elseif ($type === 'indikator_penunjang') {
            $dataIku->indikator_penunjang_id = $entity_id;
        } elseif ($type === 'indikator') {
            $dataIku->indikator_id = $entity_id;
        }

        try {
            // Memasukkan data ke dalam database
            $dataIku->save();

            return redirect()->back()->with([
                'success' => [
                    "title" => "Data Submit Succesfully",
                    "message" => "Data berhasil diisi"
                ]
            ]);
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan saat menyimpan data.'])->withInput();
        }
    }

    public function update_master_data(Request $request, $id)
    {
        // Validasi input pada kolom yang ada di data_iku
        $request->validate([
            'foto_before' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'foto_after' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'kriteria_kebersihan' => 'required|string',
            'tanggal' => 'required|date',
            'waktu' => 'required|date_format:H:i',
            'triwulan_id' => 'required|exists:triwulan,id',
        ]);

        // Cari data yang akan diupdate
        $data = DataIku::findOrFail($id);

        // Status untuk menentukan apakah ada perubahan
        $isChanged = false;

        // Update foto_before jika ada
        if ($request->hasFile('foto_before')) {
            $fotoBeforePath = $request->file('foto_before')->store('public/foto_before');
            $data->foto_before = Storage::url($fotoBeforePath);
            $isChanged = true;
        }

        // Update foto_after jika ada
        if ($request->hasFile('foto_after')) {
            $fotoAfterPath = $request->file('foto_after')->store('public/foto_after');
            $data->foto_after = Storage::url($fotoAfterPath);
            $isChanged = true;
        }

        // Update kriteria_kebersihan sesuai dengan input dropdown
        $kriteriaKebersihan = match ($request->input('kriteria_kebersihan')) {
            'harum' => 3,
            'wangi' => 2,
            'bau' => 1,
            default => 0,
        };

        if ($data->perjanjian_kinerja_target_kumulatif !== $kriteriaKebersihan) {
            $data->perjanjian_kinerja_target_kumulatif = $kriteriaKebersihan;
            $isChanged = true;
        }

        // Menggabungkan tanggal dan waktu untuk kolom tenggat_tidak_lanjut
        if ($request->filled('tanggal') && $request->filled('waktu')) {
            $data->tenggat_tidak_lanjut = \Carbon\Carbon::parse($request->input('tanggal') . ' ' . $request->input('waktu'));
            $isChanged = true;
        }

        // Update triwulan_id
        if ($data->triwulan_id !== $request->input('triwulan_id')) {
            $data->triwulan_id = $request->input('triwulan_id');
            $isChanged = true;
        }

        // Set kolom-kolom lainnya agar tetap sesuai
        $data->status = 'pending';
        $data->upload_by = Auth::id();
        $data->approve_by = null;
        $data->reject_by = null;
        $data->reject_comment = null;

        // Save data jika ada perubahan
        if ($isChanged) {
            $data->save();
            return redirect()->route('search-data-pending')->with('success', 'Data berhasil diperbarui');
        }

        return redirect()->route('search-data-pending')->with('warning', 'Tidak ada perubahan yang disimpan');
    }

    public function view_approved_master_data(Request $request)
    {
        $search = $request->input('search');
        $bidangId = Auth::user()->bidang_id;

        // Inisialisasi query
        $dataIkuQuery = DataIku::where('status', 'approved_by_ab')
            ->where(function ($query) use ($bidangId) {
                $query->whereHas('sub_indikator', function ($q) use ($bidangId) {
                    $q->whereNull('bidang_id')
                        ->orWhere('bidang_id', $bidangId);
                })
                    ->orWhereHas('indikator', function ($q) use ($bidangId) {
                        $q->whereNull('bidang_id')
                            ->orWhere('bidang_id', $bidangId);
                    })
                    ->orWhereHas('indikator_penunjang');
            })
            ->with(['sub_indikator', 'indikator_penunjang', 'indikator', 'user', 'approved_by'])
            ->orderBy('created_at', 'desc');

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
        $dataIku = $dataIkuQuery->paginate(5);

        // Return view with the data
        return view('operator.approved-master-data', [
            'dataIku' => $dataIku,
        ]);
    }

    public function view_rejected_master_data(Request $request)
    {
        $search = $request->input('search');
        $bidangId = Auth::user()->bidang_id;

        // Inisialisasi query
        $dataIkuQuery = DataIku::where('status', 'rejected')
            ->where(function ($query) use ($bidangId) {
                $query->whereHas('sub_indikator', function ($q) use ($bidangId) {
                    $q->whereNull('bidang_id')
                        ->orWhere('bidang_id', $bidangId);
                })
                    ->orWhereHas('indikator', function ($q) use ($bidangId) {
                        $q->whereNull('bidang_id')
                            ->orWhere('bidang_id', $bidangId);
                    })
                    ->orWhereHas('indikator_penunjang');
            })
            ->with(['sub_indikator', 'indikator_penunjang', 'indikator', 'user', 'rejected_by'])
            ->orderBy('created_at', 'desc');

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
        $dataIku = $dataIkuQuery->paginate(5);

        // Return view with the data
        return view('operator.rejected-master-data', [
            'dataIku' => $dataIku,
        ]);
    }

    public function viewPendingData(Request $request)
    {
        $search = $request->input('search');
        $query = DataIku::where('status', 'pending')->with(['sub_indikator', 'indikator', 'indikator_penunjang', 'user']);

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->whereHas('sub_indikator', function ($subQuery) use ($search) {
                    $subQuery->where('sub_indikator', 'like', '%' . $search . '%');
                })
                ->orWhereHas('indikator', function ($indQuery) use ($search) {
                    $indQuery->where('indikator', 'like', '%' . $search . '%');
                })
                ->orWhereHas('indikator_penunjang', function ($indPenunjangQuery) use ($search) {
                    $indPenunjangQuery->where('indikator_penunjang', 'like', '%' . $search . '%');
                })
                ->orWhereHas('user', function ($userQuery) use ($search) {
                    $userQuery->where('name', 'like', '%' . $search . '%');
                });
            });
        }

        $dataIku = $query->paginate(10);

        return view('operator.pending-master-data', compact('dataIku'));
    }

}
