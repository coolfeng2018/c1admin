@extends('admin.base')
@section('content')
    <div class="layui-card">
        <div class="layui-card-body">
            <form class="layui-form layui-form layui-form-pane">
                @include('admin.hall.userlist._form')
            </form>
        </div>
    </div>
@endsection
@section('script')
    <script>
        layui.use(['layer','form','laydate'],function (index) {
            var form = layui.form;
            var layer = layui.layer;
            var laydate = layui.laydate;
            form.on('submit(form)', function(data){
                $.post("{{route('admin.userlist.store')}}",data.field,function (result) {
                    if(result.code==0){
                        layer.msg(result.msg,{icon:1});
                        setTimeout(function(){
                            var index = parent.layer.getFrameIndex(window.name);
                            parent.layer.close(index);
                        },2000);
                    }else {
                        layer.msg(result.msg,{icon:2});
                    }
                    layer.close(index);
                });
                return false;
            });

            //开始日期
            laydate.render({
                elem: '#etime'
                , format: 'yyyy-MM-dd'
            });
        });
    </script>
@endsection

