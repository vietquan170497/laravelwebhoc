<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use DB;
use Session;
use Illuminate\Support\Facades\Redirect;

session_start();

class DangKiKhoaHocController extends Controller
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
        $users = DB::table('users')->orderBy('id','asc')->get();
        $khoahoc = DB::table('khoahoc')->orderBy('id','asc')->get();
        return view('admin.dangkikhoahoc.them')->with('users',$users)->with('khoahoc',$khoahoc);
    }
    public function getDanhSach(){
        $this->AuthLogin();
        $users = DB::table('users')->orderBy('id','asc')->get();
        $khoahoc = DB::table('khoahoc')->orderBy('id','asc')->get();
        $dangkikhoahoc = DB::table('dangkikhoahoc')->orderBy('id','asc')->get();

        return view('admin.dangkikhoahoc.danhsach')->with('khoahoc',$khoahoc)->with('dangkikhoahoc',$dangkikhoahoc)->with('users',$users);
    }

    public function postThem(Request $request){
        $this->AuthLogin();
        $this->validate($request,
            [
                'User'=>'required',
                'KhoaHoc'=>'required',
                'TrangThai'=>'required',
            ],
            [
                'User.required'=>'Bạn chưa chọn người dùng đăng kí',
                'KhoaHoc.required'=>'Bạn chưa chọn khóa học đăng kí',
                'TrangThai.required'=>'Bạn chưa chọn trạng thái',
            ]);
        $data = array();
        $data['idUser'] = $request->User;
        $data['idKhoaHoc'] = $request->KhoaHoc;
        $data['TrangThai'] = $request->TrangThai;

        $khoahoc = DB::table('khoahoc')->where('id',$request->KhoaHoc)->get();

        foreach ($khoahoc as $kh) {
            $data['TongTien'] = $kh->GiaKhoaHoc;
        }
        DB::table('dangkikhoahoc')->insert($data);

        return redirect('admin/dangkikhoahoc/them')->with('message','Bạn thêm thành công');
    }

    public function getDeactive($id){
        $this->AuthLogin();
        DB::table('dangkikhoahoc')->where('id',$id)->update(['TrangThai'=>1]);
        Session::put('message','Trạng thái với id = '.$id.' được Hiện');
        return Redirect::to('admin/dangkikhoahoc/danhsach');
    }

    public function getActive($id){
        $this->AuthLogin();
        DB::table('dangkikhoahoc')->where('id',$id)->update(['TrangThai'=>0]);
        Session::put('message','Trạng thái với id = '.$id.' được Ẩn');
        return Redirect::to('admin/dangkikhoahoc/danhsach');
    }

    public function getSua($id){
        $this->AuthLogin();
        $users = DB::table('users')->orderBy('id','asc')->get();
        $khoahoc = DB::table('khoahoc')->orderBy('id','asc')->get();
        $dangkikhoahoc = DB::table('dangkikhoahoc')->where('id',$id)->get();

        return view('admin.dangkikhoahoc.sua')->with('khoahoc',$khoahoc)->with('users',$users)->with('dangkikhoahoc',$dangkikhoahoc);
    }
    public function postSua($id, Request $request){
        $this->AuthLogin();
        $this->validate($request,
            [
                'User'=>'required',
                'KhoaHoc'=>'required',
                'TrangThai'=>'required',
            ],
            [
                'User.required'=>'Bạn chưa chọn người dùng đăng kí',
                'KhoaHoc.required'=>'Bạn chưa chọn khóa học đăng kí',
                'TrangThai.required'=>'Bạn chưa chọn trạng thái',
            ]);

        $data = array();
        $data['idUser'] = $request->User;
        $data['idKhoaHoc'] = $request->KhoaHoc;
        $data['TrangThai'] = $request->TrangThai;

        $khoahoc = DB::table('khoahoc')->where('id',$request->KhoaHoc)->get();

        foreach ($khoahoc as $kh) {
            $data['TongTien'] = $kh->GiaKhoaHoc;
        }

        DB::table('dangkikhoahoc')->where('id',$id)->update($data);

        return redirect('admin/dangkikhoahoc/danhsach')->with('message','Bạn sửa thành công');
    }

    public function getXoa($id){
        $this->AuthLogin();
        DB::table('dangkikhoahoc')->where('id',$id)->delete();
        Session::put('message','Khóa học với id = '.$id.' xóa thành công');
        return Redirect::to('admin/dangkikhoahoc/danhsach');
    }

}
