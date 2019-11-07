<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

use App\Http\Requests;

class AjaxController extends Controller
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
    public function getKhoaHoc($idLoai){
        $this->AuthLogin();
        $khoahoc = DB::table('khoahoc')->where('idLoaiKhoaHoc',$idLoai)->orderBy('id','asc')->get();
        foreach ($khoahoc as $kh){
            echo "<option value = '".$kh->id."'>".$kh->Ten."</option>";
        }
    }

}
