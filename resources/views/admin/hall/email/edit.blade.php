@extends('admin.base')
@section('content')
    <div class="layui-card">
        <div class="layui-card-body">
            <form class="layui-form layui-form layui-form-pane">
                <input type="number" name="id" value="{{$data['id'] or ''}}" style="display: none" >
                {{csrf_field()}}

                <div class="layui-form-item" id="uid">
                    <label for="" class="layui-form-label">收件人ID</label>
                    <div class="layui-input-block">
                        <input type="text" name="range" value="{{$data['range'] or ''}}"  style="background: #F0F0F0" readonly="readonly" width="60" lay-verify="required" placeholder="多个以逗号分割 如：1,2,3,4" class="layui-input">
                    </div>
                </div>

                <div class="layui-form-item" id="uid">
                    <label for="" class="layui-form-label">发件人昵称</label>
                    <div class="layui-input-block">
                        <input type="text" name="op_user" value="{{$data['op_user'] or ''}}"  style="background: #F0F0F0" readonly="readonly" width="60" lay-verify="required" placeholder="发件人昵称" class="layui-input" >
                    </div>
                </div>

                <div class="layui-form-item">
                    <label for="" class="layui-form-label">邮件标题</label>
                    <div class="layui-input-block">
                        <input type="text" name="title" value="{{$data['title'] or ''}}" lay-verify="required" autocomplete="off" placeholder="邮件标题" class="layui-input">
                    </div>
                </div>

                <div class="layui-form-item layui-form-text">
                    <label class="layui-form-label">邮件内容</label>
                    <div class="layui-input-block">
                        <textarea placeholder="请输入内容" class="layui-textarea" lay-verify="required" name="content">{{$data['content'] or ''}}</textarea>
                    </div>
                </div>



                <div class="layui-form-item">
                    <label for="" class="layui-form-label">金币</label>
                    <div class="layui-input-block">
                        <input type="number" name="coins" id="coins" value="{{$data['coins'] or ''}}" width="60" placeholder="金币" class="layui-input" >
                    </div>
                </div>


                <div class="layui-form-item">
                    <div class="layui-input-block">
                        <button type="submit" class="layui-btn" lay-submit="" lay-filter="form">确定</button>
                        {{--<a  class="layui-btn" href="{{route('admin.email')}}" >返 回</a>--}}
                    </div>
                </div>

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
                $.post("{{route('admin.email.update')}}",data.field,function (result) {
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

