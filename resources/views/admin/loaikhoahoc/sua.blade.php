@extends('admin.index')

@section('admin_content')
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    Sửa loại khóa học
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
                        @foreach($loaikhoahoc as $key=>$lkh)
                            <form role="form" action="admin/loaikhoahoc/sua/{{$lkh->id}}" method="post">
                                <input type="hidden" name="_token" value="{{csrf_token()}}">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Tên loại khóa học</label>
                                    <input type="text" name="Ten" class="form-control" id="exampleInputEmail1" placeholder="Nhập tên loại khóa học" value="{{$lkh->Ten}}">
                                </div>
                                <button type="submit" class="btn btn-info">Sửa</button>
                                <a href="admin/loaikhoahoc/danhsach"><input type="button" class="btn btn-info" value="Hủy"></a>
                            </form>
                        @endforeach
                    </div>

                </div>
            </section>
        </div>
    </div>
@endsection