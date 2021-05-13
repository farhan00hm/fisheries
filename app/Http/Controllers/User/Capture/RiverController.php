<?php

namespace App\Http\Controllers\User\Capture;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RiverController extends Controller
{

    public function index(){
        $latestDatas = $this->dataAtGlanceForALatestYear();
        $yearOfRiverLocationWise = DB::table('capture_river wise')->pluck('Year')->toArray();
        $xAxisValuesOfRiverProductionWise = array();
        $yAxisValuesOfRiverProductionWise = array();
        $yearOfRiverLocationWise = array_unique($yearOfRiverLocationWise);

        foreach ($yearOfRiverLocationWise as $value){
            array_push($xAxisValuesOfRiverProductionWise,$value);
        }

        $lowerMeghna = [];
        $upperMeghna = [];
        $lowerPadma = [];
        $upperPadma = [];
        $jamuna = [];
        $brahmaputra = [];

        foreach ($xAxisValuesOfRiverProductionWise as $year) {
            $sumOflowerMeghna = DB::table('capture_river wise')
                ->where('Year' ,$year)
                ->sum('Lower Meghna');
            $sumOfupperMeghna = DB::table('capture_river wise')
                ->where('Year' ,$year)
                ->sum('Upper Meghna');
            $sumOflowerPadma = DB::table('capture_river wise')
                ->where('Year' ,$year)
                ->sum('Lower Padma');
            $sumOfupperPadma = DB::table('capture_river wise')
                ->where('Year' ,$year)
                ->sum('Upper Padma');
            $sumOfJamuna = DB::table('capture_river wise')
                ->where('Year' ,$year)
                ->sum('Jamuna');
            $sumOfBrahmaputra = DB::table('capture_river wise')
                ->where('Year' ,$year)
                ->sum('Brahmaputra');

            array_push($lowerMeghna,$sumOflowerMeghna);
            array_push($upperMeghna,$sumOfupperMeghna);
            array_push($lowerPadma,$sumOflowerPadma);
            array_push($upperPadma,$sumOfupperPadma);
            array_push($jamuna,$sumOfJamuna);
            array_push($brahmaputra,$sumOfBrahmaputra);
        }


        $yAxisValuesOfRiverProductionWise['Lower Meghna'] = $lowerMeghna;
        $yAxisValuesOfRiverProductionWise['Upper Meghna'] = $upperMeghna;
        $yAxisValuesOfRiverProductionWise['Lower Padma'] = $lowerPadma;
        $yAxisValuesOfRiverProductionWise['Upper Padma'] = $upperPadma;
        $yAxisValuesOfRiverProductionWise['Jamuna'] = $jamuna;
        $yAxisValuesOfRiverProductionWise['Brahmaputra'] = $brahmaputra;


        $species = DB::table('capture_river_species')->pluck('Species')->unique();

        $riverBySpecies = $this->riverBySpecies($species[0]);
        $xAxisValuesOfRiverSpeciesWise = $riverBySpecies['xAxisValuesOfRiverSpeciesWise'];
        $yAxisValuesOfRiverSpeciesWise = $riverBySpecies['yAxisValuesOfRiverSpeciesWise'];


        return view(
            'user.capture.river',
            [
                "latestDatas"=>$latestDatas,
                "xAxisValuesOfRiverProductionWise"=>$xAxisValuesOfRiverProductionWise,
                "yAxisValuesOfRiverProductionWise"=>$yAxisValuesOfRiverProductionWise,
                "xAxisValuesOfRiverSpeciesWise"=>$xAxisValuesOfRiverSpeciesWise,
                "yAxisValuesOfRiverSpeciesWise"=>$yAxisValuesOfRiverSpeciesWise,
                "species"=>$species
            ]
        );

//        [
//            "xAxisValuesOfRiverProductionWise"=>$xAxisValuesOfRiverProductionWise,
//            "yAxisValuesOfRiverProductionWise"=>$yAxisValuesOfRiverProductionWise,
//            "districts"=>$districts,
//            "species"=>$species
//
//        ]
    }

