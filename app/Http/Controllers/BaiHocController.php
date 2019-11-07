<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use DB;
use Session;
use Illuminate\Support\Facades\Redirect;

session_start();

class BaiHocController extends Controller
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
    public function getThem(){
        $this->AuthLogin();
        $loaikhoahoc = DB::table('loaikhoahoc')->orderBy('id','asc')->get();
        $khoahoc = DB::table('khoahoc')->orderBy('id','asc')->get();
        return view('admin.baihoc.them')->with('loaikhoahoc',$loaikhoahoc)->with('khoahoc',$khoahoc);
    }
    public function getDanhSach(){
        $this->AuthLogin();
        $khoahoc = DB::table('khoahoc')->orderBy('id','asc')->get();
        $baihoc = DB::table('baihoc')->orderBy('id','asc')->get();

        return view('admin.baihoc.danhsach')->with('khoahoc',$khoahoc)->with('baihoc',$baihoc);
    }

    public function postThem(Request $request){
        $this->AuthLogin();
        $this->validate($request,
            [
                'LoaiKhoaHoc'=>'required',
                'KhoaHoc'=>'required',
                'TieuDe'=>'required|min:3|unique:BaiHoc,TieuDe',
                'TomTat'=>'required',
                'NoiDung'=>'required',
                'HinhAnh'=>'required|max:2048',
            ],
            [
                'LoaiKhoaHoc.required'=>'Bạn chưa chọn loại khóa học',
                'KhoaHoc.required'=>'Bạn chưa chọn khóa học',
                'TieuDe.required'=>'Bạn chưa điền tiêu đề bài học',
                'TieuDe.min'=>'Tiêu đề bài học phải ít nhất 3 kí tự',
                'TieuDe.unique'=>'Tiêu đề bài học đã tồn tại',
                'TomTat.required'=>'Bạn chưa nhập tóm tắt',
                'NoiDung.required'=>'Bạn chưa nhập nội dung',
                'HinhAnh.required'=>'Bạn chưa chọn hình ảnh hoặc bạn chọn hình ảnh lớn hơn 2Mb',
                'HinhAnh.max'=>'Bạn phải chọn hình ảnh dưới 2Mb',

            ]);
        $data = array();
        $data['TieuDe'] = $request->TieuDe;
        $data['TomTat'] = $request->TomTat;
        $data['NoiDung'] = $request->NoiDung;
        $data['NoiBat'] = $request->NoiBat;
        $data['SoLuotXem'] = '0';
        $data['idKhoaHoc'] = $request->KhoaHoc;
        $data['TrangThai'] = $request->TrangThai;

        $get_hinhanh = $request->file('HinhAnh');
        if($get_hinhanh){
            $duoi = $get_hinhanh->getClientOriginalExtension();
            if($duoi != 'jpg' && $duoi != 'png' && $duoi != 'jpeg'){
                return redirect('admin/baihoc/them')->with('loi','Bạn chỉ chọn file có đuôi jpg, png, jpeg');
            }
            $name = $get_hinhanh->getClientOriginalName();
            $hinh = str_random(4)."_".$name;
            while (file_exists("upload/baihoc/".$hinh)){
                $hinh = str_random(4)."_".$name;
            }
            $get_hinhanh->move("upload/baihoc/",$hinh);
            $data['HinhAnh'] = $hinh;
        }else{
            $data['HinhAnh'] = "";
        }

        DB::table('baihoc')->insert($data);

        return redirect('admin/baihoc/them')->with('message','Bạn thêm thành công');
    }

    public function getDeactive($id){
        $this->AuthLogin();
        DB::table('baihoc')->where('id',$id)->update(['TrangThai'=>1]);
        Session::put('message','Trạng thái với id = '.$id.' được Hiện');
        return Redirect::to('admin/baihoc/danhsach');
    }

    public function getActive($id){
        $this->AuthLogin();
        DB::table('baihoc')->where('id',$id)->update(['TrangThai'=>0]);
        Session::put('message','Trạng thái với id = '.$id.' được Ẩn');
        return Redirect::to('admin/baihoc/danhsach');
    }

    public function getSua($id){
        $this->AuthLogin();
        $loaikhoahoc = DB::table('loaikhoahoc')->orderBy('id','asc')->get();
        $khoahoc = DB::table('khoahoc')->orderBy('id','asc')->get();
        $baihoc = DB::table('baihoc')->where('id',$id)->get();
        $binhluan = DB::table('binhluan')->orderBy('id','asc')->get();
        $users = DB::table('users')->orderBy('id','asc')->get();

        return view('admin.baihoc.sua')->with('khoahoc',$khoahoc)->with('loaikhoahoc',$loaikhoahoc)->with('baihoc',$baihoc)->with('binhluan',$binhluan)->with('users',$users);
    }
    public function postSua($id, Request $request){
        $this->AuthLogin();
        $this->validate($request,
            [
                'LoaiKhoaHoc'=>'required',
                'KhoaHoc'=>'required',
                'TieuDe'=>'required|min:3',
                'TomTat'=>'required',
                'NoiDung'=>'required',
                'HinhAnh'=>'required|max:2048',
            ],
            [
                'LoaiKhoaHoc.required'=>'Bạn chưa chọn loại khóa học',
                'KhoaHoc.required'=>'Bạn chưa chọn khóa học',
                'TieuDe.required'=>'Bạn chưa điền tiêu đề bài học',
                'TieuDe.min'=>'Tiêu đề bài học phải ít nhất 3 kí tự',
                'TomTat.required'=>'Bạn chưa nhập tóm tắt',
                'NoiDung.required'=>'Bạn chưa nhập nội dung',
                'HinhAnh.required'=>'Bạn chưa chọn hình ảnh hoặc bạn chọn hình ảnh lớn hơn 2Mb',
                'HinhAnh.max'=>'Bạn phải chọn hình ảnh dưới 2Mb',

            ]);

        $data = array();
        $data['TieuDe'] = $request->TieuDe;
        $data['TomTat'] = $request->TomTat;
        $data['NoiDung'] = $request->NoiDung;
        $data['NoiBat'] = $request->NoiBat;
        $data['idKhoaHoc'] = $request->KhoaHoc;
        $data['TrangThai'] = $request->TrangThai;

        $get_hinhanh = $request->file('HinhAnh');
        if($get_hinhanh){
            $this->validate($request,
                [
                    'HinhAnh'=>'max:2048',
                ],
                [
                    'HinhAnh.max'=>'Bạn chỉ chọn hình ảnh dưới 2Mb',
                ]);
            $duoi = $get_hinhanh->getClientOriginalExtension();
            if($duoi != 'jpg' && $duoi != 'png' && $duoi != 'jpeg'){
                return redirect('admin/baihoc/sua')->with('loi','Bạn chỉ chọn file có đuôi jpg, png, jpeg');
            }
//            $size = $get_hinhanh->getClientSize();
//            if($size>=1000000){
//                return redirect('admin/khoahoc/sua')->with('size','Bạn chỉ chọn file dưới 1Mb');
//            }
            $name = $get_hinhanh->getClientOriginalName();
            $hinh = str_random(4)."_".$name;
            while (file_exists("upload/baihoc/".$hinh)){
                $hinh = str_random(4)."_".$name;
            }
            $khoahoc = DB::table('khoahoc')->where('id',$id)->get();
//            if()foreach ($khoahoc as $key=>$kh){
//                unlink('upload/khoahoc/'.$kh->HinhAnh);
//            }
            $get_hinhanh->move("upload/baihoc/",$hinh);
            $data['HinhAnh'] = $hinh;
        }

        DB::table('baihoc')->where('id',$id)->update($data);

        return redirect('admin/baihoc/danhsach')->with('message','Bài học với id = '.$id.' sửa thành công');

    }
    public function getXoa($id){
        $this->AuthLogin();
        DB::table('baihoc')->where('id',$id)->delete();
        Session::put('message','Bài học với id = '.$id.' xóa thành công');
        return Redirect::to('admin/baihoc/danhsach');
    }
}
