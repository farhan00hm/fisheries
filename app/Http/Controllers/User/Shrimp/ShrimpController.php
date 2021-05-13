<?php

namespace App\Http\Controllers\User\Shrimp;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ShrimpController extends Controller
{
    public function index(){
//        $latestDatas = $this->dataAtGlanceForALatestYear();
        $shrimpTotalYear = DB::table('shrimp_total')->pluck('Year');
        $shrimpTotal = DB::table('shrimp_total')->pluck('Total');
        $shrimpTotalValue = array();
        $shrimpTotalValue['Value']=$shrimpTotal;


        $sectors = DB::table('shrimp_sectorwise')->pluck('Sector');
        $species = DB::table('shrimp_specieswise')->pluck('Species')->unique();



        $shrimpBySector = $this->shrimpBySector($sectors[0]);
        $shrimpBySpecies = $this->shrimpBySpecies($species[0]);
//        dd($shrimpBySpecies);
//        dd($shrimpBySector,$shrimpBySpecies);
//        $xAxisValuesOfRiverSpeciesWise = $riverBySpecies['xAxisValuesOfRiverSpeciesWise'];
//        $yAxisValueOfShrimpSpeciesWise = $riverBySpecies['yAxisValueOfShrimpSpeciesWise'];


//        dd($shrimpBySpecies);
        $latestYear=2020;
        return view(
            'user.shrimp.shrimp',
            [
                "latestDatas"=>[],
                " latestYear"=>$latestYear,
                "xAxisValuesOfshrimpProductionWise"=>$shrimpTotalYear,
                "yAxisValuesOfshrimpProductionWise"=>$shrimpTotalValue,
                "xAxisValuesOfShrimpSectorWise"=>$shrimpBySector['xAxisValuesOfShrimpSectorWise'],
                "yAxisValuesOfShrimpSectorWise"=>$shrimpBySector['yAxisValuesOfShrimpSectorWise'],
                "xAxisValuesOfShrimpSpeciesWise"=>$shrimpBySpecies['xAxisValuesOfShrimpSpeciesWise'],
                "yAxisValuesOfShrimpSpeciesWise"=>$shrimpBySpecies['yAxisValuesOfShrimpSpeciesWise'],
                "sectors"=>$sectors,
                "species"=>$species
            ]
        );

//        [
//            "xAxisValuesOfShrimpSectorWise"=>$xAxisValuesOfShrimpSectorWise,
//            "yAxisValuesOfShrimpSectorWise"=>$yAxisValuesOfShrimpSectorWise,
//            "Sectors"=>$Sectors,
//            "species"=>$species
//
//        ]
    }

