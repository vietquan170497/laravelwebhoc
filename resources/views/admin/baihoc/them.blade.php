@extends('admin.index')

@section('admin_content')
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    Thêm bài học
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
                        $size = Session::get('size');
                        if($size){
                            echo '<div class="alert alert-danger" style="text-align: center">'.$size.'</div>';
                            Session::put('size',null);
                        }
                        ?>
                        @if(count($errors)>0)
                            <div class="alert alert-danger" style="text-align: center">
                                @foreach($errors->all() as $err)
                                    {{$err}}<br>
                                @endforeach
                            </div>
                        @endif

                        <form role="form" action="admin/baihoc/them" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="_token" value="{{csrf_token()}}">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Loại khóa học</label>
                                <select class="form-control m-bot15" name="LoaiKhoaHoc" id="LoaiKhoaHoc" onchange="changeLoai(this.value)">
                                    @foreach($loaikhoahoc as $lkh)
                                        <option value="{{$lkh->id}}">{{$lkh->Ten}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Khóa học</label>
                                <select class="form-control m-bot15" name="KhoaHoc" id="KhoaHoc">
                                    @foreach($khoahoc as $kh)
                                        <option value="{{$kh->id}}}">{{$kh->Ten}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Tiêu đề bài học</label>
                                <input type="text" name="TieuDe" class="form-control" id="" placeholder="Nhập tiêu đề bài học">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Tóm tắt</label>
                                <textarea name="TomTat" style="resize: none" rows="5" class="form-control" id="" placeholder="Nhập tóm tắt"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Nội dung</label>
                                <textarea name="NoiDung" style="resize: none" rows="10" class="form-control" id="" placeholder="Nhập nội dung bài học"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Hình ảnh</label>
                                <input type="file" name="HinhAnh" class="form-control" id="" placeholder="Chọn hình ảnh">
                            </div>
                            <div class="form-group">
                                <label>Nổi bật : </label>
                                <label class="radio-inline">
                                    <input name="NoiBat" value="0" checked="" type="radio"> Không
                                </label>
                                <label class="radio-inline">
                                    <input name="NoiBat" value="1" type="radio">  Có
                                </label>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Active</label>
                                <select class="form-control m-bot15" name="TrangThai">
                                    <option value="0">Deactive</option>
                                    <option value="1">Active</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-info">Thêm</button>
                            <input type="button" class="btn btn-info" value="Làm mới">
                            <a href="admin/baihoc/danhsach"><input type="button" class="btn btn-info" value="Hủy"></a>
                        </form>
                    </div>

                </div>
            </section>
        </div>
    </div>
@endsection
@section('script')
    <script>
        function changeLoai(val) {
            var khoahoc;
            khoahoc = new XMLHttpRequest();
            khoahoc.onreadystatechange = function () {
                if (this.readyState==4 && this.status == 200){
                    document.getElementById("KhoaHoc").innerHTML = this.responseText;
                }
            };
            khoahoc.open("GET", "admin/ajax/loaikhoahoc/"+val,true);
            khoahoc.send();
        }
    </script>
@endsection