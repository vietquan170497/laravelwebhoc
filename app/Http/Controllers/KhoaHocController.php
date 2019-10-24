<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use DB;
use Session;
use Illuminate\Support\Facades\Redirect;

session_start();

class KhoaHocController extends Controller
{
    //
    public function getThem(){
        $loaikhoahoc = DB::table('loaikhoahoc')->orderBy('id','asc')->get();
        return view('admin.khoahoc.them')->with('loaikhoahoc',$loaikhoahoc);
    }
    public function getDanhSach(){
        $danhsach = DB::table('loaikhoahoc')->get();
        $loaikhoahoc = view('admin.loaikhoahoc.danhsach')->with('loaikhoahoc',$danhsach );

        return view('admin.index')->with('admin.loaikhoahoc.danhsach',$loaikhoahoc);
    }

    public function postLuu(Request $request){
        $data = array();
        $data['Ten'] = $request->Ten;
        $data['TomTat'] = $request->TomTat;
        $data['TraPhi'] = $request->TraPhi;

        $data['idLoaiKhoaHoc'] = $request->LoaiKhoaHoc;
        $data['TrangThai'] = $request->TrangThai;

        if(!isset($request->GiaKhoaHoc)){
            $data['GiaKhoaHoc']=0;
        } else {
            $data['GiaKhoaHoc'] = $request->GiaKhoaHoc;
        }

        $get_hinhanh = $request->file('HinhAnh');
        if($get_hinhanh){
            $duoi = $get_hinhanh->getClientOriginalExtension();
            if($duoi != 'jpg' && $duoi != 'png' && $duoi = 'jpeg'){
                return redirect('admin/khoahoc/them')->with('loi','Bạn chỉ chọn file có đuôi jpg, png, jpeg');
            }
            $name = $get_hinhanh->getClientOriginalName();
            $hinh = str_random(4)."_".$name;
            while (file_exists("upload/khoahoc/".$hinh)){
                $hinh = str_random(4)."_".$name;
            }
            $get_hinhanh->move("upload/khoahoc",$hinh);
            $data['HinhAnh'] = $hinh;
        }else{
            $data['HinhAnh']->Hinh = "";
        }

        DB::table('khoahoc')->insert($data);

        Session::put('message','Thêm khóa học thành công');
        return Redirect::to('admin/khoahoc/them');

    }

    public function getDeactive($id){
        DB::table('loaikhoahoc')->where('id',$id)->update(['TrangThai'=>1]);
        Session::put('message','Trạng thái với id = '.$id.' được Hiện');
        return Redirect::to('admin/loaikhoahoc/danhsach');
    }

    public function getActive($id){
        DB::table('loaikhoahoc')->where('id',$id)->update(['TrangThai'=>0]);
        Session::put('message','Trạng thái với id = '.$id.' được Ẩn');
        return Redirect::to('admin/loaikhoahoc/danhsach');
    }

    public function getSua($id){
        $sua = DB::table('loaikhoahoc')->where('id',$id)->get();
        $loaikhoahoc = view('admin.loaikhoahoc.sua')->with('loaikhoahoc',$sua );

        return view('admin.index')->with('admin.loaikhoahoc.sua',$loaikhoahoc);

    }
    public function postSua($id, Request $request){
        $data = array();
        $data['Ten'] = $request->Ten;
        DB::table('loaikhoahoc')->where('id',$id)->update($data);

        Session::put('message','Loại khóa học với id = '.$id.' sửa thành công');
        return Redirect::to('admin/loaikhoahoc/danhsach');

    }
    public function getXoa($id){
        DB::table('loaikhoahoc')->where('id',$id)->delete();
        Session::put('message','Loại khóa học với id = '.$id.' xóa thành công');
        return Redirect::to('admin/loaikhoahoc/danhsach');
    }
}
