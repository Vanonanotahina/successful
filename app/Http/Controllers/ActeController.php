<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\GenericController;
use DB;

class ActeController extends Controller
{
    public function list(){
        $actes = DB::table('actes')->get();
        return view('acte_list',['actes'=>$actes]);
    }

    public function addActe(Request $request){
        $generic = new GenericController();
        if($request->input('budget') > 0){
            if($generic->insert($request)){
                return redirect('acte/list');
            }
        }
        return redirect()->back();
    }
}
