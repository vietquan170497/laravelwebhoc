@extends('admin.index')

@section('admin_content')
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    Thêm slide
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

                        <form role="form" action="admin/slide/them" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="_token" value="{{csrf_token()}}">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Tiêu đề slide</label>
                                <input type="text" name="TieuDe" class="form-control" id="" placeholder="Nhập tiêu đề slide">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Hình ảnh</label>
                                <input type="file" name="HinhAnh" class="form-control" id="" placeholder="Chọn hình ảnh">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Nội dung</label>
                                <input type="text" name="NoiDung" class="form-control" id="" placeholder="Nhập nội dung">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Link truy cập</label>
                                <input type="text" name="link" class="form-control" id="" placeholder="Nhập link truy cập">
                            </div>
                            <button type="submit" class="btn btn-info">Thêm</button>
                            <a href="admin/slide/danhsach"><input type="button" class="btn btn-info" value="Hủy"></a>
                        </form>
                    </div>
                </div>
            </section>
        </div>
    </div>
@endsection
