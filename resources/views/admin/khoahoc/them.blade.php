@extends('admin.index')

@section('admin_content')
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    Thêm loại khóa học
                </header>
                <div class="panel-body">
                    <div class="position-center">
                        <?php
                            $message = Session::get('message');
                            if($message){
                                echo '<div class="alert alert-success" style="text-align: center">'.$message.'</div>';
                                Session::put('message',null);
                            }
                        ?>
                        @if(count($errors)>0)
                            <div class="alert alert-danger" style="text-align: center">
                                @foreach($errors->all() as $err)
                                    {{$err}}<br>
                                @endforeach
                            </div>
                        @endif

                        <form role="form" action="admin/khoahoc/luu" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="_token" value="{{csrf_token()}}">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Loại khóa học</label>
                                <select class="form-control m-bot15" name="LoaiKhoaHoc">
                                    @foreach($loaikhoahoc as $lkh)
                                        <option value="{{$lkh->id}}}">{{$lkh->Ten}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Tên khóa học</label>
                                <input type="text" name="Ten" class="form-control" id="" placeholder="Nhập tên khóa học">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Tóm tắt</label>
                                <textarea name="TomTat" style="resize: none" rows="8" class="form-control" id="" placeholder="Nhập tóm tắt"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Hình ảnh</label>
                                <input type="file" name="HinhAnh" class="form-control" id="" placeholder="Chọn hình ảnh">
                            </div>
                            <div class="form-group" >
                                <label>Khóa học trả phí : </label>
                                <label class="radio-inline">
                                    <input name="TraPhi" value="0" checked="" type="radio" onchange="chon(this)">  Không
                                </label>
                                <label class="radio-inline">
                                    <input name="TraPhi" value="1" type="radio" onchange="chon(this)">  Có
                                </label>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Giá khóa học</label>
                                <input type="text" name="GiaKhoaHoc" class="form-control" id="gia" placeholder="Nhập giá khóa học (với trường hợp khóa học trả phí)" disabled>
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
                            <a href="admin/khoahoc/danhsach"><input type="button" class="btn btn-info" value="Hủy"></a>
                        </form>
                    </div>

                </div>
            </section>
        </div>
    </div>
@endsection
@section('script')
    <script>
        // document.getElementById('traphi').onchange = function () {
        //     document.getElementById("gia").disabled = (this.value === '0');
        // }

        function chon(obj)
        {
            var value = obj.value;
            if (value === '1'){
                $("#gia").removeAttr('disabled');
            }
            else {
                $("#gia").attr('disabled','');
            }
        }
    </script>
@endsection