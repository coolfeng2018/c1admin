@extends('admin.base')
@section('content')
    <br>
    @can('config.fruit.save')
        <div class="layui-input-inline" style="margin-bottom: 10px;"><button class="layui-btn layui-btn-sm" style="width: 100px" id="save" data-href="">保存</button></div>
    @endcan
    @can('config.fruit.send')
        <div class="layui-input-inline" style="margin-bottom: 10px;"><button class="layui-btn layui-btn-sm" style="width: 130px" id="send" data-href="">发送到服务器配置</button></div>
    @endcan
    <div class="" name="bet_caijin">
        <div id="award_lines">
            <div class="layui-form" name="fromRow" id="fromRow">
                <label for="" class="layui-form-label" style="width: 100px;">单线下注金额</label>
                <div class="layui-input-inline">
                    <input type="text" name="bet_range" id="bet_range"   class="layui-input" style="width: 300px;" placeholder="10,50,100,500,1000"  value="{{$data['bet_caijin']['bet_range'] or ''}}">
                </div>
            </div>
            <br>
            <div class="layui-form" name="fromRow" id="caijin_rate">
                <label for="" class="layui-form-label" style="width: 100px;">获得彩金比例</label>
                <div class="layui-input-inline">
                    <input type="text" name="caijin_rate"  class="layui-input" style="width: 100px;" placeholder="3=5" value="{{$data['bet_caijin']['caijin_rate'][0] or ''}}">
                </div> -
                <div class="layui-input-inline">
                    <input type="text" name="caijin_rate"  class="layui-input" style="width: 100px;" placeholder="3=5" value="{{$data['bet_caijin']['caijin_rate'][1] or ''}}">
                </div> -
                <div class="layui-input-inline">
                    <input type="text" name="caijin_rate"  class="layui-input" style="width: 100px;" placeholder="3=5" value="{{$data['bet_caijin']['caijin_rate'][2] or ''}}">
                </div>
            </div>

            <div class="layui-form" style="margin:20px">
                <div class="layui-input-inline">
                    <div>3=50，三个777连线获得奖金占奖池的50%，4，四个777连线。。。，5，5个777连线</div>
                </div>
            </div>
            <br>
        </div>

    </div>



@endsection

@section('script')
    <script>
        var layer = '';
        layui.use(['layer'],function () {
            layer = layui.layer;
            $("#save").click(function () {
                var temp = {};
                var from = {};
                var data = {};
                var caijin = $("#caijin_rate").find('input');
                for (var i=0;i<caijin.length;i++){
                    from[i] = $(caijin[i]).val();
                }
                temp['caijin_rate'] = from;
                temp['bet_range']   = $('#bet_range').val();
                data['bet_caijin']  = temp;
                $.post("{{route('admin.fruit.save')}}", {data:data}, function (res) {
                    if (res.code == 0){
                        layer.msg(res.msg,{icon:1})
                    }else {
                        layer.msg(res.msg,{icon:2})
                    }
                });
            });

            //发送到服务器配置
            $("#send").click(function(){
                $.post("{{route('admin.fruit.send')}}",{}, function (res) {
                    if (res.code == 0){
                        layer.msg(res.msg,{icon:1})
                    }else {
                        layer.msg(res.msg,{icon:2})
                    }
                });
            });

        });
    </script>

@endsection