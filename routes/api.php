<?php

use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\LogUserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\User\DataDiriController;
use App\Http\Controllers\User\UserDashboardController;
use App\Http\Controllers\UtilController;

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::post('/login',[AuthController::class,'login']);
Route::post('/register',[AuthController::class,'register']);
Route::post('/akun/verif-email/{id}',[AuthController::class,'validasiEmail'])->name('user.verif');
Route::post('/sendToken',[AuthController::class,'sendToken']);
Route::post('/validateToken',[AuthController::class,'validateToken']);
Route::post('/resetPassword/{id}',[AuthController::class,'resetPassword']);
Route::post('/newPassword/{id}',[AuthController::class,'newPassword']);


Route::post('/cek/email',[UtilController::class,'cekEmail']);
Route::post('/getWilayah',[UtilController::class,'getWilayah']);
Route::middleware('auth:api')->group(function(){
    Route::post('/logout',[AuthController::class,'logout']);
    Route::prefix('admin')->group(function(){
        Route::match(array('get','post'),'/users',[AdminUserController::class,'index']);
        Route::post('/user/save',[AdminUserController::class,'save']);
        Route::post("/users/edit/{id}",[AdminUserController::class,'detail']);
        Route::post("/users/delete/{id}",[AdminUserController::class,'delete']);
        Route::post("/users/valid/{id}",[AdminUserController::class,'valid']);


        Route::match(array('get','post'),'/logsuser',[LogUserController::class,'index']);
        Route::get("/logsuser/getFilter",[LogUserController::class,'getFilter']);
        Route::get('/logsuser/export', [LogUserController::class, 'export']);
    });
    Route::prefix('user')->group(function(){
        Route::get('/cek',[UserDashboardController::class,'index']);
        Route::get('/detail',[DataDiriController::class,'detail']);
        Route::post('/sendEmail',[UserDashboardController::class,'sendEmail']);
        Route::post('/saveDataDiri',[DataDiriController::class,'save']);
    });
});
