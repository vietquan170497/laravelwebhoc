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
        $loaikhoahoc = DB::table('loaikhoahoc')->orderBy('id','asc')->get();
        $khoahoc = DB::table('khoahoc')->orderBy('id','asc')->get();

        return view('admin.khoahoc.danhsach')->with('khoahoc',$khoahoc)->with('loaikhoahoc',$loaikhoahoc);
    }

    public function postLuu(Request $request){
        $this->validate($request,
            [
                'LoaiKhoaHoc'=>'required',
                'Ten'=>'required|min:3|unique:KhoaHoc,Ten',
                'TomTat'=>'required',
                'HinhAnh'=>'required',
            ],
            [
                'LoaiKhoaHoc.required'=>'Bạn chưa chọn loại khóa học',
                'Ten.required'=>'Bạn chưa điền tên khóa học',
                'Ten.min'=>'Tiêu đề phải ít nhất 3 kí tự',
                'Ten.unique'=>'Tên khóa học đã tồn tại',
                'TomTat.required'=>'Bạn chưa nhập tóm tắt',
                'HinhAnh.required'=>'Bạn chưa chọn hình ảnh',
            ]);
        if($request->TraPhi==1){
            $this->validate($request,
                [
                    'GiaKhoaHoc'=>'required|min:6',
                ],[
                    'GiaKhoaHoc.required'=>'Bạn chưa nhập giá khóa học',
                    'GiaKhoaHoc.min'=>'Giá phải ít nhất 100.000 VNĐ',
                ]);
        }
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
            $data['HinhAnh'] = "";
        }

        DB::table('khoahoc')->insert($data);

        return redirect('admin/khoahoc/them')->with('message','Bạn thêm thành công');
    }

    public function getDeactive($id){
        DB::table('khoahoc')->where('id',$id)->update(['TrangThai'=>1]);
        Session::put('message','Trạng thái với id = '.$id.' được Hiện');
        return Redirect::to('admin/khoahoc/danhsach');
    }

    public function getActive($id){
        DB::table('khoahoc')->where('id',$id)->update(['TrangThai'=>0]);
        Session::put('message','Trạng thái với id = '.$id.' được Ẩn');
        return Redirect::to('admin/khoahoc/danhsach');
    }

    public function getSua($id){
        $loaikhoahoc = DB::table('loaikhoahoc')->orderBy('id','asc')->get();
        $khoahoc = DB::table('khoahoc')->where('id',$id)->get();

        return view('admin.khoahoc.sua')->with('khoahoc',$khoahoc)->with('loaikhoahoc',$loaikhoahoc);

    }
    public function postSua($id, Request $request){
        $this->validate($request,
            [
                'LoaiKhoaHoc'=>'required',
                'Ten'=>'required|min:3|',
                'TomTat'=>'required',
            ],
            [
                'LoaiKhoaHoc.required'=>'Bạn chưa chọn loại khóa học',
                'Ten.required'=>'Bạn chưa điền tên khóa học',
                'Ten.min'=>'Tiêu đề phải ít nhất 3 kí tự',
                'TomTat.required'=>'Bạn chưa nhập tóm tắt',
            ]);
        if($request->TraPhi==1){
            $this->validate($request,
                [
                    'GiaKhoaHoc'=>'required|min:6',
                ],[
                    'GiaKhoaHoc.required'=>'Bạn chưa nhập giá khóa học',
                    'GiaKhoaHoc.min'=>'Giá phải ít nhất 100.000 VNĐ',
                ]);
        }
        $khoahoc = DB::table('khoahoc')->where('id',$id)->get();
        $data = array();
        $data['Ten'] = $request->Ten;
        $data['TomTat'] = $request->TomTat;
        $data['TraPhi'] = $request->TraPhi;

        $data['idLoaiKhoaHoc'] = $request->LoaiKhoaHoc;
        $data['TrangThai'] = $request->TrangThai;
        $data['GiaKhoaHoc'] = $request->GiaKhoaHoc;

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
            unlink("upload/khoahoc/".$khoahoc->HinhAnh);
            $get_hinhanh->move("upload/khoahoc",$hinh);
            $data['HinhAnh'] = $hinh;
        }

        DB::table('khoahoc')->where('id',$id)->update($data);

        return redirect('admin/khoahoc/danhsach')->with('message','Bạn sửa thành công');

    }
    public function getXoa($id){
        DB::table('loaikhoahoc')->where('id',$id)->delete();
        Session::put('message','Loại khóa học với id = '.$id.' xóa thành công');
        return Redirect::to('admin/loaikhoahoc/danhsach');
    }
}
