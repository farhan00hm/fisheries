<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Culture;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CultureController extends Controller
{
    public function index(){
        $latestDatas = $this->dataAtGlanceForALatestYear();
        $years = DB::table('culture_baor')->pluck('Year')->toArray();
        $years = array_unique($years);
        $xAxisValuesOfBaorProduction = array();
        foreach ($years as $year){
            array_push($xAxisValuesOfBaorProduction,$year);
        }
        $yAxisValuesOfBaorProduction = [];
        foreach ($years as $year){
            $production = DB::table('culture_baor')
                ->where('Year',$year)
                ->sum('Production (MT)');
            array_push($yAxisValuesOfBaorProduction,$production);
        }

        $districts = DB::table('culture_baor')->pluck('District')->unique();
        $species = DB::table('culture_baor_species')->pluck('Species')->unique();

        $baorBySpecies = $this->baorBySpecies($species[0]);


        return view('user.culture.baor',
            [
                "latestDatas"=>$latestDatas,
                "xAxisValuesOfBaorProduction"=>$xAxisValuesOfBaorProduction,
                "yAxisValuesOfBaorProduction"=>$yAxisValuesOfBaorProduction,
                "xAxisValuesOfBaorBySpecies"=>$baorBySpecies["xAxisValue"],
                "yAxisValuesOfBaorBySpecies"=>$baorBySpecies["yAxisValue"],
                "districts"=>$districts,
                "species"=>$species
                ]
        );
    }

    public function cultureByCategory(){
        dd($this->dataAtGlanceForALatestYear());
    }

    //Baor By district
    public function cultureByLocation($location){

        $years = DB::table('culture_baor')->pluck('Year')->toArray();
        $years = array_unique($years);
        $xAxisValuesOfBaorProduction = array();
        foreach ($years as $year){
            array_push($xAxisValuesOfBaorProduction,$year);
        }

        $yAxisValuesOfBaorProduction = [];
        foreach ($years as $year){
            $production = DB::table('culture_baor')
                ->where('Year',$year)
                ->where('District',$location)
                ->sum('Production (MT)');
            array_push($yAxisValuesOfBaorProduction,$production);
        }

        return ([
            "xAxisValuesOfBaorProduction"=>$xAxisValuesOfBaorProduction,
            "yAxisValuesOfBaorProduction"=>$yAxisValuesOfBaorProduction
        ]);

    }

    //Baor By species
    public function baorBySpecies($specie){
        $years = DB::table('culture_baor_species')->pluck('Year')->toArray();
        $xAxisValue = array();
        $yAxisValue = array();
        $years = array_unique($years);

        foreach ($years as $year){
            array_push($xAxisValue,$year);
        }



        foreach ($xAxisValue as $year) {
            $speciesValue = DB::table('culture_baor_species')
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
