<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use DB;
use Session;
use Illuminate\Support\Facades\Redirect;

session_start();



class AdminController extends Controller
{
    //
    public function getLogin(){
        return view('admin.login');
    }

    public function getIndex(){
        return view('admin.index');
    }

    public function getDashboard(){
        return view('admin.dashboard');
    }
    public function postDashboard(Request $request){
        $email = $request->email;
        $password = md5($request->password);

        $result = DB::table('admin')->where('email',$email)->where('password',$password)->first();
        if( isset( $result)){
            Session::put('name',$result->name);
            Session::put('id',$result->id);
            return Redirect::to('admin/dashboard');}
        else{
            Session::put('message',"Email hoặc password bị sai");
            return Redirect::to('admin/login');
        }
    }
    public function getLogout(){
        Session::put('name',null);
        Session::put('id',null);
        return Redirect::to('admin/login');
    }
}
