@extends('admin.index')

@section('admin_content')
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    Sửa khóa học
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

                        @foreach($khoahoc as $key=>$kh)
                        <form role="form" action="admin/khoahoc/sua/{{$kh->id}}" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="_token" value="{{csrf_token()}}">
                            <div class="form-group">
                                <label >Tên khóa học</label>
                                <input type="text" name="Ten" class="form-control" placeholder="Nhập tên khóa học" value="{{$kh->Ten}}">
                            </div>
                            <div class="form-group">
                                <label>Tóm tắt</label>
                                <textarea name="TomTat" style="resize: none" rows="8" class="form-control" id="" placeholder="Nhập tóm tắt">{{$kh->TomTat}}</textarea>
                            </div>
                            <div class="form-group">
                                <label>Hình ảnh</label>
                                <p><img width="200px" src="upload/khoahoc/{{$kh->HinhAnh}}"></p>
                                <input type="file" name="HinhAnh" class="form-control" id="" placeholder="Chọn hình ảnh" value="">
                            </div>
                            <div class="form-group" >
                                <label>Khóa học trả phí : </label>
                                <label class="radio-inline">
                                    <input name="TraPhi" value="0"
                                           @if($kh->TraPhi == 0)
                                           {{"checked"}}
                                           @endif
                                           type="radio" onchange="chon(this)">  Không
                                </label>
                                <label class="radio-inline">
                                    <input name="TraPhi" value="1"
                                           @if($kh->TraPhi == 1)
                                           {{"checked"}}
                                           @endif
                                           type="radio" onchange="chon(this)">  Có
                                </label>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Giá khóa học</label>
                                <input type="text" name="GiaKhoaHoc" class="form-control gia" value="{{$kh->GiaKhoaHoc}}" placeholder="Nhập giá khóa học (với trường hợp khóa học trả phí)"
                                       @if($kh->TraPhi==0)
                                           {{"disabled"}}
                                       @endif/>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Loại khóa học</label>
                                <select class="form-control m-bot15" name="LoaiKhoaHoc">
                                    @foreach($loaikhoahoc as $lkh)
                                        <option value="{{$lkh->id}}}">{{$lkh->Ten}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Active</label>
                                <select class="form-control m-bot15" name="TrangThai">
                                    <option value="0"
                                        @if($kh->TrangThai==0)
                                                {{"selected"}}
                                        @endif
                                        >Deactive
                                    </option>
                                    <option value="1"
                                            @if($kh->TrangThai==1)
                                            {{"selected"}}
                                            @endif
                                        >Active
                                    </option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-info">Sửa</button>
                            <input type="button" class="btn btn-info" value="Làm mới">
                            <a href="admin/khoahoc/danhsach"><input type="button" class="btn btn-info" value="Hủy"></a>
                        </form>
                        @endforeach
                    </div>

                </div>
            </section>
        </div>
    </div>
@endsection

@section('script')
    <script>
        function chon(obj)
        {
            var value = obj.value;
            if (value === '1'){
                $(".gia").removeAttr('disabled');
                $(".gia").val("{{$kh->GiaKhoaHoc}}");
            }
            else {
                $(".gia").attr('disabled','');
                $(".gia").val("0");
            }
        }
    </script>
@endsection