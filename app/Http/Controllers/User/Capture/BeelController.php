<?php

namespace App\Http\Controllers\User\Capture;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BeelController extends Controller
{
    function index(){
        $latestDatas = $this->dataAtGlanceForALatestYear();
        $years = DB::table('capture_beel_production')->pluck('Year')->toArray();
        $years = array_unique($years);
        $xAxisValuesOfBeelProduction = array();

        foreach ($years as $year){
            array_push($xAxisValuesOfBeelProduction,$year);
        }
        $yAxisValuesOfBeelProduction = [];
        foreach ($years as $year){
            $production = DB::table('capture_beel_production')
                ->where('Year',$year)
                ->sum('Total');
            $production = round($production);
            array_push($yAxisValuesOfBeelProduction,$production);
        }

        $districts = DB::table('capture_beel_production')->pluck('District')->unique();

        $species = DB::table('capture_beel_species')->pluck('Species')->unique();
        $beelBySpecies = $this->beelBySpecies($species[0]);
        return view(
            'user.capture.beel',
            [
                "latestDatas"=>$latestDatas,
                "xAxisValuesOfBeelProduction"=>$xAxisValuesOfBeelProduction,
                "yAxisValuesOfBeelProduction"=>$yAxisValuesOfBeelProduction,
                "xAxisValuesOfBeelBySpecies"=>$beelBySpecies["xAxisValue"],
                "yAxisValuesOfBeelBySpecies"=>$beelBySpecies["yAxisValue"],
                "districts"=>$districts,
                "species"=>$species
            ]
        );
    }

    //Beel By Location
    public function beelByLocation($location){

        $years = DB::table('capture_beel_production')->pluck('Year')->toArray();
        $years = array_unique($years);
        $xAxisValuesOfBeelProduction = array();
        foreach ($years as $year){
            array_push($xAxisValuesOfBeelProduction,$year);
        }

        $yAxisValuesOfBeelProduction = [];
        foreach ($years as $year){
            $production = DB::table('capture_beel_production')
                ->where('Year',$year)
                ->where('District',$location)
                ->sum('Total');
            array_push($yAxisValuesOfBeelProduction,$production);
        }


        return ([
            "xAxisValuesOfBeelProduction"=>$xAxisValuesOfBeelProduction,
            "yAxisValuesOfBeelProduction"=>$yAxisValuesOfBeelProduction
        ]);

    }

    //Beel By species
    public function beelBySpecies($specie){
        $years = DB::table('capture_beel_species')->pluck('Year')->toArray();
        $xAxisValue = array();
        $yAxisValue = array();
        $years = array_unique($years);

        foreach ($years as $year){
            array_push($xAxisValue,$year);
        }

        foreach ($xAxisValue as $year) {
            $speciesValue = DB::table('capture_beel_species')
                ->where('Year' ,$year)
                ->where("Species","=",$specie)
                ->sum('Metric Ton');

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
