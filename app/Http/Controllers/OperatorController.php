<?php

namespace App\Http\Controllers;

use App\Models\DataKinerja;
use App\Models\Indikator;
use App\Models\IndikatorPenunjang;
use App\Models\SubIndikator;
use App\Models\Day;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;

class OperatorController extends Controller
{
    public function view_master_data(Request $request)
    {
        $day = Day::all();

        // Mendapatkan nomor triwulan dari query parameter
        $selectedDay = $request->query('day', null);

        // Mengambil status triwulan dari database
        $dayStatus = Day::find($selectedDay)->status ?? null;

        // Memeriksa apakah triwulan memiliki status 'close'
        if ($dayStatus === 'close') {
            // Jika triwulan memiliki status 'close', lakukan redirect atau tampilkan pesan kesalahan
            return redirect()->back()->with('error', 'Data untuk triwulan ' . $selectedDay . ' tidak tersedia.');
        }

        return view('operator.dashboard', [
            'day' => $day,
            'dayStatus' => $dayStatus,
            'selectedDay' => $selectedDay,
        ]);
    }

    public function storeDataKinerja(Request $request)
    {
        // Validasi input
        $request->validate([
            'kriteria_kebersihan' => 'required|string',
            'tanggal' => 'required|date',
            'waktu' => 'required|date_format:H:i',
            'foto_before' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'foto_after' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'day_id' => 'required|exists:day,id',
        ]);

        // Simpan foto
        $fotoBeforePath = $request->file('foto_before')->store('public/foto_before');
        $fotoAfterPath = $request->file('foto_after')->store('public/foto_after');

        // Simpan data ke dalam tabel data_kinerja
        $dataKinerja = new DataKinerja();
        $dataKinerja->kriteria_kebersihan = $request->input('kriteria_kebersihan');
        $dataKinerja->tanggal = $request->input('tanggal');
        $dataKinerja->waktu = $request->input('waktu');
        $dataKinerja->day_id = $request->input('day_id');
        $dataKinerja->upload_by = Auth::id();

        // Assign file paths to attributes for foto
        $dataKinerja->foto_before = Storage::url($fotoBeforePath);
        $dataKinerja->foto_after = Storage::url($fotoAfterPath);

        // Simpan ke database
        $dataKinerja->save();

        // Redirect kembali ke halaman dengan pesan sukses
        return redirect()->back()->with('success', 'Data kinerja berhasil disimpan');
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

        $day = Day::all();
        $selectedDay = $request->query('day', null);
        $dayStatus = Day::find($selectedDay)->status ?? null;

        // Memeriksa apakah triwulan memiliki status 'close'
        if ($dayStatus === 'close') {
            // Jika triwulan memiliki status 'close', lakukan redirect atau tampilkan pesan kesalahan
            return redirect()->back()->with('error', 'Data untuk hari ' . $selectedDay . ' tidak tersedia.');
        }

        return view('operator.tambah-master-data', [
            'entityType' => $type,
            'entityName' => $entityName,
            'entityId' => $id,
            'day' => $day,
            'selectedDay' => $selectedDay,
            'dayStatus' => $dayStatus,
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
        $dataKinerjaQuery = DataKinerja::where('status', 'approved_by_ap')
            ->with(['user', 'approved_by']);

        // Tambahkan kondisi pencarian jika ada

        // Paginate the results
        $dataKinerja = $dataKinerjaQuery->paginate(5);

        // Return view with the data
        return view('operator.approved-master-data', [
            'dataKinerja' => $dataKinerja,
        ]);
    }

    public function view_rejected_master_data(Request $request)
    {
        $search = $request->input('search');
        $bidangId = Auth::user()->bidang_id;

        // Inisialisasi query
        $dataKinerjaQuery = DataKinerja::where('status', 'rejected')
            ->with(['user', 'rejected_by']);

        // Paginate the results
        $dataKinerja = $dataKinerjaQuery->paginate(5);

        // Return view with the data
        return view('operator.rejected-master-data', [
            'dataKinerja' => $dataKinerja,
        ]);
    }

    public function viewPendingData(Request $request)
    {
        $search = $request->input('search');
        $query = DataKinerja::where('status', 'pending')->with(['user']);

        $dataKinerja = $query->paginate(10);

        return view('operator.pending-master-data', compact('dataKinerja'));
    }

}
