<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    public function home(){
        //Data for 1st graph of first row
        $valuesOfPieChart = DB::table('total production at a glance')->first();

        //Data for 2nd graph of first row
        $totalProduction =  DB::table('total production at a glance')->pluck('Year');
        $capture = DB::table('total production at a glance')->pluck('capture');
        $culture = DB::table('total production at a glance')->pluck('culture');
        $marine = DB::table('total production at a glance')->pluck('marine');
        $hilsa = DB::table('total production at a glance')->pluck('hilsa');
        $shrimpPrawn = DB::table('total production at a glance')->pluck('Shrimp/Prawn');

        $yAxisValues = ['Capture'=>$capture,'Culture'=>$culture,"Marine"=>$marine,"Hilsa"=>$hilsa,"Shrimp/Prawn"=>$shrimpPrawn];




        // Data for 1st graph of 2nd row

        $captureLocationWise = DB::table('capture location wise')->get();
        $yearOfCaptureLocationWise = DB::table('capture location wise')->pluck('Year')->toArray();
        $locations = DB::table('capture location wise')->pluck('District')->toArray();
        $locations = array_unique($locations);
        $xAxisValueOfCaptureLocationWise = array();
        $yAxisValuesOfCaptureLocationWise = array();
        $yearOfCaptureLocationWise = array_unique($yearOfCaptureLocationWise);

        foreach ($yearOfCaptureLocationWise as $value){
            array_push($xAxisValueOfCaptureLocationWise,$value);
        }



        $riverFish = [];
        $sundarbansFish = [];
        $beelFish = [];
        $kaptaiLakeFish = [];
        $floodPlainFish = [];

        foreach ($xAxisValueOfCaptureLocationWise as $year) {
            $sumOfRiverFish = DB::table('capture location wise')->where('Year' ,$year)->sum('River');
            $sumOfSundarbansFish = DB::table('capture location wise')->where('Year' ,$year)->sum('Sundarbans');
            $sumOfBeelFish = DB::table('capture location wise')->where('Year' ,$year)->sum('Beel');
            $sumOfKaptaiLakeFish = DB::table('capture location wise')->where('Year' ,$year)->sum('Kaptai Lake');
            $sumOfFloodPlainFish = DB::table('capture location wise')->where('Year' ,$year)->sum('Flood Plain');

            array_push($riverFish,$sumOfRiverFish);
            array_push($sundarbansFish,$sumOfSundarbansFish);
            array_push($beelFish,$sumOfBeelFish);
            array_push($kaptaiLakeFish,$sumOfKaptaiLakeFish);
            array_push($floodPlainFish,$sumOfFloodPlainFish);
        }


        $yAxisValuesOfCaptureLocationWise['River'] = $riverFish;
        $yAxisValuesOfCaptureLocationWise['Sundarbans'] = $sundarbansFish;
        $yAxisValuesOfCaptureLocationWise['Beel'] = $beelFish;
        $yAxisValuesOfCaptureLocationWise['Kaptai Lake'] = $kaptaiLakeFish;
        $yAxisValuesOfCaptureLocationWise['Flood Plain'] = $floodPlainFish;


        // Data for 2nd graph of 2nd row
        $yearOfCaptureSpeciesWise = DB::table('Capture _ Specieswise')->pluck('Year')->toArray();
        $Species = DB::table('Capture _ Specieswise')->pluck('Species')->toArray();
        $species = array_unique($Species);
        $xAxisValueOfCaptureSpeciesWise = array();
        $yAxisValuesOfCaptureSpeciesWise = array();
        $yearOfCaptureSpeciesWise = array_unique($yearOfCaptureSpeciesWise);

        foreach ($yearOfCaptureSpeciesWise as $value){
            array_push($xAxisValueOfCaptureSpeciesWise,$value);
        }
        $riverFishOfSpeciesWise = [];
        $sundarbansFishOfSpeciesWise = [];
        $beelFishOfSpeciesWise = [];
        $kaptaiLakeFishOfSpeciesWise = [];
        $floodPlainFishOfSpiicesWise = [];
//        dd($xAxisValueOfCaptureSpeciesWise);

        $allSpeicesWise = DB::table('Capture _ Specieswise')->get();
        foreach ($xAxisValueOfCaptureSpeciesWise as $year) {
            $sumOfRiverFishss = DB::table('Capture _ Specieswise')->where('Year' ,$year)->sum('River');
            $sumOfSundarbansFish = DB::table('Capture _ Specieswise')->where('Year' ,$year)->sum('Sundarbans');
            $sumOfBeelFish = DB::table('Capture _ Specieswise')->where('Year' ,$year)->sum('Beel');
            $sumOfKaptaiLakeFish = DB::table('Capture _ Specieswise')->where('Year' ,$year)->sum('Kaptai Lake');
            $sumOfFloodPlainFish = DB::table('Capture _ Specieswise')->where('Year' ,$year)->sum('Flood Plain');

            array_push($riverFishOfSpeciesWise,$sumOfRiverFishss);
            array_push($sundarbansFishOfSpeciesWise,$sumOfSundarbansFish);
            array_push($beelFishOfSpeciesWise,$sumOfBeelFish);
            array_push($kaptaiLakeFishOfSpeciesWise,$sumOfKaptaiLakeFish);
            array_push($floodPlainFishOfSpiicesWise,$sumOfFloodPlainFish);
        }


        $yAxisValuesOfCaptureSpeciesWise['River'] = $riverFishOfSpeciesWise;
        $yAxisValuesOfCaptureSpeciesWise['Sundarbans'] = $sundarbansFishOfSpeciesWise;
        $yAxisValuesOfCaptureSpeciesWise['Beel'] = $beelFishOfSpeciesWise;
        $yAxisValuesOfCaptureSpeciesWise['Kaptai Lake'] = $kaptaiLakeFishOfSpeciesWise;
        $yAxisValuesOfCaptureSpeciesWise['Flood Plain'] = $floodPlainFishOfSpiicesWise;





        return view("user.home",[
            "valuesOfPieChart"=>$valuesOfPieChart,
            "yAxisValues"=>$yAxisValues,
            "totalProduction"=>$totalProduction,
            "xAxisValueOfCaptureLocationWise"=>$xAxisValueOfCaptureLocationWise,
            "yAxisValuesOfCaptureLocationWise"=>$yAxisValuesOfCaptureLocationWise,
            "locations"=>$locations,
            "xAxisValueOfCaptureSpeciesWise"=>$xAxisValueOfCaptureSpeciesWise,
            "yAxisValuesOfCaptureSpeciesWise"=>$yAxisValuesOfCaptureSpeciesWise,
            "species"=>$species,

        ]);
    }


    public function captureByLocation($location){

        $yearOfCaptureLocationWise = DB::table('capture location wise')->pluck('Year')->toArray();
        $xAxisValueOfCaptureLocationWise = array();
        $yAxisValuesOfCaptureLocationWise = array();
        $yearOfCaptureLocationWise = array_unique($yearOfCaptureLocationWise);

        foreach ($yearOfCaptureLocationWise as $value){
            array_push($xAxisValueOfCaptureLocationWise,$value);
        }



        $riverFish = [];
        $sundarbansFish = [];
        $beelFish = [];
        $kaptaiLakeFish = [];
        $floodPlainFish = [];

        foreach ($xAxisValueOfCaptureLocationWise as $year) {
            $sumOfRiverFish = DB::table('capture location wise')
                ->where('Year' ,$year)
                ->where("District","=",$location)
                ->sum('River');
            $sumOfSundarbansFish = DB::table('capture location wise')
                ->where('Year' ,$year)
                ->where("District","=",$location)
                ->sum('Sundarbans');
            $sumOfBeelFish = DB::table('capture location wise')
                ->where('Year' ,$year)
                ->where("District","=",$location)
                ->sum('Beel');
            $sumOfKaptaiLakeFish = DB::table('capture location wise')
                ->where('Year' ,$year)
                ->where("District","=",$location)
                ->sum('Kaptai Lake');
            $sumOfFloodPlainFish = DB::table('capture location wise')
                ->where('Year' ,$year)
                ->where("District","=",$location)
                ->sum('Flood Plain');

            array_push($riverFish,$sumOfRiverFish);
            array_push($sundarbansFish,$sumOfSundarbansFish);
            array_push($beelFish,$sumOfBeelFish);
            array_push($kaptaiLakeFish,$sumOfKaptaiLakeFish);
            array_push($floodPlainFish,$sumOfFloodPlainFish);
        }


        $yAxisValuesOfCaptureLocationWise['River'] = $riverFish;
        $yAxisValuesOfCaptureLocationWise['Sundarbans'] = $sundarbansFish;
        $yAxisValuesOfCaptureLocationWise['Beel'] = $beelFish;
        $yAxisValuesOfCaptureLocationWise['Kaptai Lake'] = $kaptaiLakeFish;
        $yAxisValuesOfCaptureLocationWise['Flood Plain'] = $floodPlainFish;

        return ([
            "xAxisValueOfCaptureLocationWise"=>$xAxisValueOfCaptureLocationWise,
            "yAxisValuesOfCaptureLocationWise"=>$yAxisValuesOfCaptureLocationWise,

        ]);

    }

    public function captureBySpecies($specie){
        $yearOfCaptureSpeciesWise = DB::table('Capture _ Specieswise')->pluck('Year')->toArray();
        $xAxisValueOfCaptureSpeciesWise = array();
        $yAxisValuesOfCaptureSpeciesWise = array();
        $yearOfCaptureSpeciesWise = array_unique($yearOfCaptureSpeciesWise);

        foreach ($yearOfCaptureSpeciesWise as $value){
            array_push($xAxisValueOfCaptureSpeciesWise,$value);
        }

        $riverFish = [];
        $sundarbansFish = [];
        $beelFish = [];
        $kaptaiLakeFish = [];
        $floodPlainFish = [];

        foreach ($xAxisValueOfCaptureSpeciesWise as $year) {
            $sumOfRiverFish = DB::table('Capture _ Specieswise')
                ->where('Year' ,$year)
                ->where("Species","=",$specie)
                ->sum('River');
            $sumOfSundarbansFish = DB::table('Capture _ Specieswise')
                ->where('Year' ,$year)
                ->where("Species","=",$specie)
                ->sum('Sundarbans');
            $sumOfBeelFish = DB::table('Capture _ Specieswise')
                ->where('Year' ,$year)
                ->where("Species","=",$specie)
                ->sum('Beel');
            $sumOfKaptaiLakeFish = DB::table('Capture _ Specieswise')
                ->where('Year' ,$year)
                ->where("Species","=",$specie)
                ->sum('Kaptai Lake');
            $sumOfFloodPlainFish = DB::table('Capture _ Specieswise')
                ->where('Year' ,$year)
                ->where("Species","=",$specie)
                ->sum('Flood Plain');

            array_push($riverFish,$sumOfRiverFish);
            array_push($sundarbansFish,$sumOfSundarbansFish);
            array_push($beelFish,$sumOfBeelFish);
            array_push($kaptaiLakeFish,$sumOfKaptaiLakeFish);
            array_push($floodPlainFish,$sumOfFloodPlainFish);
        }

        $yAxisValuesOfCaptureSpeciesWise['River'] = $riverFish;
        $yAxisValuesOfCaptureSpeciesWise['Sundarbans'] = $sundarbansFish;
        $yAxisValuesOfCaptureSpeciesWise['Beel'] = $beelFish;
        $yAxisValuesOfCaptureSpeciesWise['Kaptai Lake'] = $kaptaiLakeFish;
        $yAxisValuesOfCaptureSpeciesWise['Flood Plain'] = $floodPlainFish;


        return ([
            "xAxisValueOfCaptureSpeciesWise"=>$xAxisValueOfCaptureSpeciesWise,
            "yAxisValuesOfCaptureSpeciesWise"=>$yAxisValuesOfCaptureSpeciesWise,

        ]);
    }

    public function atAGlanceByCategoryAndYear($category){
        $atAGlanceByCategoryAndYear = array();
        //TODO need to fixed with
        if($category == 'Capture'){
            $years = DB::table('capture location wise')->pluck('Year');
            $latestYear = $years[0];
            $riverFish = DB::table('capture location wise')->where('Year' ,$latestYear)->sum('River');
            $sundarbansFish = DB::table('capture location wise')->where('Year' ,$latestYear)->sum('Sundarbans');
            $beelFish = DB::table('capture location wise')->where('Year' ,$latestYear)->sum('Beel');
            $kaptaiLakeFish = DB::table('capture location wise')->where('Year' ,$latestYear)->sum('Kaptai Lake');
            $floodPlainFish = DB::table('capture location wise')->where('Year' ,$latestYear)->sum('Flood Plain');

            $atAGlanceByCategoryAndYear['River'] = $riverFish;
            $atAGlanceByCategoryAndYear['Sundarbans'] = $sundarbansFish;
            $atAGlanceByCategoryAndYear['Beel'] = $beelFish;
            $atAGlanceByCategoryAndYear['Kaptai Lake'] = $kaptaiLakeFish;
            $atAGlanceByCategoryAndYear['Flood Plain'] = $floodPlainFish;

            return view('user.annual-category-atAGlance',["year"=>$latestYear,"atAGlanceByCategoryAndYear"=>$atAGlanceByCategoryAndYear]);
        }

        if($category == 'Culture'){
            $latestData = array();
            $latestYear = DB::table("culture_baor")->first('Year');
            $latestYear = $latestYear->Year;

            $baor=DB::table("culture_baor")->where('Year',$latestYear)->sum("Production (MT)");
            $cage=DB::table("culture_cage")->where('Year',$latestYear)->sum("Production (MT)");
            $pen=DB::table("culture_pen")->where('Year',$latestYear)->sum("Production (MT)");
            $pond=DB::table("culture_pond_production")->where('Year',$latestYear)->sum("Total");
            $seasonal=DB::table("culture_seasonal_production (m ton)")->where('Year',$latestYear)->sum("Total");
            $shrimp=DB::table("culture_shrimp-prawn_production (m ton)")->where('Year',$latestYear)->sum("Total");

//            $latestData['year']=$latestYear;
            $latestData['Baor']=$baor;
            $latestData['Cage']=$cage;
            $latestData['Pen']=$pen;
            $latestData['Pond']=$pond;
            $latestData['Seasonal']=$seasonal;
            $latestData['Shrimp-Prawn']=$shrimp;

            return view('user.annual-category-atAGlance',["year"=>$latestYear,"atAGlanceByCategoryAndYear"=>$latestData]);
        }

    }
}