    public function shrimpBySector($sector){

        $yearOfRiversectorWise = DB::table('shrimp_sectorwise')->pluck('Year')->toArray();
        $xAxisValuesOfShrimpSectorWise = array();
        $yAxisValuesOfShrimpSectorWise = array();
        $yearOfRiversectorWise = array_unique($yearOfRiversectorWise);

        foreach ($yearOfRiversectorWise as $value){
            array_push($xAxisValuesOfShrimpSectorWise,$value);
        }

        $galda = [];
        $bagda = [];
        $harina = [];
        $chaka = [];
        $otherShrimpPrawn = [];


        foreach ($xAxisValuesOfShrimpSectorWise as $year) {
            $sumOfgalda = DB::table('shrimp_sectorwise')
                ->where('Year' ,$year)
                ->where("Sector","=",$sector)
                ->sum('Galda');
            $sumOfbagda = DB::table('shrimp_sectorwise')
                ->where('Year' ,$year)
                ->where("Sector","=",$sector)
                ->sum('Bagda');
            $sumOfharina = DB::table('shrimp_sectorwise')
                ->where('Year' ,$year)
                ->where("Sector","=",$sector)
                ->sum('Harina');
            $sumOfchaka = DB::table('shrimp_sectorwise')
                ->where('Year' ,$year)
                ->where("Sector","=",$sector)
                ->sum('Chaka');
            $sumOfotherShrimpPrawn = DB::table('shrimp_sectorwise')
                ->where('Year' ,$year)
                ->where("Sector","=",$sector)
                ->sum('Other Shrimp/Prawn');

            array_push($galda,$sumOfgalda);
            array_push($bagda,$sumOfbagda);
            array_push($harina,$sumOfharina);
            array_push($chaka,$sumOfchaka);
            array_push($otherShrimpPrawn,$sumOfotherShrimpPrawn);

        }


        //Galda	Bagda	Harina	Chaka	Other Shrimp-Prawn
        $yAxisValuesOfShrimpSectorWise['Galda'] = $galda;
        $yAxisValuesOfShrimpSectorWise['Bagda'] = $bagda;
        $yAxisValuesOfShrimpSectorWise['Harina'] = $harina;
        $yAxisValuesOfShrimpSectorWise['Chaka'] = $chaka;
        $yAxisValuesOfShrimpSectorWise['Other Shrimp/Prawn'] = $otherShrimpPrawn;

        return ([
            "xAxisValuesOfShrimpSectorWise"=>$xAxisValuesOfShrimpSectorWise,
            "yAxisValuesOfShrimpSectorWise"=>$yAxisValuesOfShrimpSectorWise,

        ]);

    }

