@extends('admin.base')
@section('content')
    <div class="layui-tab layui-tab-card">
        @can('store.brnnstore.save')
            <div class="layui-input-inline" style="margin-bottom: 10px;"><button class="layui-btn layui-btn-sm" style="width: 100px" id="save" data-href="">保存</button></div>
        @endcan
        @can('store.brnnstore.send')
            <div class="layui-input-inline" style="margin-bottom: 10px;"><button class="layui-btn layui-btn-sm" style="width: 130px" id="send" data-href="">发送到服务器配置</button></div>
        @endcan
        <ul class="layui-tab-title">
            @if(!empty($list['data']))
            @foreach($list['data'] as $key => $val)
            <li  class=" {{$key=='brnn_normal'?'layui-this':''}}" value="{{$key or ''}}" onclick="change(this)">{{$val or ''}}</li>
            @endforeach
            @endif
        </ul>
        <div class="layui-tab-content" style="height: 100%;">
            @if(!empty($data))
            @foreach($data as $key => $val)
            <div class="layui-tab-item {{$key=='brnn_normal'?'layui-show':''}}" id="{{$key or ''}}" name="{{$key or ''}}">
                    {{--  @foreach($data[$k] as $index => $val)--}}
                    <table class="layui-table" lay-size="lg">
                        <tr id="cattle_fee">
                            <td style="width: 100px;"><b>抽水</b></td>
                            <td>
                                <div class="layui-form-item" >
                                    <label for="" class="layui-form-label" style="width: 120px;">实时抽水(元)</label>
                                    <div class="layui-input-inline">
                                        <input type="number" id="fee_coins" name="fee_coins" value="{{$val['fee_coins'] or ''}}" lay-verify="required" placeholder="0" class="layui-input" style="background: #F0F0F0" disabled >
                                    </div>
                                </div>

                                <div class="layui-form-item">
                                    <label for="" class="layui-form-label" style="width: 120px;">抽水概率(万分比)</label>
                                    <div class="layui-input-inline">
                                        <input type="number" id="fee_rate" name="fee_rate" value="{{$val['fee_rate'] or ''}}" lay-verify="required" placeholder="0" class="layui-input" >
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr id="cattle_base">
                            <td style="width: 100px;"><b>库存一（基础库存）</b></td>
                            <td>
                                <div class="layui-form-item" >
                                    <label for="" class="layui-form-label" style="width: 120px;">实时库存1(元)</label>
                                    <div class="layui-input-inline">
                                        <input type="number" id="base_curr_rate" name="base_curr_rate" value="{{$val['base_curr_rate'] or ''}}" lay-verify="required" placeholder="0" class="layui-input" style="background: #F0F0F0" readonly="readonly" >
                                    </div>
                                </div>

                                <div class="layui-form-item">
                                    <label for="" class="layui-form-label" style="width: 120px;">基础实时控制率（万分比）</label>
                                    <div class="layui-input-inline">
                                        <input type="number" id="curr_control_rate" name="curr_control_rate" value="{{$val['curr_control_rate'] or ''}}" lay-verify="required" readonly="readonly" style="background: #F0F0F0" placeholder="0" class="layui-input" >
                                    </div>
                                </div>
                                <div class="layui-form-item">
                                    <label for="" class="layui-form-label" style="width: 120px;">目标库存1(元)</label>
                                    <div class="layui-input-inline">
                                        <input type="number" id="base_goal" name="base_goal" value="{{$val['base_goal'] or ''}}" lay-verify="required" placeholder="0" class="layui-input" >
                                    </div>
                                </div>
                                <div class="layui-form-item">
                                    <label for="" class="layui-form-label" style="width: 120px;">警报值(元)</label>
                                    <div class="layui-input-inline">
                                        <input type="number" id="base_warn" name="base_warn" value="{{$val['base_warn'] or ''}}" lay-verify="required" placeholder="0" class="layui-input" >
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr id="cattle_award">
                            <td style="width: 100px;"><b>库存二（奖励库存）</b></td>
                            <td>
                                <div class="layui-form-item" >
                                    <label for="" class="layui-form-label" style="width: 120px;">实时库存2(元)</label>
                                    <div class="layui-input-inline">
                                        <input type="number" id="award_coins" name="award_coins" value="{{$val['award_coins'] or ''}}" lay-verify="required" placeholder="0" class="layui-input" style="background: #F0F0F0" disabled >
                                    </div>
                                </div>

                                <div class="layui-form-item">
                                    <label for="" class="layui-form-label" style="width: 120px;">抽水率（万分比）</label>
                                    <div class="layui-input-inline">
                                        <input type="number" id="award_rate" name="award_rate" value="{{$val['award_rate'] or ''}}" lay-verify="required" placeholder="0" class="layui-input" >
                                    </div>
                                </div>
                                <div class="layui-form-item">
                                    <label for="" class="layui-form-label" style="width: 120px;">警报值(元)</label>
                                    <div class="layui-input-inline">
                                        <input type="number" id="award_warn" name="award_warn" value="{{$val['award_warn'] or ''}}" lay-verify="required" placeholder="0" class="layui-input" >
                                    </div>
                                </div>
                                <div class="layui-form-item">
                                    <label for="" class="layui-form-label" style="width: 120px;">触发概率（万分比）</label>
                                    <div class="layui-input-inline">
                                        <input type="number" id="tigger_rate" name="tigger_rate" value="{{$val['tigger_rate'] or ''}}" lay-verify="required" placeholder="0" class="layui-input" >
                                    </div>
                                </div>

                            </td>
                        </tr>
                        <tr id="cattle_award">
                            <td style="width: 100px;"><b>单局输钱限制</b></td>
                            <td>
                                <div class="layui-form-item">
                                    <label for="" class="layui-form-label" style="width: 120px;">单局最大输钱值(元)</label>
                                    <div class="layui-input-inline">
                                        <input type="number" id="lose_limit" name="lose_limit" value="{{$val['lose_limit'] or ''}}" lay-verify="required" placeholder="0" class="layui-input" >
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
                console.log(data);
               // var data = JSON.stringify(data);
                $.post("{{route('admin.brnnstore.save')}}", {data: data, list: gameList}, function (res) {
                    if (res.code == 0){
                        layer.msg(res.msg,{icon:1})
                    }else {
                        layer.msg(res.msg,{icon:2})
                    }
                });
            });

            //发送到服务器配置
            $("#send").click(function(){
                $.post("{{route('admin.brnnstore.send')}}",{}, function (res) {
                    if (res.code == 0){
                        layer.msg(res.msg,{icon:1})
                    }else {
                        layer.msg(res.msg,{icon:2})
                    }
                });
            });
        });

        /**
         * 标签切换
         * @param obj
         */
        function change(obj){
            $("#gameType").attr('value', $(obj).attr('value'));
        }
    </script>

@endsection
