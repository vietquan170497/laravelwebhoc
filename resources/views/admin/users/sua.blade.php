@extends('admin.index')

@section('admin_content')
<div class="table-agile-info">
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    Sửa người dùng
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
                        @foreach($users as $key=>$user)
                            <form role="form" action="admin/user/sua/{{$user->id}}" method="post">
                                <input type="hidden" name="_token" value="{{csrf_token()}}">
                                <div class="form-group">
                                    <label for="">Tên người dùng</label>
                                    <input type="text" name="name" class="form-control" id="Ten" placeholder="Nhập tên người dùng" value="{{$user->name}}">
                                </div>
                                <div class="form-group">
                                    <input type="checkbox" id="passCheck" name="changePassword">
                                    <label for="">Đổi mật khẩu</label>
                                    <input type="password" name="password" class="form-control" id="passText" placeholder="Nhập mật khẩu" disabled>
                                </div>
                                <div class="form-group">
                                    <label for="">Tài Khoản</label>
                                    <input type="text" name="TaiKhoan" class="form-control" placeholder="Nhập tài khoản" value="{{$user->TaiKhoan}}">
                                </div>
                                <button type="submit" class="btn btn-info" id="btn_submit">Sửa</button>
                                <input type="button" class="btn btn-info" value="Làm mới">
                                <a href="admin/user/danhsach"><input type="button" class="btn btn-info" value="Hủy"></a>
                            </form>
                        @endforeach
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>
@endsection

@section('script')
    <script type="text/javascript">
        document.getElementById('passCheck').onchange = function() {
            document.getElementById('passText').disabled = !this.checked;
        };

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
    </script>
@endsection