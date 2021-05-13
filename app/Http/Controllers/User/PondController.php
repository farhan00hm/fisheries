<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PondController extends Controller
{
    function index(){
        $latestDatas = $this->dataAtGlanceForALatestYear();
        $years = DB::table('culture_pond_production')->pluck('Year')->toArray();
        $years = array_unique($years);
        $xAxisValuesOfPondProduction = array();

        foreach ($years as $year){
            array_push($xAxisValuesOfPondProduction,$year);
        }
        $yAxisValuesOfPondProduction = [];
        foreach ($years as $year){
            $production = DB::table('culture_pond_production')
                ->where('Year',$year)
                ->sum('Total');
            $production = round($production);
            array_push($yAxisValuesOfPondProduction,$production);
        }

        $districts = DB::table('culture_pond_production')->pluck('District')->unique();

        $species = DB::table('culture_pond_species')->pluck('Species')->unique();
        $pondBySpecies = $this->pondBySpecies($species[0]);

        return view(
            'user.culture.pond',
            [
                "latestDatas"=>$latestDatas,
                "xAxisValuesOfPondProduction"=>$xAxisValuesOfPondProduction,
                "yAxisValuesOfPondProduction"=>$yAxisValuesOfPondProduction,
                "xAxisValuesOfPondBySpecies"=>$pondBySpecies["xAxisValue"],
                "yAxisValuesOfPondBySpecies"=>$pondBySpecies["yAxisValue"],
                "districts"=>$districts,
                "species"=>$species
            ]
        );
    }

    //Pond By Location
    public function pondByLocation($location){

        $years = DB::table('culture_pond_production')->pluck('Year')->toArray();
        $years = array_unique($years);
        $xAxisValuesOfPondProduction = array();
        foreach ($years as $year){
            array_push($xAxisValuesOfPondProduction,$year);
        }

        $yAxisValuesOfPondProduction = [];
        foreach ($years as $year){
            $production = DB::table('culture_pond_production')
                ->where('Year',$year)
                ->where('District',$location)
                ->sum('Total');
            array_push($yAxisValuesOfPondProduction,$production);
        }


        return ([
            "xAxisValuesOfPondProduction"=>$xAxisValuesOfPondProduction,
            "yAxisValuesOfPondProduction"=>$yAxisValuesOfPondProduction
        ]);

    }

    //Pond By species
    public function pondBySpecies($specie){
        $years = DB::table('culture_pond_species')->pluck('Year')->toArray();
        $xAxisValue = array();
        $yAxisValue = array();
        $years = array_unique($years);

        foreach ($years as $year){
            array_push($xAxisValue,$year);
        }

        foreach ($xAxisValue as $year) {
            $speciesValue = DB::table('culture_pond_species')
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
