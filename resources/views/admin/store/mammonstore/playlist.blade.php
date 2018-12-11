@extends('admin.base')
@section('content')
    <div class="layui-tab layui-tab-card">
        @can('store.mammonstore.save')
            <div class="layui-input-inline" style="margin-bottom: 10px;">
                <button class="layui-btn layui-btn-sm" style="width: 100px" id="save" data-href="">保存</button>
            </div>
        @endcan
        @can('store.mammonstore.send')
            <div class="layui-input-inline" style="margin-bottom: 10px;">
                <button class="layui-btn layui-btn-sm" style="width: 130px" id="send" data-href="">发送到服务器配置</button>
            </div>
        @endcan

        <div class="layui-form-item" style="height:50%;">

            <div>
                <form>
                    <div class="layui-form">
                        <div class="layui-form-item" id="radio">
                            <label for="" class="layui-form-label" style="width: 120px;">玩法开关</label>
                            <div class="layui-input-inline">
                                <input type="radio" name="switch" value="1" title="开" @if( isset($list['switch']) && $list['switch'] == '1' )checked=""@endif>
                                <input type="radio" name="switch" value="0" title="关" @if( isset($list['switch']) && $list['switch'] == '0' )checked=""@endif>
                            </div>
                        </div>
                    <table class="layui-table" id="test3" lay-filter="test3">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>玩法配置</th>
                            <th>基础触发率</th>
                        </tr>
                        @foreach($data as $k=>$v)
                            <tr>
                                <th>{{$k}}</th>
                                <th>{{$v}}</th>
                                <th>
                                    <div class="layui-input-inline">
                                        <input type="number"
                                               value="{{$list['room_type_rate'][$k] or ''}}"
                                                placeholder="0" class="layui-input room_type_rate"
                                                name="room_type_rate[{{$k}}]">
                                    </div>
                                </th>
                            </tr>
                        @endforeach



                        </thead>
                    </table>
                    <div class="layui-form-item" >
                        <label for="" class="layui-form-label" style="width: 120px;">最低触发金额(元)</label>
                        <div class="layui-input-inline">
                            <input type="number" name="tigger_coins"  value="{{$list['tigger_coins']/100}}" lay-verify="required" placeholder="0" class="layui-input"  >
                        </div>
                    </div>

                    <div class="layui-form-item">
                        <label for="" class="layui-form-label" style="width: 120px;">倒计时(秒)</label>
                        <div class="layui-input-inline">
                            <input type="number"  name="countdown_time" value="{{$list['countdown_time'] or ''}}" lay-verify="required" placeholder="0" class="layui-input" >
                        </div>
                    </div>

                    <div class="layui-form-item">
                        <label for="" class="layui-form-label" style="width: 120px;">时间间隔(秒)</label>
                        <div class="layui-input-inline">
                            <input type="number" name="interval" value="{{$list['interval'] or ''}}" lay-verify="required" placeholder="0" class="layui-input" >
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@section('script')
    <script>


        layui.use(['layer', 'table', 'form'], function () {
            var layer = layui.layer;
            //保存
            $("#save").click(function () {
                var data = $('form').serializeArray();
                $.post("{{route('admin.mammon.playsave')}}", data, function (res) {
                    if (res.code == 0) {
                        layer.msg(res.msg, {icon: 1})
                    } else {
                        layer.msg(res.msg, {icon: 2})
                    }
                });
            });

            //发送到服务器配置
            $("#send").click(function () {
                $.post("{{route('admin.mammon.playsend')}}", {}, function (res) {
                    if (res.code == 0) {
                        layer.msg(res.msg, {icon: 1})
                    } else {
                        layer.msg(res.msg, {icon: 2})
                    }
                });
            });



        });


    </script>

@endsection
