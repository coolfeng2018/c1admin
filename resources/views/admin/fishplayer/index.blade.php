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
                            <li  class=" {{$k=='lose'?'layui-this':''}}" value="{{$k}}" >{{$list['data'][$k]}}</li>
                        @endforeach
                    </ul>
                    <div class="layui-tab-content" style="height: 600px;">
                        @foreach($val as $k =>$v)
                            <div class="layui-tab-item {{$k=='lose'?'layui-show':''}}" id="{{$k}}">
                                <div class="layui-input-inline" style="margin-bottom: 10px;"><button class="layui-btn layui-btn-sm" style="width: 100px" onclick="add(this)" id="{{$k}}" data-href="">添加</button></div>
                                <div class="layui-input-inline" style="margin-bottom: 10px;"><button class="layui-btn layui-btn-sm" style="width: 100px" onclick="save(this)" data-href="">保存</button></div>
                                <div class="layui-input-inline" style="margin-bottom: 10px;"><button class="layui-btn layui-btn-sm" style="width: 130px" onclick="send(this)" data-href="">发送到服务器配置</button></div>

                                <div id="{{$k}}">
                                    @foreach($v as $key => $val)
                                        <div class="layui-form" name="fromRow" id="fromRow">
                                            <div class="layui-input-inline">
                                                <input type="text" name="row" id="min"  class="layui-input" style="width: 100px;" value="{{$val['min']}}">
                                            </div> -
                                            <div class="layui-input-inline">
                                                <input type="text" name="row" id="max"  class="layui-input" style="width: 100px;" value="{{$val['max']}}">
                                            </div>
                                            <div class="layui-input-inline" style="width:60px"></div>
                                            <div class="layui-input-inline">
                                                <input type="text" name="row" id="str"  class="layui-input" value="{{$val['str']}}" style="width: 300px;">
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
                <input type="text" name="row" id="min"  class="layui-input" style="width: 100px;" value="">
            </div> -
            <div class="layui-input-inline">
                <input type="text" name="row" id="max"  class="layui-input" style="width: 100px;" value="">
            </div>
            <div class="layui-input-inline" style="width:60px"></div>
            <div class="layui-input-inline">
                <input type="text" name="row" id="str"  class="layui-input" value="" style="width: 300px;" placeholder="命中系数">
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


        });

        function send(){
            layui.use(['layer'],function () {
                var layer = layui.layer;
                $.post("{{route('admin.fishplayer.send')}}", {}, function (res) {
                    if (res.code == 0) {
                        layer.msg(res.msg, {icon: 1})
                    } else {
                        layer.msg(res.msg, {icon: 2})
                    }
                });
            })
        }


        //保存
        function save(obj){
            layui.use(['layer'],function () {
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

                        if ($("#" + field).find("div[id='" + gameType + "']").find("input[id='min']").attr('name') == undefined) {
                            continue;
                        }

                        var input = $("#" + field).find("div[id='" + gameType + "']");
                        var temp = {};
                        for (var i = 0; i < input.length; i++) {

                            var rowObj = $(input[i]).find("div[name='fromRow']");

                            for (var l = 0; l < rowObj.length; l++) {
                                var arr = {};
                                arr['min'] = $(rowObj[l]).find("input[id='min']").val();
                                arr['max'] = $(rowObj[l]).find("input[id='max']").val();
                                arr['str'] = $(rowObj[l]).find("input[id='str']").val();
                                temp[l] = arr;
                            }
                        }
                        type[gameType] = temp;
                    }
                    data[field] = type
                }
                var list = JSON.stringify(listkey);
                var data = JSON.stringify(data);
                $.post("{{route('admin.fishplayer.save')}}", {list: list, data: data}, function (res) {
                    if (res.code == 0) {
                        layer.msg(res.msg, {icon: 1})
                    } else {
                        layer.msg(res.msg, {icon: 2})
                    }
                });
            });
        }


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
