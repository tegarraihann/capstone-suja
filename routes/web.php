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

//Route Role Access
Route::group(['middleware' => 'pimpinan'], function(){
    Route::get('pimpinan/dashboard', [DashboardController::class, "dashboard"]);
});

Route::group(['middleware' => 'adminsistem'], function(){
    Route::get('adminsistem/dashboard', [DashboardController::class, "dashboard"]);
    Route::post('adminsistem/dashboard', [AdminSistemController::class, 'create_user']);
    Route::get('adminsistem/dashboard', [AdminSistemController::class, 'get_all_user']);
    Route::get('adminsistem/dashboard/tambah-akun', [AdminSistemController::class, "tambah_akun"]);
    // Route::post('adminsistem/dashboard', [AdminSistemController::class, 'create_user']);
    // Route::get('adminsistem/dashboard', [AdminSistemController::class, 'get_all_user']);
});

Route::group(['middleware' => 'adminbinagram'], function(){
    Route::get('adminbinagram/dashboard', [DashboardController::class, "dashboard"]);
});

Route::group(['middleware' => 'adminapproval'], function(){
    Route::get('adminapproval/dashboard', [DashboardController::class, "dashboard"]);
});

Route::group(['middleware' => 'operator'], function(){
    Route::get('operator/dashboard', [DashboardController::class, "dashboard"]);
});

