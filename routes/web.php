<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CaptureController;
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
});


Route::get('/logout',[AdminController::class,'logout']);
