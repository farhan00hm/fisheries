<?php

namespace App\Http\Controllers\User\Hilsa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HilsaController extends Controller
{
    public function index(){
        //        $latestDatas = $this->dataAtGlanceForALatestYear();

        $years = DB::table('hilsa_district (m ton)')->pluck('Year');
        $locations = DB::table('hilsa_district (m ton)')->pluck('District')->unique();
        $rivers = DB::table('hilsa_river (m ton)')->pluck('River')->unique();
        $locationsWise = $this->hilsaByLocation($locations[0]);
        $riverWise = $this->hilsaByRiver($rivers[0]);

        $latestYear=$years[0];
        $latestDatas = array();
        return view(
            'user.hilsa.hilsa',
            [
                "latestDatas"=>$latestDatas,
                "latestYear"=>$latestYear,
                "xAxisValuesOfHilsaLocationWise"=>$locationsWise['xAxisValuesOfHilsaLocationWise'],
                "yAxisValuesOfHilsaLocationWise"=>$locationsWise['yAxisValuesOfHilsaLocationWise'],
                "xAxisValuesOfHilsaRiverWise"=>$riverWise['xAxisValuesOfHilsaRiverWise'],
                "yAxisValuesOfHilsaRiverWise"=>$riverWise['yAxisValuesOfHilsaRiverWise'],
                "locations"=>$locations,
                "rivers"=>$rivers
            ]
        );

//        [
//            "xAxisValuesOfHilsaLocationWise"=>$xAxisValuesOfHilsaLocationWise,
//            "yAxisValuesOfHilsaLocationWise"=>$yAxisValuesOfHilsaLocationWise,
//            "districts"=>$districts,
//            "species"=>$species
//
//        ]
    }

    public function hilsaByLocation($location){

        $yearOfRiverLocationWise = DB::table('hilsa_district (m ton)')->pluck('Year')->toArray();
        $xAxisValuesOfHilsaLocationWise = array();
        $yAxisValuesOfHilsaLocationWise = array();
        $yearOfRiverLocationWise = array_unique($yearOfRiverLocationWise);

        foreach ($yearOfRiverLocationWise as $value){
            array_push($xAxisValuesOfHilsaLocationWise,$value);
        }

        $inLand = [];
        $marine = [];


        foreach ($xAxisValuesOfHilsaLocationWise as $year) {
            $sumOfInLand = DB::table('hilsa_district (m ton)')
                ->where('Year' ,$year)
                ->where("District","=",$location)
                ->sum('Inland');
            $sumOfMarine = DB::table('hilsa_district (m ton)')
                ->where('Year' ,$year)
                ->where("District","=",$location)
                ->sum('Marine');


            array_push($inLand,$sumOfInLand);
            array_push($marine,$sumOfMarine);

        }


        $yAxisValuesOfHilsaLocationWise['Inland'] = $inLand;
        $yAxisValuesOfHilsaLocationWise['Marine'] = $marine;


        return ([
            "xAxisValuesOfHilsaLocationWise"=>$xAxisValuesOfHilsaLocationWise,
            "yAxisValuesOfHilsaLocationWise"=>$yAxisValuesOfHilsaLocationWise,

        ]);

    }

    public function hilsaByRiver($river){
        $yearOfCaptureSpeciesWise = DB::table('hilsa_river (m ton)')->pluck('Year')->toArray();
        $xAxisValueOfHilsaRiverWise = array();
        $yAxisValuesOfHilsaRiverWise = array();
        $yearOfCaptureSpeciesWise = array_unique($yearOfCaptureSpeciesWise);

        foreach ($yearOfCaptureSpeciesWise as $value){
            array_push($xAxisValueOfHilsaRiverWise,$value);
        }

        $riverFish = [];

        foreach ($xAxisValueOfHilsaRiverWise as $year) {
            $sumOfRiverFish = DB::table('hilsa_river (m ton)')
                ->where('Year' ,$year)
                ->where("River","=",$river)
                ->sum('Catch (M Ton)');


            array_push($riverFish,$sumOfRiverFish);

        }
        $yAxisValuesOfHilsaRiverWise[$river] = $riverFish;


        return ([
            "xAxisValuesOfHilsaRiverWise"=>$xAxisValueOfHilsaRiverWise,
            "yAxisValuesOfHilsaRiverWise"=>$yAxisValuesOfHilsaRiverWise,

        ]);
    }
}
