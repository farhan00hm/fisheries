<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SeasonalController extends Controller
{
    function index(){
        $latestDatas = $this->dataAtGlanceForALatestYear();
        $years = DB::table('culture_seasonal_production (m ton)')->pluck('Year')->toArray();
        $years = array_unique($years);
        $xAxisValuesOfSeasonalProduction = array();

        foreach ($years as $year){
            array_push($xAxisValuesOfSeasonalProduction,$year);
        }
        $yAxisValuesOfSeasonalProduction = [];
        foreach ($years as $year){
            $production = DB::table('culture_seasonal_production (m ton)')
                ->where('Year',$year)
                ->sum('Total');
            $production = round($production);
            array_push($yAxisValuesOfSeasonalProduction,$production);
        }

        $districts = DB::table('culture_seasonal_production (m ton)')->pluck('District')->unique();

        $species = DB::table('culture_seasonal_species')->pluck('Species')->unique();
        $seasonalBySpecies = $this->seasonalBySpecies($species[0]);

        return view(
            'user.culture.seasonal',
            [
                "latestDatas"=>$latestDatas,
                "xAxisValuesOfSeasonalProduction"=>$xAxisValuesOfSeasonalProduction,
                "yAxisValuesOfSeasonalProduction"=>$yAxisValuesOfSeasonalProduction,
                "xAxisValuesOfSeasonalBySpecies"=>$seasonalBySpecies["xAxisValue"],
                "yAxisValuesOfSeasonalBySpecies"=>$seasonalBySpecies["yAxisValue"],
                "districts"=>$districts,
                "species"=>$species
            ]
        );
    }

    //Seasonal By Location
    public function seasonalByLocation($location){

        $years = DB::table('culture_seasonal_production (m ton)')->pluck('Year')->toArray();
        $years = array_unique($years);
        $xAxisValuesOfSeasonalProduction = array();
        foreach ($years as $year){
            array_push($xAxisValuesOfSeasonalProduction,$year);
        }

        $yAxisValuesOfSeasonalProduction = [];
        foreach ($years as $year){
            $production = DB::table('culture_seasonal_production (m ton)')
                ->where('Year',$year)
                ->where('District',$location)
                ->sum('Total');
            array_push($yAxisValuesOfSeasonalProduction,$production);
        }


        return ([
            "xAxisValuesOfSeasonalProduction"=>$xAxisValuesOfSeasonalProduction,
            "yAxisValuesOfSeasonalProduction"=>$yAxisValuesOfSeasonalProduction
        ]);

    }

    //Seasonal By species
    public function seasonalBySpecies($specie){
        $years = DB::table('culture_seasonal_species')->pluck('Year')->toArray();
        $xAxisValue = array();
        $yAxisValue = array();
        $years = array_unique($years);

        foreach ($years as $year){
            array_push($xAxisValue,$year);
        }

        foreach ($xAxisValue as $year) {
            $speciesValue = DB::table('culture_seasonal_species')
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
        $latestYear = DB::table("culture_baor")->first('Year');
        $latestYear = $latestYear->Year;

        $baor=DB::table("culture_baor")->where('Year',$latestYear)->sum("Production (MT)");
        $cage=DB::table("culture_cage")->where('Year',$latestYear)->sum("Production (MT)");
        $pen=DB::table("culture_pen")->where('Year',$latestYear)->sum("Production (MT)");
        $pond=DB::table("culture_pond_production")->where('Year',$latestYear)->sum("Total");
        $seasonal=DB::table("culture_seasonal_production (m ton)")->where('Year',$latestYear)->sum("Total");
        $shrimp=DB::table("culture_shrimp-prawn_production (m ton)")->where('Year',$latestYear)->sum("Total");

        $latestData['year']=$latestYear;
        $latestData['Baor']=$baor;
        $latestData['Cage']=$cage;
        $latestData['Pen']=$pen;
        $latestData['Pond']=$pond;
        $latestData['Seasonal']=$seasonal;
        $latestData['Shrimp-Prawn']=$shrimp;

        return $latestData;
    }
}
