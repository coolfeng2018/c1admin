@extends('admin.base')
@section('content')
    <br>
    @can('config.fishpowerrate.save')
        <div class="layui-input-inline" style="margin-bottom: 10px;"><button class="layui-btn layui-btn-sm" style="width: 100px" id="save" data-href="">保存</button></div>
    @endcan
    @can('config.fishpowerrate.send')
        <div class="layui-input-inline" style="margin-bottom: 10px;"><button class="layui-btn layui-btn-sm" style="width: 130px" id="send" data-href="">发送到服务器配置</button></div>
    @endcan

    <div class="layui-tab layui-tab-card">
        <ul class="layui-tab-title">
            @foreach($list['data'] as $key => $val)
                <li  class=" {{$key=='powerrate'?'layui-this':''}}" value="{{$key}}" onclick="change(this)">{{$val or ''}}</li>
            @endforeach
        </ul>
        <div class="layui-tab-content" style="height:100%;">
            @can('config.hundred.save')
                <div class="layui-input-inline" style="margin-bottom: 10px;"><button class="layui-btn layui-btn-sm" style="width: 100px" id="add" data-href="">添加</button></div>
                {{--<div class="layui-input-inline" style="margin-bottom: 10px;"><button class="layui-btn layui-btn-sm" style="width: 100px" id="save" data-href="">保存</button></div>--}}
            @endcan


                <div class="layui-tab-item layui-show" name="powerrate">
                    <div id="powerrate">
                        @foreach($data['powerrate'] as $index => $val)
                            <div class="layui-form" name="fromRow" id="fromRow">
                                <div class="layui-input-inline">
                                    <input type="number" name="input" id="key"  class="layui-input" style="width: 100px;" value="{{$val['key'] or ''}}">
                                </div> -
                                <div class="layui-input-inline">
                                    <input type="number" name="input" id="val"  class="layui-input" style="width: 100px;" value="{{$val['val'] or ''}}">
                                </div>
                                <div class="layui-input-inline"><button id="del1" onclick="del(this)" class="layui-btn layui-btn-sm">删除</button></div>
                            </div>
                        @endforeach
                    </div>
                </div>

        </div>
    </div>

    <div hidden id="from">
        <div class="layui-form" name="fromRow" id="fromRow">
            <div class="layui-input-inline">
                <input type="number" name="input" id="key"  class="layui-input" style="width: 100px;" value="">
            </div> -
            <div class="layui-input-inline">
                <input type="number" name="input" id="val"  class="layui-input" style="width: 100px;" value="">
            </div>
            <div class="layui-input-inline"><button id="del1" onclick="del(this)" class="layui-btn layui-btn-sm">删除</button></div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        var layer = '';
        layui.use(['layer','table','form'],function () {
            layer = layui.layer;

            //保存
            $("#save").click(function () {
                var  fromRow= $("#powerrate").find("div[name='fromRow']");
                var list = {};
                for (var i=0;i<fromRow.length;i++){
                    var input = $(fromRow[i]).find("input");
                    list[i] = {};
                     for (var k=0;k<input.length;k++){
                         list[i][$(input[k]).attr('id')] = $(input[k]).val();
                     }
                }
                $.post("{{route('admin.fishpowerrate.save')}}", {data:list}, function (res) {
                    if (res.code == 0){
                        layer.msg(res.msg,{icon:1})
                    }else {
                        layer.msg(res.msg,{icon:2})
                    }
                });
            });


            //发送到服务器配置
            $("#send").click(function(){
                $.post("{{route('admin.fishpowerrate.send')}}",{}, function (res) {
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
                $("#powerrate").append($("#from").html());
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