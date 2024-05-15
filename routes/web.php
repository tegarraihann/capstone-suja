<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminSistemController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;


Route::get('/', [HomeController::class, 'index']);

Route::get('/dashboard', function () {
    return view('admin.dashboard');
});

//Route Login
Route::post('/login_post', [AuthController::class, 'login_post']);

//Route logout
Route::get('/logout', [AuthController::class, 'logout']);


//Route Role Access
Route::group(['middleware' => ['pimpinan', 'no-cache']], function () {
    Route::get('pimpinan/dashboard', [DashboardController::class, "dashboard"]);
    Route::get('pimpinan/logout', [AuthController::class, 'logout']);
});

Route::group(['middleware' => ['adminsistem', 'no-cache']], function () {
    Route::get('adminsistem/dashboard', [DashboardController::class, "dashboard"]);
    Route::get('adminsistem/dashboard/tambah-akun', [AdminSistemController::class, "tambah_akun"]);
    Route::post('adminsistem/dashboard/tambah-akun', [AdminSistemController::class, 'create_user']);
    // Route::get('adminsistem/dashboard', [AdminSistemController::class, 'get_all_user']);
});

Route::group(['middleware' => ['adminbinagram', 'no-cache']], function () {
    Route::get('adminbinagram/dashboard', [DashboardController::class, "dashboard"]);
    Route::get('adminbinagram/logout', [AuthController::class, 'logout']);
});

Route::group(['middleware' => ['adminapproval', 'no-cache']], function () {
    Route::get('adminapproval/dashboard', [DashboardController::class, "dashboard"]);
    Route::get('adminapproval/logout', [AuthController::class, 'logout']);
});

Route::group(['middleware' => ['operator', 'no-cache']], function () {
    Route::get('operator/dashboard', [DashboardController::class, "dashboard"]);
    Route::get('operator/logout', [AuthController::class, 'logout']);
});

