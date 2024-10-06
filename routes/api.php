<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TestController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\BothController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


Route::group(['middleware'=>'auth:sanctum'],function(){
    Route::get('logout',[BothController::class,'logout']);
    Route::get('all',[BothController::class,'all']);
    Route::post('details',[BothController::class,'details']);
    Route::get('notification',[BothController::class,'notifications']);
    Route::post('read',[BothController::class,'read']);

    Route::group(['middleware'=>'checkadmin','prefix'=>'admin'],function(){
        Route::post('insert',[AdminController::class,'insert']);
        Route::get('allorders',[AdminController::class,'all_orders']);
        Route::post('changestatus',[AdminController::class,'change_status']);
        Route::post('changepayment',[AdminController::class,'change_payment']);
        Route::post('report',[AdminController::class,'admin_report']);
        
    });
    
    Route::group(['middleware'=>'checkuser','prefix'=>'user'],function(){
        Route::get('profile',[UserController::class,'profile']);
        Route::post('editprofile',[UserController::class,'Editprofile']);
        Route::post('addcart',[UserController::class,'to_cart']);
        Route::get('cart',[UserController::class,'from_cart']);
        Route::post('removecart',[UserController::class,'delete_cart']);
        Route::post('order',[UserController::class,'order']);
        Route::get('showorders',[UserController::class,'show_orders']);
        Route::post('addfavorite',[UserController::class,'add_favorite']);
        Route::post('removefavorite',[UserController::class,'remove_favorite']);
        Route::get('favorites',[UserController::class,'favorites']);
        Route::post('report',[UserController::class,'user_report']);
        
    });
});

Route::post('user/register',[UserController::class,'register']);
Route::post('user/login',[UserController::class,'login']);
Route::post('admin/login',[AdminController::class,'login']);
















