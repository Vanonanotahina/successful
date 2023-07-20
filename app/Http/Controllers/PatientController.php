<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\GenericController;
use App\Models\Activity;
use App\Models\Patient;
use App\Models\Invoice;
use DB;
use DateTime;

class PatientController extends Controller
{
    public function list(){
        $patients = DB::table('patient')->get();
        return view('patient_list',['patients'=>$patients]);
    }

    public function admlist(){
        $patients = DB::table('patient')->get();
        return view('adm_patient_list',['patients'=>$patients]);
    }

    public function insert(Request $request){
        $generic = new GenericController();
        if($generic->insert($request)){
            return redirect('/adm/patient/list');
        }
    }

    public function activities(Request $request,$patient_id){
        $input = $request->input('date');
        $date = new DateTime($input);
        //dd($patient_id);
        if( is_null($input) ){
            // $month = date("m");
            // $year = date("Y");
            $results = DB::select('select*from view_activity where patient_id = ?',[$patient_id]);
        }
        else{
            $month = $date->format('m');
            $year = $date->format('Y');
            $results = DB::select("select*from view_activity where date_part('month', date) = ? and date_part('year', date) = ? and patient_id = ?",[$month,$year,$patient_id]);
        }
        $array = array();
        foreach($results as $result){
            $array[] = (object) $result;
        }
        return view('activities_list',['activities'=>$array,'patient_id'=>$patient_id]);
    }

    public function allActivities($patient_id){

        $results = DB::select("select*from view_activity where patient_id = ?",[$patient_id]);
        $array = array();
        foreach($results as $result){
            $array[] = (object) $result;
        }
        return view('activities_list',['activities'=>$array,'patient_id'=>$patient_id]);
    }

    public function pageAddActivity($patient_id){
        $actes = DB::table('actes')->get();
        return view('activities_add',['actes'=>$actes,'patient_id'=>$patient_id]);
    }

    public function addActivity(Request $request,$patient_id){
        $generic = new GenericController();
        if($generic->insert($request)){
            return redirect('activities/patient/'.$patient_id);
        }
    }

    public function invoiceActivities(Request $request,$patient_id){

        $date = $request->input('date');
        $acte_ids = $request->input('acte_id');
        $amounts = $request->input('amount');
        $array = array();
        $total = 0;
        for( $i = 0 ; $i < count($acte_ids) ; $i++ ){

            if( $amounts[$i] > 0){

                $temp = new Activity();
                $temp->acte_id = $acte_ids[$i];
                $temp->amount = $amounts[$i];
                $temp->date = $date;
                $array[] = $temp;
                $total = $total + $amounts[$i];
            }
        }
        $patient = Patient::whereIdp($patient_id)->first();
        $actes = DB::table('actes')->get();
        $invoices = DB::table('invoice')->get();
        $invoice_num = count($invoices) + 1;
        $invoice = new Invoice();
        $invoice->patient_id = $patient_id;
        $invoice->invoice_date = $date;
        $reimburse = 0;
        //dd($patient->reimburse);
        if( $patient->reimburse == true){  
            $invoice->reimburse = ($total*20)/100;
            $reimburse = $invoice->reimburse;
        }
        $invoice->total = $total + $reimburse;

        return view('invoice_pdf',['patient'=>$patient,'actes'=>$actes,'activities'=>$array,'invoice'=>$invoice,'invoice_num'=>$invoice_num]);
    }

    public function addActivities(Request $request){
        $acte_ids = $request->input('acte_id');
        $amounts = $request->input('amount');
        $date = $request->input('date');
        $total = $request->input('total');
        $patient_id = $request->input('patient_id');
        $reimburse = $request->input('reimburse');

        $invoice = new Invoice();
        $invoice->patient_id = $patient_id;
        $invoice->invoice_date = $date;
        $invoice->total = $total;
        $invoice->reimburse = $reimburse;
        $invoice->save();
        $invoice_id = $invoice->idi;

        if( !is_null($invoice_id)){
            for($i = 0 ; $i < count($amounts) ; $i++){
                
                if( $amounts[$i] > 0){

                    $temp = new Activity();
                    $temp->acte_id = $acte_ids[$i];
                    $temp->invoice_id = $invoice_id;
                    $temp->date = $date;
                    $temp->amount = $amounts[$i];
                    $temp->save();
                }
            }
            return redirect('activities/patient/'.$patient_id);
        }
        return redirect()->back();
    }

    public function edit($patient_id){
        $instance = new Patient();
        $patient = $instance->find($patient_id);
        //dd($patient->name);
        return view('patient_update',['toupdate'=>$patient]);
    }

    public function update(Request $request){

        $temp = new Patient();
        $temp->idp = $request->input('idp');
        $temp->name = $request->input('name');
        $temp->birthday = $request->input('birthday');
        $temp->reimburse = $request->input('reimburse');
        $temp->update();
        return redirect('adm/patient/list');
    }
}
