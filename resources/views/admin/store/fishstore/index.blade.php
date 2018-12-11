@extends('admin.base')
@section('content')
    <div class="layui-tab layui-tab-card">
        <ul class="layui-tab-title">
            @if(!empty($list['data']))
            @foreach($list['data'] as $key => $val)
            <li  class=" {{$key=='600'?'layui-this':''}}" value="{{$key or ''}}" onclick="change(this)">{{$val or ''}}</li>
            @endforeach
            @endif
        </ul>
        <div class="layui-tab-content" style="height: 100%;">
            @can('store.fishstore.save')
                <div class="layui-input-inline" style="margin-bottom: 10px;"><button class="layui-btn layui-btn-sm" style="width: 100px" id="save" data-href="">保存</button></div>
            @endcan
            @can('store.fishstore.send')
            <div class="layui-input-inline" style="margin-bottom: 10px;"><button class="layui-btn layui-btn-sm" style="width: 130px" id="send" data-href="">发送到服务器配置</button></div>
            @endcan
            @if(!empty($data))
            @foreach($data as $key => $val)
            <div class="layui-tab-item {{$key=='600'?'layui-show':''}}" id="{{$key or ''}}" name="{{$key or ''}}">
                    {{--  @foreach($data[$k] as $index => $val)--}}
                    <table class="layui-table" lay-size="lg">
                        <tr id="pool_sysback">
                            <td style="width: 100px;"><b>系统回收(抽水)</b></td>
                            <td>
                                <div class="layui-form-item" >
                                    <label for="" class="layui-form-label" style="width: 120px;">实时数据(元)</label>
                                    <div class="layui-input-inline">
                                        <input type="number" id="sysback" name="sysback" value="{{$val['sysback'] or ''}}" lay-verify="required" placeholder="0" class="layui-input" style="background: #F0F0F0" disabled >
                                    </div>
                                </div>

                                <div class="layui-form-item">
                                    <label for="" class="layui-form-label" style="width: 120px;">贡献比例(万分比)</label>
                                    <div class="layui-input-inline">
                                        <input type="number" id="sysback_fee_rate" name="sysback_fee_rate" value="{{$val['sysback_fee_rate'] or ''}}" lay-verify="required" placeholder="0" class="layui-input" >
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr id="pool_control">
                            <td style="width: 100px;"><b>调控奖池</b></td>
                            <td>
                                <div class="layui-form-item" >
                                    <label for="" class="layui-form-label" style="width: 120px;">实时数据(元)</label>
                                    <div class="layui-input-inline">
                                        <input type="number" id="control" name="control" value="{{$val['control'] or ''}}" lay-verify="required" placeholder="0" class="layui-input" style="background: #F0F0F0" disabled >
                                    </div>
                                </div>

                                <div class="layui-form-item">
                                    <label for="" class="layui-form-label" style="width: 120px;">贡献比例(万分比)</label>
                                    <div class="layui-input-inline">
                                        <input type="number" id="control_fee_rate" name="control_fee_rate" value="{{$val['control_fee_rate'] or ''}}" lay-verify="required" placeholder="0" class="layui-input" >
                                    </div>
                                </div>
                                {{--<div class="layui-form-item">--}}
                                    {{--<label for="" class="layui-form-label" style="width: 120px;">初始值</label>--}}
                                    {{--<div class="layui-input-inline">--}}
                                        {{--<input type="number" id="control_base_goal" name="control_base_goal" value="{{$val['control_base_goal']}}" lay-verify="required" placeholder="0" class="layui-input" >--}}
                                    {{--</div>--}}
                                {{--</div>--}}
                                <div class="layui-form-item">
                                    <label for="" class="layui-form-label" style="width: 120px;">警报值(元)</label>
                                    <div class="layui-input-inline">
                                        <input type="number" id="control_base_warn" name="control_base_warn" value="{{$val['control_base_warn'] or ''}}" lay-verify="required" placeholder="0" class="layui-input" >
                                    </div>
                                </div>
                                <div class="layui-form-item">
                                    <label for="" class="layui-form-label" style="width: 120px;">阈值(元)</label>
                                    <div class="layui-input-inline">
                                        <input type="number" id="control_threshold" name="control_threshold" value="{{$val['control_threshold'] or ''}}" lay-verify="required" placeholder="0" class="layui-input" >
                                    </div>
                                </div>
                                <div class="layui-form-item">
                                    <label for="" class="layui-form-label" style="width: 120px;">系数(元)</label>
                                    <div class="layui-input-inline">
                                        <input type="number" id="control_factor" name="control_factor" value="{{$val['control_factor'] or ''}}" lay-verify="required" placeholder="0" class="layui-input" >
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr id="pool_adjust">
                            <td style="width: 100px;"><b>调整奖池</b></td>
                            <td>
                                <div class="layui-form-item" >
                                    <label for="" class="layui-form-label" style="width: 120px;">实时数据(元)</label>
                                    <div class="layui-input-inline">
                                        <input type="number" id="adjust" name="adjust" value="{{$val['adjust'] or ''}}" lay-verify="required" placeholder="0" class="layui-input" style="background: #F0F0F0" disabled >
                                    </div>
                                </div>

                                <div class="layui-form-item">
                                    <label for="" class="layui-form-label" style="width: 120px;">贡献比例(万分比)</label>
                                    <div class="layui-input-inline">
                                        <input type="number" id="adjust_fee_rate" name="adjust_fee_rate" value="{{$val['adjust_fee_rate'] or ''}}" lay-verify="required" placeholder="0" class="layui-input" >
                                    </div>
                                </div>
                                <div class="layui-form-item">
                                    <label for="" class="layui-form-label" style="width: 120px;">警报值(元)</label>
                                    <div class="layui-input-inline">
                                        <input type="number" id="adjust_base_warn" name="adjust_base_warn" value="{{$val['adjust_base_warn'] or ''}}" lay-verify="required" placeholder="0" class="layui-input" >
                                    </div>
                                </div>
                                <div class="layui-form-item">
                                    <label for="" class="layui-form-label" style="width: 120px;">触发概率</label>
                                    <div class="layui-input-inline">
                                        <input type="number" id="adjust_trigger_rate" name="adjust_trigger_rate" value="{{$val['adjust_trigger_rate'] or ''}}" lay-verify="required" placeholder="0" class="layui-input" >
                                    </div>
                                </div>
                                <div class="layui-form-item">
                                    <label for="" class="layui-form-label" style="width: 120px;">增加命中率</label>
                                    <div class="layui-input-inline">
                                        <input type="number" id="adjust_add_rate" name="adjust_add_rate" value="{{$val['adjust_add_rate'] or ''}}" lay-verify="required" placeholder="0" class="layui-input" >
                                    </div>
                                </div>


                            </td>
                        </tr>
                        <tr id="pool_addup">
                            <td style="width: 100px;"><b>累计奖池</b></td>
                            <td>
                                <div class="layui-form-item" >
                                    <label for="" class="layui-form-label" style="width: 120px;">实时数据(元)</label>
                                    <div class="layui-input-inline">
                                        <input type="number" id="addup" name="addup" value="{{$val['addup'] or ''}}" lay-verify="required" placeholder="0" class="layui-input" style="background: #F0F0F0" disabled >
                                    </div>
                                </div>

                                <div class="layui-form-item">
                                    <label for="" class="layui-form-label" style="width: 120px;">贡献比例(万分比)</label>
                                    <div class="layui-input-inline">
                                        <input type="number" id="addup_fee_rate" name="addup_fee_rate" value="{{$val['addup_fee_rate'] or ''}}" lay-verify="required" placeholder="0" class="layui-input" >
                                    </div>
                                </div>
                                <div class="layui-form-item">
                                    <label for="" class="layui-form-label" style="width: 120px;">初始值(元)</label>
                                    <div class="layui-input-inline">
                                        <input type="number" id="addup_base_goal" name="addup_base_goal" value="{{$val['addup_base_goal'] or ''}}" lay-verify="required" placeholder="0" class="layui-input" >
                                    </div>
                                </div>
                                <div class="layui-form-item">
                                    <label for="" class="layui-form-label" style="width: 120px;">阀值(元)</label>
                                    <div class="layui-input-inline">
                                        <input type="number" id="addup_base_warn" name="addup_base_warn" value="{{$val['addup_base_warn'] or ''}}" lay-verify="required" placeholder="0" class="layui-input" >
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </table>
                    {{--@endforeach--}}
            </div>
            @endforeach
            @endif

        </div>
    </div>
    <input type="hidden" id="gameType" value="600">
    <input type="hidden" id="listkey" value="{{$list['key'] or ''}}">
@endsection

@section('script')
    <script>
        layui.use(['layer','table','form'],function () {
            var layer = layui.layer;
            //保存
            $("#save").click(function () {
                var gameList = $("#listkey").val();
                gameList = JSON.parse( gameList );
                var data = {};
                for (var k = 0; k < gameList.length; k++) {
                    var gameType = gameList[k];
                    data[gameType] = {};
                    var input = $("#" + gameType).find("input");
                    for (var i = 0; i < input.length; i++) {
                        data[gameType][$(input[i]).attr('id')] =  $(input[i]).val();
                    }
                }
               // var data = JSON.stringify(data);
                $.post("{{route('admin.fishstore.save')}}", {data: data, list: gameList}, function (res) {
                    if (res.code == 0){
                        layer.msg(res.msg,{icon:1})
                    }else {
                        layer.msg(res.msg,{icon:2})
                    }
                });
            });

            //发送到服务器配置
            $("#send").click(function(){
                $.post("{{route('admin.fishstore.send')}}",{}, function (res) {
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
/*            $("#add").click(function () {
                var typeid = $("#gameType").val();
                $("#"+typeid).append($("#from").html());
            });*/


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
