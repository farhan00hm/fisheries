<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CageController extends Controller
{
    function index(){
        $latestDatas = $this->dataAtGlanceForALatestYear();
        $years = DB::table('culture_cage')->pluck('Year')->toArray();
        $years = array_unique($years);
        $xAxisValuesOfCageProduction = array();

        foreach ($years as $year){
            array_push($xAxisValuesOfCageProduction,$year);
        }
        $yAxisValuesOfCageProduction = [];
        foreach ($years as $year){
            $production = DB::table('culture_cage')
                ->where('Year',$year)
                ->sum('Production (MT)');
            $production = round($production);
            array_push($yAxisValuesOfCageProduction,$production);
        }


        $districts = DB::table('culture_cage')->pluck('District')->unique();


        return view(
            'user.culture.cage',
            [
                "latestDatas"=>$latestDatas,
                "xAxisValuesOfCageProduction"=>$xAxisValuesOfCageProduction,
                "yAxisValuesOfCageProduction"=>$yAxisValuesOfCageProduction,
                "districts"=>$districts,
            ]
        );
    }

    public function cageByLocation($location){

        $years = DB::table('culture_cage')->pluck('Year')->toArray();
        $years = array_unique($years);
        $xAxisValuesOfCageProduction = array();
        foreach ($years as $year){
            array_push($xAxisValuesOfCageProduction,$year);
        }

        $yAxisValuesOfCageProduction = [];
        foreach ($years as $year){
            $production = DB::table('culture_cage')
                ->where('Year',$year)
                ->where('District',$location)
                ->sum('Production (MT)');
            array_push($yAxisValuesOfCageProduction,$production);
        }

        return ([
            "xAxisValuesOfCageProduction"=>$xAxisValuesOfCageProduction,
            "yAxisValuesOfCageProduction"=>$yAxisValuesOfCageProduction
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