    //TODO need to remove it, if it is no longer use
    public function riverByLocation($location){

        $yearOfRiverLocationWise = DB::table('capture_river wise')->pluck('Year')->toArray();
        $xAxisValuesOfRiverProductionWise = array();
        $yAxisValuesOfRiverProductionWise = array();
        $yearOfRiverLocationWise = array_unique($yearOfRiverLocationWise);

        foreach ($yearOfRiverLocationWise as $value){
            array_push($xAxisValuesOfRiverProductionWise,$value);
        }

        $lowerMeghna = [];
        $upperMeghna = [];
        $lowerPadma = [];
        $upperPadma = [];
        $jamuna = [];
        $brahmaputra = [];

        foreach ($xAxisValuesOfRiverProductionWise as $year) {
            $sumOflowerMeghna = DB::table('capture_river wise')
                ->where('Year' ,$year)
                ->where("District","=",$location)
                ->sum('Lower Meghna');
            $sumOfupperMeghna = DB::table('capture_river wise')
                ->where('Year' ,$year)
                ->where("District","=",$location)
                ->sum('Upper Meghna');
            $sumOflowerPadma = DB::table('capture_river wise')
                ->where('Year' ,$year)
                ->where("District","=",$location)
                ->sum('Lower Padma');
            $sumOfupperPadma = DB::table('capture_river wise')
                ->where('Year' ,$year)
                ->where("District","=",$location)
                ->sum('Upper Padma');
            $sumOfJamuna = DB::table('capture_river wise')
                ->where('Year' ,$year)
                ->where("District","=",$location)
                ->sum('Jamuna');
            $sumOfBrahmaputra = DB::table('capture_river wise')
                ->where('Year' ,$year)
                ->where("District","=",$location)
                ->sum('Brahmaputra');

            array_push($lowerMeghna,$sumOflowerMeghna);
            array_push($upperMeghna,$sumOfupperMeghna);
            array_push($lowerPadma,$sumOflowerPadma);
            array_push($upperPadma,$sumOfupperPadma);
            array_push($jamuna,$sumOfJamuna);
            array_push($brahmaputra,$sumOfBrahmaputra);
        }


        $yAxisValuesOfRiverProductionWise['Lower Meghna'] = $lowerMeghna;
        $yAxisValuesOfRiverProductionWise['Upper Meghna'] = $upperMeghna;
        $yAxisValuesOfRiverProductionWise['Lower Padma'] = $lowerPadma;
        $yAxisValuesOfRiverProductionWise['Upper Padma'] = $upperPadma;
        $yAxisValuesOfRiverProductionWise['Jamuna'] = $jamuna;
        $yAxisValuesOfRiverProductionWise['Brahmaputra'] = $brahmaputra;

        return ([
            "xAxisValuesOfRiverProductionWise"=>$xAxisValuesOfRiverProductionWise,
            "yAxisValuesOfRiverProductionWise"=>$yAxisValuesOfRiverProductionWise,

        ]);

    }

    public function riverBySpecies($specie){
        $yearOfCaptureSpeciesWise = DB::table('capture_river_species')->pluck('Year')->toArray();
        $xAxisValueOfRiverSpeciesWise = array();
        $yAxisValuesOfRiverSpeciesWise = array();
        $yearOfCaptureSpeciesWise = array_unique($yearOfCaptureSpeciesWise);

        foreach ($yearOfCaptureSpeciesWise as $value){
            array_push($xAxisValueOfRiverSpeciesWise,$value);
        }

        $lowerMeghna = [];
        $upperMeghna = [];
        $lowerPadma = [];
        $upperPadma = [];
        $jamuna = [];
        $brahmaputra = [];

        //        Lower Meghna	Upper Meghna	Lower Padma	Upper Padma	Jamuna	Brahmaputra

        foreach ($xAxisValueOfRiverSpeciesWise as $year) {
            $sumOflowerMeghna = DB::table('capture_river_species')
                ->where('Year' ,$year)
                ->where("Species","=",$specie)
                ->sum('Lower Meghna');
            $sumOfupperMeghna = DB::table('capture_river_species')
                ->where('Year' ,$year)
                ->where("Species","=",$specie)
                ->sum('Upper Meghna');
            $sumOflowerPadma = DB::table('capture_river_species')
                ->where('Year' ,$year)
                ->where("Species","=",$specie)
                ->sum('Lower Padma');
            $sumOfupperPadma = DB::table('capture_river_species')
                ->where('Year' ,$year)
                ->where("Species","=",$specie)
                ->sum('Upper Padma');
            $sumOfjamuna = DB::table('capture_river_species')
                ->where('Year' ,$year)
                ->where("Species","=",$specie)
                ->sum('Jamuna');

            $sumOfBrahmaputra = DB::table('capture_river_species')
                ->where('Year' ,$year)
                ->where("Species","=",$specie)
                ->sum('Brahmaputra');

            array_push($lowerMeghna,$sumOflowerMeghna);
            array_push($upperMeghna,$sumOfupperMeghna);
            array_push($lowerPadma,$sumOflowerPadma);
            array_push($upperPadma,$sumOfupperPadma);
            array_push($jamuna,$sumOfjamuna);
            array_push($brahmaputra,$sumOfBrahmaputra);
        }

        $yAxisValuesOfRiverSpeciesWise['Lower Meghna'] = $lowerMeghna;
        $yAxisValuesOfRiverSpeciesWise['Upper Meghna'] = $upperMeghna;
        $yAxisValuesOfRiverSpeciesWise['Lower Padma'] = $lowerPadma;
        $yAxisValuesOfRiverSpeciesWise['Upper Padma'] = $upperPadma;
        $yAxisValuesOfRiverSpeciesWise['Jamuna'] = $jamuna;
        $yAxisValuesOfRiverSpeciesWise['Brahmaputra'] = $brahmaputra;

        return ([
            "xAxisValuesOfRiverSpeciesWise"=>$xAxisValueOfRiverSpeciesWise,
            "yAxisValuesOfRiverSpeciesWise"=>$yAxisValuesOfRiverSpeciesWise,

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
