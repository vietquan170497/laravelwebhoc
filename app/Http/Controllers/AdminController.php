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
    public function AuthLogin(){
        $admin_id = Session::get('admin_id');
        if($admin_id){
            return Redirect::to('admin/dashboard');
        } else{
            return Redirect::to('admin/login')->send();
        }
    }

    public function getLogin(){
        return view('admin.login');
    }

    public function getIndex(){
        $this->AuthLogin();
        return view('admin.index');
    }

    public function getDashboard(){
        $this->AuthLogin();
        return view('admin.dashboard');
    }
    public function postDashboard(Request $request){
        $email = $request->email;
        $password = md5($request->password);

        $result = DB::table('admin')->where('email',$email)->where('password',$password)->first();
        if( isset( $result)){
            Session::put('admin_name',$result->name);
            Session::put('admin_id',$result->id);
            return Redirect::to('admin/dashboard');}
        else{
            Session::put('message',"Email hoặc password bị sai");
            return Redirect::to('admin/login');
        }
    }
    public function getLogout(){
        $this->AuthLogin();
        Session::put('admin_name',null);
        Session::put('admin_id',null);
        return Redirect::to('admin/login');
    }
}
