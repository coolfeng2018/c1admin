@extends('admin.base')
@section('content')
    <div class="layui-tab layui-tab-card">
        @can('store.granddraw.save')
            <div class="layui-input-inline" style="margin-bottom: 10px;">
                <button class="layui-btn layui-btn-sm" style="width: 100px" id="save" data-href="">保存</button>
            </div>
        @endcan
        @can('store.granddraw.send')
            <div class="layui-input-inline" style="margin-bottom: 10px;">
                <button class="layui-btn layui-btn-sm" style="width: 130px" id="send" data-href="">发送到服务器配置</button>
            </div>
        @endcan
        <div class="layui-form">
            <div class="layui-form-item" id="radio">
                <label for="" class="layui-form-label" style="width: 120px;">玩法开关</label>
                <div class="layui-input-inline">
                    <input type="radio" name="open" value="1" title="开" @if( isset($data['open']) && $data['open'] == 1 )checked=""@endif>
                    <input type="radio" name="open" value="0" title="关" @if( isset($data['open']) && $data['open'] == 0 )checked=""@endif>
                </div>
            </div>

            <div class="layui-form-item">
                <label for="" class="layui-form-label" style="width: 120px;">绑定赠送次数</label>
                <div class="layui-input-inline">
                    <input type="number" id="bind_add_count" name="bind_add_count"
                           value="{{$data['bind_add_count'] ?? 0 }}" lay-verify="required" placeholder="0"
                           class="fruits layui-input">
                </div>
            </div>

            <div class="layui-form-item">
                <label for="" class="layui-form-label" style="width: 120px;">免费抽奖有效门槛（元）</label>
                <div class="layui-input-inline">
                    <input type="number" id="charge_coins" name="charge_coins" value="{{$data['charge_coins'] ?? 0 }}"
                           lay-verify="required" placeholder="0" class="fruits layui-input">
                </div>
            </div>
            <div class="layui-form" name="fromRow" id="fromRow">
                <label for="" class="layui-form-label" style="width: 120px;">推广赠送(次)</label>
                <div class="layui-input-inline">
                    <input type="number" name="advert_condition" id="advert_condition" class="fruits layui-input"
                           style="width: 90px;" value="{{$data['advert_condition'] ?? '' }}" placeholder="推广次数">
                </div>
                ~
                <div class="layui-input-inline">
                    <input type="number" name="advert_add_count" id="advert_add_count" class="fruits layui-input"
                           style="width: 90px;" value="{{$data['advert_add_count'] ?? '' }}" placeholder="赠送次数">
                </div>
            </div>
            <br/>

            <div class="layui-form-item">
                <label for="" class="layui-form-label" style="width: 120px;">抽奖消耗(元)</label>
                <div class="layui-input-inline">
                    <input type="number" id="award_cost" name="award_cost" value="{{$data['award_cost'] ?? 0 }}"
                           lay-verify="required" placeholder="0" class="fruits layui-input">
                </div>
            </div>

            <div class="layui-form-item">
                <label for="" class="layui-form-label" style="width: 120px;">彩票获取率（百分比）</label>
                <div class="layui-input-inline">
                    <input type="number" id="lottery_rate" name="lottery_rate" value="{{$data['lottery_rate'] ?? 0 }}"
                           lay-verify="required" placeholder="0" class="fruits layui-input">
                </div>
            </div>
        </div>
        <div class="layui-card-body">
            @if(!empty($paramArr) && isset($paramArr))
                @foreach($paramArr as $card => $item)
                    <div class="layui-row  layui-form-item" id="param">
                        <div class="layui-col-md3">
                            <label for="" class="layui-form-label">牌值</label>
                            <div class="layui-input-inline">
                                <input type="text" lay-verify="required" class="layui-input" name="card[{{$card}}]" value="{{ $item['card'] ?? '' }}" placeholder="牌值" >
                            </div>
                        </div>
                        <div class="layui-col-md3">
                            <label for="" class="layui-form-label">概率(百分比)</label>
                            <div class="layui-input-inline">
                                <input type="text" lay-verify="required" class="layui-input" name="rate[{{$card}}]" value="{{ $data['card_rate'][$card]['rate'] ?? 0 }}" placeholder="概率值">
                            </div>
                        </div>
                        <div class="layui-col-md3">
                            <label for="" class="layui-form-label">奖励(元)</label>
                            <div class="layui-input-inline">
                                <input type="text" lay-verify="required" class="layui-input"  name="award_coins[{{$card}}]" value="{{ $data['card_rate'][$card]['award_coins'] ?? 0 }}" placeholder="奖励金币">
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
@endsection

@section('script')
    <script>
        layui.use(['layer', 'table', 'form'], function () {
            var layer = layui.layer;
            //保存
            $("#save").click(function () {
                var data = {};
                data['open'] = $('#radio input[name="open"]:checked ').val();
                data['bind_add_count'] = $("#bind_add_count").val();
                data['charge_coins'] = $("#charge_coins").val();
                data['advert_condition'] = $("#advert_condition").val();
                data['advert_add_count'] = $("#advert_add_count").val();
                data['award_cost'] = $("#award_cost").val();
                data['lottery_rate'] = $("#lottery_rate").val();

                // 不在 form 标记中就这样
                var card = {};
                var rate = {};
                var award_coins = {};
                $("input[name^='card']").each(function(i, el) {
                    card[i] =$(this).val();
                });
                $("input[name^='rate']").each(function(i, el) {
                    rate[i] =$(this).val();
                });
                $("input[name^='award_coins']").each(function(i, el) {
                    award_coins[i] =$(this).val();
                });


                $.post("{{route('admin.granddraw.playsave')}}", {data: data,rate: rate,card: card,award_coins: award_coins}, function (res) {
                    if (res.code == 0) {
                        layer.msg(res.msg, {icon: 1})
                        window.location.reload();
                    } else {
                        layer.msg(res.msg, {icon: 2})
                    }
                });
            });

            //发送到服务器配置
            $("#send").click(function(){
                $.post("{{route('admin.granddraw.send')}}",{}, function (res) {
                    if (res.code == 0){
                        layer.msg(res.msg,{icon:1})
                        window.location.reload();
                    }else {
                        layer.msg(res.msg,{icon:2})
                    }
                });
            });
        });

    </script>

@endsection
