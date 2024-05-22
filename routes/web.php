<?php

use App\Http\Controllers\AdminBinagramController;
use App\Http\Controllers\AdminSistemController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;


Route::get('/', [HomeController::class, 'index']);

//Route Login
Route::post('/login_post', [AuthController::class, 'login_post']);

//Route logout
Route::get('/logout', [AuthController::class, 'logout']);

//Route Role Access
Route::group(['middleware' => ['pimpinan', 'no-cache']], function () {
    Route::get('pimpinan/dashboard', [DashboardController::class, "dashboard"]);
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
    Route::get('adminbinagram/dashboard', [AdminBinagramController::class, "view_master_data"]);
    Route::post('adminbinagram/dashboard/store', [AdminBinagramController::class, 'store']);
    Route::put('adminbinagram/dashboard/update/{id}', [AdminBinagramController::class, 'update']);
    Route::delete('adminbinagram/dashboard/delete/{id}', [AdminBinagramController::class, 'delete']);
});

Route::group(['middleware' => ['adminapproval', 'no-cache']], function () {
    Route::get('adminapproval/dashboard', [DashboardController::class, "dashboard"]);
});

Route::group(['middleware' => ['operator', 'no-cache']], function () {
    Route::get('operator/dashboard', [DashboardController::class, "dashboard"]);
});
