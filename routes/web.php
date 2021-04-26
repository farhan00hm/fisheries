<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CaptureController;
use App\Http\Controllers\Admin\OthersController;
use App\Http\Controllers\User\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

//Admin Routes
Route::group(['prefix'=>'admin','middleware'=>'auth'], function (){
    Route::get('/dashboard',function (){
       return view('admin.dashboard');
    })->name('admin-dashboard');

    //Capture
    Route::get('/capture',[CaptureController::class,'index'])->name('capture-index');
    Route::post('/capture',[CaptureController::class,'store'])->name('capture-store');

    Route::get('/others',[OthersController::class,'index'])->name('others-index');
    Route::post('/others',[OthersController::class,'store'])->name('others-store');
});


Route::get('/logout',[AdminController::class,'logout']);

//User Test
Route::get("/home",[UserController::class,'home']);
