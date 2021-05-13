<?php

namespace App\Http\Controllers\User\Capture;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KaptaiLakeController extends Controller
{
    function index(){
        $latestDatas = $this->dataAtGlanceForALatestYear();
        $years = DB::table('capture_kaptai lake')->pluck('Year')->toArray();
        $years = array_unique($years);
        $xAxisValuesOfKaptaiLakeProduction = array();

        foreach ($years as $year){
            array_push($xAxisValuesOfKaptaiLakeProduction,$year);
        }
        $yAxisValuesOfKaptaiLakeProduction = [];
        foreach ($years as $year){
            $production = DB::table('capture_kaptai lake')
                ->where('Year',$year)
                ->sum('Catch ( M Ton)');
            $production = round($production);
            array_push($yAxisValuesOfKaptaiLakeProduction,$production);
        }

        $species = DB::table('capture_kaptai lake')->pluck('Species')->unique();
        $kaptaiLakeBySpecies = $this->kaptaiLakeBySpecies($species[0]);
        return view(
            'user.capture.kaptaiLake',
            [
                "latestDatas"=>$latestDatas,
                "xAxisValuesOfKaptaiLakeProduction"=>$xAxisValuesOfKaptaiLakeProduction,
                "yAxisValuesOfKaptaiLakeProduction"=>$yAxisValuesOfKaptaiLakeProduction,
                "xAxisValuesOfkaptaiLakeBySpecies"=>$kaptaiLakeBySpecies["xAxisValue"],
                "yAxisValuesOfkaptaiLakeBySpecies"=>$kaptaiLakeBySpecies["yAxisValue"],
                "species"=>$species
            ]
        );
    }

    //kaptaiLake By species
    public function kaptaiLakeBySpecies($specie){
        $years = DB::table('capture_kaptai lake')->pluck('Year')->toArray();
        $xAxisValue = array();
        $yAxisValue = array();
        $years = array_unique($years);

        foreach ($years as $year){
            array_push($xAxisValue,$year);
        }

        foreach ($xAxisValue as $year) {
            $speciesValue = DB::table('capture_kaptai lake')
                ->where('Year' ,$year)
                ->where("Species","=",$specie)
                ->sum('Catch ( M Ton)');

            array_push($yAxisValue,$speciesValue);
        }

        return ([
            "xAxisValue"=>$xAxisValue,
            "yAxisValue"=>$yAxisValue,

        ]);
    }

    public function dataAtGlanceForALatestYear(){
        $latestData = array();
        $years = DB::table('capture location wise')->pluck('Year');
        $latestYear = $years[0];
        $riverFish = DB::table('capture location wise')->where('Year' ,$latestYear)->sum('River');
        $sundarbansFish = DB::table('capture location wise')->where('Year' ,$latestYear)->sum('Sundarbans');
        $beelFish = DB::table('capture location wise')->where('Year' ,$latestYear)->sum('Beel');
        $kaptaiLakeFish = DB::table('capture location wise')->where('Year' ,$latestYear)->sum('Kaptai Lake');
        $floodPlainFish = DB::table('capture location wise')->where('Year' ,$latestYear)->sum('Flood Plain');

        $latestData['year'] = $latestYear;
        $latestData['River'] = $riverFish;
        $latestData['Sundarbans'] = $sundarbansFish;
        $latestData['Beel'] = $beelFish;
        $latestData['Kaptai Lake'] = $kaptaiLakeFish;
        $latestData['Flood Plain'] = $floodPlainFish;

        return $latestData;

    }
}
