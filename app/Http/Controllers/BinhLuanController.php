<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use DB;
use Session;
use Illuminate\Support\Facades\Redirect;

session_start();

class BinhLuanController extends Controller
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
    public function getXoa($id){
        $this->AuthLogin();
        DB::table('binhluan')->where('id',$id)->delete();
        Session::put('message','Comment với id = '.$id.' xóa thành công');
        return Redirect::to('admin/baihoc/danhsach');
    }
}
