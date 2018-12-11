@extends('admin.base')
@section('content')
    <div class="layui-tab layui-tab-card">
        <ul class="layui-tab-title">
            <li  class=""  onclick="change(this)">扑鱼VIP炮台配置</li>
        </ul>
        <div class="layui-tab-content" style="height: 100%;">
            @can('config.guns.save')
                <div class="layui-input-inline" style="margin-bottom: 10px;"><button class="layui-btn layui-btn-sm" style="width: 100px" id="add" data-href="">添加</button></div>
                <div class="layui-input-inline" style="margin-bottom: 10px;"><button class="layui-btn layui-btn-sm" style="width: 100px" id="save" data-href="">保存</button></div>
            @endcan
            @can('config.guns.send')
                    <div class="layui-input-inline" style="margin-bottom: 10px;"><button class="layui-btn layui-btn-sm " style="width:120px;" id="send">发送配置到服务器</button></div>
            @endcan
            <div id="contents">
                @foreach($data as $key => $val)
                <div class="layui-form" name="fromRow" id="fromRow">
                    <div class="layui-input-inline">
                        <input type="number" name="row" id="id"  class="layui-input"  value="{{$val['id']}}" placeholder="id">
                    </div>
                    <div class="layui-input-inline">
                        <input type="number" name="row" id="vip_level"  class="layui-input"  value="{{$val['vip_level']}}" placeholder="vip等级">
                    </div>
                    <div class="layui-input-inline">
                        <input type="text" name="row" id="name"  class="layui-input"  value="{{$val['name']}}" placeholder="名称">
                    </div>
                    <div class="layui-input-inline">
                        <input type="number" name="row" id="power"  class="layui-input" value="{{$val['power']}}"  placeholder="power">
                    </div>
                    <div class="layui-input-inline"><button id="del" onclick="del(this)" class="layui-btn layui-btn-sm">删除</button></div>
                </div> <br>
                @endforeach
            </div>


        </div>
    </div>

    <div hidden id="from">
        <div class="layui-form" name="fromRow" id="fromRow">
            <div class="layui-input-inline">
                <input type="number" name="row" id="id"  class="layui-input"  value="" placeholder="id">
            </div>
            <div class="layui-input-inline">
                <input type="number" name="row" id="vip_level"  class="layui-input"  value="" placeholder="vip等级">
            </div>
            <div class="layui-input-inline">
                <input type="text" name="row" id="name"  class="layui-input"  value="" placeholder="名称">
            </div>
            <div class="layui-input-inline">
                <input type="number" name="row" id="power"  class="layui-input" value=""  placeholder="power">
            </div>
            <div class="layui-input-inline"><button id="del" onclick="del(this)" class="layui-btn layui-btn-sm">删除</button></div>
        </div> <br>
    </div>
@endsection

@section('script')
    <script>
        layui.use(['layer','table','form'],function () {
            var layer = layui.layer;

            //保存
            $("#save").click(function () {
            var data = {}
            var input = $("#contents").find("div[name=\'fromRow\']");
            for (var i = 0; i < input.length; i++) {
                data[i] = {}
                data[i]['id'] = $(input[i]).find("input[id='id']").val();
                data[i]['vip_level'] = $(input[i]).find("input[id='vip_level']").val();
                data[i]['name'] = $(input[i]).find("input[id='name']").val();
                data[i]['power'] = $(input[i]).find("input[id='power']").val();
            }
            $.post("{{route('admin.guns.save')}}", {data: data}, function (res) {
                if (res.code == 0){
                    layer.msg(res.msg,{icon:1})
                }else {
                    layer.msg(res.msg,{icon:2})
                }
            });
            });

            //发送到服务器配置
            $("#send").click(function(){
                $.post("{{route('admin.guns.send')}}",{}, function (res) {
                    if (res.code == 0){
                        layer.msg(res.msg,{icon:1})
                    }else {
                        layer.msg(res.msg,{icon:2})
                    }
                });
            });

            /**
             * 添加表单触发方法
             */
            $("#add").click(function () {
                $("#contents").append($("#from").html());
            });


        });

        /**
         * 标签切换
         * @param obj
         */
        function change(obj){
            $("#gameType").attr('value', $(obj).attr('value'));
        }

        /**
         * 删除表单
         * @param obj
         */
        function del(obj){
            $(obj).parent().parent().remove();
        }
    </script>

@endsection
