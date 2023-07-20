<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Benutzer;
use DB;

class AdmController extends Controller
{
    public function isAdmin(Benutzer $admin){
        $result = Benutzer::whereName($admin->name)->first();
        //dd($result->pwd_md5);
        if( !is_null($result) ){
            if($result->pwd_md5 == $admin->pwd_md5 && $result->level >= 100){
                return 1;
            }
            return 0;
        }
        return -1;
    }

    public function login(Request $request){
        $admin = new Benutzer();
        $admin->name = $request['name'];
        $admin->pwd_md5 = md5( $request->input('password') );
        $check = $this->isAdmin($admin);
        if( $check > 0){
            return view('adm_home');
        }
        else{
            if( $check == -1){

                return redirect()->back()->with('error_name','wrong username');
            }
            else{
                return redirect()->back()->with('error_pwd','wrong password');
            }
        }
    }

}
