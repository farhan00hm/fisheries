<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function home(){
        $totalProduction =  DB::table('total production at a glance')->pluck('Year');
        $capture = DB::table('total production at a glance')->pluck('capture');
        $culture = DB::table('total production at a glance')->pluck('culture');
        $marine = DB::table('total production at a glance')->pluck('marine');
        $hilsa = DB::table('total production at a glance')->pluck('hilsa');
        $shrimpPrawn = DB::table('total production at a glance')->pluck('Shrimp/Prawn');

//        dd($totalProduction,$capture,$culture,$marine,$hilsa,$shrimpPrawn);
        $yAxisValues = ['Capture'=>$capture,'Culture'=>$culture,"Marine"=>$marine,"Hilsa"=>$hilsa,"Shrimp/Prawn"=>$shrimpPrawn];
        return view("user.home",["yAxisValues"=>$yAxisValues,"totalProduction"=>$totalProduction]);
    }
}
