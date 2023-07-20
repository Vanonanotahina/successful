<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Brick\Math\BigDecimal;
use DB;

class DashboardController extends Controller
{
    public function dashboard(Request $request){
        $year = $request->input('year');
        $month = $request->input('month');


        $actes_budget = DB::select('select sum(budget/12) as mensuel from actes');
        $spents_budget = DB::select('select sum(budget/12) as mensuel from spent');
        $reimburse = DB::select("select sum(reimburse) from invoice where date_part('year', invoice_date) = ? and date_part('month', invoice_date) = ?",[$year,$month]);

        //dd($month);
        $activities_requete = "SELECT type,DATE_TRUNC('month', date) AS month, SUM(amount) AS total_amount,(budget/12) as budget,(SUM(amount)/(budget/12))*100 as realisation
        FROM view_activity
        GROUP BY DATE_TRUNC('month', date),type,budget
        ORDER BY month";
        // where date_part('year', date) = ?

        $activities_requete_month = "SELECT type,DATE_TRUNC('month', date) AS month, SUM(amount) AS total_amount,(budget/12) as budget,(SUM(amount)/(budget/12))*100 as realisation
        FROM view_activity
        where date_part('year', date) = ?
        and date_part('month', date) = ?
        GROUP BY DATE_TRUNC('month', date),type,budget
        ORDER BY month";

        $activities_total_requete = "select sum(total_amount) as total_reel,sum((budget/12)) as total_budget,(sum(total_amount))/sum((budget/12))*100 as realisation  from activities_board";
        // where date_part('year', month) = ?

        $activities_total_requete_month = "select sum(total_amount) as total_reel,sum((budget/12)) as total_budget,(sum(total_amount))/sum((budget/12))*100 as realisation  from activities_board
        where date_part('year', month) = ?
        and date_part('month', month) = ?";

        // ----------------------------------------------------------------------------------------
       
        $expenses_requete = "SELECT type,DATE_TRUNC('month', date) AS month, SUM(amount) AS total_amount,(budget/12) as budget,(SUM(amount)/(budget/12))*100 as realisation
        FROM view_expenses
        GROUP BY DATE_TRUNC('month', date),type,budget
        ORDER BY month";
        //  where date_part('year', date) = ?

        $expenses_requete_month = "SELECT type,DATE_TRUNC('month', date) AS month, SUM(amount) AS total_amount,(budget/12) as budget,(SUM(amount)/(budget/12))*100 as realisation
        FROM view_expenses
        where date_part('year', date) = ?
        and date_part('month', date) = ?
        GROUP BY DATE_TRUNC('month', date),type,budget
        ORDER BY month";

        $expenses_total_requete = "select sum(total_amount) as total_reel,sum((budget/12)) as total_budget,(sum(total_amount)/sum((budget/12)))*100 as realisation from expenses_board";
        // where date_part('year', month) = ?

        $expenses_total_requete_month = "select sum(total_amount) as total_reel,sum((budget/12)) as total_budget,(sum(total_amount)/sum((budget/12)))*100 as realisation  from expenses_board
        where date_part('year', month) = ?
        and date_part('month', month) = ?";

        if( is_null($year)){
            $year = date('Y');    
        }
        if( $month != "null"){
            $activities_results = DB::select($activities_requete_month,[$year,$month]);
            $expenses_results = DB::select($expenses_requete_month,[$year,$month]);
            $expenses_totals = DB::select($expenses_total_requete_month,[$year,$month]);
            $activities_totals = DB::select($activities_total_requete_month,[$year,$month]);
            $reimburse = DB::select("select sum(reimburse) from invoice where date_part('year', invoice_date) = ? and date_part('month', invoice_date) = ?",[$year,$month]);
        }
        else{

            $activities_results = DB::select($activities_requete);
            $expenses_results = DB::select($expenses_requete);
            $expenses_totals = DB::select($expenses_total_requete);
            $activities_totals = DB::select($activities_total_requete);
        }

        $recipes = array();
        $expenses = array();
        $total_recipes = array();
        $total_expenses = array();


        foreach($activities_results as $activities){
            
            $recipes[] =  $activities;
        }
       
        foreach($expenses_results as $expenses_result){

            $expenses[] =  $expenses_result;
        }

        foreach($activities_totals as $activities_total){
            $total_recipes[] = $activities_total;
        }
        foreach($expenses_totals as $expenses_total){
            $total_expenses[] = $expenses_total;
        }

        $benefice_reel = 0;
        $benefice_budget = 0;
        $benefice_realisation = 0;

        //dd($actes_budget);

        //budget total mensuel Type Acte et Type de Depense 
        $total_recipes[0]->total_budget = $actes_budget[0]->mensuel + $reimburse[0]->sum;
        $total_expenses[0]->total_budget = $spents_budget[0]->mensuel;

        $recipes_realisation = ceil(($total_recipes[0]->total_reel/$total_recipes[0]->total_budget)*100); 
        $expenses_realisation = ceil(($total_expenses[0]->total_reel/$total_expenses[0]->total_budget)*100);
        //dd($recipes_realisation); 

        if( !is_null($month)){
            $benefice_reel = $total_recipes[0]->total_reel - $total_expenses[0]->total_reel;
            $benefice_budget = $total_recipes[0]->total_budget - $total_expenses[0]->total_budget;
            //dd($total_expenses[0]->total_reel);

            if( $benefice_budget > 0){
                $benefice_realisation = ($benefice_reel/$benefice_budget)*100;
            }
        }
        
        return view('dashboard',['recipes'=>$recipes,'expenses'=>$expenses,'total_expenses'=>$total_expenses,'total_recipes'=>$total_recipes,'benefice_reel'=>$benefice_reel,'benefice_budget'=>$benefice_budget,'benefice_realisation'=>$benefice_realisation,'recipes_realisation'=>$recipes_realisation,'expenses_realisation'=>$expenses_realisation,'reimburse'=>$reimburse[0]->sum]);
    }

}
