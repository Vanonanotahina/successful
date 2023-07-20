<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BenutzerController;
use App\Http\Controllers\AdmController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\GenericController;
use App\Http\Controllers\ExpensesController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ActeController;
use App\Http\Controllers\SpentController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::view('adm_login','adm_login');
Route::view('adm_home','adm_home');
Route::view('patient_add','patient_add');
Route::view('acte_add','acte_add');
Route::view('spent_add','spent_add');
Route::view('adm_patient_add','adm_patient_add');
Route::view('adm_patient_list','adm_patient_list');

Route::post('admin/login',[AdmController::class,'login']); 
Route::get('adm/patient/list',[PatientController::class,'admlist']); 
Route::post('add/patient',[PatientController::class,'insert']); 
Route::get('dashboard',[DashboardController::class,'dashboard']); 
Route::post('dashboard',[DashboardController::class,'dashboard']); 

Route::get('acte/list',[ActeController::class,'list']);
Route::post('add/acte',[ActeController::class,'addActe']); 
Route::get('spent/list',[SpentController::class,'list']);
Route::post('add/spent',[SpentController::class,'addSpent']);  

Route::get('edit/patient/{patient_id}',[PatientController::class,'edit']); 
Route::post('update/patient',[PatientController::class,'update']); 


// ------------------------------------------------------------------

// Route::view('URI','viewname');
Route::view('benutzer_login','benutzer_login');
Route::view('benutzer_home','benutzer_home');
Route::view('activities_list','activities_list');
Route::view('upload_csv','upload_csv');
Route::view('eval_expenses_multi','eval_expenses_multi');

Route::post('benutzer/login',[BenutzerController::class,'login']);

Route::get('patient/list',[PatientController::class,'list']); 

Route::get('activities/patient/{patient_id}',[PatientController::class,'activities']);
Route::post('activities/patient/{patient_id}',[PatientController::class,'activities']);

Route::get('all/activities/patient/{patient_id}',[PatientController::class,'allActivities']);
Route::get('page/add/activity/{patient_id}',[PatientController::class,'pageAddActivity']);
Route::get('page/add/activities/{patient_id}',[PatientController::class,'pageAddActivity']);

Route::post('add/activity/{patient_id}',[PatientController::class,'addActivity']);
Route::post('add/activities/{patient_id}',[PatientController::class,'invoiceActivities']);
Route::post('add/activities',[PatientController::class,'addActivities'])->name('add.activities');

Route::get('expenses/list',[ExpensesController::class,'list']);
Route::get('page/add/expense',[ExpensesController::class,'pageAddExpense']);
Route::get('page/add/multiple/expense',[ExpensesController::class,'pageAddMultiExpense']);

Route::post('add/expense',[ExpensesController::class,'addExpense']);
// Route::post('add/multiple/expense',[ExpensesController::class,'addMultiExpense']);
Route::post('expenses/upload',[ExpensesController::class,'uploadExpenses']);
Route::post('add/multiple/expense',[ExpensesController::class,'evalAddMultiExpense']);
