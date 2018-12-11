@extends('admin.base')
@section('content')
    <div class="layui-tab layui-tab-card">
        <ul class="layui-tab-title">
            <li  class=""  onclick="change(this)">微信客服配置</li>
        </ul>
        <div class="layui-tab-content" style="height: 100%;">
            @can('hall.recharge.save')
                <div class="layui-input-inline" style="margin-bottom: 10px;"><button class="layui-btn layui-btn-sm" style="width: 100px" id="add" data-href="">添加</button></div>
                <div class="layui-input-inline" style="margin-bottom: 10px;"><button class="layui-btn layui-btn-sm" style="width: 100px" id="save" data-href="">保存</button></div>
            @endcan

            <div id="contents">
                @foreach($data as $key => $val)
                    <div class="layui-form" name="fromRow" id="fromRow">
                        <div class="layui-input-inline">
                            <input type="text" name="name" id="name"  class="layui-input"  value="{{$val['name'] or ''}}" placeholder="name">
                        </div>
                        <div class="layui-input-inline">
                            <input type="text" name="wx" id="wx"  class="layui-input" value="{{$val['wx'] or ''}}" placeholder="微信号">
                        </div>
                        <div class="layui-input-inline">
                            <input type="text" name="desc" id="desc"  class="layui-input" value="{{$val['desc'] or ''}}" style="width: 300px;" placeholder="备注">
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
                <input type="text" name="name" id="name"  class="layui-input"  value="" placeholder="name">
            </div>
            <div class="layui-input-inline">
                <input type="text" name="wx" id="wx"  class="layui-input" value="" placeholder="微信号">
            </div>
            <div class="layui-input-inline">
                <input type="text" name="desc" id="desc"  class="layui-input" value="" style="width: 300px;" placeholder="备注">
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
                var data = {};
                var input = $("#contents").find("div[name=\'fromRow\']");
                for (var i = 0; i < input.length; i++) {
                    var rowObj = $(input[i]).find("input");
                    data[i] = {};
                    for (var j = 0; j < rowObj.length; j++) {
                        data[i][$(rowObj[j]).attr('id')] = $(rowObj[j]).val();
                    }
                }
                $.post("{{route('admin.wechatservice.save')}}", {data: data}, function (res) {
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
