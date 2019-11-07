@extends('admin.index')

@section('admin_content')

    <div class="table-agile-info">
        <div class="panel panel-default">
            <div class="panel-heading">
                Danh sách bài học
            </div>
            <div class="row w3-res-tb">
                <div class="col-sm-10">
                </div>
                <div class="col-sm-2">
                    <a href="admin/baihoc/them"><input type="button" class="btn btn-info col-sm-12" value="Thêm mới"></a>
                </div>
            </div>
            <div class="table-responsive">
                <?php
                    $message = Session::get('message');
                    if($message){
                        echo '<div class="alert alert-success" style="text-align: center">'.$message.'</div>';
                        Session::put('message',null);
                    }
                ?>
                <table class="table table-striped b-t b-light">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tiêu đề bài học</th>
                        <th>Khóa học</th>
                        <th>Tóm tắt</th>
                        <th>Nội dung</th>
                        <th>Nổi bật</th>
                        <th>Số lượt xem</th>
                        <th>Trạng thái</th>
                        <th class="th_hanhdong">Hành động</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach ($baihoc as $bh)
                            <tr>
                                <td>{{$bh->id}}</td>
                                <td><p>{{$bh->TieuDe}}</p></td>
                                <td>
                                    @foreach ($khoahoc as $kh)
                                        @if($bh->idKhoaHoc == $kh->id)
                                            {{$kh->Ten}}
                                        @endif
                                    @endforeach
                                </td>
                                <td>{{$bh->TomTat}}</td>
                                <td>{{$bh->NoiDung}}</td>
                                <td>
                                    @if($bh->NoiBat == 0)
                                        {{"Không"}}
                                    @else
                                        {{"Có"}}
                                    @endif

                                </td>
                                <td style="text-align: center">{{$bh->SoLuotXem}}</td>
                                <td>
                                    <span class="text-ellipsis">
                                        @if($bh->TrangThai==0)
                                            <a href="admin/baihoc/deactive/{{$bh->id}}"><button class="btn btn-info" style="width: 80px;">Ẩn</button></a>
                                        @else
                                            <a href="admin/baihoc/active/{{$bh->id}}"><button class="btn btn-info" style="width: 80px;">Hiện</button></a>
                                        @endif
                                    </span>
                                </td>
                                <td style="width:100px;">
                                    <a href="admin/baihoc/sua/{{$bh->id}}" class="active action-icon" ui-toggle-class="">
                                        <i class="fa fa-pencil-alt text-success action_edit"></i>
                                    </a>
                                    <a onclick="return confirm('Bạn có xác nhận xóa!')" href="admin/baihoc/xoa/{{$bh->id}}" class="active action-icon" ui-toggle-class="">
                                        <i class="fa fa-times text-danger action_delete" ></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <footer class="panel-footer">
                <div class="row">

                    <div class="col-sm-5 text-center">
                        <small class="text-muted inline m-t-sm m-b-sm">showing 20-30 of 50 items</small>
                    </div>
                    <div class="col-sm-7 text-right text-center-xs">
                        <ul class="pagination pagination-sm m-t-none m-b-none">
                            <li><a href=""><i class="fa fa-chevron-left"></i></a></li>
                            <li><a href="">1</a></li>
                            <li><a href="">2</a></li>
                            <li><a href="">3</a></li>
                            <li><a href="">4</a></li>
                            <li><a href=""><i class="fa fa-chevron-right"></i></a></li>
                        </ul>
                    </div>
                </div>
            </footer>
        </div>
    </div>

@endsection