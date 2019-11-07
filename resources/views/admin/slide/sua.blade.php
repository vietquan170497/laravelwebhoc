@extends('admin.index')

@section('admin_content')
<div class="table-agile-info">
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    Sửa slide
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
                        @foreach($slides as $key=>$slide)
                            <form role="form" action="admin/slide/sua/{{$slide->id}}" method="post" enctype="multipart/form-data">
                                <input type="hidden" name="_token" value="{{csrf_token()}}">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Tiêu đề slide</label>
                                    <input type="text" name="TieuDe" class="form-control" id="" placeholder="Nhập tên khóa học" value="{{$slide->TieuDe}}">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Hình ảnh</label>
                                    <p><img width="200px" src="upload/slide/{{$slide->Hinh}}"></p>
                                    <input type="file" name="HinhAnh" class="form-control" id="" placeholder="Chọn hình ảnh" value="">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Nội dung</label>
                                    <input type="text" name="NoiDung" class="form-control" id="" placeholder="Nhập nội dung" value="{{$slide->NoiDung}}">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Link truy cập</label>
                                    <input type="text" name="link" class="form-control" id="" placeholder="Nhập link truy cập" value="{{$slide->link}}">
                                </div>
                                <button type="submit" class="btn btn-info">Sửa</button>
                                <input type="button" class="btn btn-info" value="Làm mới">
                                <a href="admin/slide/danhsach"><input type="button" class="btn btn-info" value="Hủy"></a>
                            </form>
                        @endforeach
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>
@endsection
