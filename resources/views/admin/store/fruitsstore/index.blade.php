@extends('admin.base')
@section('content')
    <div class="layui-tab layui-tab-card">
        @can('store.fruitsstore.save')
            <div class="layui-input-inline" style="margin-bottom: 10px;"><button class="layui-btn layui-btn-sm" style="width: 100px" id="save" data-href="">保存</button></div>
        @endcan
        @can('store.fruitsstore.send')
            <div class="layui-input-inline" style="margin-bottom: 10px;"><button class="layui-btn layui-btn-sm" style="width: 130px" id="send" data-href="">发送到服务器配置</button></div>
        @endcan
        <ul class="layui-tab-title">
            @if(!empty($list['data']))
            @foreach($list['data'] as $key => $val)
            <li  class=" {{$key=='fruit_nomal'?'layui-this':''}}" value="{{$key or ''}}" onclick="change(this)">{{$val or ''}}</li>
            @endforeach
            @endif
        </ul>
        <div class="layui-tab-content" style="height: 100%;">
            @if(!empty($data))
            @foreach($data as $key => $val)
            <div class="layui-tab-item {{$key=='fruit_nomal'?'layui-show':''}}" id="{{$key or ''}}" name="{{$key or ''}}">
                    {{--  @foreach($data[$k] as $index => $val)--}}
                    <table class="layui-table fruits" lay-size="lg">
                        <tr id="store_system_back" name="fruits">
                            <td style="width: 100px;"><b>系统回收（抽水）</b></td>
                            <td>
                                <div class="layui-form-item" >
                                    <label for="" class="layui-form-label" style="width: 120px;">实时数据(元)</label>
                                    <div class="layui-input-inline">
                                        <input type="number" id="fee_coins" name="fee_coins" value="{{$val['store_system_back']['curr'] or ''}}" lay-verify="required" placeholder="0" class="layui-input" style="background: #F0F0F0" readonly="readonly" >
                                    </div>
                                </div>

                                <div class="layui-form-item">
                                    <label for="" class="layui-form-label" style="width: 120px;">贡献比例（万分比）</label>
                                    <div class="layui-input-inline">
                                        <input type="number" id="contribute_rate" name="contribute_rate" value="{{$val['store_system_back']['contribute_rate'] or ''}}" lay-verify="required" placeholder="0" class="fruits layui-input" >
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr id="store_base_sys" name="fruits">
                            <td style="width: 100px;"><b>库存1（大盘库存）</b></td>
                            <td>
                                <div class="layui-form-item" >
                                    <label for="" class="layui-form-label" style="width: 120px;">实时数据(元)</label>
                                    <div class="layui-input-inline">
                                        <input type="number" id="base_curr_rate" name="base_curr_rate" value="{{$val['store_base_sys']['curr'] or ''}}" lay-verify="required" placeholder="0" class="layui-input" style="background: #F0F0F0" readonly="readonly" >
                                    </div>
                                </div>

                                <div class="layui-form-item">
                                    <label for="" class="layui-form-label" style="width: 120px;">贡献比例（万分比）</label>
                                    <div class="layui-input-inline">
                                        <input type="number" id="contribute_rate" name="contribute_rate" value="{{$val['store_base_sys']['contribute_rate'] or ''}}" lay-verify="required"  placeholder="0" class="fruits layui-input">
                                    </div>
                                </div>
                                <div class="layui-form-item">
                                    <label for="" class="layui-form-label" style="width: 120px;">警报值(元)</label>
                                    <div class="layui-input-inline">
                                        <input type="number" id="base_warn" name="base_warn" value="{{$val['store_base_sys']['base_warn'] or ''}}" lay-verify="required" placeholder="0" class="fruits layui-input" >
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr id="store_adjust" name="fruits">
                            <td style="width: 100px;"><b>库存2（调节库存）</b></td>
                            <td>
                                <div class="layui-form-item" >
                                    <label for="" class="layui-form-label" style="width: 120px;">实时数据(元)</label>
                                    <div class="layui-input-inline">
                                        <input type="number" id="award_coins" name="award_coins" value="{{$val['store_adjust']['curr'] or ''}}" lay-verify="required" placeholder="0" class="layui-input" style="background: #F0F0F0" disabled >
                                    </div>
                                </div>

                                <div class="layui-form-item">
                                    <label for="" class="layui-form-label" style="width: 120px;">贡献比例（万分比）</label>
                                    <div class="layui-input-inline">
                                        <input type="number" id="contribute_rate" name="contribute_rate" value="{{$val['store_adjust']['contribute_rate'] or ''}}" lay-verify="required" placeholder="0" class="fruits layui-input" >
                                    </div>
                                </div>
                                <div class="layui-form-item">
                                    <label for="" class="layui-form-label" style="width: 120px;">警报值(元)</label>
                                    <div class="layui-input-inline">
                                        <input type="number" id="base_warn" name="base_warn" value="{{$val['store_adjust']['base_warn'] or ''}}" lay-verify="required" placeholder="0" class="fruits layui-input" >
                                    </div>
                                </div>
                                <div class="layui-form-item">
                                    <label for="" class="layui-form-label" style="width: 120px;">触发概率（万分比）</label>
                                    <div class="layui-input-inline">
                                        <input type="number" id="target_rate" name="target_rate" value="{{$val['store_adjust']['target_rate'] or ''}}" lay-verify="required" placeholder="0" class="fruits layui-input" >
                                    </div>
                                </div>
                                <div class="layui-form-item">
                                    <label for="" class="layui-form-label" style="width: 120px;">触发流水要求（元）</label>
                                    <div class="layui-input-inline">
                                        <input type="number" id="target_turnover" name="target_turnover" value="{{$val['store_adjust']['target_turnover'] or ''}}" lay-verify="required" placeholder="0" class="fruits layui-input" >
                                    </div>
                                </div>
                                <div class="layui-form-item">
                                    <label for="" class="layui-form-label" style="width: 120px;">触发返水比例（万分比）</label>
                                    <div class="layui-input-inline">
                                        <input type="number" id="fee_rate" name="fee_rate" value="{{$val['store_adjust']['fee_rate'] or ''}}" lay-verify="required" placeholder="0" class="fruits layui-input" >
                                    </div>
                                </div>

                            </td>
                        </tr>

                        <tr id="store_real_jackpot" name="fruits">
                            <td style="width: 100px;"><b>奖池（jackpot）</b></td>
                            <td>
                                <div class="layui-form-item" >
                                    <label for="" class="layui-form-label" style="width: 120px;">实时数据(元)</label>
                                    <div class="layui-input-inline">
                                        <input type="number" id="award_coins" name="award_coins" value="{{$val['store_real_jackpot']['curr'] or ''}}" lay-verify="required" placeholder="0" class="layui-input" style="background: #F0F0F0" disabled >
                                    </div>
                                </div>

                                <div class="layui-form-item">
                                    <label for="" class="layui-form-label" style="width: 120px;">贡献比例（万分比）</label>
                                    <div class="layui-input-inline">
                                        <input type="number" id="contribute_rate" name="contribute_rate" value="{{$val['store_real_jackpot']['contribute_rate'] or ''}}" lay-verify="required" placeholder="0" class="fruits layui-input" >
                                    </div>
                                </div>
                                <div class="layui-form-item">
                                    <label for="" class="layui-form-label" style="width: 120px;">警报值(元)</label>
                                    <div class="layui-input-inline">
                                        <input type="number" id="base_warn" name="base_warn" value="{{$val['store_real_jackpot']['base_warn'] or ''}}" lay-verify="required" placeholder="0" class="fruits layui-input" >
                                    </div>
                                </div>
                                <div class="layui-form-item">
                                    <label for="" class="layui-form-label" style="width: 120px;">触发概率（万分比）</label>
                                    <div class="layui-input-inline">
                                        <input type="number" id="target_rate" name="target_rate" value="{{$val['store_real_jackpot']['target_rate'] or ''}}" lay-verify="required" placeholder="0" class="fruits layui-input" >
                                    </div>
                                </div>
                                <div class="layui-form-item">
                                    <label for="" class="layui-form-label" style="width: 120px;">触发流水要求（元）</label>
                                    <div class="layui-input-inline">
                                        <input type="number" id="target_turnover" name="target_turnover" value="{{$val['store_real_jackpot']['target_turnover'] or ''}}" lay-verify="required" placeholder="0" class="fruits layui-input" >
                                    </div>
                                </div>
                            </td>
                        </tr>

                        <tr id="store_unreal_jackpot" name="fruits">
                            <td style="width: 100px;"><b>虚假奖池（jackpot）</b></td>
                            <td>
                                <div class="layui-form-item" >
                                    <label for="" class="layui-form-label" style="width: 120px;">实时数据（元）</label>
                                    <div class="layui-input-inline">
                                        <input type="number" id="award_coins" name="award_coins" value="{{$val['store_unreal_jackpot']['curr'] or ''}}" lay-verify="required" placeholder="0" class="layui-input" style="background: #F0F0F0" readonly="readonly" >
                                    </div>
                                </div>

                                <div class="layui-form" name="fromRow" id="fromRow">
                                    <label for="" class="layui-form-label" style="width: 120px;">更新频率（秒）</label>
                                    <div class="layui-input-inline">
                                        <input type="text" name="update_rate_min" id="update_rate_min"  class="fruits layui-input" style="width: 90px;" value="{{$val['store_unreal_jackpot']['update_rate_min'] or ''}}">
                                    </div> ~
                                    <div class="layui-input-inline">
                                        <input type="text" name="update_rate_max" id="update_rate_max"  class="fruits layui-input" style="width: 90px;" value="{{$val['store_unreal_jackpot']['update_rate_max'] or ''}}">
                                    </div>
                                </div>
                                <br>

                                <div class="layui-form" name="fromRow" id="fromRow">
                                    <label for="" class="layui-form-label" style="width: 120px;">增长金额（元）</label>
                                    <div class="layui-input-inline">
                                        <input type="text" name="add_coins_min" id="add_coins_min"  class="fruits layui-input" style="width: 90px;" value="{{$val['store_unreal_jackpot']['add_coins_min'] or ''}}">
                                    </div> ~
                                    <div class="layui-input-inline">
                                        <input type="text" name="add_coins_max" id="add_coins_max"  class="fruits layui-input" style="width: 90px;" value="{{$val['store_unreal_jackpot']['add_coins_max'] or ''}}">
                                    </div>
                                </div>
                                <br>
                                <div class="layui-form-item">
                                    <label for="" class="layui-form-label" style="width: 120px;">上限阈值（元）</label>
                                    <div class="layui-input-inline">
                                        <input type="number" id="coins_hight" name="coins_hight" value="{{$val['store_unreal_jackpot']['coins_hight'] or ''}}" lay-verify="required" placeholder="0" class="fruits layui-input" >
                                    </div>
                                </div>
                                <div class="layui-form-item">
                                    <label for="" class="layui-form-label" style="width: 120px;">下限阈值（元）</label>
                                    <div class="layui-input-inline">
                                        <input type="number" id="coins_low" name="coins_low" value="{{$val['store_unreal_jackpot']['coins_low'] or ''}}" lay-verify="required" placeholder="0" class="fruits layui-input" >
                                    </div>
                                </div>
                                <div class="layui-form-item">
                                    <label for="" class="layui-form-label" style="width: 120px;">实时发放率（万分比）</label>
                                    <div class="layui-input-inline">
                                        <input type="number" id="grand_rate" name="grand_rate" value="{{$val['store_unreal_jackpot']['grand_rate'] or ''}}" lay-verify="required" placeholder="0" class="layui-input" style="background: #F0F0F0" readonly="readonly">
                                    </div>
                                </div>

                                <div class="layui-form" name="fromRow" id="fromRow">
                                    <label for="" class="layui-form-label" style="width: 120px;">发放周期（秒）</label>
                                    <div class="layui-input-inline">
                                        <input type="text" name="grand_cycle_min" id="grand_cycle_min"  class="fruits layui-input" style="width: 90px;" value="{{$val['store_unreal_jackpot']['grand_cycle_min'] or ''}}">
                                    </div> ~
                                    <div class="layui-input-inline">
                                        <input type="text" name="grand_cycle_max" id="grand_cycle_max"  class="fruits layui-input" style="width: 90px;" value="{{$val['store_unreal_jackpot']['grand_cycle_max'] or ''}}">
                                    </div>
                                </div>
                                <br>

                                <div class="layui-form" name="fromRow" id="fromRow">
                                    <label for="" class="layui-form-label" style="width: 120px;">发放额度（元）</label>
                                    <div class="layui-input-inline">
                                        <input type="text" name="grand_coins_min" id="grand_coins_min"  class="fruits layui-input" style="width: 90px;" value="{{$val['store_unreal_jackpot']['grand_coins_min'] or ''}}">
                                    </div> ~
                                    <div class="layui-input-inline">
                                        <input type="text" name="grand_coins_max" id="grand_coins_max"  class="fruits layui-input" style="width: 90px;" value="{{$val['store_unreal_jackpot']['grand_coins_max'] or ''}}">
                                    </div>
                                </div>

                            </td>
                        </tr>

                        <tr id="free_tiems" name="fruits">
                            <td style="width: 100px;"><b>免费次数</b></td>
                            <td>
                                <div class="layui-form-item">
                                    <label for="" class="layui-form-label" style="width: 120px;">触发概率（万分比）</label>
                                    <div class="layui-input-inline">
                                        <input type="number" id="target_rate" name="target_rate" value="{{$val['free_tiems']['target_rate'] or ''}}" lay-verify="required" placeholder="0" class="fruits layui-input" >
                                    </div>
                                </div>
                                <div class="layui-form-item">
                                    <label for="" class="layui-form-label" style="width: 120px;">触发局数限制</label>
                                    <div class="layui-input-inline">
                                        <input type="number" id="target_round" name="target_round" value="{{$val['free_tiems']['target_round'] or ''}}" lay-verify="required" placeholder="0" class="fruits layui-input" >
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
                var data = {};
                var fruits = $(".fruits").find("tr[name='fruits']");
                for (var i=0;i<fruits.length;i++){
                    var group = $(fruits[i]).find(".fruits");
                    data[$(fruits[i]).attr('id')] = {};
                    for (var j=0;j<group.length;j++){
                       data[$(fruits[i]).attr('id')][$(group[j]).attr('id')] = $(group[j]).val();
                    }

                }
                $.post("{{route('admin.fruitsstore.save')}}", {data: data}, function (res) {
                    if (res.code == 0){
                        layer.msg(res.msg,{icon:1})
                    }else {
                        layer.msg(res.msg,{icon:2})
                    }
                });
            });

            //发送到服务器配置
            $("#send").click(function(){
                $.post("{{route('admin.fruitsstore.send')}}",{}, function (res) {
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
