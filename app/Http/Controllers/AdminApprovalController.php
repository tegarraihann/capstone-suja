<?php

namespace App\Http\Controllers;

use App\Models\DataIku;
use App\Models\Indikator;
use App\Models\IndikatorPenunjang;
use App\Models\SubIndikator;
use App\Models\Triwulan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminApprovalController extends Controller
{
    public function view_pending_data(Request $request)
    {
        $search = $request->input('search');

        // Data dummy untuk chart
        $chartData = collect([
            (object) ['approved' => 10, 'rejected' => 5, 'triwulan_id' => 1],
            (object) ['approved' => 7, 'rejected' => 8, 'triwulan_id' => 2],
            (object) ['approved' => 15, 'rejected' => 3, 'triwulan_id' => 3],
            (object) ['approved' => 12, 'rejected' => 10, 'triwulan_id' => 4],
        ]);

        // Nama kategori dummy untuk x-axis pada chart
        $categories = ['Triwulan 1', 'Triwulan 2', 'Triwulan 3', 'Triwulan 4'];

        // Data dummy untuk tabel dataIku
        $dataIku = collect([
            (object) [
                'id' => 1,
                'capaian_kinerja' => 'Kinerja 1',
                'user' => (object) ['name' => 'User 1', 'bidang' => (object) ['nama_bidang' => 'Bidang A']],
                'triwulan' => (object) ['triwulan' => 'Triwulan 1'],
                'status' => 'pending',
            ],
            (object) [
                'id' => 2,
                'capaian_kinerja' => 'Kinerja 2',
                'user' => (object) ['name' => 'User 2', 'bidang' => (object) ['nama_bidang' => 'Bidang B']],
                'triwulan' => (object) ['triwulan' => 'Triwulan 2'],
                'status' => 'pending',
            ],
        ]);

        // Data dummy untuk triwulan
        $triwulan = collect([
            (object) ['id' => 1, 'triwulan' => 'Triwulan 1', 'status' => 'open'],
            (object) ['id' => 2, 'triwulan' => 'Triwulan 2', 'status' => 'close'],
            (object) ['id' => 3, 'triwulan' => 'Triwulan 3', 'status' => 'open'],
            (object) ['id' => 4, 'triwulan' => 'Triwulan 4', 'status' => 'close'],
        ]);

        $triwulan_id = $request->input('triwulan');

        // Query untuk mendapatkan data yang statusnya pending
        $dataIkuQuery = DataIku::where('status', 'pending')
            ->with(['user'])
            ->orderBy('created_at', 'desc');

        // Filter pencarian
        if ($search) {
            $dataIkuQuery->whereHas('user', function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%');
            });
        }

        // Paginasi
        $dataIku = $dataIkuQuery->paginate(5);

        // Ambil data triwulan
        $triwulan = Triwulan::all();

        return view('adminapproval.dashboard', [
            'dataIku' => $dataIku,
            'triwulan' => $triwulan,
            'chartData' => $chartData,
            'categories' => $categories
        ]);
    }


    public function view_approved_master_data(Request $request)
    {
        $search = $request->input('search');

        // Query untuk mendapatkan data yang disetujui
        $dataIkuQuery = DataIku::where('status', 'approved_by_ap')
            ->with(['user', 'approved_by']);

        // Filter pencarian
        if ($search) {
            $dataIkuQuery->whereHas('user', function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%');
            });
        }

        $dataIku = $dataIkuQuery->paginate(5);

        return view('adminapproval.approved-master-data', [
            'dataIku' => $dataIku,
        ]);
    }

    public function view_rejected_master_data(Request $request)
    {
        $search = $request->input('search');

        // Query untuk mendapatkan data yang ditolak
        $dataIkuQuery = DataIku::where('status', 'rejected')
            ->with(['user', 'rejected_by'])
            ->orderBy('created_at', 'desc');

        // Filter pencarian
        if ($search) {
            $dataIkuQuery->whereHas('user', function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%');
            });
        }

        $dataIku = $dataIkuQuery->paginate(5);

        return view('adminapproval.rejected-master-data', [
            'dataIku' => $dataIku,
        ]);
    }

    public function view_aksi_master_data(Request $request, $id)
    {
        // Ambil data IKU berdasarkan ID
        $dataIku = DataIku::find($id);

        if (!$dataIku) {
            return redirect()->back()->with('error', 'Data IKU tidak ditemukan');
        }

        $triwulan_id = $request->query('triwulan', $dataIku->triwulan_id);
        $triwulanStatus = Triwulan::find($triwulan_id)->status ?? null;

        if ($triwulanStatus === 'close') {
            return redirect()->back()->with([
                'error' => [
                    "title" => "Cannot Edit Data",
                    "message" => "Triwulan sedang ditutup"
                ]
            ]);
        }

        return view('adminapproval.aksi-master-data', [
            'dataIku' => $dataIku,
            'triwulan' => $triwulan_id,
            'triwulanStatus' => $triwulanStatus
        ]);
    }

    public function approve_data(Request $request, $id)
    {
        $dataIku = DataIku::find($id);

        $dataIku->status = 'approved_by_ap';
        $dataIku->approve_by = Auth::id();
        $dataIku->save();

        return response()->json([
            'success' => [
                "title" => "Data Approved Successfully",
                "message" => "Data berhasil disetujui"
            ]
        ], 200);
    }

    public function reject_data(Request $request, $id)
    {
        $dataIku = DataIku::find($id);

        $dataIku->status = 'rejected';
        $dataIku->reject_comment = $request->reject_comment;
        $dataIku->reject_by = Auth::id();
        $dataIku->save();

        return response()->json([
            'success' => [
                "title" => "Data Rejected Successfully",
                "message" => "Data berhasil ditolak"
            ]
        ], 200);
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

    public function activateTriwulan($id)
    {
        // Temukan triwulan berdasarkan ID
        $triwulan = Triwulan::find($id);

        if (!$triwulan) {
            return response()->json(['message' => 'Triwulan tidak ditemukan'], 404);
        }

        // Ubah status triwulan menjadi "open" jika "close" dan sebaliknya
        $triwulan->status = $triwulan->status === 'close' ? 'open' : 'close';
        $triwulan->save();

        return response()->json(['message' => 'Status triwulan berhasil diubah menjadi ' . ($triwulan->status === 'open' ? 'Dibuka' : 'Ditutup')]);
    }

    public function viewPendingData(Request $request)
    {
        $search = $request->input('search');
        $query = DataIku::where('status', 'pending')->with(['sub_indikator', 'indikator', 'indikator_penunjang', 'user', 'triwulan']);

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

        // Fetch all triwulan data to pass to the view
        $triwulan = Triwulan::all();


        return view('adminapproval.dashboard', compact('dataIku', 'triwulan'));
    }

    public function getChartData()
    {
        $data = DataIku::select('capaian_kinerja_kumulatif', 'created_at')->get();

        // Format data untuk chart
        $chartData = $data->map(function ($item) {
            return [
                'x' => $item->created_at->format('Y-m-d'), // tanggal
                'y' => $item->capaian_kinerja_kumulatif,   // nilai capaian
            ];
        });

        return response()->json($chartData);
    }
}
