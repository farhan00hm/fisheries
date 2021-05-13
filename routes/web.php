<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CaptureController;
use App\Http\Controllers\Admin\CultureController;
use App\Http\Controllers\Admin\HilsaController;
use App\Http\Controllers\Admin\MarineController;
use App\Http\Controllers\Admin\OthersController;
use App\Http\Controllers\Admin\ShrimpController;
use App\Http\Controllers\User\CageController;
use App\Http\Controllers\User\Capture\BeelController;
use App\Http\Controllers\User\Capture\FloodPlainController;
use App\Http\Controllers\User\Capture\KaptaiLakeController;
use App\Http\Controllers\User\Capture\RiverController;
use App\Http\Controllers\User\Capture\SundarbansController;
use App\Http\Controllers\User\PenController;
use App\Http\Controllers\User\PondController;
use App\Http\Controllers\User\SeasonalController;
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

    //Marine
    Route::get('/marine',[MarineController::class,'index'])->name('marine-index');
    Route::post('/marine',[MarineController::class,'store'])->name('marine-store');

    //hilsa
    Route::get('/hilsa',[HilsaController::class,'index'])->name('hilsa-index');
    Route::post('/hilsa',[HilsaController::class,'store'])->name('hilsa-store');

    //Shrimp
    Route::get('/shrimp',[ShrimpController::class,'index'])->name('shrimp-index');
    Route::post('/shrimp',[ShrimpController::class,'store'])->name('shrimp-store');

    //Others
    Route::get('/others',[OthersController::class,'index'])->name('others-index');
    Route::post('/others',[OthersController::class,'store'])->name('others-store');
});


Route::get('/logout',[AdminController::class,'logout']);

//User
Route::get("/home",[UserController::class,'home'])->name('home');

//Capture
Route::get('/capture/location/{location}',[UserController::class,'captureByLocation'])->name('capture-by-location');
Route::get('/capture/species/{species}',[UserController::class,'captureBySpecies'])->name('capture-by-species');
Route::get('/at-a-glance/{category}',[UserController::class,'atAGlanceByCategoryAndYear'])->name('at-a-glance-by-category-and-year');

//River
Route::get('/river',[RiverController::class,'index'])->name('River');
Route::get('/river/species/{species}',[RiverController::class,'riverBySpecies'])->name('river-by-species');

//Shundarbans
Route::get('/sundarbans',[SundarbansController::class,'index'])->name('Sundarbans');

//Beel
Route::get('/beel',[BeelController::class,'index'])->name('Beel');
Route::get('/beel/location/{location}',[BeelController::class,'beelByLocation'])->name('beel-by-location');
Route::get('/beel/species/{species}',[BeelController::class,'beelBySpecies'])->name('beel-by-species');

//kaptai Lake
Route::get('/kaptai-lake',[KaptaiLakeController::class,'index'])->name('Kaptai Lake');
Route::get('/kaptai-lake/species/{species}',[KaptaiLakeController::class,'kaptaiLakeBySpecies'])->name('kaptai-lake-by-species');

//FloodPlain
Route::get('/flood-plain',[FloodPlainController::class,'index'])->name('Flood Plain');
Route::get('/flood-plain/location/{location}',[FloodPlainController::class,'floodPlainByLocation'])->name('floodPlain-by-location');
Route::get('/flood-plain/species/{species}',[FloodPlainController::class,'floodPlainBySpecies'])->name('floodPlain-by-species');



//Culture
Route::get('/culture',[\App\Http\Controllers\User\CultureController::class,'index'])->name('Baor');
Route::get('/culture/{category}',[\App\Http\Controllers\User\CultureController::class,'cultureByCategory'])->name('culture-by-category');
Route::get('/culture/test',[\App\Http\Controllers\User\CultureController::class,'dataAtGlanceForALatestYear']);
Route::get('/culture/location/{location}',[\App\Http\Controllers\User\CultureController::class,'cultureByLocation'])->name('culture-by-location');
Route::get('/culture/species/{species}',[\App\Http\Controllers\User\CultureController::class,'baorBySpecies'])->name('baor-by-species');

//Cage
Route::get('/cage',[CageController::class,'index'])->name('Cage');
Route::get('/cage/location/{location}',[CageController::class,'cageByLocation'])->name('cage-by-location');

//pen
Route::get('/pen',[PenController::class,'index'])->name('Pen');
Route::get('/pen/location/{location}',[PenController::class,'penByLocation'])->name('pen-by-location');

//pond
Route::get('/pond',[PondController::class,'index'])->name('Pond');
Route::get('/pond/location/{location}',[PondController::class,'pondByLocation'])->name('pond-by-location');
Route::get('/pond/species/{species}',[PondController::class,'pondBySpecies'])->name('pond-by-species');

//Seasonal
Route::get('/seasonal',[SeasonalController::class,'index'])->name('Seasonal');
Route::get('/seasonal/location/{location}',[SeasonalController::class,'seasonalByLocation'])->name('seasonal-by-location');
Route::get('/seasonal/species/{species}',[SeasonalController::class,'seasonalBySpecies'])->name('seasonal-by-species');

//Seasonal Shrimp-Prawn
Route::get('/seasonal1',[SeasonalController::class,'index'])->name('Shrimp-Prawn');

//Hilsa
Route::get('/hilsa',[\App\Http\Controllers\User\Hilsa\HilsaController::class,'index'])->name('hilsa');
Route::get('/hilsa/location/{location}',[\App\Http\Controllers\User\Hilsa\HilsaController::class,'hilsaByLocation'])->name('hilsa-by-district');
Route::get('/hilsa/river/{river}',[\App\Http\Controllers\User\Hilsa\HilsaController::class,'hilsaByRiver'])->name('hilsa-by-river');

//Shrimp/Prawn
Route::get('/shrimp',[\App\Http\Controllers\User\Shrimp\ShrimpController::class,'index'])->name('shrimp');
Route::get('/shrimp/sector/{sector}',[\App\Http\Controllers\User\Shrimp\ShrimpController::class,'shrimpBySector'])->name('shrimp-by-sector');
Route::get('/shrimp/species/{species}',[\App\Http\Controllers\User\Shrimp\ShrimpController::class,'shrimpBySpecies'])->name('shrimp-by-species');
