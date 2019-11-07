@extends('admin.index')

@section('admin_content')
<div class="table-agile-info">
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    Thêm đăng kí khóa học
                </header>
                <div class="panel-body">
                    <div class="position-center">
                        <?php
                            $message = Session::get('message');
                            if($message){
                                echo '<div class="alert alert-success" style="text-align: center">'.$message.'</div>';
                                Session::put('message',null);
                            }
                            $loi = Session::get('loi');
                            if($loi){
                                echo '<div class="alert alert-danger" style="text-align: center">'.$loi.'</div>';
                                Session::put('loi',null);
                            }
                        ?>
                        @if(count($errors)>0)
                            <div class="alert alert-danger" style="text-align: center">
                                @foreach($errors->all() as $err)
                                    {{$err}}<br>
                                @endforeach
                            </div>
                        @endif

                        <form role="form" action="admin/dangkikhoahoc/them" method="post">
                            <input type="hidden" name="_token" value="{{csrf_token()}}">

                            <div class="form-group">
                                <label for="exampleInputEmail1">Người đăng kí</label>
                                <select class="form-control m-bot15" name="User">
                                    @foreach($users as $user)
                                        <option value="{{$user->id}}}">{{$user->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Khóa học</label>
                                <select class="form-control m-bot15" name="KhoaHoc">
                                    @foreach($khoahoc as $kh)
                                        <option value="{{$kh->id}}">{{$kh->Ten}} (Giá : {{$kh->GiaKhoaHoc}})</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Active</label>
                                <select class="form-control m-bot15" name="TrangThai">
                                    <option value="0">Deactive</option>
                                    <option value="1">Active</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-info">Thêm</button>
                            <a href="admin/dangkikhoahoc/danhsach"><input type="button" class="btn btn-info" value="Hủy"></a>
                        </form>
                    </div>

                </div>
            </section>
        </div>
    </div>
</div>
    @endsection
