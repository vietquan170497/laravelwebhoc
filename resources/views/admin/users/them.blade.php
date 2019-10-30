@extends('admin.index')

@section('admin_content')
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    Thêm người dùng
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
                        <div id="validate_err" style="color: red">

                        </div>
                        <form role="form" action="admin/user/them" method="post">
                            <input type="hidden" name="_token" value="{{csrf_token()}}">
                            <div class="form-group">
                                <label for="">Tên người dùng</label>
                                <input type="text" name="name" class="form-control" id="Ten" placeholder="Nhập tên người dùng">
                            </div>
                            <div class="form-group">
                                <label for="">Email</label>
                                <input type="text" name="email" class="form-control" id="Ten" placeholder="Nhập email người dùng">
                            </div>
                            <div class="form-group">
                                <label for="">Mật khẩu</label>
                                <input type="password" name="password" class="form-control" id="Ten" placeholder="Nhập mật khẩu ">
                            </div>
                            <div class="form-group">
                                <label for="">Tài Khoản</label>
                                <input type="text" name="TaiKhoan" class="form-control" id="Ten" placeholder="Nhập tài khoản">
                            </div>
                            <div class="form-group">
                                <label for="">Active</label>
                                <select class="form-control m-bot15" name="TrangThai">
                                    <option value="0">Deactive</option>
                                    <option value="1">Active</option>
                                </select>
                            </div>

                            <button type="submit" class="btn btn-info" id="btn_submit">Thêm</button>
                            <input type="button" class="btn btn-info" value="Làm mới">
                            <a href="admin/user/danhsach"><input type="button" class="btn btn-info" value="Hủy"></a>
                        </form>
                    </div>

                </div>
            </section>
        </div>
    </div>
@endsection

{{--@section('script')--}}
{{--    <script type="text/javascript">--}}
{{--        var input_Ten = document.getElementById('Ten');--}}

{{--        var div_message = document.getElementById('validate_err');--}}

{{--        btn_submit.addEventListener('click',function(e){--}}
{{--            e.preventDefault();--}}

{{--            var val_Ten = input_Ten.value;--}}
{{--            //Requried--}}
{{--            var message = "<ul>";--}}
{{--            if(val_Ten ==""){--}}
{{--                message = message+"<li>"+"Vui long nhap name"+"</li>";--}}
{{--            }--}}
{{--            var message = message + "</ul>";--}}
{{--            console.log(message);--}}
{{--            div_message.innerHTML = message;--}}
{{--        });--}}
{{--    </script>--}}
{{--@endsection--}}