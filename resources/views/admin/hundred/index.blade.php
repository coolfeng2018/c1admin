@extends('admin.base')
@section('content')
    <br>
    @can('config.hundred.save')
        <div class="layui-input-inline" style="margin-bottom: 10px;"><button class="layui-btn layui-btn-sm" style="width: 100px" id="save" data-href="">保存</button></div>
    @endcan
    @can('config.hundred.send')
        <div class="layui-input-inline" style="margin-bottom: 10px;"><button class="layui-btn layui-btn-sm" style="width: 130px" id="send" data-href="">发送到服务器配置</button></div>
    @endcan

    <div class="layui-tab layui-tab-card">
        <ul class="layui-tab-title">
            @foreach($list['data'] as $key => $val)
                <li  class=" {{$key=='hhdz'?'layui-this':''}}" value="{{$key}}" onclick="change(this)">{{$val or ''}}</li>
            @endforeach
        </ul>
        <div class="layui-tab-content" style="height:100%;">
            @can('config.hundred.save')
                <div class="layui-input-inline" style="margin-bottom: 10px;"><button class="layui-btn layui-btn-sm" style="width: 100px" id="add" data-href="">添加</button></div>
                {{--<div class="layui-input-inline" style="margin-bottom: 10px;"><button class="layui-btn layui-btn-sm" style="width: 100px" id="save" data-href="">保存</button></div>--}}
            @endcan

            @foreach($list['data'] as $k => $v)
                <div class="layui-tab-item {{$k=='hhdz'?'layui-show':''}}" name="{{$k}}">
                    <div id="{{$k}}">
                        @foreach($data[$k] as $index => $val)
                            <div class="layui-form" name="fromRow" id="fromRow">
                                <div class="layui-input-inline">
                                    <input type="text" name="row" id="min"  class="layui-input" style="width: 100px;" value="{{$val['min'] or ''}}">
                                </div> -
                                <div class="layui-input-inline">
                                    <input type="text" name="row" id="max"  class="layui-input" style="width: 100px;" value="{{$val['max'] or ''}}">
                                </div>
                                <div class="layui-input-inline" style="width:60px"></div>
                                <div class="layui-input-inline">
                                    <input type="text" name="row" id="str"  class="layui-input" value="{{$val['str'] or ''}}" style="width: 300px;" placeholder="用分号隔开，如  10；20；50；100；250">
                                </div>
                                <div class="layui-input-inline"><button id="del1" onclick="del(this)" class="layui-btn layui-btn-sm">删除</button></div>
                            </div>
                        @endforeach
                    </div>
                    <div>
                        <br><br>
                        <div><b>下注所需最低额度</b></div><br>
                        <input type="number" name="{{$k}}_min_bet" id="{{$k}}_min_bet"  class="layui-input" value="{{$minBet[$k.'_min_bet'] or ''}}" style="width: 200px;" placeholder="最小金额">
                        <br><br>
                        <div>在百人场配置中新增下注所需携带的最低额度，当携带金币不足该额度时，
                            点击下注toast提示“下注所需携带的最低额度为XXX”，点击【发送到服务器配置】后生效
                        </div>
                    </div>

                </div>

            @endforeach
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
                <input type="text" name="row" id="str"  class="layui-input" value="" style="width: 300px;" placeholder="用逗号隔开，如  10,20,50,100,250">
            </div>
            <div class="layui-input-inline "><button id="del1" onclick="del(this)" class="layui-btn layui-btn-sm">删除</button></div>
        </div>
    </div>

    <input type="hidden" id="gameType" value="hhdz">
    <input type="hidden" id="listkey" value="{{$list['key']}}">
@endsection

@section('script')
    <script>

        var layer = '';
        layui.use(['layer','table','form'],function () {
            layer = layui.layer;

            //保存
            $("#save").click(function () {
                var gameList = $("#listkey").val();
                gameList = JSON.parse( gameList );
                var data = [];
                var list = [];
                var minBet  = {};
                for (var k = 0; k < gameList.length; k++) {
                    var gameType = gameList[k];
                    if ($("#" + gameType).find("input[id='min']").attr('name') == undefined) {
                        continue;
                    }
                    var arr = [];
                    var input = $("#" + gameType).find("div[name=\'fromRow\']");
                    for (var i = 0; i < input.length; i++) {
                        var rowObj = $(input[i]).find("input[name='row']");
                        arr[i] = new Array();
                        for (var j = 0; j < rowObj.length; j++) {
                            arr[i][j] = $(rowObj[j]).val();
                        }
                    }
                    minBet[$("#"+gameType+'_min_bet').attr('id')] = $("#"+gameType+'_min_bet').val();
                    list.push(gameType);
                    data.push(arr);
                }
                var list = JSON.stringify(list);
                var data = JSON.stringify(data);
                $.post("{{route('admin.hundred.save')}}", {list: list, data: data,minBet:minBet}, function (res) {
                    if (res.code == 0){
                        // saveMinBets();
                        layer.msg(res.msg,{icon:1})
                    }else {
                        layer.msg(res.msg,{icon:2})
                    }
                });
            });


            //发送到服务器配置
            $("#send").click(function(){
                $.post("{{route('admin.hundred.send')}}",{}, function (res) {
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
                var typeid = $("#gameType").val();
                $("#"+typeid).append($("#from").html());
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