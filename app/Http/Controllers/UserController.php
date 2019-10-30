<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use DB;
use Session;
use Illuminate\Support\Facades\Redirect;

session_start();

class UserController extends Controller
{
    //
    public function getThem(){
        return view('admin.users.them');
    }
    public function getDanhSach(){
        $users = DB::table('users')->orderBy('id','asc')->get();

        return view('admin.users.danhsach')->with('users',$users);
    }

    public function postThem(Request $request){
        $this->validate($request,
            [
                'name'=>'required',
                'email'=>'required|email|unique:users,email',
                'password'=>'required|min:3',
                'TaiKhoan'=>'required',
            ],
            [
                'name.required'=>'Bạn chưa điền tên người dùng',
                'email.required'=>'Bạn chưa điền email',
                'email.email'=>'Bạn phải điền đúng định dạng email',
                'email.unique'=>'Email đã tồn tại',
                'password.required'=>'Bạn chưa điền password',
                'password.min'=>'Password ít nhất 3 kí tự',
                'TaiKhoan.required'=>'Bạn chưa điền tài khoản',
            ]);
        $data = array();
        $data['name'] = $request->name;
        $data['email'] = $request->email;
        $data['password'] = $request->password;
        $data['TaiKhoan'] = $request->TaiKhoan;
        $data['TrangThai'] = $request->TrangThai;

        DB::table('users')->insert($data);

        //Session::put('message','Thêm loại khóa học thành công');
        return redirect('admin/user/them')->with('message','Bạn thêm thành công');
    }
    public function getDeactive($id){
        DB::table('users')->where('id',$id)->update(['TrangThai'=>1]);
        Session::put('message','Trạng thái với id = '.$id.' được Hiện');
        return Redirect::to('admin/user/danhsach');
    }

    public function getActive($id){
        DB::table('users')->where('id',$id)->update(['TrangThai'=>0]);
        Session::put('message','Trạng thái với id = '.$id.' được Ẩn');
        return Redirect::to('admin/user/danhsach');
    }

    public function getSua($id){
        $users = DB::table('users')->where('id',$id)->get();
        return view('admin.users.sua')->with('users',$users);
    }
    public function postSua($id, Request $request){
        $this->validate($request,
            [
                'name'=>'required',
                'password'=>'required|min:3',
                'TaiKhoan'=>'required',
            ],
            [
                'name.required'=>'Bạn chưa điền tên người dùng',
                'password.required'=>'Bạn chưa điền password',
                'password.min'=>'Password ít nhất 3 kí tự',
                'TaiKhoan.required'=>'Bạn chưa điền tài khoản',
            ]);
        $data = array();
        $data['name'] = $request->name;
        $data['password'] = $request->password;
        $data['TaiKhoan'] = $request->TaiKhoan;
        DB::table('users')->where('id',$id)->update($data);
        return redirect('admin/user/danhsach')->with('message','Người dùng với id = '.$id.' sửa thành công');
    }
    public function getXoa($id){
        DB::table('users')->where('id',$id)->delete();
        Session::put('message','Người dùng với id = '.$id.' xóa thành công');
        return Redirect::to('admin/user/danhsach');
    }
}
