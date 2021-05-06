<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CaptureController;
use App\Http\Controllers\Admin\CultureController;
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

    //Culture
    Route::get('/culture',[CultureController::class,'index'])->name('culture-index');
    Route::post('/culture',[CultureController::class,'store'])->name('culture-store');

    //Others
    Route::get('/others',[OthersController::class,'index'])->name('others-index');
    Route::post('/others',[OthersController::class,'store'])->name('others-store');
});


Route::get('/logout',[AdminController::class,'logout']);

//User
Route::get("/home",[UserController::class,'home']);

//Capture
Route::get('/capture/location/{location}',[UserController::class,'captureByLocation'])->name('capture-by-location');
Route::get('/capture/species/{species}',[UserController::class,'captureBySpecies'])->name('capture-by-species');
Route::get('/at-a-glance/{category}',[UserController::class,'atAGlanceByCategoryAndYear'])->name('at-a-glance-by-category-and-year');

//Culture
Route::get('/culture',[\App\Http\Controllers\User\CultureController::class,'index'])->name('culture-baor');
Route::get('/culture/{category}',[\App\Http\Controllers\User\CultureController::class,'cultureByCategory'])->name('culture-by-category');
Route::get('/culture/test',[\App\Http\Controllers\User\CultureController::class,'dataAtGlanceForALatestYear']);
Route::get('/culture/location/{location}',[\App\Http\Controllers\User\CultureController::class,'cultureByLocation'])->name('culture-by-location');
Route::get('/culture/species/{species}',[\App\Http\Controllers\User\CultureController::class,'baorBySpecies'])->name('baor-by-species');
