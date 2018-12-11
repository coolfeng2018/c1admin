@extends('admin.base')
@section('content')
    <div class="layui-tab layui-tab-card">
        <ul class="layui-tab-title">
            <li  class=""  onclick="change(this)">新人奖励</li>
        </ul>
        <div class="layui-tab-content" style="height: 100%;">
            @can('hall.newaward.save')
                <div class="layui-input-inline" style="margin-bottom: 10px;"><button class="layui-btn layui-btn-sm" style="width: 100px" id="add" data-href="">添加</button></div>
                <div class="layui-input-inline" style="margin-bottom: 10px;"><button class="layui-btn layui-btn-sm" style="width: 100px" id="save" data-href="">保存</button></div>
            @endcan
            @can('hall.newaward.send')
                <div class="layui-input-inline" style="margin-bottom: 10px;"><button class="layui-btn layui-btn-sm " style="width:120px;" id="send">发送配置到服务器</button></div>
            @endcan

            <div id="contents">
                {{--<div class="layui-form-item">--}}
                    {{--<label class="layui-form-label">提示消息</label>--}}
                    {{--<div class="layui-input-block">--}}
                        {{--<textarea id="newbie_state" style="line-height: 32px" cols="64" rows="1">{{$data['newbie_state'] or ''}}</textarea>--}}
                    {{--</div>--}}
                {{--</div>--}}

                @foreach($data as $key=>$val)
                <div class="layui-form" name="fromRow" id="fromRow" style="margin-top: 5px">
                    <div class="layui-input-inline">
                        <select name="pid" id="pid" lay-filter="type" class="layui-input row" lay-verify="required">
                            <option value="{{$val['item_id']}}" selected >{{$list[$val['item_id']] or ''}}</option>
                            @include('admin.hall.newaward._option')
                        </select>
                    </div>
                    <div class="layui-input-inline" style="width:40px">(元)</div>
                    <div class="layui-input-inline">
                        <input type="text" name="row" id="money"  class="layui-input row" value="{{$val['count'] or ''}}" style="width: 300px;" placeholder="元">
                    </div>
                    <div class="layui-input-inline"><button id="del" onclick="del(this)" class="layui-btn layui-btn-sm">删除</button></div>
                </div>
                @endforeach

            </div>


        </div>
    </div>
    <div hidden id="from">
        <div class="layui-form" name="fromRow" id="fromRow" style="margin-top: 5px">
            <div class="layui-input-inline">
                <select name="pid" id="pid" lay-filter="type" class="layui-input row" lay-verify="required">
                    @include('admin.hall.newaward._option')
                </select>
            </div>
            <div class="layui-input-inline" style="width:40px">(元)</div>
            <div class="layui-input-inline">
                <input type="text" name="row" id="money"  class="layui-input row" value="" style="width: 300px;" placeholder="元">
            </div>
            <div class="layui-input-inline"><button id="del" onclick="del(this)" class="layui-btn layui-btn-sm">删除</button></div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        layui.use(['layer','table','form'],function () {
            var layer = layui.layer;
            var form = layui.form;

            //保存
            $("#save").click(function () {
            var data = new Array();
            var input = $("#contents").find("div[name=\'fromRow\']");
           // var msg = $("#newbie_state").val();
            for (var i = 0; i < input.length; i++) {
                var rowObj = $(input[i]).find('.row');
                data[i] = new Array();
                for (var j = 0; j < rowObj.length; j++) {
                    data[i][j] = $(rowObj[j]).val();
                }
            }
            // console.log(data);
            data = JSON.stringify(data);
            $.post("{{route('admin.newaward.save')}}", {data: data}, function (res) {
                if (res.code == 0){
                    layer.msg(res.msg,{icon:1})
                }else {
                    layer.msg(res.msg,{icon:2})
                }
            });
            });

            //发送到服务器配置
            $("#send").click(function(){
                $.post("{{route('admin.newaward.send')}}",{}, function (res) {
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
                form.render('select');
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
