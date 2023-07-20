<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Benutzer;

class BenutzerController extends Controller
{
    public function login(Request $request){
        $name = $request->input('name');
        $password = $request->input('password');
        $user = Benutzer::whereName($name)->first();
        //dd($user->email);
        if( !is_null($user) ){
            if( $user->pwd_md5 == md5($password) ){

                if($user->level >= 100){
                    return redirect('adm_home');
                }
                if($user->level >= 50){
                    return redirect('benutzer_home');
                }
                
            }
            else{
                return redirect()->back()->with('error_pwd', 'wrong password !');
            }
        }
        else{
            return redirect()->back()->with('error_name', 'wrong username !');
        }
    }
}
