@extends('admin.base')
@section('content')
    <div class="layui-tab layui-tab-card">
        @can('store.granddraw.save')
            <div class="layui-input-inline" style="margin-bottom: 10px;"><button class="layui-btn layui-btn-sm" style="width: 100px" id="save" data-href="">保存</button></div>
        @endcan
        @can('store.granddraw.send')
            <div class="layui-input-inline" style="margin-bottom: 10px;"><button class="layui-btn layui-btn-sm" style="width: 130px" id="send" data-href="">发送到服务器配置</button></div>
        @endcan
        <div class="layui-tab-content" style="height: 100%;">
            <div class="layui-tab-item layui-show">
                    <table class="layui-table fruits" lay-size="lg">
                        <tr id="store_system_back" name="fruits">
                            <td style="width: 100px;"><b>抽水</b></td>
                            <td>
                                <div class="layui-form-item" >
                                    <label for="" class="layui-form-label" style="width: 120px;">实时数据（元）</label>
                                    <div class="layui-input-inline">
                                        <input type="number" value="{{ $listData['fee_coins'] ?? 0}}" lay-verify="required" placeholder="0" class="layui-input" style="background: #F0F0F0" readonly="readonly" >
                                    </div>
                                </div>

                                <div class="layui-form-item">
                                    <label for="" class="layui-form-label" style="width: 120px;">分成比例（万分比）</label>
                                    <div class="layui-input-inline">
                                        <input type="number" id="fee_rate" name="fee_rate" value="{{$data['fee_rate'] ?? 0 }}" lay-verify="required" placeholder="0" class="fruits layui-input" >
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr id="store_base_sys" name="fruits">
                            <td style="width: 100px;"><b>库存</b></td>
                            <td>
                                <div class="layui-form-item" >
                                    <label for="" class="layui-form-label" style="width: 120px;">实时数据（元）</label>
                                    <div class="layui-input-inline">
                                        <input type="number" value="{{ $listData['store_coins'] ?? 0}}" lay-verify="required" placeholder="0" class="layui-input" style="background: #F0F0F0" readonly="readonly" >
                                    </div>
                                </div>

                                <div class="layui-form-item">
                                    <label for="" class="layui-form-label" style="width: 120px;">警报值（元）</label>
                                    <div class="layui-input-inline">
                                        <input type="number" id="store_warn" name="store_warn" value="{{$data['store_warn'] ?? 0 }}" lay-verify="required"  placeholder="0" class="fruits layui-input">
                                    </div>
                                </div>
                                <div class="layui-form-item">
                                    <label for="" class="layui-form-label" style="width: 120px;">库存初始值(元)</label>
                                    <div class="layui-input-inline">
                                        <input type="number" id="base_store_init" name="base_store_init" value="{{$data['base_store_init'] ?? 0 }}" lay-verify="required"  placeholder="0" class="fruits layui-input">
                                    </div>
                                </div>
                                <div class="layui-form-item">
                                    <label for="" class="layui-form-label" style="width: 120px;">添加库存（元）</label>
                                    <div class="layui-input-inline">
                                        <input type="number" id="add_money" name="add_money" value="" lay-verify="required" placeholder="0" class="fruits layui-input" >
                                    </div>
                                </div>
                                <div class="layui-form-item" >
                                    <label for="" class="layui-form-label" style="width: 120px;">系统资助金额（元）</label>
                                    <div class="layui-input-inline">
                                        <input type="number" value="{{ $listData['store_system_add'] ?? 0}}" lay-verify="required" placeholder="0" class="layui-input" style="background: #F0F0F0" readonly="readonly" >
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr id="store_adjust" name="fruits">
                            <td style="width: 100px;"><b>奖池</b></td>
                            <td>
                                <div class="layui-form-item" >
                                    <label for="" class="layui-form-label" style="width: 120px;">实时数据（元）</label>
                                    <div class="layui-input-inline">
                                        <input type="number" value="{{ $listData['award_pool_coins'] ?? 0}}" lay-verify="required" placeholder="0" class="layui-input" style="background: #F0F0F0" readonly="readonly" >
                                    </div>
                                </div>

                                <div class="layui-form-item">
                                    <label for="" class="layui-form-label" style="width: 120px;">分成比例（万分比）</label>
                                    <div class="layui-input-inline">
                                        <input type="number" id="award_pool_rate" name="award_pool_rate" value="{{$data['award_pool_rate'] ?? 0 }}" lay-verify="required" placeholder="0" class="fruits layui-input" >
                                    </div>
                                </div>
                                <div class="layui-form" name="fromRow" id="fromRow">
                                    <label for="" class="layui-form-label" style="width: 120px;">更新频率（秒）</label>
                                    <div class="layui-input-inline">
                                        <input type="number" name="update_time_min" id="update_time_min" class="fruits layui-input" style="width: 90px;" value="{{$data['update_time_min'] ?? 0 }}">
                                    </div> ~
                                    <div class="layui-input-inline">
                                        <input type="number" name="update_time_max" id="update_time_max"  class="fruits layui-input" style="width: 90px;" value="{{$data['update_time_max'] ?? 0 }}">
                                    </div>
                                </div>
                                <br />
                                <div class="layui-form" name="fromRow" id="fromRow">
                                    <label for="" class="layui-form-label" style="width: 120px;">增长金额（元）</label>
                                    <div class="layui-input-inline">
                                        <input type="number" name="add_coins_min" id="add_coins_min"  class="fruits layui-input" style="width: 90px;" value="{{$data['add_coins_min'] ?? 0 }}">
                                    </div> ~
                                    <div class="layui-input-inline">
                                        <input type="number" name="add_coins_max" id="add_coins_max"  class="fruits layui-input" style="width: 90px;" value="{{$data['add_coins_max'] ?? 0 }}">
                                    </div>
                                </div>
                                <br />
                                <div class="layui-form-item">
                                    <label for="" class="layui-form-label" style="width: 120px;">系统资助金额（元）</label>
                                    <div class="layui-input-inline">
                                        <input type="number" value="{{ $listData['award_pool_system_add'] ?? 0}}" lay-verify="required" placeholder="0" class="layui-input" style="background: #F0F0F0" readonly="readonly" >
                                    </div>
                                </div>
                                <div class="layui-form-item">
                                    <label for="" class="layui-form-label" style="width: 120px;">发奖最大人数（人）</label>
                                    <div class="layui-input-inline">
                                        <input type="number" id="max_award_num" name="max_award_num" value="{{$data['max_award_num'] ?? 0 }}" lay-verify="required" placeholder="0" class="fruits layui-input" >
                                    </div>
                                </div>

                            </td>
                        </tr>

                    </table>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        layui.use(['layer','table','form'],function () {
            var layer = layui.layer;
            //保存
            $("#save").click(function () {
                var data = {};
                data['fee_rate'] = $("#fee_rate").val();
                data['store_warn'] = $("#store_warn").val();
                data['base_store_init'] = $("#base_store_init").val();
                data['add_money'] = $("#add_money").val();
                data['award_pool_rate'] = $("#award_pool_rate").val();
                data['update_time_min'] = $("#update_time_min").val();
                data['update_time_max'] = $("#update_time_max").val();
                data['add_coins_min'] = $("#add_coins_min").val();
                data['add_coins_max'] = $("#add_coins_max").val();
                data['max_award_num'] = $("#max_award_num").val();
                $.post("{{route('admin.granddraw.save')}}", {data: data}, function (res) {
                    if (res.code == 0){
                        layer.msg(res.msg,{icon:1})
                        window.location.reload();
                    }else {
                        layer.msg(res.msg,{icon:2})
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
