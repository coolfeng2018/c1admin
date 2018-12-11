@extends('admin.base')
@section('content')
    <div class="layui-tab layui-tab-card">
        <ul class="layui-tab-title">
            @if(!empty($data))
                @foreach($data as $key=>$val)
                    <li class="{{$key==600?'layui-this':''}}" value="{{$key or ''}}" >{{$list['game'][$key] or ''}}</li>
                @endforeach
            @endif
        </ul>
        <div class="layui-tab-content" style="height: 100%;">
            @if(!empty($data))
                @foreach($data as $key=>$val)
                    <div class="layui-tab-item {{$key=='600'?'layui-show':''}}" val="123" id="{{$key}}">
                        <div class="layui-tab layui-tab-card">
                            <ul class="layui-tab-title">
                                @foreach($val as $k =>$v)
                                    <li  class=" {{$k=='adjust_rate'?'layui-this':''}}" value="{{$k}}" >{{$list['data'][$k]}}</li>
                                @endforeach
                            </ul>
                            <div class="layui-tab-content" style="height: 600px;">
                                @foreach($val as $k =>$v)
                                    <div class="layui-tab-item {{$k=='adjust_rate'?'layui-show':''}}" id="{{$k}}">
                                        <div class="layui-input-inline" style="margin-bottom: 10px;"><button class="layui-btn layui-btn-sm" style="width: 100px" onclick="add(this)" id="{{$k}}" data-href="">添加</button></div>
                                        <div class="layui-input-inline" style="margin-bottom: 10px;"><button class="layui-btn layui-btn-sm save" style="width: 100px"  data-href="">保存</button></div>
                                        <div class="layui-input-inline" style="margin-bottom: 10px;"><button class="layui-btn layui-btn-sm send" style="width: 130px"  data-href="">发送到服务器配置</button></div>

                                        <div id="{{$k}}">
                                            @foreach($v as $key => $val)
                                                <div class="layui-form" name="fromRow" id="fromRow">
                                                    <div class="layui-input-inline">
                                                        <input type="text" name="row" id="fish_score_min"  class="layui-input" style="width: 100px;" value="{{$val['fish_score_min']}}">
                                                    </div> -
                                                    <div class="layui-input-inline">
                                                        <input type="text" name="row" id="fish_score_max"  class="layui-input" style="width: 100px;" value="{{$val['fish_score_max']}}">
                                                    </div>
                                                    <div class="layui-input-inline" style="width:30px"></div>
                                                    <div class="layui-input-inline">
                                                        <input type="text" name="row" id="coefficient"  class="layui-input" value="{{$val['coefficient']}}" style="width: 100px;">
                                                    </div>
                                                    <div class="layui-input-inline"><button id="del1" onclick="del(this)" class="layui-btn layui-btn-sm">删除</button></div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>

    <div hidden id="from">
        <div class="layui-form" name="fromRow" id="fromRow">
            <div class="layui-input-inline">
                <input type="text" name="row" id="fish_score_min"  class="layui-input" style="width: 100px;" placeholder="min" value="">
            </div> -
            <div class="layui-input-inline">
                <input type="text" name="row" id="fish_score_max"  class="layui-input" style="width: 100px;" placeholder="max" value="">
            </div>
            <div class="layui-input-inline" style="width:30px"></div>
            <div class="layui-input-inline">
                <input type="text" name="row" id="coefficient"  class="layui-input" value="" style="width: 100px;" placeholder="概率系数">
            </div>
            <div class="layui-input-inline"><button id="del1" onclick="del(this)" class="layui-btn layui-btn-sm">删除</button></div>
        </div>
    </div>
    {{--<input type="hidden" id="field" value="600">--}}
    {{--<input type="hidden" id="type" value="lose">--}}
    <input type="hidden" id="listkey" value="{{$list['key'] or ''}}">
    <input type="hidden" id="gameField" value="{{$list['field'] or ''}}">
@endsection

@section('script')
    <script>
        layui.use(['layer','table','form'],function () {
            var layer = layui.layer;

            //保存
            $(".save").click(function () {
                var layer = layui.layer;
                var listkey = $("#listkey").val();
                var gameField = $("#gameField").val();
                listkey = JSON.parse(listkey);
                gameField = JSON.parse(gameField);
                var data = {};

                for (var j = 0; j < gameField.length; j++) {
                    var field = gameField[j];
                    var type = {};
                    for (var k = 0; k < listkey.length; k++) {
                        var gameType = listkey[k];

                        if ($("#" + field).find("div[id='" + gameType + "']").find("input[id='fish_score_min']").attr('name') == undefined) {
                            continue;
                        }

                        var input = $("#" + field).find("div[id='" + gameType + "']");
                        var temp = {};
                        for (var i = 0; i < input.length; i++) {

                            var rowObj = $(input[i]).find("div[name='fromRow']");

                            for (var l = 0; l < rowObj.length; l++) {
                                var arr = {};
                                arr['fish_score_min'] = $(rowObj[l]).find("input[id='fish_score_min']").val();
                                arr['fish_score_max'] = $(rowObj[l]).find("input[id='fish_score_max']").val();
                                arr['coefficient'] = $(rowObj[l]).find("input[id='coefficient']").val();
                                temp[l] = arr;
                            }
                        }
                        type[gameType] = temp;
                    }
                    data[field] = type
                }
                var list = JSON.stringify(listkey);
                var data = JSON.stringify(data);
                $.post("{{route('admin.fishcorrection.save')}}", {list: list, data: data}, function (res) {
                    if (res.code == 0) {
                        layer.msg(res.msg, {icon: 1})
                    } else {
                        layer.msg(res.msg, {icon: 2})
                    }
                });
            });

            //发送到服务器配置
            $(".send").click(function(){
                $.post("{{route('admin.fishcorrection.send')}}",{}, function (res) {
                    if (res.code == 0){
                        layer.msg(res.msg,{icon:1})
                    }else {
                        layer.msg(res.msg,{icon:2})
                    }
                });
            });

        });


        function add(obj){
            var id = $(obj).attr('id');
            $(obj).parent().nextAll("#"+id).append($("#from").html());
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
