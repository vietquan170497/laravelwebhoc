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
    public function getThem(){
        $loaikhoahoc = DB::table('loaikhoahoc')->orderBy('id','asc')->get();
        $khoahoc = DB::table('khoahoc')->orderBy('id','asc')->get();
        return view('admin.baihoc.them')->with('loaikhoahoc',$loaikhoahoc)->with('khoahoc',$khoahoc);
    }
    public function getDanhSach(){
        $khoahoc = DB::table('khoahoc')->orderBy('id','asc')->get();
        $baihoc = DB::table('baihoc')->orderBy('id','asc')->get();

        return view('admin.baihoc.danhsach')->with('khoahoc',$khoahoc)->with('baihoc',$baihoc);
    }

    public function postThem(Request $request){
        $this->validate($request,
            [
                'LoaiKhoaHoc'=>'required',
                'KhoaHoc'=>'required',
                'TieuDe'=>'required|min:3|unique:KhoaHoc,Ten',
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

        $data = array();
        $data['Ten'] = $request->Ten;
        $data['TomTat'] = $request->TomTat;
        $data['TraPhi'] = $request->TraPhi;

        $data['idLoaiKhoaHoc'] = $request->LoaiKhoaHoc;
        $data['TrangThai'] = $request->TrangThai;
        $data['GiaKhoaHoc'] = $request->GiaKhoaHoc;

        $get_hinhanh = $request->file('HinhAnh');
        if($get_hinhanh){
            $this->validate($request,
                [
                    'HinhAnh'=>'max:1024',
                ],
                [
                    'HinhAnh.max'=>'Bạn chỉ chọn hình ảnh dưới 1Mb',
                ]);
            $duoi = $get_hinhanh->getClientOriginalExtension();
            if($duoi != 'jpg' && $duoi != 'png' && $duoi != 'jpeg'){
                return redirect('admin/khoahoc/sua')->with('loi','Bạn chỉ chọn file có đuôi jpg, png, jpeg');
            }
//            $size = $get_hinhanh->getClientSize();
//            if($size>=1000000){
//                return redirect('admin/khoahoc/sua')->with('size','Bạn chỉ chọn file dưới 1Mb');
//            }
            $name = $get_hinhanh->getClientOriginalName();
            $hinh = str_random(4)."_".$name;
            while (file_exists("upload/khoahoc/".$hinh)){
                $hinh = str_random(4)."_".$name;
            }
            $khoahoc = DB::table('khoahoc')->where('id',$id)->get();
//            if()foreach ($khoahoc as $key=>$kh){
//                unlink('upload/khoahoc/'.$kh->HinhAnh);
//            }
            $get_hinhanh->move("upload/khoahoc/",$hinh);
            $data['HinhAnh'] = $hinh;
        }

        DB::table('khoahoc')->where('id',$id)->update($data);

        return redirect('admin/khoahoc/danhsach')->with('message','Bạn sửa thành công');

    }
    public function getXoa($id){
        DB::table('baihoc')->where('id',$id)->delete();
        Session::put('message','Bài học với id = '.$id.' xóa thành công');
        return Redirect::to('admin/baihoc/danhsach');
    }
}
