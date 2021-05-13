<?php

namespace App\Http\Controllers\User\Capture;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

//capture_floodplain_total
//capture_floodplain_species

class FloodPlainController extends Controller
{

    function index(){
        $latestDatas = $this->dataAtGlanceForALatestYear();
        $years = DB::table('capture_floodplain_total')->pluck('Year')->toArray();
        $years = array_unique($years);
        $xAxisValuesOfFloodPlainProduction = array();

        foreach ($years as $year){
            array_push($xAxisValuesOfFloodPlainProduction,$year);
        }
        $yAxisValuesOfFloodPlainProduction = [];
        foreach ($years as $year){
            $production = DB::table('capture_floodplain_total')
                ->where('Year',$year)
                ->sum('Catch (M Ton)');
            $production = round($production);
            array_push($yAxisValuesOfFloodPlainProduction,$production);
        }

        $districts = DB::table('capture_floodplain_total')->pluck('District')->unique();

        $species = DB::table('capture_floodPlain_species')->pluck('Species')->unique();
        $floodPlainBySpecies = $this->floodPlainBySpecies($species[0]);
        return view(
            'user.capture.floodPlain',
            [
                "latestDatas"=>$latestDatas,
                "xAxisValuesOfFloodPlainProduction"=>$xAxisValuesOfFloodPlainProduction,
                "yAxisValuesOfFloodPlainProduction"=>$yAxisValuesOfFloodPlainProduction,
                "xAxisValuesOfFloodPlainBySpecies"=>$floodPlainBySpecies["xAxisValue"],
                "yAxisValuesOfFloodPlainBySpecies"=>$floodPlainBySpecies["yAxisValue"],
                "districts"=>$districts,
                "species"=>$species
            ]
        );
    }

    //floodPlain By Location
    public function floodPlainByLocation($location){

        $years = DB::table('capture_floodplain_total')->pluck('Year')->toArray();
        $years = array_unique($years);
        $xAxisValuesOfFloodPlainProduction = array();
        foreach ($years as $year){
            array_push($xAxisValuesOfFloodPlainProduction,$year);
        }

        $yAxisValuesOfFloodPlainProduction = [];
        foreach ($years as $year){
            $production = DB::table('capture_floodplain_total')
                ->where('Year',$year)
                ->where('District',$location)
                ->sum('Catch (M Ton)');
            array_push($yAxisValuesOfFloodPlainProduction,$production);
        }


        return ([
            "xAxisValuesOfFloodPlainProduction"=>$xAxisValuesOfFloodPlainProduction,
            "yAxisValuesOfFloodPlainProduction"=>$yAxisValuesOfFloodPlainProduction
        ]);

    }

    //floodPlain By species
    public function floodPlainBySpecies($specie){
        $years = DB::table('capture_floodPlain_species')->pluck('Year')->toArray();
        $xAxisValue = array();
        $yAxisValue = array();
        $years = array_unique($years);

        foreach ($years as $year){
            array_push($xAxisValue,$year);
        }

        foreach ($xAxisValue as $year) {
            $speciesValue = DB::table('capture_floodPlain_species')
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
