@extends('admin.base')
@section('content')
    <div class="layui-card">
        <div class="layui-card-body">
            <form class="layui-form layui-form layui-form-pane">
                @include('admin.hall.gmcontrol._form')
            </form>
        </div>
    </div>
@endsection
@section('script')
    <script>
        layui.use(['layer','form'],function (index) {
            var form = layui.form;
            var layer = layui.layer;
            form.on('submit(form)', function(data){
                $.post("{{route('admin.gmcontrol.store')}}",data.field,function (result) {
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
        });
    </script>
@endsection