    public function shrimpBySpecies($specie){
        $yearOfShrimpSpeciesWise = DB::table('shrimp_specieswise')->pluck('Year')->toArray();
        $xAxisValueOfShrimpSpeciesWise = array();
        $yAxisValueOfShrimpSpeciesWise = array();
        $yearOfShrimpSpeciesWise = array_unique($yearOfShrimpSpeciesWise);

        foreach ($yearOfShrimpSpeciesWise as $value){
            array_push($xAxisValueOfShrimpSpeciesWise,$value);
        }

        $river = [];
        $sundarbans = [];
        $beel = [];
        $kaptaiLake = [];
        $floodPlain = [];
        $pond = [];
        $seasonalCulturedWaterBody = [];
        $baor = [];
        $shrimpPrawnFarm = [];
        $marineIndustrial = [];
        $marineArtisanal = [];


        foreach ($xAxisValueOfShrimpSpeciesWise as $year) {
            $sumOfRiver = DB::table('shrimp_specieswise')
                ->where('Year' ,$year)
                ->where("Species","=",$specie)
                ->sum('River');
            $sumOfSundarbans = DB::table('shrimp_specieswise')
                ->where('Year' ,$year)
                ->where("Species","=",$specie)
                ->sum('Sundarbans');
            $sumOfBeel = DB::table('shrimp_specieswise')
                ->where('Year' ,$year)
                ->where("Species","=",$specie)
                ->sum('Beel');
            $sumOfKaptaiLake = DB::table('shrimp_specieswise')
                ->where('Year' ,$year)
                ->where("Species","=",$specie)
                ->sum('Kaptai Lake');
            $sumOfFloodPlain = DB::table('shrimp_specieswise')
                ->where('Year' ,$year)
                ->where("Species","=",$specie)
                ->sum('Floodplain');


            $sumOfPond = DB::table('shrimp_specieswise')
                ->where('Year' ,$year)
                ->where("Species","=",$specie)
                ->sum('Pond');

            $sumOfSeasonalCulturedWaterBody = DB::table('shrimp_specieswise')
                ->where('Year' ,$year)
                ->where("Species","=",$specie)
                ->sum('Seasonal cultured water body');

            $sumOfBaor = DB::table('shrimp_specieswise')
                ->where('Year' ,$year)
                ->where("Species","=",$specie)
                ->sum('Baor');

            $sumOfShrimpPrawnFarm = DB::table('shrimp_specieswise')
                ->where('Year' ,$year)
                ->where("Species","=",$specie)
                ->sum('Shrimp/Prawn Farm');

            $sumOfMarineIndustrial = DB::table('shrimp_specieswise')
                ->where('Year' ,$year)
                ->where("Species","=",$specie)
                ->sum('Marine Industrial');

            $sumOfMarineArtisanal = DB::table('shrimp_specieswise')
                ->where('Year' ,$year)
                ->where("Species","=",$specie)
                ->sum('Marine Artisanal');



            array_push($river,$sumOfRiver);
            array_push($sundarbans,$sumOfSundarbans);
            array_push($beel,$sumOfBeel);
            array_push($kaptaiLake,$sumOfKaptaiLake);
            array_push($floodPlain,$sumOfFloodPlain);
            array_push($pond,$sumOfPond);
            array_push($seasonalCulturedWaterBody,$sumOfSeasonalCulturedWaterBody);
            array_push($baor,$sumOfBaor);
            array_push($shrimpPrawnFarm,$sumOfShrimpPrawnFarm);
            array_push($marineIndustrial,$sumOfMarineIndustrial);
            array_push($marineArtisanal,$sumOfMarineArtisanal);
        }

        //        River	Sundarbans	Beel	Kaptai Lake	Floodplain	Pond	Seasonal cultured water body	Baor	Shrimp/Prawn Farm	Marine Industrial	Marine Artisanal

        $yAxisValueOfShrimpSpeciesWise['River'] = $river;
        $yAxisValueOfShrimpSpeciesWise['Sundarbans'] = $sundarbans;
        $yAxisValueOfShrimpSpeciesWise['Beel'] = $beel;
        $yAxisValueOfShrimpSpeciesWise['Kaptai Lake'] = $kaptaiLake;
        $yAxisValueOfShrimpSpeciesWise['Floodplain'] = $floodPlain;
        $yAxisValueOfShrimpSpeciesWise['Pond'] = $pond;
        $yAxisValueOfShrimpSpeciesWise['Seasonal Cultured Water Body'] = $seasonalCulturedWaterBody;
        $yAxisValueOfShrimpSpeciesWise['Baor'] = $baor;
        $yAxisValueOfShrimpSpeciesWise['Shrimp/Prawn Farm'] = $shrimpPrawnFarm;
        $yAxisValueOfShrimpSpeciesWise['Marine Industrial'] = $marineIndustrial;
        $yAxisValueOfShrimpSpeciesWise['Marine Artisanal'] = $marineArtisanal;

        return ([
            "xAxisValuesOfShrimpSpeciesWise"=>$xAxisValueOfShrimpSpeciesWise,
            "yAxisValuesOfShrimpSpeciesWise"=>$yAxisValueOfShrimpSpeciesWise,

        ]);
    }

    public function dataAtGlanceForALatestYear(){
        $latestData = array();
        $years = DB::table('Shrimp sector wise')->pluck('Year');
        $latestYear = $years[0];
        $riverFish = DB::table('Shrimp sector wise')->where('Year' ,$latestYear)->sum('River');
        $sundarbansFish = DB::table('Shrimp sector wise')->where('Year' ,$latestYear)->sum('Sundarbans');
        $beelFish = DB::table('Shrimp sector wise')->where('Year' ,$latestYear)->sum('Beel');
        $kaptaiLakeFish = DB::table('Shrimp sector wise')->where('Year' ,$latestYear)->sum('Kaptai Lake');
        $floodPlainFish = DB::table('Shrimp sector wise')->where('Year' ,$latestYear)->sum('Flood Plain');

        $latestData['year'] = $latestYear;
        $latestData['River'] = $riverFish;
        $latestData['Sundarbans'] = $sundarbansFish;
        $latestData['Beel'] = $beelFish;
        $latestData['Kaptai Lake'] = $kaptaiLakeFish;
        $latestData['Flood Plain'] = $floodPlainFish;

        return $latestData;

    }
}
