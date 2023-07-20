<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\GenericController;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ExpensesImport; 
use Illuminate\Support\File;
use App\Models\Expenses;
use League\Csv\Reader;
use App\Models\Spent;
use DB;

class ExpensesController extends Controller
{
    public function list(){
        $results = DB::select('select*from view_expenses order by date');
        $array = array();
        foreach($results as $result){
            $array[] = (object) $result;
        }
        return view('expenses_list',['expenses'=>$array]);
    }

    public function pageAddExpense(){
        $results = DB::table('spent')->get();
        $array = array();
        foreach($results as $result){
            $array[] = (object) $result;
        }
        return view('expense_add',['spents'=>$array]);
    }

    public function pageAddMultiExpense(){
        $results = DB::table('spent')->get();
        $array = array();
        foreach($results as $result){
            $array[] = (object) $result;
        }
        return view('expenses_add_multiple',['spents'=>$array]);
    }

    public function addExpense(Request $request){
        $amount = $request->input('amount');
        $generic = new GenericController();
        if( $amount > 0 ){
            $generic->insert($request);
            return redirect('expenses/list');
        }
        return redirect()->back()->with('error','value invalid !');
    }

    public function addMultiExpense(Request $request){
        $day = $request->input('day');
        $year = $request->input('year');
        $spent_id = $request->input('spent_id');
        $amount = $request->input('amount');
        $months = $request->input('month');
        // foreach($months as $month){
        //     if( $month % 2 === 0 && $day >= 31 || $month ){
        //         return redirect()->back()->with('validation_error',' invalid  value !');
        //     }
        // }
        if( $amount > 0 ){
            foreach($months as $month){
                if( $day < 10){
                    $stringDate = $year.'/'.$month.'/0'.$day;
                }
                $stringDate = $year.'/'.$month.'/'.$day;
                $datetime = strtotime($stringDate);
                if(checkdate($month,$day,$year) == false){
                    return redirect()->back()->with('validation_error','value invalid !');
                }
                $date = date('Y-m-d',$datetime);
                $temp = new Expenses();
                $temp->spent_id = $spent_id;
                $temp->date = $date;
                $temp->amount = $amount;
                $temp->save();
            }
            return redirect('expenses/list');
        }
        return redirect()->back()->with('error','value invalid !');
    }

    public function uploadExpenses(Request $request){

        $file = $request->file('csv');
        //dd($file->getSize());
        if ($request->hasFile('csv') && $file->getSize() > 0) {
            $csv = Reader::createFromPath($file->getRealpath(), 'r')->setDelimiter(';');
            $csv->setHeaderOffset(0);
            $header = $csv->fetchOne();
            $records = $csv->getRecords();
            foreach ($records as $record) {

                $temp = new Expenses();
                $spent = new Spent();
                $datetime = strtotime($record['date']);
                $date = date('d-m-Y',$datetime);
                $temp->date = $date;
                $temp->amount = $record['montant'];
                $temp->spent_id = $spent->getSpentId($record['code']);
                $temp->save();
                // Process each record
                // Example: Insert the record into the database
                // $record is an associative array representing each row of the CSV file
            }
            return redirect('expenses/list');
        }
        return redirect()->back()->with('file_error','file error !');
    }




    public function EvalAddMultiExpense(Request $request){
        $day = $request->input('day');
        $year = $request->input('year');
        $spent_code = $request->input('spent');
        $amount = $request->input('amount');
        $months = $request->input('month');

        $code_error = 'code doesnt exist!';
        $montant_error = null;
        $date_error = null;
        
        $spents = DB::table('spent')->get();
        $temp = null;
        foreach($spents as$spent){
            if( $spent->code == $spent_code){
                $temp = $spent;
            }
        }

        foreach($months as $month){

            if( $day < 10){
                $stringDate = $year.'/'.$month.'/0'.$day;
            }
            $stringDate = $year.'/'.$month.'/'.$day;
            $datetime = strtotime($stringDate);
            if(checkdate($month,$day,$year) == false){
                $date_error = 'date invalid';
            }
        }
        if($amount < 0 ){
            $montant_error = 'montant invalid';
        }

        if( !is_null($temp)){

            if( $amount > 0 ){
                foreach($months as $month){
                    if( $day < 10){
                        $stringDate = $year.'/'.$month.'/0'.$day;
                    }
                    $stringDate = $year.'/'.$month.'/'.$day;
                    $datetime = strtotime($stringDate);
                    if(checkdate($month,$day,$year) == false){
                        $code_error= null;
                        $date_error = 'date invalid';
                        return redirect()->back()->with(array('code_error'=>$code_error,'montant_error'=>$montant_error,'date_error'=>$date_error));
                    }
                    $date = date('Y-m-d',$datetime);
                    $temp = new Expenses();
                    $temp->spent_id = $spent->ids;
                    $temp->date = $date;
                    $temp->amount = $amount;
                    $temp->save();
                }
                return redirect('expenses/list');
            }
            $code_error= null;
            $montant_error = 'montant invalid';
            return redirect()->back()->with(array('code_error'=>$code_error,'montant_error'=>$montant_error,'date_error'=>$date_error));
        }
        else{
            return redirect()->back()->with(array('code_error'=>$code_error,'montant_error'=>$montant_error,'date_error'=>$date_error));
        }
    }
}
