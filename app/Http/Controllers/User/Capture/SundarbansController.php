<?php

namespace App\Http\Controllers\User\Capture;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SundarbansController extends Controller
{
    public function index(){
        $latestDatas = $this->dataAtGlanceForALatestYear();
        $yearOfRiverLocationWise = DB::table('capture_sundarbans (m ton)')->pluck('Year')->toArray();
        $xAxisValues = array();
        $yAxisValues = array();
        $yearOfRiverLocationWise = array_unique($yearOfRiverLocationWise);

        foreach ($yearOfRiverLocationWise as $value){
            array_push($xAxisValues,$value);
        }

//        Hilsa	Big Shrimp/ Prawn	Small Shrimp/Prawn	Other Fish	Total

        $hilsa = [];
        $bigShrimpPrawn = [];
        $smallShrimpPrawn = [];
        $otherFish = [];

        foreach ($xAxisValues as $year) {
            $sumOfHilsa = DB::table('capture_sundarbans (m ton)')
                ->where('Year' ,$year)
                ->sum('Hilsa');
            $sumOfBigShrimpPrawn = DB::table('capture_sundarbans (m ton)')
                ->where('Year' ,$year)
                ->sum('Big Shrimp/ Prawn');
            $sumOfSmallShrimpPrawn = DB::table('capture_sundarbans (m ton)')
                ->where('Year' ,$year)
                ->sum('Small Shrimp/Prawn');
            $sumOfOtherFish = DB::table('capture_sundarbans (m ton)')
                ->where('Year' ,$year)
                ->sum('Other Fish');

            array_push($hilsa,$sumOfHilsa);
            array_push($bigShrimpPrawn,$sumOfBigShrimpPrawn);
            array_push($smallShrimpPrawn,$sumOfSmallShrimpPrawn);
            array_push($otherFish,$sumOfOtherFish);
        }


        $yAxisValues['Hilsa'] = $hilsa;
        $yAxisValues['Big Shrimp/ Prawn'] = $bigShrimpPrawn;
        $yAxisValues['Small Shrimp/ Prawn'] = $smallShrimpPrawn;
        $yAxisValues['Other Fish'] = $otherFish;



        return view(
            'user.capture.sundarbans',
            [
                "latestDatas"=>$latestDatas,
                "xAxisValues"=>$xAxisValues,
                "yAxisValues"=>$yAxisValues,
            ]
        );

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
