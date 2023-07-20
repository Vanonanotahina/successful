<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use PDF;

class GenericController extends Controller
{
                /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($request)
    {
        $table = new $request['table']();
        $table->save();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    public function insert(Request $request){
        //dd($request->id_event);
        $modelName = 'App\Models\\'.$request['table'];
        $modelNewInstance = app()->make($modelName);
        foreach($modelNewInstance->getFillable() as $fillable){
            $modelNewInstance[$fillable] = $request[$fillable];
        }
        $modelNewInstance->save();
        return $modelNewInstance;
    }

    public function update(Request $request){
        $modelName = 'App\Models\\'.$request['table'];
        $modelNewInstance = app()->make($modelName);
        $modelNewInstance = $modelNewInstance->find($request['id']);
        foreach($modelNewInstance->getFillable() as $fillable){
            $modelNewInstance[$fillable] = $request[$fillable];
        }
        $modelNewInstance->update(); 
        //dd($modelNewInstance);
        //dd($request['point_de_venteid']);
        return redirect('utilisateurs');
    }

    public function delete(Request $request){
        $table = $request['table'];
        $id = $request['id'];
        $results = DB::select('delete from ? where id = ? ', [$table,$id]);
        // DB::table($table)->where('id','=',$request['id'])->delete();
        // dd('deleted');
    }

    public function list($table){
        return DB::table($table)->get();
        //dd($list);
    }

    public function exportPdf(){
        // $pdf = PDF::loadView('export_pdf',['event'=>$event]);
        // return $pdf->download('poster_'.$event->name.'.pdf');
        $pdf = PDF::loadView('export_pdf',['invoice'=>'facture']);
        return $pdf->download('invoice.pdf');
    }

//     public function listSono(string $id_devis){
//         $results = DB::select('select*from view_sono where id_devis = ?', [$id_devis]);
//         $array = array();
//         foreach($results as $result){
//             $array[] = (object) $result;
//         }
//         return view('devis_sono',['sonos'=>$array])->with('id_devis',$id_devis);
//     }

//    : => sono->name
}
