<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class SlideController extends Controller
{
    //
    public function getThem(){
        return view('admin.slide.them');
    }
    public function getDanhSach(){
        $loaikhoahoc = DB::table('loaikhoahoc')->orderBy('id','asc')->get();
        $khoahoc = DB::table('khoahoc')->orderBy('id','asc')->get();

        return view('admin.khoahoc.danhsach')->with('khoahoc',$khoahoc)->with('loaikhoahoc',$loaikhoahoc);
    }
}
