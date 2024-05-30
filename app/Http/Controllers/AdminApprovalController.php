<?php

namespace App\Http\Controllers;

use App\Models\DataIku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminApprovalController extends Controller
{
    public function view_pending_data(Request $request)
    {
        $search = $request->input('search');
        $bidangId = Auth::user()->bidang_id;

        $triwulan_id = $request->input('triwulan');

        // Inisialisasi query
        $dataIkuQuery = DataIku::where('status', 'pending')
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
            ->with(['sub_indikator', 'indikator_penunjang', 'indikator', 'user'])
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
        $dataIku = $dataIkuQuery->paginate(7);

        // Return view with the data
        return view('adminapproval.dashboard', [
            'dataIku' => $dataIku,
            'triwulan' => $triwulan_id
        ]);
    }

    public function view_approved_master_data(Request $request)
    {
        $search = $request->input('search');
        $bidangId = Auth::user()->bidang_id;

        // Inisialisasi query
        $dataIkuQuery = DataIku::where('status', 'approved_by_ab')
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
        return view('adminapproval.approved-master-data', [
            'dataIku' => $dataIku,
        ]);
    }

    public function view_rejected_master_data(Request $request)
    {
        $search = $request->input('search');
        $bidangId = Auth::user()->bidang_id;

        // Inisialisasi query
        $dataIkuQuery = DataIku::where('status', 'rejected')
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
        return view('adminapproval.rejected-master-data', [
            'dataIku' => $dataIku,
        ]);
    }
}
