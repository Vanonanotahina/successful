<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\GenericController;
use DB;

class SpentController extends Controller
{
    public function list(){
        $spents = DB::table('spent')->get();
        return view('spent_list',['spents'=>$spents]);
    }

    public function addSpent(Request $request){
        $generic = new GenericController();
        if( $request->input('budget') > 0){
            if($generic->insert($request)){
                return redirect('spent/list');
            }
        }
        return redirect()->back();
    }
}
