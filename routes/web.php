<?php

use App\Http\Controllers\AdminApprovalController;
use App\Http\Controllers\AdminBinagramController;
use App\Http\Controllers\AdminSistemController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OperatorController;
use Illuminate\Support\Facades\Route;


Route::get('/', [HomeController::class, 'index']);

//Route Login
Route::post('/login_post', [AuthController::class, 'login_post']);

//Route logout
Route::get('/logout', [AuthController::class, 'logout']);

//Route Role Access
Route::group(['middleware' => ['pimpinan', 'no-cache']], function () {
    Route::get('pimpinan/dashboard', [DashboardController::class, "dashboard"]);
    Route::get('pimpinan/edit-user/{id}', [AdminSistemController::class, "view_update_user"]);
    Route::put('pimpinan/edit-user/{id}', [AdminSistemController::class, "edit_user"]);
});

Route::group(['middleware' => ['adminsistem', 'no-cache']], function () {
    Route::get('adminsistem/dashboard', [DashboardController::class, "dashboard"]);
    // Route::get('adminsistem/dashboard', [AdminSistemController::class, 'get_all_user']);
    Route::get('adminsistem/dashboard', [AdminSistemController::class, 'search_users'])->name('search-user');
    Route::get('adminsistem/tambah-user', [AdminSistemController::class, "view_add_user"]);
    Route::get('adminsistem/edit-user/{id}', [AdminSistemController::class, "view_update_user"]);
    Route::delete('adminsistem/dashboard/{id}', [AdminSistemController::class, 'delete_user']);
    Route::post('adminsistem/tambah-user', [AdminSistemController::class, 'create_user']);
    Route::put('adminsistem/edit-user/{id}', [AdminSistemController::class, "edit_user"]);
});

Route::group(['middleware' => ['adminbinagram', 'no-cache']], function () {
    Route::get('adminbinagram/dashboard', [DashboardController::class, "dashboard"]);
    Route::get('adminbinagram/edit-user/{id}', [AdminSistemController::class, "view_update_user"]);
    Route::put('adminbinagram/edit-user/{id}', [AdminSistemController::class, "edit_user"]);
    Route::get('adminbinagram/dashboard', [AdminBinagramController::class, "view_master_data"]);
    Route::post('adminbinagram/dashboard/store', [AdminBinagramController::class, 'store']);
    Route::put('adminbinagram/dashboard/update/{id}', [AdminBinagramController::class, 'update']);
    Route::put('adminbinagram/dashboard/actived-triwulan/{id}', [AdminBinagramController::class, 'activate_triwulan']);
    Route::delete('adminbinagram/dashboard/delete/{id}', [AdminBinagramController::class, 'delete']);
    Route::get('adminbinagram/pending-master-data', [AdminBinagramController::class, 'view_uploaded_master_data'])->name('search-data-pending-ab');
    Route::get('adminbinagram/edit-master-data/{type}/{id}', [AdminBinagramController::class, 'view_edit_master_data']);
    Route::put('adminbinagram/approve-master-data/{id}', [AdminBinagramController::class, "approve_data"]);
    Route::put('adminbinagram/reject-master-data/{id}', [AdminBinagramController::class, "reject_data"]);
});

Route::group(['middleware' => ['adminapproval', 'no-cache']], function () {
    Route::get('adminapproval/dashboard', [DashboardController::class, "dashboard"]);
    Route::get('adminapproval/dashboard', [AdminApprovalController::class, "view_pending_data"])->name('search-data-pending-ap');
    Route::get('adminapproval/approved-master-data', [AdminApprovalController::class, "view_approved_master_data"])->name('search-data-approved-ap');
    Route::get('adminapproval/rejected-master-data', [AdminApprovalController::class, 'view_rejected_master_data'])->name('search-data-rejected-ap');
    Route::get('adminapproval/edit-user/{id}', [AdminSistemController::class, "view_update_user"]);
    Route::put('adminapproval/edit-user/{id}', [AdminSistemController::class, "edit_user"]);
    Route::get('adminapproval/aksi-master-data/{id}', [AdminApprovalController::class, 'view_aksi_master_data'])->name('adminapproval.aksi-master-data');
    Route::put('adminapproval/approve-master-data/{id}', [AdminApprovalController::class, "approve_data"]);
    Route::put('adminapproval/reject-master-data/{id}', [AdminApprovalController::class, "reject_data"]);
    Route::put('adminapproval/dashboard/actived-triwulan/{id}', [AdminApprovalController::class, 'activateTriwulan']);
    Route::get('adminapproval/dashboard', [AdminApprovalController::class, 'viewPendingData'])->name('search-data-pending-ap');
    Route::put('adminapproval/update-master-data/{id}', [AdminApprovalController::class, 'update_master_data'])->name('adminapproval.update-master-data');

    Route::get('adminapproval/chart', [AdminApprovalController::class, 'getChartData'])->name('adminapproval.chart-data');


});

Route::group(['middleware' => ['operator', 'no-cache']], function () {
    Route::get('operator/dashboard', [DashboardController::class, "dashboard"]);
    Route::get('operator/dashboard', [OperatorController::class, "view_master_data"]);
    Route::get('operator/edit-master-data/{type}/{id}', [OperatorController::class, 'view_edit_master_data']);
    Route::get('operator/tambah-master-data/{type}/{id}', [OperatorController::class, 'view_add_master_data']);
    Route::get('operator/pending-master-data', [OperatorController::class, 'view_uploaded_master_data'])->name('search-data-pending');
    Route::get('operator/approved-master-data', [OperatorController::class, 'view_approved_master_data'])->name('search-data-approved');
    Route::get('operator/rejected-master-data', [OperatorController::class, 'view_rejected_master_data'])->name('search-data-rejected');
    Route::post('operator/tambah-master-data', [OperatorController::class, "add_master_data"]);
    Route::get('operator/edit-master-data/{id}', [OperatorController::class, 'view_edit_master_data']);
    Route::put('operator/update-master-data/{id}', [OperatorController::class, "update_master_data"])->name('operator.update_master_data');
    Route::get('operator/edit-user/{id}', [AdminSistemController::class, "view_update_user"]);
    Route::put('operator/edit-user/{id}', [AdminSistemController::class, "edit_user"]);
    Route::post('operator/store', [OperatorController::class, 'tambah_master_data'])->name('operator.store');
    Route::post('operator/store', [OperatorController::class, 'storeDataIku'])->name('operator.store');
    Route::get('operator/pending', [OperatorController::class, 'viewPendingData'])->name('search-data-pending');
});
