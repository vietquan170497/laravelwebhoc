<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

use App\Http\Requests;

class AjaxController extends Controller
{
    //
    public function getKhoaHoc($idLoai){
        $khoahoc = DB::table('khoahoc')->where('idLoaiKhoaHoc',$idLoai)->orderBy('id','asc')->get();
        foreach ($khoahoc as $kh){
            echo "<option value = '".$kh->id."'>".$kh->Ten."</option>";
        }
    }
}
