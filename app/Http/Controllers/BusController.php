<?php

namespace App\Http\Controllers;

use App\Models\Bus;
use Illuminate\Http\Request;

class BusController extends Controller
{
    //
    public function index(Request $request){
        return "Accion de index de buskjgjkgkgjkghjk-CONTROLLER";
    }

    public function buses(Request $request){
        $buses = Bus::all();
        return response()->json([
            'code'=>200,
            'status'=>'success',
            'buses'=>$buses
        ]);
    }
}
