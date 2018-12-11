


@extends('admin.base')
@section('content')
    <div class="layui-tab layui-tab-card">
            <div class="layui-input-inline" style="margin-bottom: 10px;"><button class="layui-btn layui-btn-sm" style="width: 100px" id="save" data-href="">保存</button></div>
        <ul class="layui-tab-title">
            @if(!empty($list))
                @foreach($list as $key => $val)
                    <li  class=" {{$key=='complaint'?'layui-this':''}}" value="{{$key or ''}}" onclick="change(this)">{{$val or ''}}</li>
                @endforeach
            @endif
        </ul>
        <div class="layui-tab-content" style="height: 100%;">
                    <div class="layui-tab-item layui-show" id="complaint" name="complaint">
                        <div class="layui-form" name="fromRow" id="fromRow">
                            <div class="layui-form-item" >
                                <label for="" class="layui-form-label" style="width: 120px;">微信号</label>
                                <div class="layui-input-inline">
                                    <input type="text" name="wx" id="wx"  class="layui-input"  value="{{$data['wx'] or ''}}" placeholder="微信号">
                                </div>
                            </div>
                            <div class="layui-form-item" >
                                <label for="" class="layui-form-label" style="width: 120px;">金额</label>
                                <div class="layui-input-inline">
                                    <input type="text" name="money" id="money"  class="layui-input"  value="{{$data['money'] or ''}}" placeholder="微信号">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="layui-tab-item }}" id="limit" name="limit">
                        <div class="layui-form" name="fromRow" id="fromRow">
                            <div class="layui-form-item" >
                                <label for="" class="layui-form-label" style="width: 120px;">ip限制</label>
                                <div class="layui-input-inline">
                                    <input type="text" name="ip_num" id="ip_num"  class="layui-input"  value="{{$data['ip_num'] or ''}}" placeholder="微信号">
                                </div>
                            </div>
                            <div class="layui-form-item" >
                                <label for="" class="layui-form-label" style="width: 120px;">设备码限制</label>
                                <div class="layui-input-inline">
                                    <input type="text" name="dev_num" id="dev_num"  class="layui-input"  value="{{$data['dev_num'] or ''}}" placeholder="微信号">
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
        </div>
    @endsection

    @section('script')
        <script>
            layui.use(['layer','table','form'],function () {
                var layer = layui.layer;
                $("#save").click(function () {
                    var data = {};
                    data['wx']      = $("#wx").val();
                    data['money']   = $("#money").val();
                    data['ip_num']  = $("#ip_num").val();
                    data['dev_num'] = $("#dev_num").val();
                    $.post("{{route('admin.complaint.save')}}", {data: data}, function (res) {
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
