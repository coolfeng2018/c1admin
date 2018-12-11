@extends('admin.base')
@section('content')
    <div class="layui-tab layui-tab-card">
        @can('store.mammonstore.save')
            <div class="layui-input-inline" style="margin-bottom: 10px;"><button class="layui-btn layui-btn-sm" style="width: 100px" id="save" data-href="">保存</button></div>
        @endcan
        @can('store.mammonstore.send')
            <div class="layui-input-inline" style="margin-bottom: 10px;"><button class="layui-btn layui-btn-sm" style="width: 130px" id="send" data-href="">发送到服务器配置</button></div>
        @endcan

        <div class="layui-tab-content" style="height: 100%;">

            <div >
            <form>
                    <table class="layui-table" lay-size="lg">
                        <tr id="cattle_fee">
                            <td style="width: 100px;"><b>抽水</b></td>
                            <td>
                                <div class="layui-form-item" >
                                    <label for="" class="layui-form-label" style="width: 120px;">实时抽水(元)</label>
                                    <div class="layui-input-inline">
                                        <input type="number"  value="{{$data['fee_store']/100}}" lay-verify="required" placeholder="0" class="layui-input" style="background: #F0F0F0" disabled >
                                    </div>
                                </div>

                                <div class="layui-form-item">
                                    <label for="" class="layui-form-label" style="width: 120px;">抽水概率(万分比)</label>
                                    <div class="layui-input-inline">
                                        <input type="number" id="fee_rate" name="fee_rate" value="{{$rest['fee_rate'] or ''}}" lay-verify="required" placeholder="0" class="layui-input" >
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr id="cattle_base">
                            <td style="width: 100px;"><b>库存（基础库存）</b></td>
                            <td>
                                <div class="layui-form-item">
                                    <label for="" class="layui-form-label" style="width: 120px;">目标库存(元)</label>
                                    <div class="layui-input-inline">
                                        <input type="number" id="base_goal" name="base_goal" value="{{$rest['base_goal']/100}}" lay-verify="required" placeholder="0" class="layui-input" >
                                    </div>
                                </div>
                                <div class="layui-form-item" >
                                    <label for="" class="layui-form-label" style="width: 120px;">实时库存(元)</label>
                                    <div class="layui-input-inline">
                                        <input type="number" value="{{$data['base_store']/100 }}" lay-verify="required" placeholder="0" class="layui-input" style="background: #F0F0F0" readonly="readonly" >
                                    </div>
                                </div>

                                <div class="layui-form-item">
                                    <label for="" class="layui-form-label" style="width: 120px;">警报值(元)</label>
                                    <div class="layui-input-inline">
                                        <input type="number" id="base_warn" name="base_warn" value="{{$rest['base_warn']/100}}" lay-verify="required" placeholder="0" class="layui-input" >
                                    </div>
                                </div>

                                <div class="layui-form-item">
                                    <label for="" class="layui-form-label" style="width: 120px;">基础发放概率（万分比）</label>
                                    <div class="layui-input-inline">
                                        <input type="number"  name="base_tigger_rate" value="{{$rest['base_tigger_rate'] or ''}}" lay-verify="required" placeholder="0" class="layui-input" >
                                    </div>
                                </div>


                                <div class="layui-form-item">
                                    <label for="" class="layui-form-label" style="width: 120px;">最终发放概率（万分比）</label>
                                    <div class="layui-input-inline">
                                        <input type="number"  value="{{$data['real_time_rate'] or ''}}" lay-verify="required" readonly="readonly" style="background: #F0F0F0" placeholder="0" class="layui-input" >
                                    </div>
                                </div>
                            </td>
                        </tr>

                    </table>
            </form>
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
                var data = $('form').serializeArray();
                var d = {};
                $.each(data, function() {
                    d[this.name] = this.value;
                });

                $.post("{{route('admin.mammonstore.save')}}", {data: d}, function (res) {
                    if (res.code == 0){
                        layer.msg(res.msg,{icon:1})
                    }else {
                        layer.msg(res.msg,{icon:2})
                    }
                });
            });

            //发送到服务器配置
            $("#send").click(function(){
                $.post("{{route('admin.mammonstore.send')}}",{}, function (res) {
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
