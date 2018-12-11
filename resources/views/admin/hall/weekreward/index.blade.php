@extends('admin.base')
@section('content')
    <br>
    @can('hall.weekreward.save')
        <div class="layui-input-inline" style="margin-bottom: 10px;"><button class="layui-btn layui-btn-sm" style="width: 100px" id="save" data-href="">保存</button></div>
    @endcan
    @can('hall.weekreward.send')
        <div class="layui-input-inline" style="margin-bottom: 10px;"><button class="layui-btn layui-btn-sm" style="width: 130px" id="send" data-href="">发送到服务器配置</button></div>
    @endcan

    <div class="layui-tab layui-tab-card">
        <ul class="layui-tab-title">
            @foreach($list['data'] as $key => $val)
                <li  class=" {{$key=='weekreward'?'layui-this':''}}" value="{{$key}}" onclick="change(this)">{{$val or ''}}</li>
            @endforeach
        </ul>
        <div class="layui-tab-content" style="height:100%;">
            @can('config.hundred.save')
                {{--<div class="layui-input-inline" style="margin-bottom: 10px;"><button class="layui-btn layui-btn-sm" style="width: 100px" id="save" data-href="">保存</button></div>--}}
            @endcan
                <div class="layui-tab-item layui-show" name="line_rate">
                    <div class="layui-input-inline" style="margin-bottom: 10px;"><button class="layui-btn layui-btn-sm add" style="width: 100px"  data-href="">添加</button></div>
                    <table style="width: 350px;" lay-size="sg">
                        <tr id="pool_sysback" style="line-height: 40px">
                            <td style="width: 110px;"><b>流水下限值(元)</b></td>
                            <td style="width: 110px;"><b>流水上限值(元)</b></td>
                            <td style="width: 110px;"><b>返水系数(百分比)</b></td>
                        </tr>
                    </table>

                    <div id="line_rate">
                        <div class="layui-tab-item layui-show weekreward">
                            <div id="weekreward">
                                @foreach($data as $key=>$val)
                                <div class="layui-form fromRow" name="fromRow" style="margin-top: 10px">
                                    <div class="layui-input-inline">
                                        <input type="number" name="row" id="coins_low"  class="layui-input" style="width: 100px;" value="{{$val['coins_low'] or ''}}">
                                    </div> -
                                    <div class="layui-input-inline">
                                        <input type="number" name="row" id="coins_hight"  class="layui-input" style="width: 100px;" value="{{$val['coins_hight'] or ''}}">
                                    </div> -
                                    <div class="layui-input-inline">
                                        <input type="number" name="row" id="back_rate"  class="layui-input" value="{{$val['back_rate'] or ''}}">
                                    </div>
                                    <div class="layui-input-inline"><button id="del1" onclick="del(this)" class="layui-btn layui-btn-sm">删除</button></div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

        </div>
    </div>


    <div hidden id="from-weekreward">
        <div class="layui-form fromRow" name="fromRow" style="margin-top: 10px">
            <div class="layui-input-inline">
                <input type="text" name="row" id="coins_low"  class="layui-input" style="width: 100px;" value="{{$val['min'] or ''}}">
            </div> -
            <div class="layui-input-inline">
                <input type="text" name="row" id="coins_hight"  class="layui-input" style="width: 100px;" value="{{$val['max'] or ''}}">
            </div> -
            <div class="layui-input-inline">
                <input type="text" name="row" id="back_rate"  class="layui-input" value="{{$val['str'] or ''}}">
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
                var list = {};
                var fromRow = $("#weekreward").find('.fromRow');
                for (var i = 0; i < fromRow.length; i++) {
                    list[i] = {};
                    var input = $(fromRow[i]).find('input');
                    for (var j=0;j<input.length;j++){
                        list[i][$(input[j]).attr('id')] = $(input[j]).val();
                    }
                }
                $.post("{{route('admin.weekreward.save')}}", {data:list}, function (res) {
                    if (res.code == 0){
                        layer.msg(res.msg,{icon:1})
                    }else {
                        layer.msg(res.msg,{icon:2})
                    }
                });
            });


            //发送到服务器配置
            $("#send").click(function(){
                $.post("{{route('admin.weekreward.send')}}",{}, function (res) {
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
            $(".add").click(function () {
                $("#weekreward").append($("#from-weekreward").html());
            });

        });


        /**
         * 删除表单
         * @param obj
         */
        function del(obj){
            $(obj).parent().parent().remove();
        }
    </script>

@endsection