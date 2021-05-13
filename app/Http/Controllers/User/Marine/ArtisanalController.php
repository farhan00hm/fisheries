<?php

namespace App\Http\Controllers\User\Marine;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ArtisanalController extends Controller
{
    function index(){
        $latestDatas = $this->dataAtGlanceForALatestYear();
        $years = DB::table('capture_artisanal_production')->pluck('Year')->toArray();
        $years = array_unique($years);
        $xAxisValuesOfartisanalProduction = array();

        foreach ($years as $year){
            array_push($xAxisValuesOfartisanalProduction,$year);
        }
        $yAxisValuesOfartisanalProduction = [];
        foreach ($years as $year){
            $production = DB::table('capture_artisanal_production')
                ->where('Year',$year)
                ->sum('Total');
            $production = round($production);
            array_push($yAxisValuesOfartisanalProduction,$production);
        }

        $districts = DB::table('capture_artisanal_production')->pluck('District')->unique();

        $species = DB::table('capture_artisanal_species')->pluck('Species')->unique();
        $artisanalBySpecies = $this->artisanalBySpecies($species[0]);
        return view(
            'user.capture.artisanal',
            [
                "latestDatas"=>$latestDatas,
                "xAxisValuesOfartisanalProduction"=>$xAxisValuesOfartisanalProduction,
                "yAxisValuesOfartisanalProduction"=>$yAxisValuesOfartisanalProduction,
                "xAxisValuesOfartisanalBySpecies"=>$artisanalBySpecies["xAxisValue"],
                "yAxisValuesOfartisanalBySpecies"=>$artisanalBySpecies["yAxisValue"],
                "districts"=>$districts,
                "species"=>$species
            ]
        );
    }

    //artisanal By species
    public function artisanalBySpecies($specie){
        $years = DB::table('capture_artisanal_species')->pluck('Year')->toArray();
        $xAxisValue = array();
        $yAxisValue = array();
        $years = array_unique($years);

        foreach ($years as $year){
            array_push($xAxisValue,$year);
        }

        foreach ($xAxisValue as $year) {
            $speciesValue = DB::table('capture_artisanal_species')
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
        $artisanalFish = DB::table('capture location wise')->where('Year' ,$latestYear)->sum('artisanal');
        $kaptaiLakeFish = DB::table('capture location wise')->where('Year' ,$latestYear)->sum('Kaptai Lake');
        $floodPlainFish = DB::table('capture location wise')->where('Year' ,$latestYear)->sum('Flood Plain');

        $latestData['year'] = $latestYear;
        $latestData['River'] = $riverFish;
        $latestData['Sundarbans'] = $sundarbansFish;
        $latestData['artisanal'] = $artisanalFish;
        $latestData['Kaptai Lake'] = $kaptaiLakeFish;
        $latestData['Flood Plain'] = $floodPlainFish;

        return $latestData;

    }
}
