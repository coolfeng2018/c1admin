@extends('admin.base')
@section('content')
    <style>
        .ling{width: 350px;}
    </style>
    <div class="layui-tab layui-tab-card">
        <ul class="layui-tab-title">
            @if(!empty($list['data']))
            @foreach($list['data'] as $key => $val)
            <li  class=" {{$key=='brnn_normal'?'layui-this':''}}" value="{{$key or ''}}" onclick="change(this)">{{$val or ''}}</li>
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
            <div class="layui-tab-item {{$key=='brnn_normal'?'layui-show':''}}" id="{{$key or ''}}" name="{{$key or ''}}">
                    <table class="layui-table" lay-size="lg">
                        <tr id="NN_NUMBER">
                            <td style="width: 100px;"><b>牛牛概率</b></td>
                            <td>
                                <div class="layui-form-item">
                                    <label for="" class="layui-form-label" style="width: 120px;">	生成0副牛牛的概率</label>
                                    <div class="layui-input-inline">
                                        <input type="number" id="NO_NN" name="NN_NUMBER" value="{{$val['NN_NUMBER']['NO_NN'] or ''}}" lay-verify="required" placeholder="0" class="layui-input ling" >
                                    </div>
                                </div>
                                <div class="layui-form-item">
                                    <label for="" class="layui-form-label" style="width: 120px;">	生成1副牛牛的概率</label>
                                    <div class="layui-input-inline">
                                        <input type="number" id="ONE_NN" name="NN_NUMBER" value="{{$val['NN_NUMBER']['ONE_NN'] or ''}}" lay-verify="required" placeholder="0" class="layui-input ling">
                                    </div>
                                </div>
                                <div class="layui-form-item">
                                    <label for="" class="layui-form-label" style="width: 120px;">	生成2副牛牛的概率</label>
                                    <div class="layui-input-inline">
                                        <input type="number" id="TWO_NN" name="NN_NUMBER" value="{{$val['NN_NUMBER']['TWO_NN'] or ''}}" lay-verify="required" placeholder="0" class="layui-input ling">
                                    </div>
                                </div>
                                <div class="layui-form-item">
                                    <label for="" class="layui-form-label" style="width: 120px;">	生成3副牛牛的概率</label>
                                    <div class="layui-input-inline">
                                        <input type="number" id="THREE_NN" name="NN_NUMBER" value="{{$val['NN_NUMBER']['THREE_NN'] or ''}}" lay-verify="required" placeholder="0" class="layui-input ling">
                                    </div>
                                </div>
                                <div class="layui-form-item">
                                    <label for="" class="layui-form-label" style="width: 120px;">	生成4副牛牛的概率</label>
                                    <div class="layui-input-inline">
                                        <input type="number" id="FOUR_NN" name="NN_NUMBER" value="{{$val['NN_NUMBER']['FOUR_NN'] or ''}}" lay-verify="required" placeholder="0" class="layui-input ling">
                                    </div>
                                </div>
                                <div class="layui-form-item">
                                    <label for="" class="layui-form-label" style="width: 120px;">	生成5副牛牛的概率</label>
                                    <div class="layui-input-inline">
                                        <input type="number" id="FIVE_NN" name="NN_NUMBER" value="{{$val['NN_NUMBER']['FIVE_NN'] or ''}}" lay-verify="required" placeholder="0" class="layui-input ling">
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr id="BANKER_STORE">
                            <td style="width: 100px;"><b>区间库存</b></td>
                            <td>
                                <div class="layui-form-item">
                                    <label for="" class="layui-form-label" style="width: 120px;">库存区间</label>
                                    <div class="layui-input-inline">
                                        <input type="text" id="STORE_RANGE" name="BANKER_STORE" value="{{$val['BANKER_STORE']['STORE_RANGE'] or ''}}" lay-verify="required" placeholder="0" class="layui-input ling">
                                    </div>
                                </div>

                                <div class="layui-form-item">
                                    <label for="" class="layui-form-label" style="width: 120px;">区间一 第一到五大的牌的权重</label>
                                    <div class="layui-input-inline">
                                        <input type="text" id="ONE_PROBABILITY" name="BANKER_STORE" value="{{$val['BANKER_STORE']['ONE_PROBABILITY'] or ''}}" lay-verify="required" placeholder="0" class="layui-input ling">
                                    </div>
                                </div>
                                <div class="layui-form-item">
                                    <label for="" class="layui-form-label" style="width: 120px;">区间二 第一到五大的牌的权重</label>
                                    <div class="layui-input-inline">
                                        <input type="text" id="TWO_PROBABILITY" name="BANKER_STORE" value="{{$val['BANKER_STORE']['TWO_PROBABILITY'] or ''}}" lay-verify="required" placeholder="0" class="layui-input ling" >
                                    </div>
                                </div>
                                <div class="layui-form-item">
                                    <label for="" class="layui-form-label" style="width: 120px;">区间三 第一到五大的牌的权重</label>
                                    <div class="layui-input-inline">
                                        <input type="text" id="THREE_PROBABILITY" name="BANKER_STORE" value="{{$val['BANKER_STORE']['THREE_PROBABILITY'] or ''}}" lay-verify="required" placeholder="0" class="layui-input ling" >
                                    </div>
                                </div>
                                <div class="layui-form-item">
                                    <label for="" class="layui-form-label" style="width: 120px;">区间四 第一到五大的牌的权重</label>
                                    <div class="layui-input-inline">
                                        <input type="text" id="FOUR_PROBABILITY" name="BANKER_STORE" value="{{$val['BANKER_STORE']['FOUR_PROBABILITY'] or ''}}" lay-verify="required" placeholder="0" class="layui-input ling" >
                                    </div>
                                </div>
                                <div class="layui-form-item">
                                    <label for="" class="layui-form-label" style="width: 120px;">区间五 第一到五大的牌的权重</label>
                                    <div class="layui-input-inline">
                                        <input type="text" id="FIVE_PROBABILITY" name="BANKER_STORE" value="{{$val['BANKER_STORE']['FIVE_PROBABILITY'] or ''}}" lay-verify="required" placeholder="0" class="layui-input ling" >
                                    </div>
                                </div>
                                <div class="layui-form-item">
                                    <label for="" class="layui-form-label" style="width: 120px;">区间六 第一到五大的牌的权重</label>
                                    <div class="layui-input-inline">
                                        <input type="text" id="SIX_PROBABILITY" name="BANKER_STORE" value="{{$val['BANKER_STORE']['SIX_PROBABILITY'] or ''}}" lay-verify="required" placeholder="0" class="layui-input ling" >
                                    </div>
                                </div>
                                <div class="layui-form-item">
                                    <label for="" class="layui-form-label" style="width: 120px;">区间七 第一到五大的牌的权重</label>
                                    <div class="layui-input-inline">
                                        <input type="text" id="SEVEN_PROBABILITY" name="BANKER_STORE" value="{{$val['BANKER_STORE']['SEVEN_PROBABILITY'] or ''}}" lay-verify="required" placeholder="0" class="layui-input ling" >
                                    </div>
                                </div>

                            </td>
                        </tr>

                        <tr id="pool_addup">
                            <td style="width: 100px;"><b>额外抽水比率</b></td>
                            <td>
                                <div class="layui-form-item" >
                                    <label for="" class="layui-form-label" style="width: 120px;">额外抽水比率</label>
                                    <div class="layui-input-inline">
                                        <input type="number" id="EXTRA_FEE_PERCENT" name="EXTRA_FEE_PERCENT" value="{{$val['EXTRA_FEE_PERCENT']['EXTRA_FEE_PERCENT'] or ''}}" lay-verify="required" placeholder="" class="layui-input ling">
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </table>
            </div>
            @endforeach
            @endif

        </div>
    </div>
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
                        data[gameType][$(input[i]).attr('name')] = {};
                    }
                    for (var i = 0; i < input.length; i++) {
                        data[gameType][$(input[i]).attr('name')][$(input[i]).attr('id')] =  $(input[i]).val();
                    }
                }

                $.post("{{route('admin.brnnbanker.save')}}", {data: data, list: gameList}, function (res) {
                    if (res.code == 0){
                        layer.msg(res.msg,{icon:1})
                    }else {
                        layer.msg(res.msg,{icon:2})
                    }
                });
            });

            //发送到服务器配置
            $("#send").click(function(){
                $.post("{{route('admin.brnnbanker.send')}}",{}, function (res) {
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

        /**
         * 删除表单
         * @param obj
         */
        function del(obj){
            $(obj).parent().parent().remove();
        }
    </script>

@endsection
