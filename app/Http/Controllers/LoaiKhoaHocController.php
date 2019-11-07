<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use DB;
use Session;
use Illuminate\Support\Facades\Redirect;

session_start();

class LoaiKhoaHocController extends Controller
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
        return view('admin.loaikhoahoc.them');
    }
    public function getDanhSach(){
        $this->AuthLogin();
        $danhsach = DB::table('loaikhoahoc')->paginate(10);
        $loaikhoahoc = view('admin.loaikhoahoc.danhsach')->with('loaikhoahoc',$danhsach );

        return view('admin.index')->with('admin.loaikhoahoc.danhsach',$loaikhoahoc);
    }

    public function postThem(Request $request){
        $this->AuthLogin();
        $this->validate($request,
            [
                'Ten'=>'required|min:3|unique:loaikhoahoc,Ten',
            ],
            [
                'Ten.required'=>'Bạn chưa điền tên khóa học',
                'Ten.min'=>'Tiêu đề phải ít nhất 3 kí tự',
                'Ten.unique'=>'Tên khóa học đã tồn tại',
            ]);
        $data = array();
        $data['Ten'] = $request->Ten;
        $data['TrangThai'] = $request->TrangThai;

        DB::table('loaikhoahoc')->insert($data);

        //Session::put('message','Thêm loại khóa học thành công');
        return redirect('admin/loaikhoahoc/them')->with('message','Bạn thêm thành công');

    }

    public function getDeactive($id){
        $this->AuthLogin();
        DB::table('loaikhoahoc')->where('id',$id)->update(['TrangThai'=>1]);
        Session::put('message','Trạng thái với id = '.$id.' được Hiện');
        return Redirect::to('admin/loaikhoahoc/danhsach');
    }

    public function getActive($id){
        $this->AuthLogin();
        DB::table('loaikhoahoc')->where('id',$id)->update(['TrangThai'=>0]);
        Session::put('message','Trạng thái với id = '.$id.' được Ẩn');
        return Redirect::to('admin/loaikhoahoc/danhsach');
    }

    public function getSua($id){
        $this->AuthLogin();
        $sua = DB::table('loaikhoahoc')->where('id',$id)->get();
        $loaikhoahoc = view('admin.loaikhoahoc.sua')->with('loaikhoahoc',$sua );

        return view('admin.index')->with('admin.loaikhoahoc.sua',$loaikhoahoc);

    }
    public function postSua($id, Request $request){
        $this->AuthLogin();
        $this->validate($request,
            [
                'Ten'=>'required|min:3|unique:loaikhoahoc,Ten',
            ],
            [
                'Ten.required'=>'Bạn chưa điền tên khóa học',
                'Ten.min'=>'Tiêu đề phải ít nhất 3 kí tự',
                'Ten.unique'=>'Tên khóa học đã tồn tại',
            ]);
        $data = array();
        $data['Ten'] = $request->Ten;
        DB::table('loaikhoahoc')->where('id',$id)->update($data);
        return redirect('admin/loaikhoahoc/danhsach')->with('message','Loại khóa học với id = '.$id.' sửa thành công');
    }
    public function getXoa($id){
        $this->AuthLogin();
        DB::table('loaikhoahoc')->where('id',$id)->delete();
        Session::put('message','Loại khóa học với id = '.$id.' xóa thành công');
        return Redirect::to('admin/loaikhoahoc/danhsach');
    }
}
